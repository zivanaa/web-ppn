<?php
// admin/page/logbook.php - BACKEND INTEGRATION ONLY (Frontend tetap sama)
require_once __DIR__ . '/../auth_check.php';
require_once __DIR__ . '/../../config/koneksi.php';

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $conn->prepare("DELETE FROM logbook WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Logbook berhasil dihapus!";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus logbook!";
    }
    
    header("Location: logbook.php");
    exit;
}

// Get logbook data from database
$query = "SELECT * FROM logbook ORDER BY tanggal DESC LIMIT 50";
$result = mysqli_query($conn, $query);

// Get statistics
$stats_query = "SELECT 
    COUNT(*) as total_transaksi,
    SUM(jumlah_total) as total_pendapatan,
    SUM(CASE WHEN MONTH(tanggal) = MONTH(CURRENT_DATE()) AND YEAR(tanggal) = YEAR(CURRENT_DATE()) THEN jumlah_total ELSE 0 END) as pendapatan_bulan_ini
FROM logbook";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// Get monthly chart data (last 6 months)
$chart_query = "SELECT 
    DATE_FORMAT(tanggal, '%Y-%m') as bulan,
    SUM(jumlah_total) as total
FROM logbook 
WHERE tanggal >= DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)
GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
ORDER BY bulan";
$chart_result = mysqli_query($conn, $chart_query);
$chart_data = [];
while ($row = mysqli_fetch_assoc($chart_result)) {
    $chart_data[] = $row;
}

// Get product sales data
$product_query = "SELECT produk_json FROM logbook";
$product_result = mysqli_query($conn, $product_query);
$product_stats = [];

while ($row = mysqli_fetch_assoc($product_result)) {
    $products = json_decode($row['produk_json'], true);
    if (is_array($products)) {
        foreach ($products as $product) {
            $nama = $product['nama'] ?? 'Unknown';
            $jumlah = $product['jumlah'] ?? 0;
            
            if (!isset($product_stats[$nama])) {
                $product_stats[$nama] = 0;
            }
            $product_stats[$nama] += $jumlah;
        }
    }
}

