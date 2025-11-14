<?php
// admin/action/hapus.php (UPDATE)

session_start();
include "../../config/koneksi.php";

$mod = $_GET['mod'];
$id = $_GET['id'];

// Validasi input
if (empty($mod) || empty($id) || !is_numeric($id)) {
    $_SESSION['error_message'] = 'Parameter tidak valid';
    header('Location: ../' . $mod);
    exit;
}

try {
    switch ($mod) {
        case 'produk': 
            // Ambil data produk untuk mendapatkan nama file gambar
            $result = mysqli_query($conn, "SELECT * FROM produk WHERE id=$id");
            
            if (!$result || mysqli_num_rows($result) == 0) {
                throw new Exception('Produk tidak ditemukan');
            }
            
            $row = mysqli_fetch_assoc($result);
            
            // Hapus file gambar utama jika ada
            if (!empty($row['gambar']) && file_exists("../../asset/img/" . $row['gambar'])) {
                unlink("../../asset/img/" . $row['gambar']);
            }
            
            // Hapus file gambar kecil jika ada
            if (!empty($row['gambar_kecil']) && file_exists("../../asset/img/" . $row['gambar_kecil'])) {
                unlink("../../asset/img/" . $row['gambar_kecil']);
            }
            
            // Hapus dari database menggunakan prepared statement
            $stmt = $conn->prepare("DELETE FROM produk WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            if (!$stmt->execute()) {
                throw new Exception('Gagal menghapus produk dari database');
            }
            
            $_SESSION['success_message'] = 'Produk berhasil dihapus';
            break;
        
        case 'ulasan': 
            $result = mysqli_query($conn, "SELECT * FROM ulasan WHERE id=$id");
            
            if (!$result || mysqli_num_rows($result) == 0) {
                throw new Exception('Ulasan tidak ditemukan');
            }
            
            $row = mysqli_fetch_assoc($result);
            
            // Hapus gambar jika bukan gambar default
            if ($row['gambar'] != 'Logo Ganyeum.png' && file_exists("../../asset/img/" . $row['gambar'])) {
                unlink("../../asset/img/" . $row['gambar']);
            }
            
            $stmt = $conn->prepare("DELETE FROM ulasan WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            if (!$stmt->execute()) {
                throw new Exception('Gagal menghapus ulasan dari database');
            }
            
            $_SESSION['success_message'] = 'Ulasan berhasil dihapus';
            break;

        case 'galeri': 
            $result = mysqli_query($conn, "SELECT * FROM galeri WHERE id=$id");
            
            if (!$result || mysqli_num_rows($result) == 0) {
                throw new Exception('Galeri tidak ditemukan');
            }
            
            $row = mysqli_fetch_assoc($result);
            
            // Hapus file gambar
            if (!empty($row['gambar']) && file_exists("../../asset/img/" . $row['gambar'])) {
                unlink("../../asset/img/" . $row['gambar']);
            }
            
            $stmt = $conn->prepare("DELETE FROM galeri WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            if (!$stmt->execute()) {
                throw new Exception('Gagal menghapus galeri dari database');
            }
            
            $_SESSION['success_message'] = 'Galeri berhasil dihapus';
            break;

        case 'diskon': 
            $stmt = $conn->prepare("DELETE FROM diskon WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            if (!$stmt->execute()) {
                throw new Exception('Gagal menghapus diskon dari database');
            }
            
            $_SESSION['success_message'] = 'Diskon berhasil dihapus';
            break;
        
        default:
            throw new Exception('Module tidak dikenali');
    }
    
} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
}

header('Location: ../' . $mod);
exit;
?>