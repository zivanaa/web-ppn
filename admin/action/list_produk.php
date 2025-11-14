<?php
// admin/action/list_produk.php
// File baru untuk menampilkan daftar produk dengan filter dan search

session_start();
include '../../config/koneksi.php';

// Parameter dari request
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : '';
$status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$offset = ($page - 1) * $limit;

// Build WHERE clause
$where_clauses = [];
$params = [];
$types = '';

if (!empty($search)) {
    $where_clauses[] = "(nama LIKE ? OR deskripsi LIKE ? OR kategori LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= 'sss';
}

if (!empty($kategori)) {
    $where_clauses[] = "kategori = ?";
    $params[] = $kategori;
    $types .= 's';
}

if (!empty($status)) {
    $where_clauses[] = "status = ?";
    $params[] = $status;
    $types .= 's';
}

$where_sql = '';
if (count($where_clauses) > 0) {
    $where_sql = "WHERE " . implode(' AND ', $where_clauses);
}

try {
    // Count total records
    $count_query = "SELECT COUNT(*) as total FROM produk $where_sql";
    
    if (!empty($params)) {
        $count_stmt = $conn->prepare($count_query);
        $count_stmt->bind_param($types, ...$params);
        $count_stmt->execute();
        $count_result = $count_stmt->get_result();
    } else {
        $count_result = mysqli_query($conn, $count_query);
    }
    
    $total_records = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_records / $limit);
    
    // Get products
    $query = "SELECT * FROM produk $where_sql ORDER BY created_at DESC LIMIT ? OFFSET ?";
    
    $stmt = $conn->prepare($query);
    
    // Bind parameters
    if (!empty($params)) {
        $types .= 'ii';
        $params[] = $limit;
        $params[] = $offset;
        $stmt->bind_param($types, ...$params);
    } else {
        $stmt->bind_param('ii', $limit, $offset);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            'id' => $row['id'],
            'kategori' => $row['kategori'],
            'nama' => $row['nama'],
            'deskripsi' => substr($row['deskripsi'], 0, 100) . '...',
            'harga' => number_format($row['harga'], 0, ',', '.'),
            'stok' => $row['stok'],
            'gambar' => $row['gambar'],
            'gambar_kecil' => $row['gambar_kecil'],
            'status' => $row['status'],
            'atribut' => $row['atribut'],
            'created_at' => date('d/m/Y H:i', strtotime($row['created_at']))
        ];
    }
    
    $response = [
        'success' => true,
        'data' => $products,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'total_records' => $total_records,
            'limit' => $limit
        ]
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
    
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

$conn->close();
?>