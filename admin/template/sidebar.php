<!-- Favicon -->
<link href="/WEB_PPN/asset/img/LogoIco.ico" rel="icon">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icon Fonts -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="/WEB_PPN/asset/style/sidebar.css">

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

  .fw-semibold {
    font-weight: 600 !important;
  }

  .fw-bold {
    font-weight: 700 !important;
  }

  /* === Sidebar Font === */
  .sidebar {
    font-family: 'Poppins', sans-serif;
  }

  .sidebar .logo-full {
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

  .menu-item {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
  }

  .menu-item span {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
  }

  .text-secondary {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
  }

  .sidebar-footer {
    font-family: 'Poppins', sans-serif;
  }

  .footer-toggle {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
  }

  .footer-toggle span {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
  }

  .dropup-menu {
    font-family: 'Poppins', sans-serif;
  }

  .dropup-menu button {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
  }

  .btn-danger {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
  }

  .text-muted {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
  }
</style>

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">
  <div class="logo d-flex justify-content-between align-items-center p-2">
    <img src="/WEB_PPN/asset/img/Logo.png" alt="PPN Logo" class="logo-full">
    <button class="btn btn-sm" id="toggleSidebar" style="background: none; border: none; padding: 0;">
      <img src="/WEB_PPN/asset/img/Sidebar.png" alt="Toggle Sidebar" style="width: 20px; height: 20px;">
    </button>
  </div>

  <!-- SEARCH -->
  <div class="search-container">
    <div class="search-box">
      <i class="bi bi-search"></i>
      <input type="text" placeholder="Search" id="searchInput">
    </div>
    <div class="search-icon-only">
      <i class="bi bi-search"></i>
    </div>
  </div>

  <!-- MENU -->
  <div class="p-3">
    <p class="text-secondary small fw-semibold">Menu</p>
    <div class="menu-item" data-link="/WEB_PPN/admin/page/produk.php" data-keywords="manajemen produk product">
      <i class="bi bi-box-seam"></i><span>Manajemen Produk</span>
    </div>
    <div class="menu-item" data-link="/WEB_PPN/admin/page/logbook.php" data-keywords="logbook log book catatan">
      <i class="bi bi-journal-text"></i><span>Logbook</span>
    </div>
    <div class="menu-item" data-link="/WEB_PPN/admin/page/ulasan.php" data-keywords="testimoni ulasan review">
      <i class="bi bi-chat-dots"></i><span>Testimoni</span>
    </div>
    <div class="menu-item" data-link="/WEB_PPN/admin/page/galeri.php" data-keywords="galeri gallery gambar foto">
      <i class="bi bi-image"></i><span>Galeri</span>
    </div>
    <div class="menu-item" data-link="/WEB_PPN/admin/page/faq.php" data-keywords="faq pertanyaan question">
      <i class="bi bi-question-circle"></i><span>FAQ</span>
    </div>
  </div>

  <!-- No Results Message -->
  <div class="p-3" id="noResults" style="display: none;">
    <p class="text-muted text-center small">Tidak ada hasil ditemukan</p>
  </div>

  <!-- FOOTER -->
  <div class="sidebar-footer position-relative" id="footerDropdown">
    <div class="d-flex align-items-center gap-2 footer-toggle" style="cursor: pointer;">
      <img src="/WEB_PPN/asset/img/userlog.png" alt="Admin">
      <span>Administrator</span>
    </div>

    <!-- Dropup Menu -->
    <div class="dropup-menu bg-white shadow rounded-3 p-2 position-absolute" 
         style="bottom: 50px; left: 0; right: 0; text-align: center; display: none;">
      <button class="btn btn-danger w-100 py-1" id="logoutBtn">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </div>
  </div>
</div>

<!-- Sidebar Script -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const menuItems = document.querySelectorAll('.menu-item');
    const footerToggle = document.querySelector('.footer-toggle');
    const dropupMenu = document.querySelector('.dropup-menu');
    const activeIndex = localStorage.getItem('activeMenuIndex');
    const searchInput = document.getElementById('searchInput');
    const noResults = document.getElementById('noResults');

    // Sidebar toggle
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('minimized');
      document.querySelector('.main')?.classList.toggle('sidebar-minimized');
    });

    // Restore active menu
    if (activeIndex !== null && menuItems[activeIndex]) {
      menuItems[activeIndex].classList.add('active');
    }

    // Menu item click
    menuItems.forEach((item, index) => {
      item.addEventListener('click', () => {
        menuItems.forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        localStorage.setItem('activeMenuIndex', index);
        const link = item.getAttribute('data-link');
        if (link) window.location.href = link;
      });
    });

    // Search functionality
    searchInput.addEventListener('input', (e) => {
      const searchTerm = e.target.value.toLowerCase().trim();
      let hasVisibleItems = false;

      menuItems.forEach(item => {
        const itemText = item.textContent.toLowerCase();
        const keywords = item.getAttribute('data-keywords') || '';
        const searchableText = itemText + ' ' + keywords;

        if (searchTerm === '' || searchableText.includes(searchTerm)) {
          item.style.display = 'flex';
          hasVisibleItems = true;
        } else {
          item.style.display = 'none';
        }
      });

      // Show/hide "no results" message
      if (searchTerm !== '' && !hasVisibleItems) {
        noResults.style.display = 'block';
      } else {
        noResults.style.display = 'none';
      }
    });

    // Dropup toggle
    footerToggle.addEventListener('click', () => {
      dropupMenu.style.display = dropupMenu.style.display === 'none' || dropupMenu.style.display === '' ? 'block' : 'none';
    });

    // Close dropup outside click
    document.addEventListener('click', (e) => {
      if (!document.getElementById('footerDropdown').contains(e.target)) {
        dropupMenu.style.display = 'none';
      }
    });

    // Logout button
    document.getElementById('logoutBtn').addEventListener('click', () => {
      window.location.href = '/WEB_PPN/logout.php';
    });
  });
</script>
