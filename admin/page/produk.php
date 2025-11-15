<?php
// admin/page/produk.php - FIXED VERSION
require_once __DIR__ . '/../auth_check.php';
require_once __DIR__ . '/../../config/koneksi.php';

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Get product data first to delete images
    $stmt = $conn->prepare("SELECT gambar, gambar_kecil FROM produk WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        // Delete images
        if (file_exists("../../asset/img/" . $row['gambar'])) {
            unlink("../../asset/img/" . $row['gambar']);
        }
        if (file_exists("../../asset/img/" . $row['gambar_kecil'])) {
            unlink("../../asset/img/" . $row['gambar_kecil']);
        }
        
        // Delete from database
        $delete_stmt = $conn->prepare("DELETE FROM produk WHERE id = ?");
        $delete_stmt->bind_param("i", $id);
        
        if ($delete_stmt->execute()) {
            $_SESSION['success_message'] = "Produk berhasil dihapus!";
        } else {
            $_SESSION['error_message'] = "Gagal menghapus produk!";
        }
    }
    
    header("Location: produk.php");
    exit;
}

// Get all products
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$kategori_filter = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : '';

$where = [];
$params = [];
$types = '';

if (!empty($search)) {
    $where[] = "(nama LIKE ? OR deskripsi LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= 'ss';
}

if (!empty($kategori_filter)) {
    $where[] = "kategori = ?";
    $params[] = $kategori_filter;
    $types .= 's';
}

$where_sql = !empty($where) ? "WHERE " . implode(' AND ', $where) : "";

$query = "SELECT * FROM produk $where_sql ORDER BY tanggal DESC";

if (!empty($params)) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = mysqli_query($conn, $query);
}

