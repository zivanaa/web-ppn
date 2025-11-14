<?php
require_once __DIR__ . '/../auth_check.php';
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
  
</head>

<body>
  <div class="d-flex">
    <?php include('../template/sidebar.php'); ?>

    <div class="main w-100">
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
            <h3>4000</h3>
          </div>
        </div>
        <div class="col-md-3 col-lg-3">
          <div class="card-stat center">
            <p class="label">Pendapatan Bulan Ini</p>
            <h3>Rp. 2xx.xxx.x</h3>
          </div>
        </div>
        <div class="col-md-3 col-lg-3">
          <div class="card-stat center">
            <p class="label">Pendapatan Total</p>
            <h3>Rp. 2xx.xxx.x</h3>
          </div>
        </div>
      </div>

      <!-- Search & Button -->
      <div class="search-bar-top mb-3">
        <div class="d-flex gap-2">
          <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Cari logbook...">
          </div>
          <button class="btn-filter"><i class="bi bi-funnel"></i></button>
          <button class="btn-sort"><i class="bi bi-sort-down"></i></button>
        </div>
        <button class="btn-add"><i class="bi bi-plus"></i></button>
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
                <th>TNA</th>
                <th>TNH</th>
                <th>TNS</th>
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
            <tbody>
              <tr>
                <td>20/10/2025</td>
                <td>Fauzan</td>
                <td>Purwokerto Selatan, Jalan Kucing</td>
                <td>3</td>
                <td>3</td>
                <td></td>
                <td>250.000</td>
                <td>200.000</td>
                <td>200.000</td>
                <td>450.000</td>
                <td>Juned</td>
                <td>Kohar</td>
                <td>45.000</td>
                <td>Lunas</td>
                <td>
                  <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                  <button class="btn btn-warning btn-sm text-white"><i class="bi bi-pencil"></i></button>
                </td>
              </tr>
              <tr>
                <td>19/10/2025</td>
                <td>Chandra</td>
                <td>Tegal Barat, Jalanin dulu</td>
                <td></td>
                <td>2</td>
                <td></td>
                <td>50.000</td>
                <td>50.000</td>
                <td>50.000</td>
                <td>100.000</td>
                <td>Budi</td>
                <td>Kohar</td>
                <td>10.000</td>
                <td>Lunas</td>
                <td>
                  <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                  <button class="btn btn-warning btn-sm text-white"><i class="bi bi-pencil"></i></button>
                </td>
              </tr>
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
    </div> <!-- end .main -->

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
          <input type="date"class="form-control border-success mb-3">
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
        <div class="d-flex align-items-center gap-2">
          <img src="/WEB_PPN/asset/img/Logo.png" alt="Logo" width="90">
          <h5 class="fw-semibold m-0">Logbook</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <label>Tanggal Transaksi</label>
        <input type="date" class="form-control mb-2">

        <label>Alamat</label>
        <input type="text" class="form-control mb-2" placeholder="Masukkan alamat">

        <div id="produkContainer">
          <div class="d-flex gap-2 align-items-end mb-2 produk-item">
            <div class="flex-fill">
              <label>Nama Produk</label>
              <input type="text" class="form-control" placeholder="Masukkan nama produk">
            </div>
            <div class="flex-fill">
              <label>Jumlah</label>
              <input type="number" class="form-control" placeholder="Masukkan jumlah">
            </div>
          </div>
        </div>

        <!-- Tombol tambah produk di tengah -->
        <div class="text-center">
          <button id="btnTambahProduk" class="gradient-btn btn-sm mb-4 px-3 py-1">
            + Tambah Produk
          </button>
        </div>

        <label>Koordinator</label>
        <input type="text" class="form-control mb-2" placeholder="Masukkan nama koordinator">

        <label>Cash/DP</label>
        <input type="number" class="form-control mb-2" placeholder="Masukkan nominal">

        <label>1-Minggu</label>
        <input type="number" class="form-control mb-2" placeholder="Masukkan nominal">

        <label>1-Bulan</label>
        <input type="number" class="form-control mb-2" placeholder="Masukkan nominal">

        <label>Jumlah Total</label>
        <input type="number" class="form-control mb-2" placeholder="Nominal total">

        <label>Presenter</label>
        <input type="text" class="form-control mb-2" placeholder="Masukkan nama presenter">

        <label>Marketing</label>
        <input type="text" class="form-control mb-2" placeholder="Masukkan nama marketing">

        <label>Komisi</label>
        <input type="number" class="form-control mb-3" placeholder="Masukkan nominal komisi">

        <label>Keterangan</label>
        <select class="form-select mb-3">
          <option>Lunas</option>
          <option>Belum Lunas</option>
        </select>

        <button id="btnSimpanLogbook" class="gradient-btn w-100 py-2">Simpan</button>
      </div>
    </div>
  </div>
</div>


