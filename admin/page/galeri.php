<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galeri - PPN</title>
  
  <!-- Favicon -->
  <link href="/WEB_PPN/asset/img/LogoIco.ico" rel="icon">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="/WEB_PPN/asset/style/galeri_admin.css">
  
  <style>
    .gallery-card {
      position: relative;
      cursor: pointer;
      transition: transform 0.2s, outline 0.3s;
      border-radius: 12px;
      overflow: hidden;
      aspect-ratio: 16/9;
    }
    
    .gallery-card:hover {
      transform: scale(1.02);
    }
    
    .gallery-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      border-radius: 12px;
    }
    
    .check-icon {
      position: absolute;
      bottom: 10px;
      right: 10px;
      width: 32px;
      height: 32px;
      background-color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      pointer-events: none;
    }
    
    .check-icon i {
      font-size: 28px;
      color: #007bff;
    }
    
    .gallery-card[data-selected="true"] .check-icon {
      opacity: 1;
    }
    
    .gallery-card[data-selected="true"] {
      outline: 3px solid #007bff;
      outline-offset: -3px;
    }
  </style>
  
</head>
<body>

<?php include('../template/sidebar.php'); ?>

<!-- MAIN CONTENT -->
<div class="main">
  <div class="header-section">Galeri</div>

  <!-- FILTER TABS & BUTTONS -->
  <div class="search-bar-top">
    <div class="left-col">
      <div class="filter-tabs">
        <button class="btn-primary-tab" id="btnPilih">PILIH</button>
        <button class="btn-outline" id="btnPilihSemua">PILIH SEMUA</button>
      </div>
    </div>
    
    <div class="right-col d-flex gap-2">
      <button class="btn-action btn-tambah" id="btnTambah">
        TAMBAH
      </button>
      <button class="btn-action btn-hapus" id="btnHapus">
        HAPUS
      </button>
    </div>
  </div>

  <!-- GALLERY GRID -->
  <div class="gallery-grid">
    <?php 
    $galeri_images = ['Galeri1.png', 'Galeri2.png', 'Galeri3.png', 'Galeri4.png'];
    foreach($galeri_images as $img){
      if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/WEB_PPN/asset/img/' . $img)){
    ?>
    <div class="gallery-card" data-selected="false">
      <img src="/WEB_PPN/asset/img/<?php echo $img; ?>" alt="<?php echo $img; ?>">
      <div class="check-icon">
        <i class="bi bi-check-circle-fill"></i>
      </div>
    </div>
    <?php 
      }
    } 
    ?>
  </div>
</div>

<!-- ====================== -->
<!-- MODAL TAMBAH / EDIT -->
<div class="modal fade" id="galeriModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-4 border-0 shadow-sm">
      <!-- HEADER -->
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="d-flex align-items-center gap-2">
          <img src="/WEB_PPN/asset/img/logo.png" alt="Logo" width="100">
          <div class="vr" style="height: 35px; width: 2px; background-color: #000;"></div>
          <h5 class="fw-bold mb-0">Galeri</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- FORM -->
      <label class="fw-semibold mb-1">Judul</label>
      <input type="text" class="form-control border-success mb-3" placeholder="Masukkan Judul" id="judulInput">

      <label class="fw-semibold mb-1">Deskripsi</label>
      <textarea class="form-control border-success mb-3" placeholder="Masukkan Deskripsi" id="deskripsiInput" rows="3"></textarea>

      <label class="fw-semibold mb-1">Tanggal</label>
      <input type="date" class="form-control border-success mb-3" id="tanggalInput">

      <label class="fw-semibold mb-1">Unggah Gambar</label>
      <input type="file" class="form-control border-success mb-3" id="gambarInput">

      <div class="form-check mt-2 mb-4">
        <input class="form-check-input" type="checkbox" id="tampilkanInput">
        <label class="form-check-label">Tampilkan</label>
      </div>

      <button class="btn w-100 text-white fw-semibold" id="btnSimpan"
        style="background: linear-gradient(90deg, #4E8E55, #D6C72A); border-radius: 12px;">
        Simpan
      </button>
    </div>
  </div>
</div>

<!-- MODAL HAPUS -->
<div class="modal fade" id="hapusModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-4 text-center">
      <img src="/WEB_PPN/asset/img/logo.png" alt="Logo" width="120" class="mb-3">
      <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
      <h5 class="fw-semibold mt-3 mb-4">Apakah Anda yakin ingin menghapus data ini?</h5>
      <button class="btn text-white w-100 fw-semibold" id="btnKonfirmasiHapus"
        style="background-color: #C0392B; border-radius: 12px;">Hapus</button>
    </div>
  </div>
