<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi & Misi - PT Pramudita Pupuk Nusantara</title>
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../asset/style/visi_misi.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Poppins Styling -->
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

        /* Hero Section */
        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 3.5rem;
            letter-spacing: 1px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
        }

        .hero-subtitle {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
        }

        /* Section Headers */
        .section-label {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            letter-spacing: 0.5px;
            margin-top: 0.5rem;
        }

        /* Visi Card */
        .visi-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 1.1rem;
            line-height: 1.8;
            letter-spacing: 0.3px;
        }

        /* Misi Cards */
        .misi-number {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            opacity: 0.15;
        }

        .misi-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 0.3px;
        }

        .misi-description {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 0.95rem;
            line-height: 1.7;
            letter-spacing: 0.2px;
        }

        /* Values Section */
        .value-item h4 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.3px;
            margin-top: 1rem;
        }

        /* Scroll Indicator */
        .scroll-indicator {
            font-size: 1.5rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>

</head>
<body>

    <?php include '../admin/template/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title fw-bold" data-aos="fade-up">Visi & Misi</h1>
            <p class="hero-subtitle fw-semibold" data-aos="fade-up" data-aos-delay="100">Membangun Masa Depan Pertanian Indonesia</p>
        </div>
        <div class="scroll-indicator">
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- Visi Section -->
    <section class="visi-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-label fw-semibold">Visi Kami</span>
                <h2 class="section-title fw-bold">Menjadi Perusahaan Pupuk Terdepan</h2>
            </div>
            
            <div class="visi-card" data-aos="fade-up" data-aos-delay="200">
                <div class="visi-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="visi-content">
                    <p class="visi-text fw-normal">
                        Menjadi perusahaan pupuk nasional yang inovatif dan berkelanjutan guna mendukung pertanian dan peternakan berkelanjutan melalui produk berkualitas, peningkatan produktivitas pertanian, kesejahteraan petani, dan menjadi solusi pertanian masa depan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Misi Section -->
    <section class="misi-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-label fw-semibold">Misi Kami</span>
                <h2 class="section-title fw-bold">Komitmen untuk Indonesia</h2>
            </div>

            <div class="misi-grid">
                <div class="misi-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="misi-number fw-bold">01</div>
                    <div class="misi-icon"><i class="fas fa-seedling"></i></div>
                    <h3 class="misi-title fw-bold">Solusi Pertanian Terjangkau</h3>
                    <p class="misi-description fw-normal">Memberikan solusi pertanian Indonesia yang terjangkau, mudah diakses, dan membantu petani meningkatkan hasil panen, kualitas tanaman, serta kesejahteraan petani.</p>
                </div>
                <div class="misi-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="misi-number fw-bold">02</div>
                    <div class="misi-icon"><i class="fas fa-leaf"></i></div>
                    <h3 class="misi-title fw-bold">Pupuk Efektif & Efisien</h3>
                    <p class="misi-description fw-normal">Menyediakan pupuk efektif, dan efisien untuk mendukung pertumbuhan tanaman optimal, sekaligus menjaga kualitas tanah dan lingkungan.</p>
                </div>
                <div class="misi-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="misi-number fw-bold">03</div>
                    <div class="misi-icon"><i class="fas fa-flask"></i></div>
                    <h3 class="misi-title fw-bold">Inovasi Pupuk Organik</h3>
                    <p class="misi-description fw-normal">Mengembangkan dan memproduksi pupuk serta suplemen organik dan hayati berkualitas tinggi yang mendukung pertumbuhan tanaman dan ternak secara optimal.</p>
                </div>
                <div class="misi-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="misi-number fw-bold">04</div>
                    <div class="misi-icon"><i class="fas fa-hands-helping"></i></div>
                    <h3 class="misi-title fw-bold">Kontribusi Nyata</h3>
                    <p class="misi-description fw-normal">Memberikan kontribusi nyata terhadap ketahanan pangan dan kesejahteraan masyarakat Indonesia melalui pertanian dan peternakan yang sehat, produktif, dan berdaya saing.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-label fw-semibold">Nilai Perusahaan</span>
                <h2 class="section-title fw-bold">Prinsip yang Kami Pegang</h2>
            </div>

            <div class="values-grid">
                <div class="value-item" data-aos="zoom-in" data-aos-delay="100">
                    <i class="fas fa-lightbulb"></i>
                    <h4 class="fw-bold">Inovasi</h4>
                </div>
                <div class="value-item" data-aos="zoom-in" data-aos-delay="200">
                    <i class="fas fa-award"></i>
                    <h4 class="fw-bold">Kualitas</h4>
                </div>
                <div class="value-item" data-aos="zoom-in" data-aos-delay="300">
                    <i class="fas fa-heart"></i>
                    <h4 class="fw-bold">Integritas</h4>
                </div>
                <div class="value-item" data-aos="zoom-in" data-aos-delay="400">
                    <i class="fas fa-recycle"></i>
                    <h4 class="fw-bold">Berkelanjutan</h4>
                </div>
            </div>
        </div>
    </section>

<!-- WA -->
<?php include ('../admin/template/whatsapp_float.php'); ?>

<!-- Footer -->
<?php include '../admin/template/footer.php'; ?>

    <script src="../asset/js/visi_misi.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
