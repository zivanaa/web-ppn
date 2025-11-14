<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Testimoni - PPN</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../asset/style/ulasan.css">
</head>

<body>
  <div class="d-flex">
  <?php include('../template/sidebar.php'); ?>

    <div class="main">
      <div class="header-section">Testimoni</div>

      <!-- SEARCH BAR -->
      <div class="search-bar-top">
        <div class="left-col">
          <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search testimoni...">
          </div>
          <button class="search-btn" style="background-color: #4E8E55;"><i class="bi bi-sort-down"></i></button>
        </div>
        <div class="right-col">
          <button class="search-btn" style="background-color: #4E8E55;"><i class="bi bi-plus"></i></button>
        </div>
      </div>

      <!-- TABEL TESTIMONI -->
      <div class="table-responsive">
        <table class="table align-middle table-bordered">
          <thead>
            <tr class="text-center">
              <th>Nama Pembeli</th>
              <th>Nama Produk</th>
              <th>Alamat</th>
              <th>Foto</th>
              <th>Review</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Adi Tani</td>
              <td>Maxi-D</td>
              <td>Kab. Bandung</td>
              <td class="text-center">
                <img src="../../asset/img/Testimoni1.png" alt="Foto Adi">
              </td>
              <td>Setelah pakai Maxi-D, tanaman jagung saya tumbuh lebih cepat dan subur!</td>
              <td class="text-success fw-semibold text-center">Ditampilkan</td>
              <td class="text-center">
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <button class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-trash"></i>
                  </button>
                  <button class="btn btn-warning btn-sm rounded-circle d-flex align-items-center justify-content-center text-white">
                    <i class="bi bi-pencil"></i>
                  </button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Rina Agustina</td>
              <td>TeraNusa Silika</td>
              <td>Sleman, Yogyakarta</td>
              <td class="text-center">
                <img src="../../asset/img/Testimoni2.png" alt="Foto Rina">
              </td>
              <td>Daun padi jadi lebih kuat, nggak gampang rebah. Keren banget produknya!</td>
              <td class="text-danger fw-semibold text-center">Disembunyikan</td>
              <td class="text-center">
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <button class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-trash"></i>
                  </button>
                  <button class="btn btn-warning btn-sm rounded-circle d-flex align-items-center justify-content-center text-white">
                    <i class="bi bi-pencil"></i>
                  </button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Bambang</td>
              <td>TeraNusa Probiotik</td>
              <td>Sidoarjo, Jawa Timur</td>
              <td class="text-center">
                <img src="../../asset/img/Testimoni3.png" alt="Foto Bambang">
              </td>
              <td>Bagus buat padi, tapi kemasannya agak susah dibuka!</td>
              <td class="text-danger fw-semibold text-center">Disembunyikan</td>
              <td class="text-center">
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <button class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-trash"></i>
                  </button>
                  <button class="btn btn-warning btn-sm rounded-circle d-flex align-items-center justify-content-center text-white">
                    <i class="bi bi-pencil"></i>
                  </button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Sari Pratama</td>
              <td>TeraTusa Hama</td>
              <td>Cilacap, Jawa Tengah</td>
              <td class="text-center">
                <img src="../../asset/img/Testimoni4.png" alt="Foto Sari">
              </td>
              <td>Produknya bagus tapi agak susah didapat di toko sekitar sini.</td>
              <td class="text-danger fw-semibold text-center">Disembunyikan</td>
              <td class="text-center">
                <div class="d-flex justify-content-center align-items-center gap-2">
                  <button class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-trash"></i>
                  </button>
                  <button class="btn btn-warning btn-sm rounded-circle d-flex align-items-center justify-content-center text-white">
                    <i class="bi bi-pencil"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="d-flex justify-content-center mt-4 gap-2">
        <button class="btn btn-warning rounded-circle d-flex align-items-center justify-content-center">
          <i class="bi bi-chevron-left text-white" ></i>
        </button>
        <button class="btn btn-success rounded-circle d-flex align-items-center justify-content-center fw-semibold text-white">
          1
        </button>
        <button class="btn btn-warning rounded-circle d-flex align-items-center justify-content-center" style>
          <i class="bi bi-chevron-right text-white"></i>
        </button>
      </div>
    </div>
  </div>

<!-- ======================
MODAL TAMBAH / EDIT TESTIMONI
====================== -->
<div class="modal fade" id="testimoniModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4 rounded-4 border-0 shadow-sm">
      <!-- HEADER -->
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="d-flex align-items-center gap-2">
          <img src="../../asset/img/logo.png" alt="Logo" width="100">
          <div class="vr" style="height: 35px; width: 2px; background-color: #000;"></div>
          <h5 class="fw-bold mb-0">Testimoni</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- FORM BODY -->
      <label class="fw-semibold mb-1">Nama Pembeli</label>
      <input type="text" class="form-control border-success mb-3" placeholder="Masukan Nama Pembeli" id="namaPembeli">

      <label class="fw-semibold mb-1">Nama Produk</label>
      <input type="text" class="form-control border-success mb-3" placeholder="Masukan Nama Produk" id="namaProduk">

      <label class="fw-semibold mb-1">Alamat</label>
      <input type="text" class="form-control border-success mb-3" placeholder="Masukan Alamat" id="alamat">

      <label class="fw-semibold mb-1">Review</label>
      <textarea class="form-control border-success mb-3" placeholder="Masukan Review" id="reviewInput" rows="4"></textarea>

      <label class="fw-semibold mb-1">Unggah Gambar</label>
      <input type="file" class="form-control border-success mb-3" id="gambarInput">

      <label class="fw-semibold mb-1">Status</label>
      <div class="form-check mt-2 mb-4">
        <input class="form-check-input" type="checkbox" id="statusInput">
        <label class="form-check-label">Tampilkan</label>
      </div>

      <button class="btn w-100 text-white fw-semibold" id="btnSimpanTestimoni"
        style="background: linear-gradient(90deg, #4E8E55, #D6C72A); border-radius: 12px;">
        Simpan
      </button>
    </div>
  </div>
