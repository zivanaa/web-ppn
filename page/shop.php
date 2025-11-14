<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online - Belanja Sekarang</title>
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../asset/style/shop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom CSS for Poppins Font -->
    <style>
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include '../admin/template/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title fw-bold" style="text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6); letter-spacing: 1px;">Ayo Gunakan Produk Kami!</h1>
            <p class="hero-subtitle fw-normal" style="text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5); font-size: 1.1rem; line-height: 1.6;">Temukan produk berkualitas di toko resmi Kami!</p>
            <div class="hero-badge fw-semibold">
                <i class="fas fa-shopping-bag"></i>
                <span>Tersedia di 4+ Platform</span>
            </div>
        </div>
        <div class="hero-decoration">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="shop-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title fw-bold">Senang Bertemu Anda!</h2>
                <p class="section-description fw-semibold">Kami Tersedia Di</p>
            </div>

            <div class="shop-grid">
                <!-- TikTok Shop -->
                <div class="shop-card" data-platform="tiktok">
                    <div class="card-glow"></div>
                    <div class="card-content">
                        <div class="logo-wrapper">
                            <img src="../asset/img/tiktokshop.png" alt="TikTok Shop" class="platform-logo">
                        </div>
                        <h3 class="platform-name fw-bold">TikTok Shop</h3>
                        <p class="platform-desc fw-normal">Belanja sambil nonton video seru</p>
                        <div class="platform-features">
                            <span class="feature-tag fw-semibold"><i class="fas fa-bolt"></i> Flash Sale</span>
                            <span class="feature-tag fw-semibold"><i class="fas fa-video"></i> Live Shopping</span>
                        </div>
                        <button class="shop-btn fw-semibold" onclick="redirectToShop('tiktok')">
                            <span>Belanja Sekarang</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Tokopedia -->
                <div class="shop-card" data-platform="tokopedia">
                    <div class="card-glow"></div>
                    <div class="card-content">
                        <div class="logo-wrapper">
                            <img src="../asset/img/tokopedia.png" alt="Tokopedia" class="platform-logo">
                        </div>
                        <h3 class="platform-name fw-bold">Tokopedia</h3>
                        <p class="platform-desc fw-normal">Mulai aja dulu, #MulaiAjaDulu</p>
                        <div class="platform-features">
                            <span class="feature-tag fw-semibold"><i class="fas fa-shield-alt"></i> Bebas Ongkir</span>
                            <span class="feature-tag fw-semibold"><i class="fas fa-coins"></i> Cashback</span>
                        </div>
                        <button class="shop-btn fw-semibold" onclick="redirectToShop('tokopedia')">
                            <span>Belanja Sekarang</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Shopee -->
                <div class="shop-card" data-platform="shopee">
                    <div class="card-glow"></div>
                    <div class="card-content">
                        <div class="logo-wrapper">
                            <img src="../asset/img/shopee.png" alt="Shopee" class="platform-logo">
                        </div>
                        <h3 class="platform-name fw-bold">Shopee</h3>
                        <p class="platform-desc fw-normal">Gratis ongkir & voucher setiap hari</p>
                        <div class="platform-features">
                            <span class="feature-tag fw-semibold"><i class="fas fa-truck"></i> Gratis Ongkir</span>
                            <span class="feature-tag fw-semibold"><i class="fas fa-gift"></i> Voucher</span>
                        </div>
                        <button class="shop-btn fw-semibold" onclick="redirectToShop('shopee')">
                            <span>Belanja Sekarang</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Lazada -->
                <div class="shop-card" data-platform="lazada">
                    <div class="card-glow"></div>
                    <div class="card-content">
                        <div class="logo-wrapper">
                            <img src="../asset/img/lazada.png" alt="Lazada" class="platform-logo">
                        </div>
                        <h3 class="platform-name fw-bold">Lazada</h3>
                        <p class="platform-desc fw-normal">Belanja online terlengkap</p>
                        <div class="platform-features">
                            <span class="feature-tag fw-semibold"><i class="fas fa-tag"></i> Diskon</span>
                            <span class="feature-tag fw-semibold"><i class="fas fa-star"></i> Brand Resmi</span>
                        </div>
                        <button class="shop-btn fw-semibold" onclick="redirectToShop('lazada')">
                            <span>Belanja Sekarang</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="section-title fw-bold">Mengapa Belanja Di Toko Resmi Kami?</h2>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="fw-bold">Produk Original</h3>
                    <p class="fw-normal">100% produk asli dan berkualitas terjamin</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3 class="fw-bold">Pengiriman Cepat</h3>
                    <p class="fw-normal">Pengiriman ke seluruh Indonesia dengan cepat</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="fw-bold">Customer Service</h3>
                    <p class="fw-normal">Siap membantu Anda kapan saja</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3 class="fw-bold">Pembayaran Aman</h3>
                    <p class="fw-normal">Transaksi dilindungi dengan sistem keamanan terbaik platform mitra</p>
                </div>
            </div>
        </div>
    </section>

    <!-- WA Float -->
    <?php include '../admin/template/whatsapp_float.php'; ?>

    <!-- Footer -->
    <?php include '../admin/template/footer.php'; ?>

    <script src="../asset/js/shop.js"></script>
</body>
</html>