</div>

<!-- MODAL NOTIFIKASI -->
<div class="modal fade" id="notifModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content notif-card text-center p-4 rounded-4 border-0 shadow">
      <img src="/WEB_PPN/asset/img/logo.png" alt="Logo" width="90" class="mb-3">
      <i id="notifIcon" class="bi fs-1 mb-3"></i>
      <h5 id="notifText" class="fw-semibold"></h5>
    </div>
  </div>
</div>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  let isPilihMode = true;
  
  // Tabs - Mode PILIH
  document.getElementById('btnPilih').addEventListener('click', function() {
    isPilihMode = true;
    this.classList.remove('btn-outline'); 
    this.classList.add('btn-primary-tab');
    document.getElementById('btnPilihSemua').classList.remove('btn-primary-tab');
    document.getElementById('btnPilihSemua').classList.add('btn-outline');
    
    // Hapus semua seleksi saat kembali ke mode PILIH
    document.querySelectorAll('.gallery-card').forEach(card => {
      card.setAttribute('data-selected', 'false');
    });
  });
  
  // Tabs - Mode PILIH SEMUA
  document.getElementById('btnPilihSemua').addEventListener('click', function() {
    isPilihMode = false;
    this.classList.remove('btn-outline'); 
    this.classList.add('btn-primary-tab');
    document.getElementById('btnPilih').classList.remove('btn-primary-tab');
    document.getElementById('btnPilih').classList.add('btn-outline');
    
    // Pilih semua gambar sekaligus
    document.querySelectorAll('.gallery-card').forEach(card => {
      card.setAttribute('data-selected', 'true');
    });
  });

  // Klik pada gallery card untuk toggle selection (hanya di mode PILIH)
  document.querySelectorAll('.gallery-card').forEach(card => {
    card.addEventListener('click', function(e) {
      if (isPilihMode) {
        const isSelected = this.getAttribute('data-selected') === 'true';
        this.setAttribute('data-selected', !isSelected);
      }
    });
  });

  // Modals
  const galeriModal = new bootstrap.Modal(document.getElementById('galeriModal'));
  const hapusModal = new bootstrap.Modal(document.getElementById('hapusModal'));
  const notifModal = new bootstrap.Modal(document.getElementById('notifModal'));
  const notifText = document.getElementById('notifText');
  const notifIcon = document.getElementById('notifIcon');

  // Tombol Tambah
  document.getElementById('btnTambah').addEventListener('click', () => {
    document.getElementById('judulInput').value = '';
    document.getElementById('deskripsiInput').value = '';
    document.getElementById('tanggalInput').value = '';
    document.getElementById('gambarInput').value = '';
    document.getElementById('tampilkanInput').checked = false;
    galeriModal.show();
  });

  // Simpan Galeri
  document.getElementById('btnSimpan').addEventListener('click', () => {
    galeriModal.hide();
    setTimeout(() => {
      const isSuccess = Math.random() > 0.3; // simulasi 70% berhasil
      if (isSuccess) {
        notifIcon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
        notifText.textContent = "Galeri berhasil disimpan!";
      } else {
        notifIcon.className = 'bi bi-x-circle-fill text-danger fs-1 mb-3';
        notifText.textContent = "Gagal menyimpan galeri!";
      }
      notifModal.show();
      setTimeout(() => notifModal.hide(), 1600);
    }, 400);
  });

  // Tombol Hapus - Validasi seleksi gambar
  document.getElementById('btnHapus').addEventListener('click', () => {
    const selectedCards = document.querySelectorAll('.gallery-card[data-selected="true"]');
    if (selectedCards.length === 0) {
      notifIcon.className = 'bi bi-exclamation-circle-fill text-warning fs-1 mb-3';
      notifText.textContent = "Pilih gambar terlebih dahulu!";
      notifModal.show();
      setTimeout(() => notifModal.hide(), 1500);
      return;
    }
    hapusModal.show();
  });

  // Konfirmasi Hapus
  document.getElementById('btnKonfirmasiHapus').addEventListener('click', () => {
    hapusModal.hide();
    setTimeout(() => {
      // Hapus gambar yang terseleksi
      document.querySelectorAll('.gallery-card[data-selected="true"]').forEach(card => {
        card.remove();
      });
      
      notifIcon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
      notifText.textContent = "Data galeri berhasil dihapus!";
      notifModal.show();
      setTimeout(() => notifModal.hide(), 1500);
    }, 400);
  });
</script>

</body>
</html>