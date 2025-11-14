<?php
include('config/koneksi.php');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTPPN Galeri</title>
    
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/style/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="asset/style/style.css" rel="stylesheet">
    <link rel="stylesheet" href="asset/style/fab.css">
    <link rel="stylesheet" href="asset/style/galeri.css">

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

        /* Galeri Title dengan Garis Rapi */
        .galeri-title-container {
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            width: 100%;
        }

        .galeri-line {
            flex: 1;
            height: 3px;
            background: #1B5930;
            max-width: 150px;
        }

        .galeri-title-line {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.8rem;
            letter-spacing: 0.5px;
            color: #1B5930;
            margin: 0;
            white-space: nowrap;
        }

        /* Gallery Images */
        .gallery-img {
            font-family: 'Poppins', sans-serif;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 300px;
        }

        .gallery-img:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(27, 89, 48, 0.2) !important;
        }

        /* Modal Styling */
        .modal-content {
            font-family: 'Poppins', sans-serif;
        }

        .modal-header {
            font-family: 'Poppins', sans-serif;
            padding: 1.5rem;
        }

        .modal-body {
            font-family: 'Poppins', sans-serif;
            padding: 2rem;
        }

        #modalDate {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
        }

        #modalTitle {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 0.3px;
            color: #1B5930;
        }

        #modalDesc {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 0.95rem;
            line-height: 1.7;
            letter-spacing: 0.2px;
            color: #333;
        }

        /* Container Styling */
        .container-fluid {
            font-family: 'Poppins', sans-serif;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .galeri-title-container {
                gap: 1rem;
            }

            .galeri-line {
                max-width: 80px;
            }

            .galeri-title-line {
                font-size: 2rem;
            }

            .gallery-img {
                height: 250px;
            }
        }

        @media (max-width: 576px) {
            .galeri-title-container {
                gap: 0.8rem;
                flex-wrap: wrap;
            }

            .galeri-line {
                max-width: 60px;
                height: 2px;
            }

            .galeri-title-line {
                font-size: 1.5rem;
                width: 100%;
                order: 2;
            }

            .galeri-line:first-child {
                order: 1;
            }

            .galeri-line:last-child {
                order: 3;
            }

            .gallery-img {
                height: 200px;
            }
        }
    </style>

</head>
<body>
    <?php include('admin/template/navbar.php'); ?>

    <!-- Galeri -->
    <div class="container-fluid py-5 mt-4">
        <div class="container">
            <div class="text-center galeri-title-container">
                <div class="galeri-line"></div>
                <h1 class="galeri-title-line">Galeri</h1>
                <div class="galeri-line"></div>
            </div>

            <div class="row g-4">
                <!-- Contoh Gambar 1 -->
                <div class="col-md-6">
                    <div class="mb-4">
                        <img src="asset/img/For PG1.jpg" class="img-fluid rounded-4 shadow gallery-img"
                             alt="Kerjasama PT. Pramudita"
                             data-title="Kerjasama PT. Pramudita dengan Telkom University"
                             data-date="24 Oktober 2025"
                             data-desc="Kegiatan kerjasama dalam rangka digitalisasi PT. Pramudita Pupuk Nusantara dengan Telkom University dalam rangka mendukung proses bisnis yang lebih modern dan efisien."
                             data-img="asset/img/For PG1.jpg"
                             style="width: 100%; object-fit: cover; cursor:pointer;">
                    </div>
                    <div class="mb-4">
                        <img src="asset/img/For PG3.jpg" class="img-fluid rounded-4 shadow gallery-img"
                             alt="Program Pertanian Berkelanjutan"
                             data-title="Program Pertanian Berkelanjutan"
                             data-date="10 Oktober 2025"
                             data-desc="Inisiatif ramah lingkungan untuk mendukung pertanian berkelanjutan di wilayah Jawa Barat."
                             data-img="asset/img/For PG3.jpg"
                             style="width: 100%; object-fit: cover; cursor:pointer;">
                    </div>
                </div>

                <!-- Contoh Gambar 2 -->
                <div class="col-md-6">
                    <div class="mb-4">
                        <img src="asset/img/For PG2.jpg" class="img-fluid rounded-4 shadow gallery-img"
                             alt="Inovasi Digitalisasi Pupuk"
                             data-title="Inovasi Digitalisasi Pupuk"
                             data-date="5 Oktober 2025"
                             data-desc="Proyek pengembangan sistem digitalisasi distribusi pupuk untuk efisiensi rantai pasok nasional."
                             data-img="asset/img/For PG2.jpg"
                             style="width: 100%; object-fit: cover; cursor:pointer;">
                    </div>
                    <div class="mb-4">
                        <img src="asset/img/For PG4.jpg" class="img-fluid rounded-4 shadow gallery-img"
                             alt="Kegiatan Sosial PPN"
                             data-title="Kegiatan Sosial PPN"
                             data-date="20 September 2025"
                             data-desc="PT. Pramudita Pupuk Nusantara melaksanakan kegiatan sosial bersama masyarakat sekitar."
                             data-img="asset/img/For PG4.jpg"
                             style="width: 100%; object-fit: cover; cursor:pointer;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Popup -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4" style="background-color:#F5FAF6;">
                <div class="modal-header border-0 justify-content-start">
                    <img src="asset/img/logo.png" alt="Logo" style="height:40px;">
                </div>
                <div class="modal-body text-center">
                    <img id="modalImg" src="" alt="Detail Gambar" class="img-fluid rounded-4 mb-3 shadow" style="max-height:300px; object-fit:cover;">
                    <p class="text-muted mb-1 fw-semibold" id="modalDate"></p>
                    <h5 class="fw-bold mb-2" id="modalTitle"></h5>
                    <p class="px-3 fw-normal" id="modalDesc"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS + Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const modal = new bootstrap.Modal(document.getElementById('imageModal'), {
            backdrop: true, 
            keyboard: true
        });

        document.querySelectorAll('.gallery-img').forEach(img => {
            img.addEventListener('click', () => {
                document.getElementById('modalImg').src = img.dataset.img;
                document.getElementById('modalTitle').textContent = img.dataset.title;
                document.getElementById('modalDate').textContent = img.dataset.date;
                document.getElementById('modalDesc').textContent = img.dataset.desc;
                modal.show();
            });
        });
    </script>

    <!-- WA -->
    <?php include ('admin/template/whatsapp_float.php'); ?>

    <!-- Footer -->
    <?php include('admin/template/footer.php'); ?>

</body>
</html>