<!-- MODAL FILTER LOGBOOK -->
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
        <label>Keterangan</label>
        <select id="filterKeterangan" class="form-select mb-2">
          <option value="">Pilih</option>
          <option>Lunas</option>
          <option>Belum Lunas</option>
        </select>

        <label>Nama Koordinator</label>
        <input type="text" class="form-control mb-2" placeholder="Masukkan nama koordinator">

        <label>Nama Presenter</label>
        <input type="text" class="form-control mb-2" placeholder="Masukkan nama presenter">

        <label>Nama Marketing</label>
        <input type="text" class="form-control mb-2" placeholder="Masukkan nama marketing">

        <label>Alamat</label>
        <input type="text" class="form-control mb-2" placeholder="Masukkan alamat">

        <label>Tanggal Transaksi</label>
        <div class="d-flex gap-2">
          <input type="date" class="form-control">
          <input type="date" class="form-control">
        </div>

        <div class="d-flex justify-content-between mt-4">
          <button id="btnTerapkanFilter" class="gradient-btn px-4 py-2">Terapkan</button>
          <button id="btnBersihkanFilter" class="outline-btn px-4 py-2">Bersihkan</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL ADD/EDIT LOGBOOK -->
<div class="modal fade" id="logbookModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center mb-4">
                <img src="/WEB_PPN/asset/img/Logo.png" alt="Logo" style="height: 40px;">
            <div class="ms-3" style="border-left: 3px solid #333; padding-left: 15px;">
                <h4 class="mb-0 fw-bold">Logbook</h4>
            </div>
        </div>
      </div>

      <div class="modal-body">
        <label class="fw-semibold mb-1">Tanggal Transaksi</label>
        <input type="date" class="form-control border-success mb-3" >

        <label class="fw-semibold mb-1">Alamat</label>
        <input type="text" class="form-control border-success mb-3" placeholder="Masukkan alamat">

        <div id="produkContainer">
          <div class="d-flex gap-2 align-items-end mb-2 produk-item">
            <div class="flex-fill">
              <label class="fw-semibold mb-1">Nama Produk</label>
              <input type="text" class="form-control border-success mb-3" placeholder="Masukkan nama produk">
            </div>
            <div class="flex-fill">
              <label class="fw-semibold mb-1">Jumlah</label>
              <input type="number" class="form-control border-success mb-3"  placeholder="Masukkan jumlah">
            </div>
          </div>
        </div>

        <button id="btnTambahProduk" class="btn btn-success btn-sm mb-3">
          + Tambah Produk
        </button>

        <label class="fw-semibold mb-1">Koordinator</label>
        <input type="text" class="form-control border-success mb-3"  placeholder="Masukkan nama koordinator">

        <label class="fw-semibold mb-1">Cash/DP</label>
        <input type="number" class="form-control border-success mb-3"  placeholder="Masukkan nominal">

        <label class="fw-semibold mb-1">1-Minggu</label>
        <input type="number" class="form-control border-success mb-3"  placeholder="Masukkan nominal">

        <label class="fw-semibold mb-1">1-Bulan</label>
        <input type="number" class="form-control border-success mb-3"  placeholder="Masukkan nominal">

        <label class="fw-semibold mb-1">Jumlah Total</label>
        <input type="number" class="form-control border-success mb-3"  placeholder="Nominal total">

        <label class="fw-semibold mb-1" >Presenter</label>
        <input type="text" class="form-control border-success mb-3" placeholder="Masukkan nama presenter">

        <label class="fw-semibold mb-1">Marketing</label>
        <input type="text" class="form-control border-success mb-3"  placeholder="Masukkan nama marketing">

        <label class="fw-semibold mb-1">Komisi</label>
        <input type="number" class="form-control border-success mb-3"  placeholder="Masukkan nominal komisi">

        <label class="fw-semibold mb-1">Keterangan</label>
        <select class="form-control border-success mb-3" >
          <option>Lunas</option>
          <option>Belum Lunas</option>
        </select>

        <button class="btn btn-success w-100">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const logbookModal = new bootstrap.Modal(document.getElementById('logbookModal'));
const filterModal = new bootstrap.Modal(document.getElementById('filterModal'));
const analitikModal = new bootstrap.Modal(document.getElementById('analitikModal'));

// Tombol tambah dan edit
document.querySelector('.btn-add').addEventListener('click', () => logbookModal.show());
document.querySelectorAll('.btn-warning').forEach(btn => btn.addEventListener('click', () => logbookModal.show()));

// Tombol filter
document.querySelector('.btn-filter').addEventListener('click', () => filterModal.show());

// Tambah produk baru di form
document.getElementById('btnTambahProduk').addEventListener('click', () => {
  const container = document.getElementById('produkContainer');
  const div = document.createElement('div');
  div.classList.add('d-flex','gap-2','align-items-end','mb-2','produk-item');
  div.innerHTML = `
    <div class="flex-fill">
      <label>Nama Produk</label>
      <input type="text" class="form-control" placeholder="Masukkan nama produk">
    </div>
    <div class="flex-fill">
      <label>Jumlah</label>
      <input type="number" class="form-control" placeholder="Masukkan jumlah">
    </div>
  `;
  container.appendChild(div);
});