// Prepare chart labels and data
$chart_labels = json_encode(array_column($chart_data, 'bulan'));
$chart_values = json_encode(array_column($chart_data, 'total'));
$product_labels = json_encode(array_keys($product_stats));
$product_values = json_encode(array_values($product_stats));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logbook - PPN</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Sidebar Style -->
  <link rel="stylesheet" href="/WEB_PPN/asset/style/sidebar.css">

  <!-- Logbook Style -->
  <link rel="stylesheet" href="../../asset/style/logbook.css">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <style>
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
  <div class="d-flex">
    <?php include('../template/sidebar.php'); ?>

    <div class="main w-100">
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

      <!-- Header -->
      <div class="header-section">Logbook</div>

      <!-- Statistik -->
      <div class="row g-3 mb-3">
        <div class="col-md-4 col-lg-3">
          <div class="card-stat">
            <canvas id="chartProduk" height="200"></canvas>
          </div>
        </div>
        <div class="col-md-2 col-lg-3">
          <div class="card-stat center">
            <p class="label">Produk Terjual</p>
            <h3><?= number_format(array_sum($product_stats)) ?></h3>
          </div>
        </div>
        <div class="col-md-3 col-lg-3">
          <div class="card-stat center">
            <p class="label">Pendapatan Bulan Ini</p>
            <h3>Rp. <?= number_format($stats['pendapatan_bulan_ini'] ?? 0, 0, ',', '.') ?></h3>
          </div>
        </div>
        <div class="col-md-3 col-lg-3">
          <div class="card-stat center">
            <p class="label">Pendapatan Total</p>
            <h3>Rp. <?= number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') ?></h3>
          </div>
        </div>
      </div>

      <!-- Search & Button -->
      <div class="search-bar-top mb-3">
        <div class="d-flex gap-2">
          <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Cari logbook..." id="searchInput">
          </div>
          <button class="btn-filter" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="bi bi-funnel"></i>
          </button>
          <button class="btn-sort"><i class="bi bi-sort-down"></i></button>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#logbookModal" onclick="resetForm()">
          <i class="bi bi-plus"></i>
        </button>
      </div>

      <!-- Table -->
      <div class="table-wrapper">
        <div class="table-responsive">
          <table class="table table-bordered align-middle text-center">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Koordinator</th>
                <th>Alamat</th>
                <th>Produk</th>
                <th>Cash/DP</th>
                <th>1-Minggu</th>
                <th>1-Bulan</th>
                <th>Jumlah</th>
                <th>Presenter</th>
                <th>Marketing</th>
                <th>Komisi</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="logbookTableBody">
              <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                  <tr>
                    <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                    <td><?= htmlspecialchars($row['koordinator']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td>
                      <?php 
                      $products = json_decode($row['produk_json'], true);
                      if (is_array($products)):
                        foreach ($products as $p):
                          echo htmlspecialchars($p['nama']) . ': ' . $p['jumlah'] . '<br>';
                        endforeach;
                      endif;
                      ?>
                    </td>
                    <td><?= number_format($row['cash_dp'], 0, ',', '.') ?></td>
                    <td><?= number_format($row['satu_minggu'], 0, ',', '.') ?></td>
                    <td><?= number_format($row['satu_bulan'], 0, ',', '.') ?></td>
                    <td><?= number_format($row['jumlah_total'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['presenter'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['marketing'] ?? '-') ?></td>
                    <td><?= number_format($row['komisi'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['keterangan']) ?></td>
                    <td>
                      <button class="btn btn-danger btn-sm" onclick="deleteLogbook(<?= $row['id'] ?>)">
                        <i class="bi bi-trash"></i>
                      </button>
                      <button class="btn btn-warning btn-sm text-white" onclick="editLogbook(<?= $row['id'] ?>)">
                        <i class="bi bi-pencil"></i>
                      </button>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="13" class="text-center py-4">
                    <p class="text-muted">Tidak ada data logbook</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination -->
      <div class="pagination-wrapper d-flex justify-content-center mt-3 gap-3">
        <button class="btn-page nav"><i class="bi bi-chevron-left"></i></button>
        <button class="btn-page active">1</button>
        <button class="btn-page nav"><i class="bi bi-chevron-right"></i></button>
      </div>
    </div>
  </div>

<!-- ================== MODAL ANALITIK ================== -->
<div class="modal fade" id="analitikModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
          <img src="/WEB_PPN/asset/img/Logo.png" alt="Logo" width="90">
          <h5 class="fw-semibold m-0">Analitik</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <div class="d-flex justify-content-center gap-2 mb-3">
          <select id="produkSelect" class="form-select w-auto">
            <option value="">Pilih Produk</option>
            <option>TNH</option>
            <option>TNA</option>
            <option>TNS</option>
          </select>
          <input type="number" id="tahunInput" class="form-control w-auto" placeholder="Tahun">
          <button class="gradient-btn px-3">Cari</button>
        </div>
        <canvas id="chartAnalitik" height="250"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- ================== MODAL FILTER LOGBOOK ================== -->
<div class="modal fade" id="filterModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
          <img src="/WEB_PPN/asset/img/Logo.png" alt="Logo" width="90">
          <h5 class="fw-semibold m-0">Filter Logbook</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label class="fw-semibold mb-1">Keterangan</label>
        <select id="filterKeterangan" class="form-control border-success mb-3">
          <option value="">Pilih</option>
          <option>Lunas</option>
          <option>Belum Lunas</option>
        </select>

        <label class="fw-semibold mb-1">Nama Koordinator</label>
        <input type="text" class="form-control border-success mb-3" placeholder="Masukkan nama koordinator">

        <label class="fw-semibold mb-1">Nama Presenter</label>
        <input type="text" class="form-control border-success mb-3" placeholder="Masukkan nama presenter">

        <label class="fw-semibold mb-1">Nama Marketing</label>
        <input type="text" class="form-control border-success mb-3" placeholder="Masukkan nama marketing">

        <label class="fw-semibold mb-1">Alamat</label>
        <input type="text" class="form-control border-success mb-3" placeholder="Masukkan alamat">

        <label class="fw-semibold mb-1">Tanggal Transaksi</label>
        <div class="d-flex gap-2">
          <input type="date" class="form-control border-success mb-3">
          <input type="date" class="form-control border-success mb-3">
        </div>

        <div class="d-flex justify-content-between mt-4">
          <button id="btnTerapkanFilter" class="gradient-btn px-4 py-2">Terapkan</button>
          <button id="btnBersihkanFilter" class="outline-btn px-4 py-2">Bersihkan</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ================== MODAL ADD/EDIT LOGBOOK ================== -->
<div class="modal fade" id="logbookModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center mb-4">
          <img src="/WEB_PPN/asset/img/Logo.png" alt="Logo" style="height: 40px;">
          <div class="ms-3" style="border-left: 3px solid #333; padding-left: 15px;">
            <h4 class="mb-0 fw-bold" id="modalTitle">Logbook</h4>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="logbookForm" method="POST">
        <input type="hidden" name="id" id="logbookId">
        <input type="hidden" name="action" id="formAction" value="tambah">

        <label class="fw-semibold mb-1">Tanggal Transaksi</label>
        <input type="date" class="form-control border-success mb-3" name="tanggal" id="tanggal" required>

        <label class="fw-semibold mb-1">Alamat</label>
        <input type="text" class="form-control border-success mb-3" name="alamat" id="alamat" placeholder="Masukkan alamat" required>

        <div id="produkContainer">
          <div class="d-flex gap-2 align-items-end mb-2 produk-item">
            <div class="flex-fill">
              <label class="fw-semibold mb-1">Nama Produk</label>
              <input type="text" class="form-control border-success mb-3 produk-nama" name="produk_nama[]" placeholder="Masukkan nama produk" required>
            </div>
            <div class="flex-fill">
              <label class="fw-semibold mb-1">Jumlah</label>
              <input type="number" class="form-control border-success mb-3 produk-jumlah" name="produk_jumlah[]" placeholder="Masukkan jumlah" required>
            </div>
          </div>
        </div>

        <div class="text-center">
          <button type="button" id="btnTambahProduk" class="gradient-btn btn-sm mb-4 px-3 py-1">
            + Tambah Produk
          </button>
        </div>

        <label class="fw-semibold mb-1">Koordinator</label>
        <input type="text" class="form-control border-success mb-3" name="koordinator" id="koordinator" placeholder="Masukkan nama koordinator" required>

        <label class="fw-semibold mb-1">Cash/DP</label>
        <input type="number" class="form-control border-success mb-3 payment-input" name="cash_dp" id="cash_dp" placeholder="Masukkan nominal" value="0">

        <label class="fw-semibold mb-1">1-Minggu</label>
        <input type="number" class="form-control border-success mb-3 payment-input" name="satu_minggu" id="satu_minggu" placeholder="Masukkan nominal" value="0">

        <label class="fw-semibold mb-1">1-Bulan</label>
        <input type="number" class="form-control border-success mb-3 payment-input" name="satu_bulan" id="satu_bulan" placeholder="Masukkan nominal" value="0">

        <label class="fw-semibold mb-1">Jumlah Total</label>
        <input type="number" class="form-control border-success mb-3" name="jumlah_total" id="jumlah_total" placeholder="Nominal total" readonly required>

        <label class="fw-semibold mb-1">Presenter</label>
        <input type="text" class="form-control border-success mb-3" name="presenter" id="presenter" placeholder="Masukkan nama presenter">

        <label class="fw-semibold mb-1">Marketing</label>
        <input type="text" class="form-control border-success mb-3" name="marketing" id="marketing" placeholder="Masukkan nama marketing">

        <label class="fw-semibold mb-1">Komisi</label>
        <input type="number" class="form-control border-success mb-3" name="komisi" id="komisi" placeholder="Masukkan nominal komisi" value="0">

        <label class="fw-semibold mb-1">Keterangan</label>
        <select class="form-control border-success mb-3" name="keterangan" id="keterangan" required>
          <option>Lunas</option>
          <option>Belum Lunas</option>
        </select>

        <button type="submit" class="btn btn-success w-100">Simpan</button>
      </form>
    </div>
  </div>
</div>

<!-- MODAL HAPUS -->
<div class="modal fade" id="hapusModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-4 text-center">
      <img src="/WEB_PPN/asset/img/Logo.png" alt="Logo" width="120" class="mb-3">
      <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
      <h5 class="fw-semibold mt-3 mb-4">Apakah Anda yakin untuk menghapus logbook ini?</h5>
      <button class="btn text-white w-100 fw-semibold" id="btnKonfirmasiHapusLogbook"
        style="background-color: #C0392B; border-radius: 12px;">Hapus</button>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const logbookModal = new bootstrap.Modal(document.getElementById('logbookModal'));
const filterModal = new bootstrap.Modal(document.getElementById('filterModal'));
const hapusModal = new bootstrap.Modal(document.getElementById('hapusModal'));
const notifModal = new bootstrap.Modal(document.getElementById('notifModal'));
const notifIcon = document.getElementById('notifIcon');
const notifText = document.getElementById('notifText');

let deleteId = null;

// Chart Product
const ctx = document.getElementById('chartProduk');
const chartData = <?= $product_values ?>;
const chartLabels = <?= $product_labels ?>;

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: chartLabels,
    datasets: [{
      label: 'Jumlah Terjual',
      data: chartData,
      backgroundColor: ['#8C8CFF', '#FFB2A8', '#74D4E0', '#FFC56D'],
      borderRadius: 5,
      barThickness: 30
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false }
    },
    scales: {
      x: { grid: { display: false } },
      y: { beginAtZero: true, grid: { color: '#f2f2f2' } }
    }
  }
});

// Tambah produk
document.getElementById('btnTambahProduk').addEventListener('click', function() {
  const container = document.getElementById('produkContainer');
  const newItem = container.querySelector('.produk-item').cloneNode(true);
  newItem.querySelectorAll('input').forEach(el => el.value = '');
  container.appendChild(newItem);
});

// Auto calculate total
document.querySelectorAll('.payment-input').forEach(input => {
  input.addEventListener('input', calculateTotal);
});

function calculateTotal() {
  const cash = parseFloat(document.getElementById('cash_dp').value) || 0;
  const minggu = parseFloat(document.getElementById('satu_minggu').value) || 0;
  const bulan = parseFloat(document.getElementById('satu_bulan').value) || 0;
  document.getElementById('jumlah_total').value = cash + minggu + bulan;
}

// Submit form
document.getElementById('logbookForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  const action = document.getElementById('formAction').value;
  const url = action === 'tambah' ? '../action/tambah_logbook.php' : '../action/ubah_logbook.php';
  
  try {
    const response = await fetch(url, {
      method: 'POST',
      body: formData
    });
    
    const result = await response.json();
    
    logbookModal.hide();
    
    if (result.success) {
      showNotif(true, result.message);
      setTimeout(() => window.location.reload(), 1500);
    } else {
      showNotif(false, result.message);
    }
  } catch (error) {
    showNotif(false, 'Error: ' + error.message);
  }
});

