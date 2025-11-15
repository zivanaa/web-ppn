<?php
// admin/action/tambah_logbook.php
session_start();
header('Content-Type: application/json');

include '../../config/koneksi.php';

function sanitize_input($data) {
    if ($data === null) return '';
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

try {
    // Validasi input
    if (empty($_POST['tanggal']) || empty($_POST['koordinator']) || empty($_POST['alamat'])) {
        throw new Exception('Data wajib harus diisi');
    }

    // Ambil data
    $tanggal = sanitize_input($_POST['tanggal']);
    $koordinator = sanitize_input($_POST['koordinator']);
    $alamat = sanitize_input($_POST['alamat']);
    $cash_dp = floatval($_POST['cash_dp'] ?? 0);
    $satu_minggu = floatval($_POST['satu_minggu'] ?? 0);
    $satu_bulan = floatval($_POST['satu_bulan'] ?? 0);
    $jumlah_total = floatval($_POST['jumlah_total'] ?? 0);
    $presenter = sanitize_input($_POST['presenter'] ?? '');
    $marketing = sanitize_input($_POST['marketing'] ?? '');
    $komisi_persen = floatval($_POST['komisi_persen'] ?? 10);
    $komisi = floatval($_POST['komisi'] ?? 0);
    $keterangan = sanitize_input($_POST['keterangan'] ?? 'Belum Lunas');

    // Validasi produk
    if (empty($_POST['produk_nama']) || !is_array($_POST['produk_nama'])) {
        throw new Exception('Minimal 1 produk harus diisi');
    }

    // Build produk JSON
    $products = [];
    for ($i = 0; $i < count($_POST['produk_nama']); $i++) {
        if (!empty($_POST['produk_nama'][$i]) && !empty($_POST['produk_jumlah'][$i])) {
            $products[] = [
                'nama' => sanitize_input($_POST['produk_nama'][$i]),
                'jumlah' => intval($_POST['produk_jumlah'][$i])
            ];
        }
    }

    if (empty($products)) {
        throw new Exception('Data produk tidak valid');
    }

    $produk_json = json_encode($products);

    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO logbook (
        tanggal, koordinator, alamat, produk_json, 
        cash_dp, satu_minggu, satu_bulan, jumlah_total, 
        presenter, marketing, komisi, keterangan, created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    $stmt->bind_param(
        "ssssddddssds",
        $tanggal, $koordinator, $alamat, $produk_json,
        $cash_dp, $satu_minggu, $satu_bulan, $jumlah_total,
        $presenter, $marketing, $komisi, $keterangan
    );

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Logbook berhasil ditambahkan!';
        echo json_encode([
            'success' => true,
            'message' => 'Logbook berhasil ditambahkan'
        ]);
    } else {
        throw new Exception('Gagal menyimpan ke database: ' . $stmt->error);
    }

} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>