// === Ubah tulisan "Rekap Bulanan" jadi tombol kecil kuning ===
const chartCard = document.querySelector('.card-stat');
const labelOld = chartCard.querySelector('.chart-label');
if (labelOld) labelOld.remove(); // hapus tulisan lama

const searchBtn = document.createElement('button');
searchBtn.className = 'btn-analitik-btn';
searchBtn.innerHTML = '<i class="bi bi-search"></i>';
chartCard.style.position = 'relative';
chartCard.appendChild(searchBtn);
searchBtn.addEventListener('click', () => analitikModal.show());

// Chart di modal analitik
const ctxA = document.getElementById('chartAnalitik');
new Chart(ctxA, {
  type: 'bar',
  data: {
    labels: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
    datasets: [{
      label: 'TNH',
      data: [10,20,25,35,30,50,20,15,10,45,65,30],
      backgroundColor: '#8C8CFF'
    }]
  },
  options: {
    responsive: true,
    scales: { y: { beginAtZero: true } }
  }
});
</script>




  </div> <!-- end .d-flex -->

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


  <!-- Chart Script -->
  <script>
    const ctx = document.getElementById('chartProduk');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Oktober'],
        datasets: [
          { label: 'TNS', data: [25], backgroundColor: '#8C8CFF', borderRadius: 5, barThickness: 30 },
          { label: 'TNT', data: [30], backgroundColor: '#FFB2A8', borderRadius: 5, barThickness: 30 },
          { label: 'TNH', data: [10], backgroundColor: '#74D4E0', borderRadius: 5, barThickness: 30 },
          { label: 'TNB', data: [40], backgroundColor: '#FFC56D', borderRadius: 5, barThickness: 30 }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'bottom',
            labels: {
              usePointStyle: true,
              pointStyle: 'circle',
              boxWidth: 8,   // lebar buletan legend (default 40)
              boxHeight: 8, 
              padding: 10,
              color: '#555',
              font: { size: 13 }
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.7)',
            titleColor: '#fff',
            bodyColor: '#fff',
            cornerRadius: 6
          }
        },
        scales: {
          x: { grid: { display: false }, ticks: { color: '#666', font: { size: 14 } } },
          y: { beginAtZero: true, grid: { color: '#f2f2f2' }, ticks: { stepSize: 5, color: '#666' } }
        },
        layout: { padding: 10 }
      }
    });

    const hapusModal = new bootstrap.Modal(document.getElementById('hapusModal'));
const notifModal = new bootstrap.Modal(document.getElementById('notifModal'));
const notifIcon = document.getElementById('notifIcon');
const notifText = document.getElementById('notifText');

// Tombol Hapus Logbook
document.querySelectorAll('.btn-danger').forEach(btn => {
  btn.addEventListener('click', () => {
    hapusModal.show();
  });
});

// Konfirmasi Hapus
document.getElementById('btnKonfirmasiHapusLogbook').addEventListener('click', () => {
  hapusModal.hide();
  setTimeout(() => {
    notifIcon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
    notifText.textContent = "Logbook berhasil dihapus!";
    notifModal.show();
    setTimeout(() => notifModal.hide(), 1500);
  }, 400);
});

// Filter Buttons (untuk modal filter logbook)
document.getElementById('btnTerapkanFilter').addEventListener('click', () => {
  filterModal.hide();
  setTimeout(() => {
    notifIcon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
    notifText.textContent = "Filter diterapkan!";
    notifModal.show();
    setTimeout(() => notifModal.hide(), 1500);
  }, 400);
});

document.getElementById('btnBersihkanFilter').addEventListener('click', () => {
  document.getElementById('filterKeterangan').value = '';
  notifIcon.className = 'bi bi-x-circle-fill text-warning fs-1 mb-3';
  notifText.textContent = "Filter dibersihkan!";
  notifModal.show();
  setTimeout(() => notifModal.hide(), 1500);
});

// Tombol Simpan Logbook
document.getElementById('btnSimpanLogbook').addEventListener('click', () => {
  // Sembunyikan modal logbook
  logbookModal.hide();

  // Simulasi delay penyimpanan
  setTimeout(() => {
    const isSuccess = Math.random() > 0.3; // 70% chance berhasil

    if (isSuccess) {
      notifIcon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
      notifText.textContent = "Logbook berhasil disimpan!";
    } else {
      notifIcon.className = 'bi bi-x-circle-fill text-danger fs-1 mb-3';
      notifText.textContent = "Gagal menyimpan logbook!";
    }

    notifModal.show();
    setTimeout(() => notifModal.hide(), 1600);
  }, 400);
});

  </script>
</body>
</html>
