<?php
// page/detail_produk.php - INTEGRATED VERSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include config files
include($_SERVER['DOCUMENT_ROOT'] . '/WEB_PPN/config/config.php');
include($_SERVER['DOCUMENT_ROOT'] . '/WEB_PPN/config/koneksi.php');

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate ID
if ($product_id <= 0) {
    header("Location: " . $base_url . "produk");
    exit;
}

// Query product details
$stmt = $conn->prepare("SELECT * FROM produk WHERE id = ? AND status IN ('Aktif', 'Dipajang')");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if product exists
if ($result->num_rows === 0) {
    header("Location: " . $base_url . "produk");
    exit;
}

$product = $result->fetch_assoc();

// Get related products from same category
$related_stmt = $conn->prepare("SELECT * FROM produk WHERE kategori = ? AND id != ? AND status IN ('Aktif', 'Dipajang') ORDER BY RAND() LIMIT 3");
$related_stmt->bind_param("si", $product['kategori'], $product_id);
$related_stmt->execute();
$related_result = $related_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['nama']) ?> - PT Pramudita Pupuk Nusantara</title>

    <!-- Favicon -->
    <link href="<?= $base_url ?>asset/img/LogoIco.ico" rel="icon">

    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>asset/style/detail_produk.css">

    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { font-weight: 400; }
        h1, h2, h3, h4, h5, h6 { font-weight: 600; }
        .fw-bold { font-weight: 700 !important; }
        .fw-semibold { font-weight: 600 !important; }

        .hero-section {
            background: linear-gradient(135deg, #1B5930 0%, #2B8D4C 100%);
            padding: 6rem 0 3rem;
            position: relative;
            overflow: hidden;
        }

        .hero-title {
            font-weight: 700;
            font-size: 3rem;
            letter-spacing: 1px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .main-product {
            padding: 3rem 0;
            display: flex;
            align-items: center;
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-image-container {
            flex: 1;
            max-width: 500px;
        }

        .product-image-wrapper {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .product-image {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .product-description {
            flex: 1;
        }

        .product-title {
            font-weight: 700;
            font-size: 2rem;
            color: #1B5930;
            margin-bottom: 1rem;
        }

        .product-category {
            display: inline-block;
            background: #f0f0f0;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .product-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .product-price {
            font-size: 2rem;
            font-weight: 700;
            color: #1B5930;
            margin: 1.5rem 0;
        }

        .product-text {
            font-size: 1rem;
            line-height: 1.8;
            color: #555;
        }

        .order-btn {
            background: linear-gradient(90deg, #2B8D4C 0%, #D5D44B 100%);
            color: white;
            padding: 1rem 3rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
        }

        .order-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(43, 141, 76, 0.3);
        }

        .section-title {
            font-weight: 700;
            font-size: 1.8rem;
            color: #1B5930;
            margin: 3rem 0 1.5rem;
            text-transform: uppercase;
            text-align: center;
        }

        .detail-section, .benefits-section, .usage-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .detail-content {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .detail-description {
            line-height: 1.9;
            color: #555;
            text-align: justify;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .benefit-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .benefit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .benefit-icon {
            font-size: 2rem;
            color: #2B8D4C;
            margin-bottom: 0.5rem;
        }

        .usage-category {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .usage-subtitle {
            font-weight: 600;
            font-size: 1.3rem;
            color: #1B5930;
            margin-bottom: 1rem;
        }

        .usage-item {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .usage-item::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #2B8D4C;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .dosage {
            font-weight: 700;
            color: #1B5930;
            font-size: 1.1rem;
        }

        .related-products {
            background: #f8f9fa;
            padding: 3rem 0;
            margin-top: 3rem;
        }

        .related-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .related-card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            padding: 1rem;
            background: #f8f9fa;
        }

        .related-card-body {
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .main-product {
                flex-direction: column;
            }
            .hero-title {
                font-size: 2rem;
            }
            .product-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <?php include(__DIR__ . '/../admin/template/navbar.php'); ?>

    <div class="main-content">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container text-center">
                <h1 class="hero-title"><?= htmlspecialchars($product['kategori']) ?></h1>
            </div>
        </section>

        <!-- Main Product Section -->
        <section class="container">
            <div class="main-product">
                <div class="product-image-container">
                    <div class="product-image-wrapper">
                        <img src="<?= $base_url ?>asset/img/<?= htmlspecialchars($product['gambar']) ?>" 
                             alt="<?= htmlspecialchars($product['nama']) ?>" 
                             class="product-image"
                             onerror="this.src='<?= $base_url ?>asset/img/placeholder.png'">
                    </div>
                </div>
                <div class="product-description">
                    <h2 class="product-title"><?= htmlspecialchars($product['nama']) ?></h2>
                    
                    <div class="product-category">
                        <i class="bi bi-tag"></i> <?= htmlspecialchars($product['kategori']) ?>
                    </div>

                    <?php if (!empty($product['atribut'])): ?>
                        <div class="product-badges">
                            <?php 
                            $atribut_array = explode(' ', $product['atribut']);
                            foreach ($atribut_array as $atribut):
                                $badge_class = '';
                                switch($atribut) {
                                    case 'Baru': $badge_class = 'bg-primary'; break;
                                    case 'Laris': $badge_class = 'bg-warning text-dark'; break;
                                    case 'Promo': $badge_class = 'bg-success'; break;
                                    case 'Bonus': $badge_class = 'bg-info text-dark'; break;
                                    case 'Habis': $badge_class = 'bg-danger'; break;
                                }
                            ?>
                                <span class="badge <?= $badge_class ?>">
                                    <?= htmlspecialchars($atribut) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="product-price">
                        Rp <?= number_format($product['harga'], 0, ',', '.') ?>
                    </div>

                    <?php if (!empty($product['deskripsi'])): ?>
                        <p class="product-text">
                            <?= nl2br(htmlspecialchars($product['deskripsi'])) ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($product['stok'] > 0): ?>
                        <p class="text-muted">
                            <i class="bi bi-box-seam"></i> Stok tersedia: <?= $product['stok'] ?> unit
                        </p>
                    <?php else: ?>
                        <p class="text-danger">
                            <i class="bi bi-exclamation-circle"></i> Stok habis
                        </p>
                    <?php endif; ?>

                    <button class="order-btn" onclick="window.location.href='<?= $base_url ?>page/shop.php'">
                        Pesan Sekarang <i class="bi bi-cart-plus"></i>
                    </button>
                </div>
            </div>
        </section>

        <?php if (!empty($product['penjelasan'])): ?>
        <!-- Detail Produk -->
        <section class="detail-section">
            <h3 class="section-title">Penjelasan Produk</h3>
            <div class="detail-content">
                <p class="detail-description">
                    <?= nl2br(htmlspecialchars($product['penjelasan'])) ?>
                </p>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($product['manfaat'])): ?>
        <!-- Manfaat & Keunggulan -->
        <section class="benefits-section">
            <h3 class="section-title">Manfaat & Keunggulan</h3>
            <div class="benefits-grid">
                <?php 
                $manfaat_items = explode("\n", $product['manfaat']);
                foreach ($manfaat_items as $manfaat): 
                    if (trim($manfaat)):
                ?>
                    <div class="benefit-card">
                        <div class="benefit-icon">✓</div>
                        <p><?= htmlspecialchars(trim($manfaat)) ?></p>
                    </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($product['aturan_pakai'])): ?>
        <!-- Aturan Pakai -->
        <section class="usage-section">
            <h3 class="section-title">Aturan Pakai</h3>
            
            <div class="usage-category">
                <?php if (!empty($product['jenis_tanaman'])): ?>
                    <h4 class="usage-subtitle">
                        <i class="bi bi-flower1"></i> 
                        Untuk: <?= htmlspecialchars(str_replace(';', ', ', $product['jenis_tanaman'])) ?>
                    </h4>
                <?php endif; ?>
                
                <div class="mt-3">
                    <?= nl2br(htmlspecialchars($product['aturan_pakai'])) ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($product['keistimewaan'])): ?>
        <!-- Keistimewaan -->
        <section class="detail-section">
            <h3 class="section-title">Keistimewaan</h3>
            <div class="detail-content">
                <p class="detail-description">
                    <?= nl2br(htmlspecialchars($product['keistimewaan'])) ?>
                </p>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($product['penyimpanan'])): ?>
        <!-- Petunjuk Penyimpanan -->
        <section class="detail-section">
            <h3 class="section-title">Petunjuk Penyimpanan</h3>
            <div class="detail-content">
                <p class="detail-description">
                    <?= nl2br(htmlspecialchars($product['penyimpanan'])) ?>
                </p>
            </div>
        </section>
        <?php endif; ?>

        <!-- Related Products -->
        <?php if ($related_result->num_rows > 0): ?>
        <section class="related-products">
            <div class="container">
                <h3 class="section-title">Produk Terkait</h3>
                <div class="row g-4 mt-2">
                    <?php while ($related = $related_result->fetch_assoc()): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="related-card">
                                <img src="<?= $base_url ?>asset/img/<?= htmlspecialchars($related['gambar_kecil']) ?>" 
                                     alt="<?= htmlspecialchars($related['nama']) ?>"
                                     onerror="this.src='<?= $base_url ?>asset/img/placeholder.png'">
                                <div class="related-card-body">
                                    <h5 class="fw-semibold"><?= htmlspecialchars($related['nama']) ?></h5>
                                    <p class="text-muted small mb-2"><?= htmlspecialchars($related['kategori']) ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold" style="color: #1B5930;">
                                            Rp <?= number_format($related['harga'], 0, ',', '.') ?>
                                        </span>
                                        <a href="<?= $base_url ?>page/detail_produk.php?id=<?= $related['id'] ?>" 
                                           class="btn btn-sm btn-success">
                                            Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Back to Products Button -->
        <div class="container text-center my-5">
            <a href="<?= $base_url ?>produk" class="btn btn-outline-success btn-lg">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Produk
            </a>
        </div>
    </div>

    <!-- WA Float -->
    <?php include(__DIR__ . '/../admin/template/whatsapp_float.php'); ?>

    <!-- Footer -->
    <?php include(__DIR__ . '/../admin/template/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $base_url ?>asset/js/detail_produk.js"></script>

</body>
</html>