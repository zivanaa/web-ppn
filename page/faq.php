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
  <title>FAQ Pupuk Silika</title>
  
  <!-- Google Fonts - Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="asset/style/page_faq.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    /* === Global Font Poppins === */
    * {
      font-family: 'Poppins', sans-serif;
    }

    html, body {
      height: 100%;
    }

    body {
      font-family: 'Poppins', sans-serif;
      font-weight: 400;
      display: flex;
      flex-direction: column;
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

    button {
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
    }

    span {
      font-family: 'Poppins', sans-serif;
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

    /* === Main Content Flex === */
    main, .main-content {
      flex: 1;
    }

    /* === FAQ Section === */
    .faq-section {
      font-family: 'Poppins', sans-serif;
      flex: 1;
    }

    /* === FAQ Title === */
    .faq-title {
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      font-size: 3.5rem;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #1B5930;
    }

    /* === FAQ Description === */
    .faq-desc {
      font-family: 'Poppins', sans-serif;
      font-weight: 400;
      line-height: 1.8;
      font-size: 1.1rem;
      color: #333;
    }

    /* === FAQ Question Button === */
    .faq-question {
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      font-size: 1.15rem;
      letter-spacing: 0.3px;
      transition: all 0.3s ease;
      color: #1B5930;
    }

    .faq-question:hover {
      font-family: 'Poppins', sans-serif;
      transform: translateX(5px);
    }

    .faq-question span {
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      font-size: 1.15rem;
    }

    /* === FAQ Answer === */
    .faq-answer {
      font-family: 'Poppins', sans-serif;
    }

    .faq-answer p {
      font-family: 'Poppins', sans-serif;
      font-weight: 400;
      line-height: 1.9;
      font-size: 1.05rem;
      color: #555;
    }

    /* === FAQ Item === */
    .faq-item {
      font-family: 'Poppins', sans-serif;
      margin-bottom: 1.5rem;
    }

    /* === FAQ Wrapper === */
    .faq-wrapper {
      font-family: 'Poppins', sans-serif;
    }

    /* === FAQ Content === */
    .faq-content {
      font-family: 'Poppins', sans-serif;
    }

    .faq-left {
      font-family: 'Poppins', sans-serif;
    }

    .faq-right {
      font-family: 'Poppins', sans-serif;
    }

    /* === FAQ Icon === */
    .icon {
      font-family: 'Poppins', sans-serif;
      font-size: 1.5rem;
    }

    /* === Footer Fix === */
    footer {
      margin-top: auto;
    }

    /* === Responsive Typography === */
    @media (max-width: 768px) {
      .faq-title {
        font-size: 2.5rem;
        letter-spacing: 1px;
      }

      .faq-desc {
        font-size: 1rem;
      }

      .faq-question {
        font-size: 1rem;
      }

      .faq-question span {
        font-size: 1rem;
      }

      .faq-answer p {
        font-size: 0.95rem;
      }
    }

    @media (max-width: 576px) {
      .faq-title {
        font-size: 2rem;
        letter-spacing: 0.5px;
      }

      .faq-desc {
        font-size: 0.95rem;
      }

      .faq-question {
        font-size: 0.95rem;
      }

      .faq-question span {
        font-size: 0.9rem;
      }

      .faq-answer p {
        font-size: 0.9rem;
      }
    }
  </style>

</head>
<body>

<?php
    include('admin/template/navbar.php');
?>

<section class="faq-section">

  <!-- background kuning -->
  <div class="faq-bg"></div>

  <div class="faq-wrapper">
    <h1 class="faq-title">FAQ</h1>

    <div class="faq-content">

      <!-- KIRI -->
      <div class="faq-left">
        <img src="asset/img/Galeri2.png" alt="Pupuk Silika" class="faq-img">
        <p class="faq-desc">
          Pupuk silika bukan sekadar pelengkap, tapi solusi untuk meningkatkan daya tahan tanaman tanpa ketergantungan pada pestisida berlebihan.
          Tertarik mencoba atau butuh konsultasi dosis? Chat WhatsApp sekarang!
        </p>
      </div>

      <!-- KANAN -->
      <div class="faq-right">

        <div class="faq-item">
          <button class="faq-question">
            <span>Apa keunggulan Pupuk Silika dibandingkan pupuk pelengkap lainnya?</span>
            <i class="bi bi-chevron-down icon"></i>
          </button>
          <div class="faq-answer">
            <p>
              Pupuk Silika tidak hanya menyuplai nutrisi, tetapi juga berperan penting dalam memperkuat dinding sel tanaman (physical barrier),
              membuat tanaman lebih tegak dan lebih tahan terhadap serangan hama dan penyakit, bahkan di cuaca ekstrem.
            </p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">
            <span>Bagaimana cara mengaplikasikan Pupuk Silika Pramudita ini pada tanaman padi/sayuran?</span>
            <i class="bi bi-chevron-down icon"></i>
          </button>
          <div class="faq-answer">
            <p>
              Larutkan pupuk silika sesuai dosis anjuran dalam air, lalu semprotkan secara merata pada daun tanaman atau campurkan ke dalam tanah.
            </p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">
            <span>Apakah Pupuk Silika ini dapat dicampur dengan pupuk kimia (NPK) yang sudah saya gunakan?</span>
            <i class="bi bi-chevron-down icon"></i>
          </button>
          <div class="faq-answer">
            <p>
              Bisa, Pupuk Silika kompatibel dengan sebagian besar pupuk kimia dan organik. Namun, sebaiknya lakukan uji coba kecil terlebih dahulu.
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script src="asset/js/faq.js"></script>

<!-- WA -->
<?php include ('admin/template/whatsapp_float.php'); ?>

<!-- Footer -->
<?php
include('admin/template/footer.php');
?>
</body>
</html>
