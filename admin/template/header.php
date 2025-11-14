<!-- Favicon -->
    <link href="asset/img/LogoIco.ico" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Heebo&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheets -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/style/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">


<div class="">
    <nav class="navbar navbar-expand-md px-3" style="background-color: rgb(59, 72, 133);">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">
                <img src="../asset/img/Logo Ganyeum.png" alt="" width="40" height="40" class="d-inline-block align-text-top">
            </a>
            <span class="navbar-text text-white fs-4 fw-medium">
                Ganyeum Admin
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon d-flex"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item py-2">
                        <form class="d-flex" method="POST" action="action/cari.php">
                            <input class="form-control me-2 rounded-4" type="text" name="cari" placeholder="Cari menu" value="<?php if (isset($_GET['cari'])) { echo $_GET['cari']; } ?>">
                            <button class="btn btn-success me-2 rounded-4" type="submit">Cari</button>
                            <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <ul class="nav nav-underline nav-fill menu-navbar scrollable-content" data-bs-theme="dark" style="background-color: rgb(56, 69, 126);">
        <li class="nav-item">
            <a class="nav-link <?php if ($_GET['mod'] === 'produk') {echo 'active';} ?>" href="produk">Menu</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if ($_GET['mod'] === 'ulasan') {echo 'active';} ?>" href="ulasan">Ulasan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if ($_GET['mod'] === 'galeri') {echo 'active';} ?>" href="galeri">Galeri</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if ($_GET['mod'] === 'diskon') {echo 'active';} ?>" href="diskon">Diskon</a>
        </li>
    </ul>
    
    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bolder" id="logoutModalLabel">Konfirmasi Logout</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin logout dari Dashboard Admin?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <a href="logout" class="btn btn-primary">Ya</a>
                </div>
            </div>
        </div>
    </div>
</div>
