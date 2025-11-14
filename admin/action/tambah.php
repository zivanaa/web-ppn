<?php
// admin/action/tambah.php (UPDATE untuk case 'produk')

date_default_timezone_set('Asia/Jakarta');
include '../../config/koneksi.php';

$mod = $_GET['mod'];

// Fungsi untuk validasi dan sanitasi input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk upload gambar dengan validasi
function upload_image($file, $upload_path, $allowed_types = ['jpg', 'jpeg', 'png', 'gif']) {
    if (!isset($file) || $file['error'] == UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'message' => 'No file uploaded'];
    }
    
    if ($file['error'] != UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Upload error: ' . $file['error']];
    }
    
    // Validasi ukuran file (max 5MB)
    $max_size = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $max_size) {
        return ['success' => false, 'message' => 'File terlalu besar. Maksimal 5MB'];
    }
    
    // Validasi tipe file
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_ext, $allowed_types)) {
        return ['success' => false, 'message' => 'Tipe file tidak diizinkan'];
    }
    
    // Generate nama file unik
    $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
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
            // Validasi input
            if (empty($_POST['nama']) || empty($_POST['kategori'])) {
                throw new Exception('Nama dan kategori produk wajib diisi');
            }
            
            // Ambil dan sanitasi data
            $kategori = sanitize_input($_POST['kategori']);
            $jenis_tanaman = isset($_POST['jenis_tanaman']) ? sanitize_input($_POST['jenis_tanaman']) : '';
            $nama = sanitize_input($_POST['nama']);
            $deskripsi = isset($_POST['deskripsi']) ? sanitize_input($_POST['deskripsi']) : '';
            $penjelasan = isset($_POST['penjelasan']) ? sanitize_input($_POST['penjelasan']) : '';
            $manfaat = isset($_POST['manfaat']) ? sanitize_input($_POST['manfaat']) : '';
            $aturan = isset($_POST['aturan']) ? sanitize_input($_POST['aturan']) : '';
            $keistimewaan = isset($_POST['keistimewaan']) ? sanitize_input($_POST['keistimewaan']) : '';
            $penyimpanan = isset($_POST['penyimpanan']) ? sanitize_input($_POST['penyimpanan']) : '';
            $stok = isset($_POST['stok']) ? intval($_POST['stok']) : 0;
            $harga = isset($_POST['harga']) ? floatval($_POST['harga']) : 0;
            $status = isset($_POST['status']) ? sanitize_input($_POST['status']) : 'Aktif';

            // Handle atribut (badge)
            $baru = isset($_POST['baru']) ? 'Baru' : '';
            $laris = isset($_POST['laris']) ? 'Laris' : '';
            $promo = isset($_POST['promo']) ? 'Promo' : '';
            $bonus = isset($_POST['bonus']) ? 'Bonus' : '';
            $habis = isset($_POST['habis']) ? 'Habis' : '';
            
            $atribut_tersedia = array_filter([$baru, $laris, $promo, $bonus, $habis]);
            $atribut = implode(' ', $atribut_tersedia);

            // Handle status dipajang
            if ($status === 'Aktif' && isset($_POST['pajang'])) {
                $status = 'Dipajang';
            }

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
                unlink($lokasi . $nama_gambar);
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
                $_SESSION['success_message'] = 'Produk berhasil ditambahkan';
                header('Location: ../produk');
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
            header('Location: ../produk');
            exit;
        }
        break;

    // Case lainnya tetap sama (ulasan, galeri, diskon)
    case 'ulasan':
        $nama = $_POST['nama'];
        $ulasan = $_POST['ulasan'];
        $nilai = $_POST['nilai'];
        $status = $_POST['status'];
        $nama_gambar = 'Logo Ganyeum.png';

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
            if ($_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
                $lokasi = "../../asset/img/";
                $nama_gambar = $_FILES["gambar"]["name"];
                move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi.$nama_gambar);
            }
        }

        $query = "INSERT INTO ulasan (nama, ulasan, nilai, gambar, tanggal, status)
                  VALUES ('$nama', '$ulasan', '$nilai', '$nama_gambar', NOW(), '$status')";
        mysqli_query($conn, $query);
        header('Location: ../ulasan');
        exit;
        break;
    
    case 'galeri':
        $deskripsi = $_POST['deskripsi'];
        $status = $_POST['status'];

        $lokasi = "../../asset/img/";
        $nama_gambar = $_FILES["gambar"]["name"];
        move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi.$nama_gambar);

        $query = "INSERT INTO galeri (deskripsi, gambar, tanggal, status)
                  VALUES ('$deskripsi', '$nama_gambar', NOW(), '$status')";
        mysqli_query($conn, $query);
        header('Location: ../galeri');
        exit;
        break;

    case 'diskon':
        $id_produk = $_POST['id_produk'];
        $diskon = $_POST['diskon'];
        $tanggal_mulai = $_POST['tanggal_mulai'];
        $tanggal_selesai = $_POST['tanggal_selesai'];
        $status = "Direncanakan";

        $tanggal_waktu_mulai = new DateTime($_POST['tanggal_mulai']);
        $tanggal_waktu_selesai = new DateTime($_POST['tanggal_selesai']);
        $tanggal_sekarang = new DateTime();
        if ($tanggal_sekarang >= $tanggal_waktu_mulai && $tanggal_sekarang <= $tanggal_waktu_selesai) {
            $status = "Berjalan";
        } else if ($tanggal_sekarang > $tanggal_waktu_selesai) {
            $status = "Selesai";
        }

        $query = "INSERT INTO diskon (id_produk, diskon, tanggal_mulai, tanggal_selesai, status)
                  VALUES ('$id_produk', '$diskon', '$tanggal_mulai', '$tanggal_selesai', '$status')";
        mysqli_query($conn, $query);
        header('Location: ../diskon');
        exit;
        break;
}
?>