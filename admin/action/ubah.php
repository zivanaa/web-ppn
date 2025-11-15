<?php
// admin/action/ubah.php - FIXED VERSION FOR PRODUK
session_start();
include '../../config/koneksi.php';

$mod = $_GET['mod'] ?? '';
$id = intval($_POST['id'] ?? 0);

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
        return ['success' => false, 'message' => 'Tipe file tidak diizinkan'];
    }
    
    // Generate nama file unik
    $new_filename = 'produk_' . uniqid() . '_' . time() . '.' . $file_ext;
    $target_path = $upload_path . $new_filename;
    
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return ['success' => true, 'filename' => $new_filename];
    } else {
        return ['success' => false, 'message' => 'Gagal upload file'];
    }
}

switch ($mod) {
    case 'produk':
        try {
            // Validasi ID
            if (empty($id) || !is_numeric($id)) {
                throw new Exception('ID produk tidak valid');
            }

            // Ambil data produk lama
            $stmt_check = $conn->prepare("SELECT * FROM produk WHERE id = ?");
            $stmt_check->bind_param("i", $id);
            $stmt_check->execute();
            $result = $stmt_check->get_result();
            
            if ($result->num_rows == 0) {
                throw new Exception('Produk tidak ditemukan');
            }
            $row = $result->fetch_assoc();

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
            $stok = intval($_POST['stok'] ?? 0);
            $harga = floatval($_POST['harga'] ?? 0);
            $status = sanitize_input($_POST['status'] ?? 'Aktif');
            
            // Handle atribut
            $atribut_array = [];
            if (isset($_POST['baru'])) $atribut_array[] = 'Baru';
            if (isset($_POST['laris'])) $atribut_array[] = 'Laris';
            if (isset($_POST['promo'])) $atribut_array[] = 'Promo';
            if (isset($_POST['bonus'])) $atribut_array[] = 'Bonus';
            if (isset($_POST['habis'])) $atribut_array[] = 'Habis';
            $atribut = implode(' ', $atribut_array);

            $lokasi = "../../asset/img/";
            $nama_gambar = $row['gambar'];
            $nama_gambar_kecil = $row['gambar_kecil'];

            // Upload gambar utama baru (jika ada)
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
                $gambar_result = upload_image($_FILES['gambar'], $lokasi);
                
                if ($gambar_result['success']) {
                    // Hapus gambar lama
                    if (!empty($row['gambar']) && file_exists($lokasi . $row['gambar'])) {
                        unlink($lokasi . $row['gambar']);
                    }
                    $nama_gambar = $gambar_result['filename'];
                } else {
                    throw new Exception('Error upload gambar utama: ' . $gambar_result['message']);
                }
            }

            // Upload gambar kecil baru (jika ada)
            if (isset($_FILES['gambar_kecil']) && $_FILES['gambar_kecil']['error'] != UPLOAD_ERR_NO_FILE) {
                $gambar_kecil_result = upload_image($_FILES['gambar_kecil'], $lokasi);
                
                if ($gambar_kecil_result['success']) {
                    // Hapus gambar kecil lama
                    if (!empty($row['gambar_kecil']) && file_exists($lokasi . $row['gambar_kecil'])) {
                        unlink($lokasi . $row['gambar_kecil']);
                    }
                    $nama_gambar_kecil = $gambar_kecil_result['filename'];
                } else {
                    throw new Exception('Error upload gambar kecil: ' . $gambar_kecil_result['message']);
                }
            }

            // Update database dengan prepared statement
            $stmt = $conn->prepare("UPDATE produk SET 
                kategori = ?, 
                jenis_tanaman = ?,
                nama = ?, 
                deskripsi = ?, 
                penjelasan = ?,
                manfaat = ?,
                aturan_pakai = ?,
                keistimewaan = ?,
                penyimpanan = ?,
                stok = ?,
                harga = ?, 
                gambar = ?, 
                gambar_kecil = ?, 
                atribut = ?, 
                status = ?
                WHERE id = ?");
            
            $stmt->bind_param(
                "sssssssssidssssi",
                $kategori, $jenis_tanaman, $nama, $deskripsi, $penjelasan,
                $manfaat, $aturan, $keistimewaan, $penyimpanan,
                $stok, $harga, $nama_gambar, $nama_gambar_kecil, $atribut, $status, $id
            );
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Produk berhasil diupdate!';
                header('Location: ../produk.php');
                exit;
            } else {
                throw new Exception('Gagal update database: ' . $stmt->error);
            }
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: ../produk.php');
            exit;
        }
        break;

    case 'ulasan':
        try {
            if (empty($id)) {
                throw new Exception('ID tidak valid');
            }

            $nama = sanitize_input($_POST['nama'] ?? '');
            $produk = sanitize_input($_POST['produk'] ?? '');
            $alamat = sanitize_input($_POST['alamat'] ?? '');
            $ulasan = sanitize_input($_POST['ulasan'] ?? '');
            $nilai = intval($_POST['nilai'] ?? 5);
            $status = sanitize_input($_POST['status'] ?? 'Disembunyikan');

            // Get old data
            $result = mysqli_query($conn, "SELECT * FROM ulasan WHERE id=$id");
            if (!$result || mysqli_num_rows($result) == 0) {
                throw new Exception('Ulasan tidak ditemukan');
            }
            $row = mysqli_fetch_assoc($result);
            $nama_gambar = $row['gambar'];

            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
                $upload_result = upload_image($_FILES['gambar'], "../../asset/img/");
                if ($upload_result['success']) {
                    // Delete old image if not default
                    if ($row['gambar'] != 'Logo Ganyeum.png' && file_exists("../../asset/img/" . $row['gambar'])) {
                        unlink("../../asset/img/" . $row['gambar']);
                    }
                    $nama_gambar = $upload_result['filename'];
                }
            }

            $stmt = $conn->prepare("UPDATE ulasan SET nama=?, produk=?, alamat=?, ulasan=?, nilai=?, gambar=?, status=? WHERE id=?");
            $stmt->bind_param("ssssissi", $nama, $produk, $alamat, $ulasan, $nilai, $nama_gambar, $status, $id);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Ulasan berhasil diupdate!';
            } else {
                throw new Exception('Gagal update ulasan');
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
            if (empty($id)) {
                throw new Exception('ID tidak valid');
            }

            $judul = sanitize_input($_POST['judul'] ?? '');
            $deskripsi = sanitize_input($_POST['deskripsi'] ?? '');
            $status = sanitize_input($_POST['status'] ?? 'Ditampilkan');

            // Get old data
            $result = mysqli_query($conn, "SELECT * FROM galeri WHERE id=$id");
            if (!$result || mysqli_num_rows($result) == 0) {
                throw new Exception('Galeri tidak ditemukan');
            }
            $row = mysqli_fetch_assoc($result);
            $nama_gambar = $row['gambar'];

            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
                $upload_result = upload_image($_FILES['gambar'], "../../asset/img/");
                if ($upload_result['success']) {
                    // Delete old image
                    if (file_exists("../../asset/img/" . $row['gambar'])) {
                        unlink("../../asset/img/" . $row['gambar']);
                    }
                    $nama_gambar = $upload_result['filename'];
                }
            }

            $stmt = $conn->prepare("UPDATE galeri SET judul=?, deskripsi=?, gambar=?, status=? WHERE id=?");
            $stmt->bind_param("ssssi", $judul, $deskripsi, $nama_gambar, $status, $id);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Galeri berhasil diupdate!';
            } else {
                throw new Exception('Gagal update galeri');
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
            if (empty($id)) {
                throw new Exception('ID tidak valid');
            }

            $id_produk = intval($_POST['id_produk'] ?? 0);
            $diskon = intval($_POST['diskon'] ?? 0);
            $tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
            $tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
            $status = sanitize_input($_POST['status'] ?? 'Direncanakan');

            $tanggal_waktu_mulai = new DateTime($tanggal_mulai);
            $tanggal_waktu_selesai = new DateTime($tanggal_selesai);
            $tanggal_sekarang = new DateTime();
            
            if ($status === 'Direncanakan' && $tanggal_sekarang >= $tanggal_waktu_mulai && $tanggal_sekarang <= $tanggal_waktu_selesai) {
                $status = "Berjalan";
            } else if ($status === 'Berjalan' && $tanggal_sekarang > $tanggal_waktu_selesai) {
                $status = "Selesai";
            }

            $stmt = $conn->prepare("UPDATE diskon SET id_produk=?, diskon=?, tanggal_mulai=?, tanggal_selesai=?, status=? WHERE id=?");
            $stmt->bind_param("iisssi", $id_produk, $diskon, $tanggal_mulai, $tanggal_selesai, $status, $id);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Diskon berhasil diupdate!';
            } else {
                throw new Exception('Gagal update diskon');
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