</div>

<!-- ======================
MODAL HAPUS TESTIMONI
====================== -->
<div class="modal fade" id="hapusTestimoniModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-4 text-center border-0 shadow-sm">
      <img src="../../asset/img/logo.png" alt="Logo" width="120" class="mb-3">
      <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
      <h5 class="fw-semibold mt-3 mb-4">Apakah Anda yakin untuk menghapus testimoni ini?</h5>
      <button class="btn text-white w-100 fw-semibold" id="btnKonfirmasiHapusTestimoni"
        style="background-color: #C0392B; border-radius: 12px;">Hapus</button>
    </div>
  </div>
</div>

<!-- ======================
MODAL NOTIFIKASI
====================== -->
<div class="modal fade" id="notifModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content notif-card text-center p-4 rounded-4 border-0 shadow">
      <img src="../../asset/img/logo.png" alt="Logo" width="90" class="mb-3">
      <i id="notifIcon" class="bi fs-1 mb-3"></i>
      <h5 id="notifText" class="fw-semibold"></h5>
    </div>
  </div>
</div>

<!-- ======================
STYLE TAMBAHAN
====================== -->
<style>
  .notif-card {
    background: #fff;
    animation: fadeScale 0.3s ease;
  }
  @keyframes fadeScale {
    from {opacity: 0; transform: scale(0.9);}
    to {opacity: 1; transform: scale(1);}
  }
  .shadow {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  }
</style>

<!-- ======================
SCRIPT
====================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const testimoniModal = new bootstrap.Modal(document.getElementById('testimoniModal'));
  const hapusTestimoniModal = new bootstrap.Modal(document.getElementById('hapusTestimoniModal'));
  const notifModal = new bootstrap.Modal(document.getElementById('notifModal'));
  const notifText = document.getElementById('notifText');
  const notifIcon = document.getElementById('notifIcon');

  // Tombol Tambah Testimoni
  document.querySelectorAll('.btnTambahTestimoni, .bi-plus').forEach(btn => {
    btn.addEventListener('click', () => {
      document.getElementById('namaPembeli').value = '';
      document.getElementById('namaProduk').value = '';
      document.getElementById('alamat').value = '';
      document.getElementById('reviewInput').value = '';
      document.getElementById('gambarInput').value = '';
      document.getElementById('statusInput').checked = false;
      testimoniModal.show();
    });
  });

  // Tombol Edit Testimoni
  document.querySelectorAll('.btnEditTestimoni, .bi-pencil').forEach(btn => {
    btn.addEventListener('click', () => {
      // Isi form dengan data testimoni (dummy untuk sekarang)
      document.getElementById('namaPembeli').value = 'Adi Tani';
      document.getElementById('namaProduk').value = 'Maxi-D';
      document.getElementById('alamat').value = 'Kab. Bandung';
      document.getElementById('reviewInput').value = 'Tanaman saya tumbuh lebih cepat!';
      document.getElementById('statusInput').checked = true;
      testimoniModal.show();
    });
  });

  // Simpan Testimoni
  document.getElementById('btnSimpanTestimoni').addEventListener('click', () => {
    testimoniModal.hide();
    setTimeout(() => {
      const isSuccess = Math.random() > 0.2; // contoh 80% berhasil
      if (isSuccess) {
        notifIcon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
        notifText.textContent = "Berhasil menyimpan testimoni!";
      } else {
        notifIcon.className = 'bi bi-x-circle-fill text-danger fs-1 mb-3';
        notifText.textContent = "Gagal menyimpan testimoni!";
      }
      notifModal.show();
      setTimeout(() => notifModal.hide(), 1600);
    }, 400);
  });

  // Tombol Hapus Testimoni
  document.querySelectorAll('.btnHapusTestimoni, .bi-trash').forEach(btn => {
    btn.addEventListener('click', () => {
      hapusTestimoniModal.show();
    });
  });

  // Konfirmasi Hapus
  document.getElementById('btnKonfirmasiHapusTestimoni').addEventListener('click', () => {
    hapusTestimoniModal.hide();
    setTimeout(() => {
      notifIcon.className = 'bi bi-check-circle-fill text-success fs-1 mb-3';
      notifText.textContent = "Berhasil menghapus testimoni!";
      notifModal.show();
      setTimeout(() => notifModal.hide(), 1500);
    }, 400);
  });
</script>
</body>
</html>
