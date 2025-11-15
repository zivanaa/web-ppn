<?php
// admin/action/tambah.php - FIXED VERSION FOR PRODUK
session_start();
date_default_timezone_set('Asia/Jakarta');
include '../../config/koneksi.php';

$mod = $_GET['mod'] ?? '';

// Fungsi untuk validasi dan sanitasi input
function sanitize_input($data) {
    if ($data === null) return '';
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk upload gambar dengan validasi
function upload_image($file, $upload_path, $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp']) {
    if (!isset($file) || $file['error'] == UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'message' => 'No file uploaded'];
    }
    
    if ($file['error'] != UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Upload error: ' . $file['error']];
    }
    
    // Validasi ukuran file (max 5MB)
    $max_size = 5 * 1024 * 1024;
    if ($file['size'] > $max_size) {
        return ['success' => false, 'message' => 'File terlalu besar. Maksimal 5MB'];
    }
    
    // Validasi tipe file
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_ext, $allowed_types)) {
        return ['success' => false, 'message' => 'Tipe file tidak diizinkan. Gunakan: ' . implode(', ', $allowed_types)];
    }
    
    // Generate nama file unik
    $new_filename = 'produk_' . uniqid() . '_' . time() . '.' . $file_ext;
    $target_path = $upload_path . $new_filename;
    
    // Upload file
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return ['success' => true, 'filename' => $new_filename];
    } else {
        return ['success' => false, 'message' => 'Gagal upload file'];
    }
}

