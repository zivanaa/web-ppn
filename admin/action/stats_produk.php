<?php
// admin/action/stats_produk.php
// Endpoint untuk mendapatkan statistik produk

session_start();
include '../../config/koneksi.php';

header('Content-Type: application/json');

try {
    // Total produk
    $total_query = "SELECT COUNT(*) as total FROM produk";
    $total_result = mysqli_query($conn, $total_query);
    $total_produk = $total_result->fetch_assoc()['total'];
    
    // Produk aktif
    $aktif_query = "SELECT COUNT(*) as total FROM produk WHERE status IN ('Aktif', 'Dipajang')";
    $aktif_result = mysqli_query($conn, $aktif_query);
    $produk_aktif = $aktif_result->fetch_assoc()['total'];
    
    // Produk non-aktif
    $nonaktif_query = "SELECT COUNT(*) as total FROM produk WHERE status = 'Non-aktif'";
    $nonaktif_result = mysqli_query($conn, $nonaktif_query);
    $produk_nonaktif = $nonaktif_result->fetch_assoc()['total'];
    
    // Produk dipajang
    $dipajang_query = "SELECT COUNT(*) as total FROM produk WHERE status = 'Dipajang'";
    $dipajang_result = mysqli_query($conn, $dipajang_query);
    $produk_dipajang = $dipajang_result->fetch_assoc()['total'];
    
    // Total stok
    $stok_query = "SELECT SUM(stok) as total FROM produk WHERE status IN ('Aktif', 'Dipajang')";
    $stok_result = mysqli_query($conn, $stok_query);
    $total_stok = $stok_result->fetch_assoc()['total'] ?? 0;
    
    // Produk per kategori
    $kategori_query = "SELECT kategori, COUNT(*) as jumlah FROM produk GROUP BY kategori";
    $kategori_result = mysqli_query($conn, $kategori_query);
    $produk_per_kategori = [];
    while ($row = $kategori_result->fetch_assoc()) {
        $produk_per_kategori[] = [
            'kategori' => $row['kategori'],
            'jumlah' => $row['jumlah']
        ];
    }
    
    // Produk terbaru (5 terakhir)
    $terbaru_query = "SELECT id, nama, kategori, harga, stok, created_at 
                      FROM produk 
                      ORDER BY created_at DESC 
                      LIMIT 5";
    $terbaru_result = mysqli_query($conn, $terbaru_query);
    $produk_terbaru = [];
    while ($row = $terbaru_result->fetch_assoc()) {
        $produk_terbaru[] = [
            'id' => $row['id'],
            'nama' => $row['nama'],
            'kategori' => $row['kategori'],
            'harga' => number_format($row['harga'], 0, ',', '.'),
            'stok' => $row['stok'],
            'created_at' => date('d/m/Y H:i', strtotime($row['created_at']))
        ];
    }
    
    // Produk stok rendah (< 10)
    $stok_rendah_query = "SELECT id, nama, stok FROM produk WHERE stok < 10 AND status IN ('Aktif', 'Dipajang') ORDER BY stok ASC";
    $stok_rendah_result = mysqli_query($conn, $stok_rendah_query);
    $produk_stok_rendah = [];
    while ($row = $stok_rendah_result->fetch_assoc()) {
        $produk_stok_rendah[] = [
            'id' => $row['id'],
            'nama' => $row['nama'],
            'stok' => $row['stok']
        ];
    }
    
    // Response
    $response = [
        'success' => true,
        'data' => [
            'summary' => [
                'total_produk' => $total_produk,
                'produk_aktif' => $produk_aktif,
                'produk_nonaktif' => $produk_nonaktif,
                'produk_dipajang' => $produk_dipajang,
                'total_stok' => $total_stok
            ],
            'produk_per_kategori' => $produk_per_kategori,
            'produk_terbaru' => $produk_terbaru,
            'produk_stok_rendah' => $produk_stok_rendah
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