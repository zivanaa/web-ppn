<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - PT Pramudita Pupuk Nusantara</title>

    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../asset/style/detail_produk.css">

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

        p {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            line-height: 1.6;
        }

        strong {
            font-weight: 700;
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

        /* === Hero Section === */
        .hero-section {
            font-family: 'Poppins', sans-serif;
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* === Product Title === */
        .product-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        /* === Product Text === */
        .product-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            line-height: 1.7;
        }

        /* === Section Title === */
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* === Detail Description === */
        .detail-description {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            line-height: 1.8;
            text-align: justify;
        }

        /* === Benefit Card === */
        .benefit-card {
            font-family: 'Poppins', sans-serif;
        }

        .benefit-card p {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            line-height: 1.6;
        }

        .benefit-icon {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
        }

        /* === Usage Section === */
        .usage-subtitle {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .usage-item {
            font-family: 'Poppins', sans-serif;
        }

        .usage-item p {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            line-height: 1.7;
        }

        .dosage {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #1B5930;
        }

        /* === Button === */
        .order-btn,
        .order-btn-bottom {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
        }

        .order-btn:hover,
        .order-btn-bottom:hover {
            font-family: 'Poppins', sans-serif;
        }

        /* === Main Content === */
        .main-content {
            font-family: 'Poppins', sans-serif;
        }

        /* === Product Image Container === */
        .product-image-container,
        .product-image-wrapper {
            font-family: 'Poppins', sans-serif;
        }

        .product-image {
            font-family: 'Poppins', sans-serif;
        }

        /* === Product Description === */
        .product-description {
            font-family: 'Poppins', sans-serif;
        }

        /* === Responsive Typography === */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .product-title {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 1.3rem;
            }

            .detail-description {
                font-size: 0.95rem;
            }

            .benefit-card p {
                font-size: 0.9rem;
            }

            .usage-item p {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.5rem;
            }

            .product-title {
                font-size: 1.2rem;
            }

            .section-title {
                font-size: 1.1rem;
            }

            .detail-description {
                font-size: 0.9rem;
            }

            .benefit-card p {
                font-size: 0.85rem;
            }

            .usage-item p {
                font-size: 0.85rem;
            }

            .dosage {
                font-size: 0.9rem;
            }
        }
    </style>

</head>
<body>

    <?php include '../admin/template/navbar.php'; ?>

    <div class="main-content">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-divider left"></div>
            <h1 class="hero-title">PRODUK</h1>
            <div class="hero-divider right"></div>
        </section>

        <!-- Main Product Section -->
        <section class="main-product">
            <div class="product-image-container">
                <div class="product-image-wrapper">
                    <img src="../asset/img/produk2.png" alt="MAXI-D Pupuk Daun" class="product-image">
                </div>
            </div>
            <div class="product-description">
                <h2 class="product-title">MAXI-D Pupuk Daun untuk Fase Vegetatif</h2>
                <p class="product-text">
                    Terra Nusa Maxi D diformulasikan khusus untuk mendukung 
                    pertumbuhan tanaman pada fase vegetatif.
                </p>
                <button class="order-btn">Pesan Sekarang</button>
            </div>
        </section>

        <!-- Detail Produk -->
        <section class="detail-section">
            <h3 class="section-title">KEUNGGULAN PRODUK</h3>
            <div class="detail-content">
                <p class="detail-description">
                    Terra Nusa Maxi-D diformulasikan khusus untuk mendukung pertumbuhan tanaman pada fase vegetatif, 
                    yaitu fase awal yang sangat memerlukan kekuatan dan kualitas pertumbuhan tanaman. Mengandung nitrogen 
                    tinggi yang dikorelasikan dengan unsur hara mikro lainnya secara sinergis menciptakan keseimbangan 
                    pertumbuhan daun yang hijau, lebat, dan sehat, serta merangsang pertumbuhan akar dan batang secara optimal.
                </p>
            </div>
        </section>

        <!-- Manfaat & Keunggulan -->
        <section class="benefits-section">
            <h3 class="section-title">MANFAAT & KEUNGGULAN</h3>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">✓</div>
                    <p>Memperbanyak jumlah anakan produktif padi</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">✓</div>
                    <p>Memicu pertumbuhan dan menghijaukan panen</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">✓</div>
                    <p>Meningkatkan daya tahan tanaman terhadap serangan hama dan penyakit</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">✓</div>
                    <p>Mempercepat panen pada tanaman semusim</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">✓</div>
                    <p>Memperpanjang masa umur tanaman</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">✓</div>
                    <p>Meningkatkan frekuensi panen</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">✓</div>
                    <p>Meningkatkan dan menjaga kesuburan tanah</p>
                </div>
            </div>
        </section>

        <!-- Aturan Pakai -->
        <section class="usage-section">
            <h3 class="section-title">ATURAN PAKAI</h3>
            
            <div class="usage-category">
                <h4 class="usage-subtitle">Tanaman Sayuran & Tanaman Hias</h4>
                <div class="usage-item">
                    <span class="dosage">4 - 6 tutup</span>
                    <p>"Termasuk Maxi-D" dilarutkan kedalam <strong>15 liter air</strong> (sesuai dengan umur tanaman)</p>
                </div>
                <div class="usage-item">
                    <p>Penyemprotan pertama saat tanaman berumur <strong>10 sd 15 hari</strong> setelah tanam</p>
                </div>
                <div class="usage-item">
                    <p>Ulangi penyemprotan setiap <strong>1 minggu</strong></p>
                </div>
            </div>

            <div class="usage-category">
                <h4 class="usage-subtitle">Tanaman Palawija (Padi & jagung)</h4>
                <div class="usage-item">
                    <span class="dosage">6 - 10 tutup</span>
                    <p>"Termasuk Maxi-D" dilarutkan kedalam <strong>15 liter air</strong> (sesuai dengan umur tanaman)</p>
                </div>
                <div class="usage-item">
                    <p>Penyemprotan pertama saat tanaman berumur <strong>15 hari</strong> setelah tanam</p>
                </div>
                <div class="usage-item">
                    <p><strong>Sekali</strong> untuk padi dan <strong>1 minggu</strong> sekali untuk jagung  <strong>2 kali aplikasi</strong></p>
                </div>
            </div>

            <button class="order-btn-bottom">Pesan Sekarang</button>
        </section>
    </div>

    <!-- WA -->
    <?php include ('../admin/template/whatsapp_float.php'); ?>

    <!-- Footer -->
    <?php include '../admin/template/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../asset/js/detail_produk.js"></script>

</body>
</html>
