<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - PT Pramudita Pupuk Nusantara</title>

    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../asset/style/tentang_kami.css">

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

        /* Hero Section Styling */
        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: 1px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
        }

        /* Section Titles */
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Intro Text */
        .intro-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        /* About Text */
        .about-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            line-height: 1.8;
            font-size: 1rem;
        }

        /* Stat Cards */
        .stat-number {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
        }

        .stat-label {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
        }

        /* Value Cards */
        .value-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .value-desc {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* CTA Section */
        .cta-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
        }

        .cta-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            line-height: 1.6;
            font-size: 1.05rem;
        }

        .cta-button {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
    </style>

</head>
<body>

    <?php include '../admin/template/navbar.php'; ?>

    <div class="main-content">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <div class="hero-divider left"></div>
                <div class="hero-text-wrapper">
                    <h1 class="hero-title fw-bold">PT Pramudita Pupuk Nusantara</h1>
                    <div class="hero-underline"></div>
                </div>
                <div class="hero-divider right"></div>
            </div>
        </section>

        <!-- Introduction Text -->
        <section class="intro-section">
            <div class="intro-content">
                <p class="intro-text fw-normal">
                    Di tengah tantangan global dalam sektor pertanian—mulai dari perubahan iklim, degradasi lahan, rendahnya produktivitas petani, hingga krisis ketahanan pangan—PT Pramudita Pupuk Nusantara hadir sebagai jawaban untuk membangun sistem pertanian Indonesia yang lebih tangguh, modern, dan berkelanjutan.
                </p>
            </div>
        </section>

        <!-- Video Section -->
        <section class="video-section">
            <div class="video-container">
                <div class="video-wrapper">
                    <div class="company-video" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                        <iframe 
                            src="https://www.youtube.com/embed/iGkdUqwvf28" 
                            title="YouTube video" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                        </iframe>
                    </div>
                    <div class="video-overlay">
                        <div class="play-button">
                            <svg viewBox="0 0 24 24" fill="white">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="about-section">
            <div class="about-header">
                <h2 class="section-title fw-bold">Tentang Kami</h2>
                <div class="title-decoration"></div>
            </div>
            
            <div class="about-content">
                <div class="about-text-wrapper">
                    <p class="about-text fw-normal">
                        PT Pramudita Pupuk Nusantara adalah perusahaan perorangan yang bergerak dalam bidang produksi, distribusi, dan pemasaran pupuk, dengan cakupan layanan menyeluruh dari hulu ke hilir. Kami tidak hanya memproduksi pupuk, tetapi juga melakukan edukasi pertanian, pembinaan petani, hingga pendampingan dampak penggunaan produk kami di lapangan. Dengan demikian, kami mampu memberikan solusi pertanian terpadu yang aplikatif, efisien, dan relevan terhadap kondisi petani Indonesia saat ini.
                    </p>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">🌾</div>
                        <div class="stat-number fw-bold" data-target="1000">0</div>
                        <div class="stat-label fw-semibold">Petani Mitra</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">🏭</div>
                        <div class="stat-number fw-bold" data-target="50">0</div>
                        <div class="stat-label fw-semibold">Produk Unggulan</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">🌍</div>
                        <div class="stat-number fw-bold" data-target="100">0</div>
                        <div class="stat-label fw-semibold">Wilayah Distribusi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-number fw-bold" data-target="15">0</div>
                        <div class="stat-label fw-semibold">Tahun Pengalaman</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="values-section">
            <div class="values-header">
                <h2 class="section-title fw-bold">Nilai-Nilai Kami</h2>
                <div class="title-decoration"></div>
            </div>
            
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon-wrapper">
                        <div class="value-icon">🎯</div>
                    </div>
                    <h3 class="value-title fw-bold">Inovasi</h3>
                    <p class="value-desc fw-normal">Mengembangkan solusi pertanian terkini dengan teknologi modern</p>
                </div>
                <div class="value-card">
                    <div class="value-icon-wrapper">
                        <div class="value-icon">🤝</div>
                    </div>
                    <h3 class="value-title fw-bold">Kolaborasi</h3>
                    <p class="value-desc fw-normal">Bekerja sama dengan petani untuk kesuksesan bersama</p>
                </div>
                <div class="value-card">
                    <div class="value-icon-wrapper">
                        <div class="value-icon">🌱</div>
                    </div>
                    <h3 class="value-title fw-bold">Berkelanjutan</h3>
                    <p class="value-desc fw-normal">Membangun pertanian yang ramah lingkungan dan berkelanjutan</p>
                </div>
                <div class="value-card">
                    <div class="value-icon-wrapper">
                        <div class="value-icon">💪</div>
                    </div>
                    <h3 class="value-title fw-bold">Integritas</h3>
                    <p class="value-desc fw-normal">Komitmen penuh terhadap kualitas dan kepuasan pelanggan</p>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="cta-content">
                <h2 class="cta-title fw-bold">Mari Bergabung Bersama Kami</h2>
                <p class="cta-text fw-semibold">Menjadi bagian dari revolusi pertanian Indonesia yang lebih modern dan berkelanjutan</p>
                <button class="cta-button fw-semibold">Hubungi Kami</button>
            </div>
        </section>
    </div>


<!-- WA -->
<?php include ('../admin/template/whatsapp_float.php'); ?>

<!-- Footer -->
<?php include '../admin/template/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../asset/js/tentang_kami.js"></script>
</body>
</html>
