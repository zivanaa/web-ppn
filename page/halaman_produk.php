<?php
// page/halaman_produk.php - INTEGRATED VERSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include config files
include($_SERVER['DOCUMENT_ROOT'] . '/WEB_PPN/config/config.php');
include($_SERVER['DOCUMENT_ROOT'] . '/WEB_PPN/config/koneksi.php');

// Get filter parameters
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$kategori_filter = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : '';

// Build WHERE clause
$where = ["status IN ('Aktif', 'Dipajang')"];
$params = [];
$types = '';

if (!empty($search)) {
    $where[] = "(nama LIKE ? OR deskripsi LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= 'ss';
}

if (!empty($kategori_filter)) {
    $where[] = "kategori = ?";
    $params[] = $kategori_filter;
    $types .= 's';
}

$where_sql = "WHERE " . implode(' AND ', $where);

// Query products
$query = "SELECT * FROM produk $where_sql ORDER BY tanggal DESC";

if (!empty($params)) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = mysqli_query($conn, $query);
}

// Get all categories for filter
$kategori_query = "SELECT DISTINCT kategori FROM produk WHERE status IN ('Aktif', 'Dipajang') ORDER BY kategori";
$kategori_result = mysqli_query($conn, $kategori_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - PTPPN</title>
    
    <!-- Favicon -->
    <link href="<?= $base_url ?>asset/img/LogoIco.ico" rel="icon">
    
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
    <link href="<?= $base_url ?>asset/style/halaman_produk.css" rel="stylesheet">
    
    <style>
        /* Reset & Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
    overflow-x: hidden;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    animation: fadeIn 0.8s ease-in;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

/* Navbar dropdown muncul */
.navbar {
    overflow: visible !important;
    position: relative;
    z-index: 1000;
}

/* Full-width main content */
.main-content {
    width: 100%;
    margin: 0;
    padding: 0;
    background-color: #f6f7f9;
}

/* Semua section full-width */
.hero-section,
.main-product,
.detail-section,
.benefits-section,
.usage-section {
    width: 100%;
    padding: 3rem 0;
}

/* Konten di dalam section */
.hero-content,
.detail-content,
.benefits-grid,
.usage-category,
.usage-item {
    max-width: 1200px;
    margin: 0 auto;
    padding-left: 40px;
    padding-right: 40px;
}

/* Hero Section */
.hero-section {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 3rem 0;
}
.hero-divider {
    flex: 1;
    height: 2px;
    background: #28a745;
    margin: 0 1rem;
}
.hero-title {
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    letter-spacing: 1px;
}

/* ===== MAIN PRODUCT (gambar + deskripsi) ===== */
.main-product {
    display: flex;
    flex-wrap: wrap;
    gap: 2.5rem;
    align-items: center;
    justify-content: center;
    max-width: 1200px;
    margin: 0 auto 3rem auto;
    padding: 3rem 50px;
    background: transparent; 
}
.product-image-container {
    flex: 1 1 400px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.product-image {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.product-description {
    flex: 1 1 400px;
    font-size: 1.05rem;
    line-height: 1.7;
}
.product-title {
    font-weight: 700;
    font-size: 1.5rem;
    color: #28a745;
    margin-bottom: 1rem;
}

/* Button */
.order-btn, .order-btn-bottom {
    background: linear-gradient(90deg, #2B8D4C 0%, #D5D44B 100%);
    color: white;
    border: none;
    padding: 12px 35px;
    cursor: pointer;
    border-radius: 50px; 
    margin-top: 15px;
    font-weight: 600;
    letter-spacing: 0.3px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(43, 141, 76, 0.3);
}
.order-btn:hover, .order-btn-bottom:hover {
    filter: brightness(1.1);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(43, 141, 76, 0.4);
}

/* ===== CARD WRAPPER UNTUK SECTION ===== */
.detail-section,
.benefits-section,
.usage-section {
    background: #ffffff;
    max-width: 1200px;
    margin: 0 auto 3rem auto;
    border-radius: 16px;
    padding: 3rem 50px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

/* Section Title */
.section-title {
    font-weight: 700;
    font-size: 1.6rem;
    color: #28a745;
    text-align: center;
    margin-bottom: 2rem;
    letter-spacing: 0.5px;
}

.detail-content {
    font-size: 1.05rem;
    line-height: 1.7;
    text-align: justify;
}

/* Benefits Grid */
.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}
.benefit-card {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: 0.3s;
}
.benefit-card:hover {
    background-color: #e9f9ed;
    transform: translateY(-3px);
}
.benefit-icon {
    font-size: 1.5rem;
    color: #fff200ff;
}

/* Usage Section */
.usage-category {
    margin-bottom: 2.5rem;
}
.usage-subtitle {
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: #333;
}
.usage-item {
    margin-bottom: 0.75rem;
    line-height: 1.6;
}
.dosage {
    font-weight: bold;
    color: #28a745;
}

/* Responsiveness */
@media (max-width: 768px) {
    .hero-title {
        font-size: 1.5rem;
    }
    .main-product {
        flex-direction: column;
        text-align: center;
        padding: 2rem 25px;
    }
    .product-description {
        padding-top: 1rem;
    }
    .benefits-grid {
        gap: 1rem;
    }
    .detail-section,
    .benefits-section,
    .usage-section {
        padding: 2rem 25px;
    }
}


/* Hero Section */
.hero-section {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 0 40px;
    gap: 30px;
    animation: fadeIn 1s ease-in;
}

.hero-divider {
    height: 2px;
    width: 150px;
    background: linear-gradient(90deg, transparent, #4CAF50, transparent);
    animation: slideInLeft 1s ease-out;
}

.hero-divider.left {
    background: linear-gradient(90deg, transparent, #4CAF50);
}

.hero-divider.right {
    background: linear-gradient(90deg, #4CAF50, transparent);
    animation: slideInRight 1s ease-out;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    color: #2E7D32;
    letter-spacing: 3px;
    text-align: center;
    position: relative;
    animation: scaleIn 0.8s ease-out;
}

.hero-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 4px;
    background: #4CAF50;
    border-radius: 2px;
}

/* Product Header */
.product-header {
    text-align: center;
    padding: 20px 0;
    animation: fadeIn 1.2s ease-in;
}

.product-title {
    font-size: 1.5rem;
    color: #333;
    font-weight: 500;
}

/* Main Product Section */
.main-product {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
    padding: 40px 0;
    margin: 40px 0;
}

.product-image-container {
    animation: slideInLeft 1s ease-out;
}

.product-image-wrapper {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.product-image-wrapper::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        45deg,
        transparent,
        rgba(76, 175, 80, 0.1),
        transparent
    );
    animation: shimmer 3s infinite;
}

.product-image-wrapper:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 20px 60px rgba(76, 175, 80, 0.3);
}

.product-image {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.4s ease;
}

.product-image-wrapper:hover .product-image {
    transform: scale(1.1);
}

.product-description {
    animation: slideInRight 1s ease-out;
}

.product-text {
    font-size: 1.2rem;
    line-height: 1.8;
    color: #555;
    margin-bottom: 30px;
    position: relative;
    padding-left: 20px;
}

.product-text::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: linear-gradient(180deg, #4CAF50, #2E7D32);
    border-radius: 2px;
}

/* Buttons */
.order-btn, .order-btn-bottom {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    color: white;
    padding: 15px 40px;
    border: none;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
    position: relative;
    overflow: hidden;
}

.order-btn::before, .order-btn-bottom::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.order-btn:hover::before, .order-btn-bottom:hover::before {
    width: 300px;
    height: 300px;
}

.order-btn:hover, .order-btn-bottom:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
    animation: pulse 0.6s ease;
}

.order-btn:active, .order-btn-bottom:active {
    transform: translateY(-1px);
}

.order-btn-bottom {
    display: block;
    margin: 40px auto 0;
}

/* Detail Section */
.detail-section {
    background: white;
    padding: 50px;
    border-radius: 20px;
    margin: 40px 0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    animation: fadeIn 1.5s ease-in;
}

.section-title {
    font-size: 2rem;
    color: #2E7D32;
    text-align: left;
    margin-bottom: 30px;
    font-weight: 700;
    position: relative;
    display: inline-block;
    padding-bottom: 15px;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 4px;
    background: #FFC107;
    border-radius: 2px;
}

.detail-content {
    animation: fadeIn 1.8s ease-in;
}

.detail-description {
    font-size: 1.1rem;
    line-height: 1.9;
    color: #666;
    text-align: justify;
}

/* Benefits Section */
.benefits-section {
    background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 100%);
    padding: 50px;
    border-radius: 20px;
    margin: 40px 0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-top: 30px;
}

.benefit-card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: flex-start;
    gap: 15px;
    transition: all 0.3s ease;
    animation: scaleIn 0.5s ease-out;
    animation-fill-mode: both;
}

.benefit-card:nth-child(1) { animation-delay: 0.1s; }
.benefit-card:nth-child(2) { animation-delay: 0.2s; }
.benefit-card:nth-child(3) { animation-delay: 0.3s; }
.benefit-card:nth-child(4) { animation-delay: 0.4s; }
.benefit-card:nth-child(5) { animation-delay: 0.5s; }
.benefit-card:nth-child(6) { animation-delay: 0.6s; }
.benefit-card:nth-child(7) { animation-delay: 0.7s; }

.benefit-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(76, 175, 80, 0.2);
    border-left: 4px solid #4CAF50;
}

