<?php
// admin/action/ubah.php (UPDATE untuk case 'produk')

include '../../config/koneksi.php';

$mod = $_GET['mod'];
$id = $_POST['id'];

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
    $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
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
            $result = mysqli_query($conn, "SELECT * FROM produk WHERE id=$id");
            if (!$result || mysqli_num_rows($result) == 0) {
                throw new Exception('Produk tidak ditemukan');
            }
            $row = mysqli_fetch_assoc($result);

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
            
            // Handle atribut
            $baru = isset($_POST['baru']) ? 'Baru' : '';
            $laris = isset($_POST['laris']) ? 'Laris' : '';
            $promo = isset($_POST['promo']) ? 'Promo' : '';
            $bonus = isset($_POST['bonus']) ? 'Bonus' : '';
            $habis = isset($_POST['habis']) ? 'Habis' : '';
            
            $atribut_tersedia = array_filter([$baru, $laris, $promo, $bonus, $habis]);
            $atribut = implode(' ', $atribut_tersedia);
            
            if ($status === 'Aktif' && isset($_POST['pajang'])) {
                $status = 'Dipajang';
            }

            $lokasi = "../../asset/img/";
            $nama_gambar = $row['gambar'];
            $nama_gambar_kecil = $row['gambar_kecil'];

            // Upload gambar utama baru (jika ada)
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
                $gambar_result = upload_image($_FILES['gambar'], $lokasi);
                
                if ($gambar_result['success']) {
                    // Hapus gambar lama
                    if (file_exists($lokasi . $row['gambar'])) {
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
                    if (file_exists($lokasi . $row['gambar_kecil'])) {
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
                $_SESSION['success_message'] = 'Produk berhasil diupdate';
                header('Location: ../produk');
                exit;
            } else {
                throw new Exception('Gagal update database: ' . $stmt->error);
            }
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: ../produk');
            exit;
        }
        break;

    // Case lainnya tetap sama
    case 'ulasan':
        $nama = $_POST['nama'];
        $ulasan = $_POST['ulasan'];
        $nilai = $_POST['nilai'];
        $status = $_POST['status'];
        $nama_gambar = 'Logo Ganyeum.png';

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
            if ($_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
                $result = mysqli_query($conn, "SELECT * FROM " .$mod. " WHERE id=$id");
                $row = mysqli_fetch_assoc($result);
                if ($row['gambar'] != $nama_gambar) {
                    unlink("../../asset/img/" .$row['gambar']);
                }
                
                $lokasi = "../../asset/img/";
                $nama_gambar = $_FILES["gambar"]["name"];
                move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi.$nama_gambar);

                $query = "UPDATE ulasan SET nama='" .$nama. "', ulasan='" .$ulasan. "', nilai='" .$nilai. "', 
                          gambar='" .$nama_gambar. "', status='" .$status. "' WHERE id='" .$id. "'";
            }
        }
        else {
            $query = "UPDATE ulasan SET nama='" .$nama. "', ulasan='" .$ulasan. "', nilai='" .$nilai. "', 
                      status='" .$status. "' WHERE id='" .$id. "'";
        }
        mysqli_query($conn, $query);
        header('Location: ../ulasan');
        exit;
        break;

    case 'galeri':
        $deskripsi = $_POST['deskripsi'];
        $status = $_POST['status'];

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
            if ($_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
                $result = mysqli_query($conn, "SELECT * FROM " .$mod. " WHERE id=$id");
                $row = mysqli_fetch_assoc($result);
                unlink("../../asset/img/" .$row['gambar']);
                
                $lokasi = "../../asset/img/";
                $nama_gambar = $_FILES["gambar"]["name"];
                move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi.$nama_gambar);

                $query = "UPDATE galeri SET deskripsi='" .$deskripsi. "', gambar='" .$nama_gambar. "', status='" .$status. "' WHERE id='" .$id. "'";
            }
        }
        else {
            $query = "UPDATE galeri SET deskripsi='" .$deskripsi. "', status='" .$status. "' WHERE id='" .$id. "'";
        }
        mysqli_query($conn, $query);
        header('Location: ../galeri');
        exit;
        break;

    case 'diskon':
        $id_produk = $_POST['id_produk'];
        $diskon = $_POST['diskon'];
        $tanggal_mulai = $_POST['tanggal_mulai'];
        $tanggal_selesai = $_POST['tanggal_selesai'];
        $status = $_POST['status'];

        $tanggal_waktu_mulai = new DateTime($_POST['tanggal_mulai']);
        $tanggal_waktu_selesai = new DateTime($_POST['tanggal_selesai']);
        $tanggal_sekarang = new DateTime();
        if ($status === 'Direncanakan' && $tanggal_sekarang >= $tanggal_waktu_mulai && $tanggal_sekarang <= $tanggal_waktu_selesai) {
            $status = "Berjalan";
        } else if ($status === 'Berjalan' && $tanggal_sekarang > $tanggal_waktu_selesai) {
            $status = "Selesai";
        }

        $query = "UPDATE diskon SET id_produk='" .$id_produk. "', diskon='" .$diskon. "', tanggal_mulai='" .$tanggal_mulai. "', 
                  tanggal_selesai='" .$tanggal_selesai. "', status='" .$status. "' WHERE id='" .$id. "'";
        mysqli_query($conn, $query);
        header('Location: ../diskon');
        exit;
        break;
}
?>