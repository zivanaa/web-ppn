<?php
// Jalankan session dan output buffering sebelum HTML apapun
if (session_status() === PHP_SESSION_NONE) {
    ob_start();
    session_start();
}

if (!isset($base_url)) {
    include($_SERVER['DOCUMENT_ROOT'] . '/WEB_PPN/config/config.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Navbar | PTPPN</title>
    
    <!-- Favicon -->
    <link href="<?= $base_url ?>asset/img/LogoIco.ico" rel="icon" />
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- Icon Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>asset/style/navbar.css">
    <link rel="stylesheet" href="<?= $base_url ?>asset/style/login.css">
</head>
<body>

<!-- ============================================ -->
<!-- NAVBAR -->
<!-- ============================================ -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
        <!-- LOGO -->
        <a href="<?= $base_url ?>beranda" class="navbar-brand d-flex align-items-center">
            <img src="<?= $base_url ?>asset/img/Logo.png" alt="Logo" />
        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" 
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa fa-bars" style="color: #2b8d4c"></span>
        </button>

        <!-- NAV LINKS -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <a href="<?= $base_url ?>beranda" class="nav-link active">Beranda</a>
                </li>
                <li class="nav-item">
                    <a href="<?= $base_url ?>page/shop.php" class="nav-link">Shop</a>
                </li>
                
                <!-- Dropdown Tentang Kami -->
                <li class="nav-item dropdown position-static">
                    <a href="<?= $base_url ?>page/tentang_kami.php" class="nav-link dropdown-toggle" 
                       id="tentangKamiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tentang Kami
                    </a>
                    <div class="dropdown-menu w-100 mt-0 p-4" aria-labelledby="tentangKamiDropdown" 
                         style="background-color: #fff">
                        <div class="container">
                            <div class="col-lg-3 col-md-12 mb-3 text-center text-lg-start">
                                <h4 class="fw-bold mb-0" style="color: #2b8d4c">TENTANG<br />KAMI</h4>
                            </div>
                            <div class="dropdown-divider-vert"></div>
                            <div class="col-lg-6 col-md-12">
                                <a href="<?= $base_url ?>page/tentang_kami.php" class="d-block py-2 fw-semibold text-link">
                                    Sekilas Pramudita Pupuk Nusantara
                                </a>
                                <a href="<?= $base_url ?>page/visi_misi.php" class="d-block py-2 fw-semibold text-link">
                                    Visi & Misi
                                </a>
                                <a href="<?= $base_url ?>tim-kami" class="d-block py-2 fw-semibold text-link">
                                    Jangkauan Pengguna
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a href="<?= $base_url ?>galeri" class="nav-link">Galeri</a>
                </li>
                <li class="nav-item">
                    <a href="<?= $base_url ?>produk" class="nav-link">Produk</a>
                </li>
                <li class="nav-item">
                    <a href="<?= $base_url ?>faq" class="nav-link">FAQ</a>
                </li>
            </ul>

            <!-- ICON USER -->
            <a href="#" class="nav-link d-flex align-items-center ms-lg-3" 
               data-bs-toggle="modal" data-bs-target="#loginModal">
                <img src="<?= $base_url ?>asset/img/userlog.png" alt="User" height="22" width="22" />
            </a>
        </div>
    </div>
</nav>

<!-- Alert untuk error login -->
<?php if (!empty($_SESSION['login_error'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 80px;">
    <?= htmlspecialchars($_SESSION['login_error']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php 
    unset($_SESSION['login_error']);
endif; 
?>

<!-- ============================================ -->
<!-- MODAL LOGIN PPN -->
<!-- ============================================ -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 p-4">
            <div class="text-center mb-4">
                <img src="<?= $base_url ?>asset/img/Logo.png" alt="Logo PPN" style="height:60px;">
            </div>
            <form action="login.php" method="POST" class="px-2">
                <div class="mb-3">
                    <label for="username" class="form-label fw-medium">Username</label>
                    <input type="text" class="form-control custom-input" id="username" name="username" 
                           placeholder="Masukkan username" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label fw-medium">Password</label>
                    <input type="password" class="form-control custom-input" id="password" name="password" 
                           placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn btn-gradient w-100 py-2 fw-semibold" style="color: white;">
                 Masuk
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- JAVASCRIPT -->
<!-- ============================================ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php
if (ob_get_level() > 0) {
    ob_end_flush();
}
?>