.benefit-icon {
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: bold;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.benefit-card:hover .benefit-icon {
    animation: bounce 0.6s ease;
}

.benefit-card p {
    color: #555;
    line-height: 1.6;
    font-size: 1rem;
}

/* Usage Section */
.usage-section {
    background: white;
    padding: 50px;
    border-radius: 20px;
    margin: 40px 0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    animation: fadeIn 2s ease-in;
}

.usage-category {
    margin: 40px 0;
    padding: 30px;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-radius: 15px;
    border-left: 5px solid #4CAF50;
    transition: all 0.3s ease;
    animation: slideInLeft 0.8s ease-out;
}

.usage-category:hover {
    transform: translateX(10px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.usage-subtitle {
    font-size: 1.4rem;
    color: #2E7D32;
    margin-bottom: 20px;
    font-weight: 600;
}

.usage-item {
    margin: 15px 0;
    padding: 15px;
    background: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.3s ease;
}

.usage-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.dosage {
    background: linear-gradient(135deg, #FFC107 0%, #FFB300 100%);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-weight: 700;
    font-size: 1rem;
    white-space: nowrap;
    box-shadow: 0 3px 10px rgba(255, 193, 7, 0.3);
}

.usage-item p {
    color: #555;
    line-height: 1.7;
    font-size: 1rem;
}

.usage-item strong {
    color: #2E7D32;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 968px) {
    .main-product {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-divider {
        width: 100px;
    }
    
    .benefits-grid {
        grid-template-columns: 1fr;
    }
    
    .detail-section, .benefits-section, .usage-section {
        padding: 30px;
    }
}

@media (max-width: 768px) {
    .container {
        padding: 10px;
    }
    
    .hero-title {
        font-size: 2rem;
        letter-spacing: 2px;
    }
    
    .hero-divider {
        width: 60px;
    }
    
    .product-title {
        font-size: 1.2rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .usage-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .dosage {
        align-self: flex-start;
    }
}

/* Loading Animation */
@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

/* Scroll Reveal Animation */
.reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease;
}

.reveal.active {
    opacity: 1;
    transform: translateY(0);
}

 /* Navbar dropdown muncul */
    .navbar {
        overflow: visible !important;
        position: relative;
        z-index: 1000;
    }

    /* Full-width main content */
    .main-content {
        width: 100%;
        margin: 0;
        padding: 0;
        background-color: #f6f7f9;
    }

    /* Semua section full-width */
    .hero-section,
    .main-product,
    .detail-section,
    .benefits-section,
    .usage-section {
        width: 100%;
        padding: 3rem 0;
    }

    /* Konten di dalam section */
    .hero-content,
    .detail-content,
    .benefits-grid,
    .usage-category,
    .usage-item {
        max-width: 1200px;
        margin: 0 auto;
        padding-left: 40px;
        padding-right: 40px;
    }

    /* Hero Section */
    .hero-section {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 3rem 0;
    }
    .hero-divider {
        flex: 1;
        height: 2px;
        background: #28a745;
        margin: 0 1rem;
    }
    .hero-title {
        font-size: 2rem;
        font-weight: bold;
        text-align: center;
        letter-spacing: 1px;
    }

    /* ===== MAIN PRODUCT (gambar + deskripsi) ===== */
    .main-product {
        display: flex;
        flex-wrap: wrap;
        gap: 2.5rem;
        align-items: center;
        justify-content: center;
        max-width: 1200px;
        margin: 0 auto 3rem auto;
        padding: 3rem 50px;
        background: transparent; /* transparan */
    }
    .product-image-container {
        flex: 1 1 400px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .product-image {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .product-description {
        flex: 1 1 400px;
        font-size: 1.05rem;
        line-height: 1.7;
    }

    .product-title {
        font-weight: 700;
        font-size: 1.5rem;
        color: #28a745;
        margin-bottom: 1rem;
    }

.order-btn, .order-btn-bottom {
    background: linear-gradient(90deg, #2B8D4C 0%, #D5D44B 100%);
    color: white;
    border: none;
    padding: 12px 35px;
    cursor: pointer;
    border-radius: 50px; 
    margin-top: 15px;
    font-weight: 600;
    letter-spacing: 0.3px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(43, 141, 76, 0.3);
}

.order-btn:hover, .order-btn-bottom:hover {
    filter: brightness(1.1);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(43, 141, 76, 0.4);
}


    /* ===== CARD WRAPPER UNTUK SECTION ===== */
    .detail-section,
    .benefits-section,
    .usage-section {
        background: #ffffff;
        max-width: 1200px;
        margin: 0 auto 3rem auto;
        border-radius: 16px;
        padding: 3rem 50px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    /* Section Title */
    .section-title {
        font-weight: 700;
        font-size: 1.6rem;
        color: #28a745;
        text-align: center;
        margin-bottom: 2rem;
        letter-spacing: 0.5px;
    }

    .detail-content {
        font-size: 1.05rem;
        line-height: 1.7;
        text-align: justify;
    }

    /* Benefits Grid */
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    .benefit-card {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: 0.3s;
    }
    .benefit-card:hover {
        background-color: #e9f9ed;
        transform: translateY(-3px);
    }
    .benefit-icon {
        font-size: 1.5rem;
        color: #fff200ff;
    }

    /* Usage Section */
    .usage-category {
        margin-bottom: 2.5rem;
    }
    .usage-subtitle {
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #333;
    }
    .usage-item {
        margin-bottom: 0.75rem;
        line-height: 1.6;
    }
    .dosage {
        font-weight: bold;
        color: #28a745;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 1.5rem;
        }
        .main-product {
            flex-direction: column;
            text-align: center;
            padding: 2rem 25px;
        }
        .product-description {
            padding-top: 1rem;
        }
        .benefits-grid {
            gap: 1rem;
        }
        .detail-section,
        .benefits-section,
        .usage-section {
            padding: 2rem 25px;
        }
    }
    </style>
    
</head>
<body>

<?php include(__DIR__ . '/../admin/template/navbar.php'); ?>

<div class="container-fluid" style="background-color: #ffffff; min-height: 100vh;">
    <div class="container">
        <div class="text-center produk-title-container">
            <h1 class="produk-title-line">PRODUK</h1>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cari Produk</label>
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari berdasarkan nama atau deskripsi..." 
                               value="<?= htmlspecialchars($search) ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php 
                        mysqli_data_seek($kategori_result, 0);
                        while ($kat = mysqli_fetch_assoc($kategori_result)): 
                        ?>
                            <option value="<?= htmlspecialchars($kat['kategori']) ?>" 
                                    <?= $kategori_filter === $kat['kategori'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($kat['kategori']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </form>
            
            <?php if (!empty($search) || !empty($kategori_filter)): ?>
                <div class="mt-3">
                    <a href="<?= $base_url ?>produk" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-circle"></i> Clear Filter
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <br></br>

        <!-- Products Grid -->
        <div class="row g-4 pb-5">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="product-card">
                            <div class="product-image-wrapper">
                                <img src="<?= $base_url ?>asset/img/<?= htmlspecialchars($product['gambar']) ?>" 
                                     alt="<?= htmlspecialchars($product['nama']) ?>" 
                                     class="product-image"
                                     onerror="this.src='<?= $base_url ?>asset/img/placeholder.png'">
                            </div>
                            <div class="product-content">
                                <h5 class="product-name"><?= htmlspecialchars($product['nama']) ?></h5>
                                

                                

                                <a href="<?= $base_url ?>page/detail_produk.php?id=<?= $product['id'] ?>" 
                                   class="btn-selengkapnya">
                                    Selengkapnya 
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="no-products">
                        <i class="bi bi-inbox"></i>
                        <h4 class="fw-semibold text-muted">Tidak ada produk ditemukan</h4>
                        <p class="text-muted">
                            <?php if (!empty($search)): ?>
                                Tidak ada produk yang sesuai dengan pencarian "<?= htmlspecialchars($search) ?>"
                            <?php elseif (!empty($kategori_filter)): ?>
                                Tidak ada produk dalam kategori "<?= htmlspecialchars($kategori_filter) ?>"
                            <?php else: ?>
                                Belum ada produk yang tersedia saat ini.
                            <?php endif; ?>
                        </p>
                        <?php if (!empty($search) || !empty($kategori_filter)): ?>
                            <a href="<?= $base_url ?>produk" class="btn btn-success mt-3">
                                <i class="bi bi-arrow-left"></i> Lihat Semua Produk
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- WA Float -->
<?php include(__DIR__ . '/../admin/template/whatsapp_float.php'); ?>

<!-- Footer -->
<?php include(__DIR__ . '/../admin/template/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>