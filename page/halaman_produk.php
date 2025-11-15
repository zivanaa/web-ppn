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
        * { font-family: 'Poppins', sans-serif; }
        body { font-weight: 400; }
        h1, h2, h3, h4, h5, h6 { font-weight: 600; }
        .fw-bold { font-weight: 700 !important; }
        .fw-semibold { font-weight: 600 !important; }

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

        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e0e0e0;
            border-radius: 15px;
            overflow: hidden;
            background: #fff;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(27, 89, 48, 0.15) !important;
        }

        .product-image-wrapper {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            background: #f8f9fa;
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 1rem;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.3px;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .product-category {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .product-description {
            font-size: 0.9rem;
            color: #777;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.3rem;
            margin-bottom: 1rem;
        }

        .badge-custom {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-weight: 600;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1B5930;
            margin-bottom: 1rem;
        }

        .btn-selengkapnya {
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.2px;
            text-decoration: none;
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background: linear-gradient(90deg, #2B8D4C 0%, #D5D44B 100%);
            color: white !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-align: center;
            margin-top: auto;
        }

        .btn-selengkapnya:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(43, 141, 76, 0.3);
            text-decoration: none;
        }

        /* Filter Section */
        .filter-section {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 500px;
        }

        .search-box input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .no-products {
            text-align: center;
            padding: 4rem 2rem;
        }

        .no-products i {
            font-size: 4rem;
            color: #ccc;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .produk-title-line { font-size: 2rem; }
            .product-name { font-size: 1rem; }
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

        <!-- Products Grid -->
        <div class="row g-4 pb-5">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="product-card">
                            <div class="product-image-wrapper">
                                <img src="<?= $base_url ?>asset/img/<?= htmlspecialchars($product['gambar_kecil']) ?>" 
                                     alt="<?= htmlspecialchars($product['nama']) ?>" 
                                     class="product-image"
                                     onerror="this.src='<?= $base_url ?>asset/img/placeholder.png'">
                            </div>
                            <div class="product-content">
                                <h5 class="product-name"><?= htmlspecialchars($product['nama']) ?></h5>
                                <p class="product-category">
                                    <i class="bi bi-tag"></i> <?= htmlspecialchars($product['kategori']) ?>
                                </p>
                                
                                <?php if (!empty($product['deskripsi'])): ?>
                                    <p class="product-description">
                                        <?= htmlspecialchars($product['deskripsi']) ?>
                                    </p>
                                <?php endif; ?>

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
                                                default: $badge_class = 'bg-secondary';
                                            }
                                        ?>
                                            <span class="badge badge-custom <?= $badge_class ?>">
                                                <?= htmlspecialchars($atribut) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="product-price">
                                    Rp <?= number_format($product['harga'], 0, ',', '.') ?>
                                </div>

                                <a href="<?= $base_url ?>page/detail_produk.php?id=<?= $product['id'] ?>" 
                                   class="btn-selengkapnya">
                                    Selengkapnya <i class="bi bi-arrow-right"></i>
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