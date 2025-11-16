<?php
// admin/action/get_chart_data.php
session_start();
header('Content-Type: application/json');

include '../../config/koneksi.php';

function sanitize_input($data) {
    if ($data === null) return '';
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

try {
    // Ambil parameter filter
    $produk = isset($_GET['produk']) ? sanitize_input($_GET['produk']) : '';
    $tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : date('Y');
    
    // Validasi tahun
    if ($tahun < 2020 || $tahun > date('Y') + 1) {
        throw new Exception('Tahun tidak valid');
    }
    
    // Query untuk mengambil data penjualan per bulan
    $query = "SELECT 
                MONTH(tanggal) as bulan,
                produk_json
              FROM logbook 
              WHERE YEAR(tanggal) = ?
              ORDER BY tanggal";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tahun);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Initialize data array untuk 12 bulan
    $monthly_data = array_fill(1, 12, 0);
    
    // Process hasil query
    while ($row = $result->fetch_assoc()) {
        $bulan = intval($row['bulan']);
        $products = json_decode($row['produk_json'], true);
        
        if (is_array($products)) {
            foreach ($products as $product) {
                $nama_produk = $product['nama'] ?? '';
                $jumlah = intval($product['jumlah'] ?? 0);
                
                // Jika filter produk kosong atau sesuai dengan produk yang dipilih
                if (empty($produk) || stripos($nama_produk, $produk) !== false) {
                    $monthly_data[$bulan] += $jumlah;
                }
            }
        }
    }
    
    // Nama bulan dalam bahasa Indonesia
    $nama_bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    
    // Format data untuk Chart.js
    $labels = [];
    $data = [];
    
    foreach ($monthly_data as $bulan => $jumlah) {
        $labels[] = $nama_bulan[$bulan];
        $data[] = $jumlah;
    }
    
    // Hitung total
    $total = array_sum($data);
    
    // Response
    echo json_encode([
        'success' => true,
        'data' => [
            'labels' => $labels,
            'values' => $data,
            'total' => $total,
            'produk' => !empty($produk) ? $produk : 'Semua Produk',
            'tahun' => $tahun
        ]
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>