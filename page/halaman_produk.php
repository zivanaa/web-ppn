<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($base_url)) {
    include($_SERVER['DOCUMENT_ROOT'] . '/WEB_PPN/config/config.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTPPN Produk</title>
    
    <!-- Favicon -->
    <link href="asset/img/LogoIco.ico" rel="icon">
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheets -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="asset/style/halaman_produk.css" rel="stylesheet">
    
    <style>
        /* === Global Font Poppins === */
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

        .fw-bold {
            font-weight: 700 !important;
        }

        .fw-semibold {
            font-weight: 600 !important;
        }

        .fw-normal {
            font-weight: 400 !important;
        }

        .fw-light {
            font-weight: 300 !important;
        }

        /* === Produk Title Container === */
        .produk-title-container {
            margin: 3rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .produk-title-line {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.8rem;
            letter-spacing: 1px;
            color: #1B5930;
            margin: 0;
            text-transform: uppercase;
        }

        /* === Product Card === */
        .product-card {
            font-family: 'Poppins', sans-serif;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(27, 89, 48, 0.15) !important;
        }

        .product-image-wrapper {
            font-family: 'Poppins', sans-serif;
        }

        .product-image {
            font-family: 'Poppins', sans-serif;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.3px;
            color: #333;
            margin: 1rem 0 0.5rem 0;
        }

        .btn-selengkapnya {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.2px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-selengkapnya:hover {
            text-decoration: none;
        }

        /* === Container === */
        .container-fluid {
            font-family: 'Poppins', sans-serif;
        }

        .container {
            font-family: 'Poppins', sans-serif;
        }

        /* === Responsive === */
        @media (max-width: 768px) {
            .produk-title-line {
                font-size: 2rem;
            }

            .product-name {
                font-size: 1rem;
            }

            .btn-selengkapnya {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .produk-title-line {
                font-size: 1.5rem;
            }

            .product-name {
                font-size: 0.95rem;
            }

            .btn-selengkapnya {
                font-size: 0.85rem;
            }
        }
    </style>
    
</head>
<body>

<?php include('admin/template/navbar.php'); ?>

<div class="container-fluid" style="background-color: #ffffff;">
    <div class="container">
        <div class="text-center produk-title-container">
            <h1 class="produk-title-line">PRODUK</h1>
        </div>

        <div class="row g-4 pb-5">
            <?php
            $produk = [
                ['id' => 1, 'img' => 'asset/img/Produk1.png', 'nama' => 'mAXI-d'],
                ['id' => 2, 'img' => 'asset/img/produk2.png', 'nama' => 'SILIKA'],
                ['id' => 3, 'img' => 'asset/img/produk3.png', 'nama' => 'Pengendali Hama'],
                ['id' => 4, 'img' => 'asset/img/produk4.png', 'nama' => 'Probiotik'],
                ['id' => 5, 'img' => 'asset/img/produk5.png', 'nama' => 'mAXI'],
            ];

            foreach ($produk as $p):
            ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="<?= $p['img'] ?>" alt="<?= $p['nama'] ?>" class="product-image">
                    </div>
                    <h5 class="product-name"><?= $p['nama'] ?></h5>
                    <a href="page/detail_produk.php?id=<?= $p['id'] ?>" class="btn-selengkapnya">Selengkapnya</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Tombol WhatsApp Floating -->
<a href="https://wa.me/6281234567890" target="_blank" id="whatsapp-float">
  <i class="bi bi-whatsapp"></i>
</a>

<!-- WA -->
<?php include ('admin/template/whatsapp_float.php'); ?>

<!-- Footer -->
<?php include('admin/template/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
