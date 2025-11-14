<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Produk - PPN</title>
  
  <!-- Favicon -->
  <link href="/WEB_PPN/asset/img/LogoIco.ico" rel="icon">

  <!-- Google Fonts - Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="/WEB_PPN/asset/style/style_admin.css">

  <style>
    /* === Global Poppins Font === */
    * {
      font-family: 'Poppins', sans-serif;
    }

    body {
      font-family: 'Poppins', sans-serif;
      font-weight: 400;
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
    }

    p {
      font-family: 'Poppins', sans-serif;
      font-weight: 400;
    }

    button {
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
    }

    span {
      font-family: 'Poppins', sans-serif;
      font-weight: 400;
    }

    label {
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
    }

    input, textarea, select {
      font-family: 'Poppins', sans-serif;
      font-weight: 400;
    }

    .fw-semibold {
      font-weight: 600 !important;
    }

    .fw-bold {
      font-weight: 700 !important;
    }

    /* === Modal Styles === */
    .modal-content {
      border-radius: 20px;
      border: none;
      font-family: 'Poppins', sans-serif;
    }
    
    .modal-header {
      border: none;
      padding-bottom: 0;
      font-family: 'Poppins', sans-serif;
    }

    .modal-body input[type="text"],
    .modal-body input[type="number"],
    .modal-body textarea,
    .modal-body select {
      border: 1px solid #E3E3E3;
      border-radius: 10px;
      padding: 8px 12px;
      font-size: 14px;
      outline: none;
      width: 100%;
      font-family: 'Poppins', sans-serif;
      font-weight: 400;
    }

    .modal-body label {
      font-weight: 500;
      margin-top: 10px;
      font-family: 'Poppins', sans-serif;
    }

    .gradient-btn {
      background: linear-gradient(90deg, #4E8E55 0%, #B3D134 100%);
      border: none;
      color: #fff;
      border-radius: 10px;
      font-weight: 600;
      transition: 0.3s;
      font-family: 'Poppins', sans-serif;
    }

    .gradient-btn:hover {
      opacity: 0.9;
    }

    .outline-btn {
      border: 2px solid #4E8E55;
      color: #4E8E55;
      border-radius: 10px;
      font-weight: 600;
      background: #fff;
      transition: 0.3s;
      font-family: 'Poppins', sans-serif;
    }

    .outline-btn:hover {
      background: #4E8E55;
      color: #fff;
    }

    .notif-card {
      background: #fff;
      animation: fadeScale 0.3s ease;
      font-family: 'Poppins', sans-serif;
    }

    @keyframes fadeScale {
      from {opacity: 0; transform: scale(0.9);}
      to {opacity: 1; transform: scale(1);}
    }

    .shadow {
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .upload-box {
      background: #F2F6F2;
      border-radius: 15px;
      height: 130px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      color: #A3A3A3;
      font-size: 14px;
      border: 1px dashed #C9C9C9;
      font-family: 'Poppins', sans-serif;
    }

    .switch {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 10px;
      font-family: 'Poppins', sans-serif;
    }

    /* Checkbox kecil */
    .form-check-input {
      width: 16px;
      height: 16px;
    }

    .form-check-label {
      margin-bottom: 0;
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
    }

    .header-section {
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
    }

    .search-box {
      font-family: 'Poppins', sans-serif;
    }

    .search-box input {
      font-family: 'Poppins', sans-serif;
      font-weight: 400;
    }

    .search-box input::placeholder {
      font-family: 'Poppins', sans-serif;
      font-weight: 400;
    }

    .product-card {
      font-family: 'Poppins', sans-serif;
    }

    .product-info span {
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
    }

    .btn {
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
    }

    .text-center {
      font-family: 'Poppins', sans-serif;
    }

  </style>
</head>
<body>

<?php include('../template/sidebar.php'); ?>

<!-- MAIN CONTENT -->
<div class="main">
  <div class="header-section">Manajemen Produk</div>

  <!-- SEARCH BAR & BUTTONS -->
  <div class="search-bar-top">
    <div class="left-col">
      <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Search">
      </div>
      <button id="btnFilter" class="search-btn" style="background-color: #4E8E55;"><i class="bi bi-funnel"></i></button>
    </div>
    
    <div class="right-col">
      <button id="btnTambah" class="search-btn" style="background-color: #4E8E55;"><i class="bi bi-plus"></i></button>
    </div>
  </div>

  <!-- PRODUCT LIST -->
  <?php
  $products = [
    ["name" => "Maxi-D", "img" => "Produk1.png"],
    ["name" => "TerraNusa Silika", "img" => "produk2.png"],
    ["name" => "TeraNusa Probiotik", "img" => "produk3.png"],
    ["name" => "TeraTusa Hama", "img" => "produk4.png"],
    ["name" => "Maxi-B", "img" => "produk5.png"]
  ];
  
  foreach ($products as $p) {
    echo "
    <div class='product-card'>
      <div class='product-info'>
        <img src='/WEB_PPN/asset/img/{$p['img']}' alt='{$p['name']}'>
        <span class='fw-semibold'>{$p['name']}</span>
      </div>
      <div class='action-btns'>
        <button class='btn-delete'><i class='bi bi-trash'></i></button>
        <button class='btn-edit'><i class='bi bi-pencil'></i></button>
      </div>
    </div>";
  }
  ?>

  <!-- PAGINATION -->
  <div class="d-flex justify-content-center mt-4 gap-2">
    <button class="btn btn-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
      <i class="bi bi-chevron-left" style="color: white;"></i>
    </button>
    <button class="btn btn-success rounded-circle d-flex align-items-center justify-content-center fw-semibold text-white" style="width: 32px; height: 32px;">
      1
    </button>
    <button class="btn btn-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
      <i class="bi bi-chevron-right" style="color: white;"></i>
    </button>
  </div>
</div>


<!-- ========================= MODALS ========================= -->

<!-- MODAL TAMBAH PRODUK -->
<div class="modal fade" id="produkModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="d-flex align-items-center gap-2">
          <img src="../../asset/img/logo.png" alt="Logo" width="100">
          <div class="vr" style="height: 35px; width: 2px; background-color: #000;"></div>
          <h5 class="fw-bold mb-0">Produk</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <label class="fw-semibold mb-1">Kategori Produk</label>
        <input type="text" class="form-control border-success mb-3" id="kategoriProduk" placeholder="Masukkan kategori produk">

        <label class="fw-semibold mb-1">Jenis Tanaman</label>
        <input type="text" class="form-control border-success mb-3" id="jenisTanaman" placeholder="Masukkan jenis tanaman. Pisahkan dengan ';' (Eg: Jagung;Padi)">

        <label class="fw-semibold mb-1">Nama Produk</label>
        <input type="text" class="form-control border-success mb-3" id="namaProduk" placeholder="Masukkan nama produk">

        <label class="fw-semibold mb-1">Deskripsi</label>
        <textarea class="form-control border-success mb-3" id="deskripsi" rows="2" placeholder="Masukkan deskripsi"></textarea>

        <label class="fw-semibold mb-1">Penjelasan Produk</label>
        <textarea class="form-control border-success mb-3" id="penjelasan" rows="2" placeholder="Masukkan deskripsi"></textarea>

        <label class="fw-semibold mb-1">Manfaat & Keunggulan</label>
        <textarea class="form-control border-success mb-3" id="manfaat" rows="2" placeholder="Masukkan deskripsi"></textarea>

        <label class="fw-semibold mb-1">Aturan Pakai</label>
        <textarea class="form-control border-success mb-3" id="aturan" rows="2" placeholder="Masukkan deskripsi"></textarea>

        <label class="fw-semibold mb-1">Keistimewaan</label>
        <textarea class="form-control border-success mb-3" id="keistimewaan" rows="2" placeholder="Masukkan deskripsi"></textarea>

        <label class="fw-semibold mb-1">Petunjuk Penyimpanan</label>
        <textarea class="form-control border-success mb-3" id="penyimpanan" rows="2" placeholder="Masukkan deskripsi"></textarea>

        <label class="fw-semibold mb-1">Stok</label>
        <input class="form-control border-success mb-3" type="number" id="stok" placeholder="Jumlah">

        <label class="fw-semibold mb-1">Unggah Gambar</label>
        <input type="file" class="form-control border-success mb-3" id="gambarInput">

        <div class="form-check mt-2 mb-4 d-flex align-items-center gap-2">
          <input class="form-check-input" type="checkbox" id="tampilkanInput">
          <label for="tampilkanInput" class="form-check-label fw-semibold">Tampilkan</label>
        </div>

        <button id="btnSimpan" class="w-100 mt-4 gradient-btn py-2">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL FILTER PRODUK -->
<div class="modal fade" id="filterModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="d-flex align-items-center gap-2">
          <img src="../../asset/img/logo.png" alt="Logo" width="100">
          <div class="vr" style="height: 35px; width: 2px; background-color: #000;"></div>
          <h5 class="fw-bold mb-0">Filter Produk</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <label class="fw-semibold mb-1">Kategori</label>
        <select class="form-control border-success mb-3" id="filterKategori">
          <option value="">Pilih Kategori</option>
          <option>Pupuk Cair</option>
          <option>Pupuk Padat</option>
          <option>Obat Tanaman</option>
        </select>

        <div class="d-flex justify-content-between mt-4">
          <button id="btnTerapkan" class="gradient-btn px-4 py-2">Terapkan</button>
          <button id="btnBersihkan" class="outline-btn px-4 py-2">Bersihkan</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL HAPUS -->
<div class="modal fade" id="hapusModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-4 text-center">
      <img src="/WEB_PPN/asset/img/Logo.png" alt="Logo" width="120" class="mb-3">
      <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
      <h5 class="fw-semibold mt-3 mb-4">Apakah Anda yakin untuk menghapus produk ini?</h5>
      <button class="btn text-white w-100 fw-semibold" id="btnKonfirmasiHapus"
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
  const produkModal = new bootstrap.Modal(document.getElementById('produkModal'));
  const filterModal = new bootstrap.Modal(document.getElementById('filterModal'));
  const hapusModal = new bootstrap.Modal(document.getElementById('hapusModal'));
  const notifModal = new bootstrap.Modal(document.getElementById('notifModal'));
  const notifText = document.getElementById('notifText');
  const notifIcon = document.getElementById('notifIcon');

  // Tambah Produk
  document.getElementById('btnTambah').addEventListener('click', () => {
    produkModal.show();
  });

  // Tombol Edit Produk
  document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', () => {
      produkModal.show();
    });
  });

  // Filter Produk
  document.getElementById('btnFilter').addEventListener('click', () => {
    filterModal.show();
  });

  // Simpan Produk
  document.getElementById('btnSimpan').addEventListener('click', () => {
    produkModal.hide();
    setTimeout(() => {
      const isSuccess = Math.random() > 0.3;
      if (isSuccess) {
        notifIcon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
        notifText.textContent = "Produk berhasil disimpan!";
      } else {
        notifIcon.className = 'bi bi-x-circle-fill text-danger fs-1 mb-3';
        notifText.textContent = "Gagal menyimpan produk!";
      }
      notifModal.show();
      setTimeout(() => notifModal.hide(), 1600);
    }, 400);
  });

  // Tombol Hapus
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', () => {
      hapusModal.show();
    });
  });

  // Konfirmasi Hapus
  document.getElementById('btnKonfirmasiHapus').addEventListener('click', () => {
    hapusModal.hide();
    setTimeout(() => {
      notifIcon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
      notifText.textContent = "Produk berhasil dihapus!";
      notifModal.show();
      setTimeout(() => notifModal.hide(), 1500);
    }, 400);
  });

  // Filter Buttons
  document.getElementById('btnTerapkan').addEventListener('click', () => {
    filterModal.hide();
    setTimeout(() => {
      notifIcon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
      notifText.textContent = "Filter diterapkan!";
      notifModal.show();
      setTimeout(() => notifModal.hide(), 1500);
    }, 400);
  });

  document.getElementById('btnBersihkan').addEventListener('click', () => {
    document.getElementById('filterKategori').value = '';
    notifIcon.className = 'bi bi-x-circle-fill text-warning fs-1 mb-3';
    notifText.textContent = "Filter dibersihkan!";
    notifModal.show();
    setTimeout(() => notifModal.hide(), 1500);
  });
</script>

</body>
</html>