switch ($mod) {
    case 'produk':
        try {
            // Validasi input wajib
            if (empty($_POST['nama']) || empty($_POST['kategori'])) {
                throw new Exception('Nama dan kategori produk wajib diisi');
            }
            
            // Validasi gambar wajib untuk tambah data
            if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] == UPLOAD_ERR_NO_FILE) {
                throw new Exception('Gambar utama wajib diupload');
            }
            
            if (!isset($_FILES['gambar_kecil']) || $_FILES['gambar_kecil']['error'] == UPLOAD_ERR_NO_FILE) {
                throw new Exception('Gambar kecil wajib diupload');
            }
            
            // Ambil dan sanitasi data
            $kategori = sanitize_input($_POST['kategori']);
            $jenis_tanaman = sanitize_input($_POST['jenis_tanaman'] ?? '');
            $nama = sanitize_input($_POST['nama']);
            $deskripsi = sanitize_input($_POST['deskripsi'] ?? '');
            $penjelasan = sanitize_input($_POST['penjelasan'] ?? '');
            $manfaat = sanitize_input($_POST['manfaat'] ?? '');
            $aturan = sanitize_input($_POST['aturan_pakai'] ?? '');
            $keistimewaan = sanitize_input($_POST['keistimewaan'] ?? '');
            $penyimpanan = sanitize_input($_POST['penyimpanan'] ?? '');
            $stok = isset($_POST['stok']) ? intval($_POST['stok']) : 0;
            $harga = isset($_POST['harga']) ? floatval($_POST['harga']) : 0;
            $status = sanitize_input($_POST['status'] ?? 'Aktif');

            // Handle atribut (badge)
            $atribut_array = [];
            if (isset($_POST['baru'])) $atribut_array[] = 'Baru';
            if (isset($_POST['laris'])) $atribut_array[] = 'Laris';
            if (isset($_POST['promo'])) $atribut_array[] = 'Promo';
            if (isset($_POST['bonus'])) $atribut_array[] = 'Bonus';
            if (isset($_POST['habis'])) $atribut_array[] = 'Habis';
            $atribut = implode(' ', $atribut_array);

            // Upload gambar utama
            $lokasi = "../../asset/img/";
            $gambar_result = upload_image($_FILES['gambar'], $lokasi);
            
            if (!$gambar_result['success']) {
                throw new Exception('Error upload gambar utama: ' . $gambar_result['message']);
            }
            $nama_gambar = $gambar_result['filename'];

            // Upload gambar kecil
            $gambar_kecil_result = upload_image($_FILES['gambar_kecil'], $lokasi);
            
            if (!$gambar_kecil_result['success']) {
                // Hapus gambar utama jika gambar kecil gagal
                if (file_exists($lokasi . $nama_gambar)) {
                    unlink($lokasi . $nama_gambar);
                }
                throw new Exception('Error upload gambar kecil: ' . $gambar_kecil_result['message']);
            }
            $nama_gambar_kecil = $gambar_kecil_result['filename'];

            // Prepared statement untuk keamanan
            $stmt = $conn->prepare("INSERT INTO produk (
                kategori, jenis_tanaman, nama, deskripsi, penjelasan, 
                manfaat, aturan_pakai, keistimewaan, penyimpanan, 
                stok, harga, gambar, gambar_kecil, tanggal, atribut, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)");
            
            $stmt->bind_param(
                "sssssssssidssss",
                $kategori, $jenis_tanaman, $nama, $deskripsi, $penjelasan,
                $manfaat, $aturan, $keistimewaan, $penyimpanan,
                $stok, $harga, $nama_gambar, $nama_gambar_kecil, $atribut, $status
            );
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Produk berhasil ditambahkan!';
                header('Location: ../produk.php');
                exit;
            } else {
                throw new Exception('Gagal menyimpan ke database: ' . $stmt->error);
            }
            
        } catch (Exception $e) {
            // Hapus file yang sudah diupload jika ada error
            if (isset($nama_gambar) && file_exists($lokasi . $nama_gambar)) {
                unlink($lokasi . $nama_gambar);
            }
            if (isset($nama_gambar_kecil) && file_exists($lokasi . $nama_gambar_kecil)) {
                unlink($lokasi . $nama_gambar_kecil);
            }
            
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: ../produk.php');
            exit;
        }
        break;

    case 'ulasan':
        try {
            $nama = sanitize_input($_POST['nama'] ?? '');
            $produk = sanitize_input($_POST['produk'] ?? '');
            $alamat = sanitize_input($_POST['alamat'] ?? '');
            $ulasan = sanitize_input($_POST['ulasan'] ?? '');
            $nilai = intval($_POST['nilai'] ?? 5);
            $status = sanitize_input($_POST['status'] ?? 'Disembunyikan');
            $nama_gambar = 'Logo Ganyeum.png';

            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
                $upload_result = upload_image($_FILES['gambar'], "../../asset/img/");
                if ($upload_result['success']) {
                    $nama_gambar = $upload_result['filename'];
                }
            }

            $stmt = $conn->prepare("INSERT INTO ulasan (nama, produk, alamat, ulasan, nilai, gambar, tanggal, status)
                      VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
            $stmt->bind_param("ssssiss", $nama, $produk, $alamat, $ulasan, $nilai, $nama_gambar, $status);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Ulasan berhasil ditambahkan!';
            } else {
                throw new Exception('Gagal menyimpan ulasan');
            }
            
            header('Location: ../ulasan.php');
            exit;
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: ../ulasan.php');
            exit;
        }
        break;
    
    case 'galeri':
        try {
            $judul = sanitize_input($_POST['judul'] ?? '');
            $deskripsi = sanitize_input($_POST['deskripsi'] ?? '');
            $status = sanitize_input($_POST['status'] ?? 'Ditampilkan');

            if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] == UPLOAD_ERR_NO_FILE) {
                throw new Exception('Gambar wajib diupload');
            }

            $upload_result = upload_image($_FILES['gambar'], "../../asset/img/");
            if (!$upload_result['success']) {
                throw new Exception($upload_result['message']);
            }
            $nama_gambar = $upload_result['filename'];

            $stmt = $conn->prepare("INSERT INTO galeri (judul, deskripsi, gambar, tanggal, status)
                      VALUES (?, ?, ?, NOW(), ?)");
            $stmt->bind_param("ssss", $judul, $deskripsi, $nama_gambar, $status);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Galeri berhasil ditambahkan!';
            } else {
                throw new Exception('Gagal menyimpan galeri');
            }
            
            header('Location: ../galeri.php');
            exit;
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: ../galeri.php');
            exit;
        }
        break;

    case 'diskon':
        try {
            $id_produk = intval($_POST['id_produk'] ?? 0);
            $diskon = intval($_POST['diskon'] ?? 0);
            $tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
            $tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
            $status = "Direncanakan";

            $tanggal_waktu_mulai = new DateTime($tanggal_mulai);
            $tanggal_waktu_selesai = new DateTime($tanggal_selesai);
            $tanggal_sekarang = new DateTime();
            
            if ($tanggal_sekarang >= $tanggal_waktu_mulai && $tanggal_sekarang <= $tanggal_waktu_selesai) {
                $status = "Berjalan";
            } else if ($tanggal_sekarang > $tanggal_waktu_selesai) {
                $status = "Selesai";
            }

            $stmt = $conn->prepare("INSERT INTO diskon (id_produk, diskon, tanggal_mulai, tanggal_selesai, status)
                      VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisss", $id_produk, $diskon, $tanggal_mulai, $tanggal_selesai, $status);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Diskon berhasil ditambahkan!';
            } else {
                throw new Exception('Gagal menyimpan diskon');
            }
            
            header('Location: ../diskon.php');
            exit;
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: ../diskon.php');
            exit;
        }
        break;
        
    default:
        $_SESSION['error_message'] = 'Module tidak valid';
        header('Location: ../produk.php');
        exit;
}
?>