// Edit logbook
function editLogbook(id) {
  fetch(`../action/get_logbook.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const d = data.data;
        
        document.getElementById('logbookId').value = d.id;
        document.getElementById('formAction').value = 'edit';
        document.getElementById('modalTitle').textContent = 'Edit Logbook';
        document.getElementById('tanggal').value = d.tanggal;
        document.getElementById('koordinator').value = d.koordinator;
        document.getElementById('alamat').value = d.alamat;
        document.getElementById('cash_dp').value = d.cash_dp;
        document.getElementById('satu_minggu').value = d.satu_minggu;
        document.getElementById('satu_bulan').value = d.satu_bulan;
        document.getElementById('jumlah_total').value = d.jumlah_total;
        document.getElementById('presenter').value = d.presenter || '';
        document.getElementById('marketing').value = d.marketing || '';
        document.getElementById('komisi').value = d.komisi;
        document.getElementById('keterangan').value = d.keterangan;
        
        // Load products
        const container = document.getElementById('produkContainer');
        container.innerHTML = '';
        d.products.forEach(p => {
          const item = document.createElement('div');
          item.className = 'd-flex gap-2 align-items-end mb-2 produk-item';
          item.innerHTML = `
            <div class="flex-fill">
              <label class="fw-semibold mb-1">Nama Produk</label>
              <input type="text" class="form-control border-success mb-3 produk-nama" name="produk_nama[]" value="${p.nama}" required>
            </div>
            <div class="flex-fill">
              <label class="fw-semibold mb-1">Jumlah</label>
              <input type="number" class="form-control border-success mb-3 produk-jumlah" name="produk_jumlah[]" value="${p.jumlah}" required>
            </div>
          `;
          container.appendChild(item);
        });
        
        logbookModal.show();
      }
    });
}

// Reset form
function resetForm() {
  document.getElementById('logbookForm').reset();
  document.getElementById('logbookId').value = '';
  document.getElementById('formAction').value = 'tambah';
  document.getElementById('modalTitle').textContent = 'Tambah Logbook';
  document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
  
  const container = document.getElementById('produkContainer');
  const items = container.querySelectorAll('.produk-item');
  items.forEach((item, index) => {
    if (index > 0) item.remove();
  });
}

// Delete logbook
function deleteLogbook(id) {
  deleteId = id;
  hapusModal.show();
}

document.getElementById('btnKonfirmasiHapusLogbook').addEventListener('click', () => {
  if (deleteId) {
    window.location.href = `logbook.php?action=delete&id=${deleteId}`;
  }
});

// Show notification
function showNotif(success, message) {
  if (success) {
    notifIcon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
  } else {
    notifIcon.className = 'bi bi-x-circle-fill text-danger fs-1 mb-3';
  }
  notifText.textContent = message;
  notifModal.show();
  setTimeout(() => notifModal.hide(), 2000);
}

// Auto-hide alerts
setTimeout(() => {
  document.querySelectorAll('.alert').forEach(alert => {
    alert.classList.remove('show');
  });
}, 5000);

// Set default date
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
});
</script>

</body>
</html>