<?php
// admin/action/get_produk.php
// File baru untuk mengambil data produk (untuk Edit)

session_start();
include '../../config/koneksi.php';

header('Content-Type: application/json');

// Validasi metode request
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
    exit;
}

$id = intval($_GET['id']);

try {
    // Query untuk mengambil data produk
    $stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'Produk tidak ditemukan']);
        exit;
    }
    
    $produk = $result->fetch_assoc();
    
    // Parse atribut menjadi array
    $atribut = $produk['atribut'] ? explode(' ', $produk['atribut']) : [];
    
    // Format data untuk response
    $response = [
        'success' => true,
        'data' => [
            'id' => $produk['id'],
            'kategori' => $produk['kategori'],
            'jenis_tanaman' => $produk['jenis_tanaman'],
            'nama' => $produk['nama'],
            'deskripsi' => $produk['deskripsi'],
            'penjelasan' => $produk['penjelasan'],
            'manfaat' => $produk['manfaat'],
            'aturan_pakai' => $produk['aturan_pakai'],
            'keistimewaan' => $produk['keistimewaan'],
            'penyimpanan' => $produk['penyimpanan'],
            'stok' => $produk['stok'],
            'harga' => $produk['harga'],
            'gambar' => $produk['gambar'],
            'gambar_kecil' => $produk['gambar_kecil'],
            'status' => $produk['status'],
            'atribut' => [
                'baru' => in_array('Baru', $atribut),
                'laris' => in_array('Laris', $atribut),
                'promo' => in_array('Promo', $atribut),
                'bonus' => in_array('Bonus', $atribut),
                'habis' => in_array('Habis', $atribut)
            ],
            'pajang' => $produk['status'] === 'Dipajang'
        ]
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

$conn->close();
?>