// Get unique categories for filter
$kategori_query = "SELECT DISTINCT kategori FROM produk ORDER BY kategori";
$kategori_result = mysqli_query($conn, $kategori_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Produk - PPN</title>
  
  <link href="/WEB_PPN/asset/img/LogoIco.ico" rel="icon">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="/WEB_PPN/asset/style/style_admin.css">

  <style>
    * { font-family: 'Poppins', sans-serif; }
    body { font-weight: 400; }
    h1, h2, h3, h4, h5, h6 { font-weight: 600; }
    .fw-bold { font-weight: 700 !important; }
    .fw-semibold { font-weight: 600 !important; }
    
    .alert { 
      position: fixed; 
      top: 80px; 
      right: 20px; 
      z-index: 9999; 
      min-width: 300px;
      animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
      from { transform: translateX(400px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
  </style>
</head>
<body>

<?php include('../template/sidebar.php'); ?>

<!-- MAIN CONTENT -->
<div class="main">
  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= htmlspecialchars($_SESSION['success_message']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>
  
  <?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= htmlspecialchars($_SESSION['error_message']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>

  <div class="header-section">Manajemen Produk</div>

  <!-- SEARCH BAR & BUTTONS -->
  <div class="search-bar-top">
    <div class="left-col">
      <form method="GET" class="d-flex gap-2">
        <div class="search-box">
          <i class="bi bi-search"></i>
          <input type="text" name="search" placeholder="Search" value="<?= htmlspecialchars($search) ?>">
        </div>
        <button type="submit" class="search-btn" style="background-color: #4E8E55;">
          <i class="bi bi-search"></i>
        </button>
        <button type="button" id="btnFilter" class="search-btn" style="background-color: #4E8E55;">
          <i class="bi bi-funnel"></i>
        </button>
      </form>
    </div>
    
    <div class="right-col">
      <button id="btnTambah" class="search-btn" style="background-color: #4E8E55;">
        <i class="bi bi-plus"></i>
      </button>
    </div>
  </div>

  <!-- PRODUCT LIST -->
  <?php if ($result && mysqli_num_rows($result) > 0): ?>
    <?php while ($product = mysqli_fetch_assoc($result)): ?>
      <div class='product-card'>
        <div class='product-info'>
          <img src='/WEB_PPN/asset/img/<?= htmlspecialchars($product['gambar_kecil']) ?>' 
               alt='<?= htmlspecialchars($product['nama']) ?>'>
          <div>
            <span class='fw-semibold'><?= htmlspecialchars($product['nama']) ?></span>
            <small class="d-block text-muted"><?= htmlspecialchars($product['kategori']) ?></small>
            <small class="d-block">Stok: <?= htmlspecialchars($product['stok']) ?> | 
            Rp <?= number_format($product['harga'], 0, ',', '.') ?></small>
          </div>
        </div>
        <div class='action-btns'>
          <button class='btn-delete' onclick="confirmDelete(<?= $product['id'] ?>)">
            <i class='bi bi-trash'></i>
          </button>
          <button class='btn-edit' onclick="editProduct(<?= $product['id'] ?>)">
            <i class='bi bi-pencil'></i>
          </button>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="text-center py-5">
      <p class="text-muted">Tidak ada produk ditemukan</p>
    </div>
  <?php endif; ?>
</div>

<!-- MODAL TAMBAH/EDIT PRODUK -->
<div class="modal fade" id="produkModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="d-flex align-items-center gap-2">
          <img src="/WEB_PPN/asset/img/logo.png" alt="Logo" width="100">
          <div class="vr" style="height: 35px; width: 2px; background-color: #000;"></div>
          <h5 class="fw-bold mb-0" id="modalTitle">Tambah Produk</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="produkForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" id="produkId">
        <input type="hidden" name="action" id="formAction" value="tambah">
        
        <label class="fw-semibold mb-1">Kategori Produk</label>
        <input type="text" class="form-control border-success mb-3" name="kategori" 
               id="kategori" placeholder="Masukkan kategori produk" required>

        <label class="fw-semibold mb-1">Jenis Tanaman</label>
        <input type="text" class="form-control border-success mb-3" name="jenis_tanaman" 
               id="jenisTanaman" placeholder="Pisahkan dengan ';' (Eg: Jagung;Padi)">

        <label class="fw-semibold mb-1">Nama Produk</label>
        <input type="text" class="form-control border-success mb-3" name="nama" 
               id="namaProduk" placeholder="Masukkan nama produk" required>

        <label class="fw-semibold mb-1">Deskripsi</label>
        <textarea class="form-control border-success mb-3" name="deskripsi" 
                  id="deskripsi" rows="2" placeholder="Masukkan deskripsi" required></textarea>

        <label class="fw-semibold mb-1">Penjelasan Produk</label>
        <textarea class="form-control border-success mb-3" name="penjelasan" 
                  id="penjelasan" rows="2" placeholder="Masukkan penjelasan"></textarea>

        <label class="fw-semibold mb-1">Manfaat & Keunggulan</label>
        <textarea class="form-control border-success mb-3" name="manfaat" 
                  id="manfaat" rows="2" placeholder="Masukkan manfaat"></textarea>

        <label class="fw-semibold mb-1">Aturan Pakai</label>
        <textarea class="form-control border-success mb-3" name="aturan_pakai" 
                  id="aturan" rows="2" placeholder="Masukkan aturan pakai"></textarea>

        <label class="fw-semibold mb-1">Keistimewaan</label>
        <textarea class="form-control border-success mb-3" name="keistimewaan" 
                  id="keistimewaan" rows="2" placeholder="Masukkan keistimewaan"></textarea>

        <label class="fw-semibold mb-1">Petunjuk Penyimpanan</label>
        <textarea class="form-control border-success mb-3" name="penyimpanan" 
                  id="penyimpanan" rows="2" placeholder="Masukkan petunjuk penyimpanan"></textarea>

        <label class="fw-semibold mb-1">Harga</label>
        <input type="number" class="form-control border-success mb-3" name="harga" 
               id="harga" placeholder="Masukkan harga" required>

        <label class="fw-semibold mb-1">Stok</label>
        <input type="number" class="form-control border-success mb-3" name="stok" 
               id="stok" placeholder="Jumlah stok" required>

        <label class="fw-semibold mb-1">Gambar Utama</label>
        <input type="file" class="form-control border-success mb-3" name="gambar" 
               id="gambarInput" accept="image/*">
        <small class="text-muted d-block mb-3" id="currentGambar"></small>

        <label class="fw-semibold mb-1">Gambar Kecil</label>
        <input type="file" class="form-control border-success mb-3" name="gambar_kecil" 
               id="gambarKecilInput" accept="image/*">
        <small class="text-muted d-block mb-3" id="currentGambarKecil"></small>

        <label class="fw-semibold mb-1">Status</label>
        <select class="form-select border-success mb-3" name="status" id="status" required>
          <option value="Aktif">Aktif</option>
          <option value="Non-aktif">Non-aktif</option>
          <option value="Dipajang">Dipajang</option>
        </select>

        <label class="fw-semibold mb-1">Atribut Produk</label>
        <div class="mb-3">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="baru" id="baru" value="1">
            <label class="form-check-label" for="baru">Baru</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="laris" id="laris" value="1">
            <label class="form-check-label" for="laris">Laris</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="promo" id="promo" value="1">
            <label class="form-check-label" for="promo">Promo</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="bonus" id="bonus" value="1">
            <label class="form-check-label" for="bonus">Bonus</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="habis" id="habis" value="1">
            <label class="form-check-label" for="habis">Habis</label>
          </div>
        </div>

        <button type="submit" class="w-100 mt-4 gradient-btn py-2">Simpan</button>
      </form>
    </div>
  </div>
</div>

<!-- MODAL FILTER -->
<div class="modal fade" id="filterModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="d-flex align-items-center gap-2">
          <img src="/WEB_PPN/asset/img/logo.png" alt="Logo" width="100">
          <div class="vr" style="height: 35px; width: 2px; background-color: #000;"></div>
          <h5 class="fw-bold mb-0">Filter Produk</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="GET">
        <label class="fw-semibold mb-1">Kategori</label>
        <select class="form-control border-success mb-3" name="kategori">
          <option value="">Semua Kategori</option>
          <?php while ($kat = mysqli_fetch_assoc($kategori_result)): ?>
            <option value="<?= htmlspecialchars($kat['kategori']) ?>" 
                    <?= $kategori_filter === $kat['kategori'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($kat['kategori']) ?>
            </option>
          <?php endwhile; ?>
        </select>

        <div class="d-flex justify-content-between mt-4">
          <button type="submit" class="gradient-btn px-4 py-2">Terapkan</button>
          <a href="produk.php" class="outline-btn px-4 py-2">Bersihkan</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL NOTIFIKASI -->
<div class="modal fade" id="notifModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content notif-card text-center p-4 rounded-4 border-0 shadow">
      <img src="/WEB_PPN/asset/img/Logo.png" alt="Logo" width="90" class="mb-3">
      <i id="notifIcon" class="bi fs-1 mb-3"></i>
      <h5 id="notifText" class="fw-semibold"></h5>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const produkModal = new bootstrap.Modal(document.getElementById('produkModal'));
const filterModal = new bootstrap.Modal(document.getElementById('filterModal'));
const notifModal = new bootstrap.Modal(document.getElementById('notifModal'));

// Tambah Produk
document.getElementById('btnTambah').addEventListener('click', () => {
  document.getElementById('produkForm').reset();
  document.getElementById('produkId').value = '';
  document.getElementById('formAction').value = 'tambah';
  document.getElementById('modalTitle').textContent = 'Tambah Produk';
  document.getElementById('currentGambar').textContent = '';
  document.getElementById('currentGambarKecil').textContent = '';
  document.getElementById('gambarInput').required = true;
  document.getElementById('gambarKecilInput').required = true;
  produkModal.show();
});

// Edit Product
function editProduct(id) {
  fetch(`../action/get_produk.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const p = data.data;
        document.getElementById('produkId').value = p.id;
        document.getElementById('formAction').value = 'edit';
        document.getElementById('modalTitle').textContent = 'Edit Produk';
        document.getElementById('kategori').value = p.kategori;
        document.getElementById('jenisTanaman').value = p.jenis_tanaman || '';
        document.getElementById('namaProduk').value = p.nama;
        document.getElementById('deskripsi').value = p.deskripsi;
        document.getElementById('penjelasan').value = p.penjelasan || '';
        document.getElementById('manfaat').value = p.manfaat || '';
        document.getElementById('aturan').value = p.aturan_pakai || '';
        document.getElementById('keistimewaan').value = p.keistimewaan || '';
        document.getElementById('penyimpanan').value = p.penyimpanan || '';
        document.getElementById('harga').value = p.harga;
        document.getElementById('stok').value = p.stok;
        document.getElementById('status').value = p.status;
        
        document.getElementById('baru').checked = p.atribut.baru;
        document.getElementById('laris').checked = p.atribut.laris;
        document.getElementById('promo').checked = p.atribut.promo;
        document.getElementById('bonus').checked = p.atribut.bonus;
        document.getElementById('habis').checked = p.atribut.habis;
        
        document.getElementById('currentGambar').textContent = `Gambar saat ini: ${p.gambar}`;
        document.getElementById('currentGambarKecil').textContent = `Gambar kecil saat ini: ${p.gambar_kecil}`;
        document.getElementById('gambarInput').required = false;
        document.getElementById('gambarKecilInput').required = false;
        
        produkModal.show();
      } else {
        showNotif(false, data.message);
      }
    })
    .catch(err => showNotif(false, 'Error loading product data'));
}

// Submit Form
document.getElementById('produkForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  
  const formData = new FormData(e.target);
  const action = document.getElementById('formAction').value;
  const url = action === 'tambah' ? '../action/tambah.php?mod=produk' : '../action/ubah.php?mod=produk';
  
  try {
    const response = await fetch(url, {
      method: 'POST',
      body: formData
    });
    
    produkModal.hide();
    
    // Reload page to show updated data
    setTimeout(() => {
      window.location.reload();
    }, 500);
    
  } catch (error) {
    showNotif(false, 'Error menyimpan produk');
  }
});

// Confirm Delete
function confirmDelete(id) {
  if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
    window.location.href = `produk.php?action=delete&id=${id}`;
  }
}

// Filter
document.getElementById('btnFilter').addEventListener('click', () => {
  filterModal.show();
});

// Show Notification
function showNotif(success, message) {
  const icon = document.getElementById('notifIcon');
  const text = document.getElementById('notifText');
  
  if (success) {
    icon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
  } else {
    icon.className = 'bi bi-x-circle-fill text-danger fs-1 mb-3';
  }
  
  text.textContent = message;
  notifModal.show();
  
  setTimeout(() => notifModal.hide(), 2000);
}

// Auto-hide alerts
setTimeout(() => {
  document.querySelectorAll('.alert').forEach(alert => {
    alert.classList.remove('show');
  });
}, 5000);
</script>

</body>
</html>