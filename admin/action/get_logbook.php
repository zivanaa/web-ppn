<?php
// admin/action/get_logbook.php
session_start();
header('Content-Type: application/json');

include '../../config/koneksi.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
    exit;
}

$id = intval($_GET['id']);

try {
    // Query logbook
    $stmt = $conn->prepare("SELECT * FROM logbook WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Logbook tidak ditemukan');
    }
    
    $logbook = $result->fetch_assoc();
    
    // Parse produk JSON
    $products = json_decode($logbook['produk_json'], true);
    if (!is_array($products)) {
        $products = [];
    }
    
    // Calculate komisi percentage
    $komisi_persen = 10; // default
    if ($logbook['jumlah_total'] > 0 && $logbook['komisi'] > 0) {
        $komisi_persen = ($logbook['komisi'] / $logbook['jumlah_total']) * 100;
    }
    
    // Format response
    $response = [
        'success' => true,
        'data' => [
            'id' => $logbook['id'],
            'tanggal' => $logbook['tanggal'],
            'koordinator' => $logbook['koordinator'],
            'alamat' => $logbook['alamat'],
            'cash_dp' => $logbook['cash_dp'],
            'satu_minggu' => $logbook['satu_minggu'],
            'satu_bulan' => $logbook['satu_bulan'],
            'jumlah_total' => $logbook['jumlah_total'],
            'presenter' => $logbook['presenter'],
            'marketing' => $logbook['marketing'],
            'komisi' => $logbook['komisi'],
            'komisi_persen' => round($komisi_persen, 2),
            'keterangan' => $logbook['keterangan'],
            'products' => $products
        ]
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>