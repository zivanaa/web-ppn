<?php

include('koneksi.php');

$category = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$search = isset($_GET['cari']) ? $_GET['cari'] : '';

if ($category === 'Semua') {
    $sql = "SELECT produk.*, diskon.diskon, diskon.status AS status_diskon FROM produk LEFT JOIN diskon ON produk.id = diskon.id_produk";
    if ($search) {
        $sql .= " WHERE nama LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_param = "%" . $search . "%";
        $stmt->bind_param("s", $search_param);
    } else {
        $stmt = $conn->prepare($sql);
    }
} else {
    $sql = "SELECT produk.*, diskon.diskon, diskon.status AS status_diskon FROM produk LEFT JOIN diskon ON produk.id = diskon.id_produk WHERE kategori = ?";
    if ($search) {
        $sql .= " AND nama LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_param = "%" . $search . "%";
        $stmt->bind_param("ss", $category, $search_param);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $category);
    }
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $atribut = htmlspecialchars($row["atribut"]);
        $cek_atribut = array("Baru", "Laris", "Promo", "Bonus", "Habis");
        
        if (htmlspecialchars($row["status"]) !== 'Non-aktif') {
            echo '<div class="col">
                    <div class="card h-100">
                        <img src="asset/img/' .htmlspecialchars($row["gambar_kecil"]). '" class="card-img-top" alt="' .htmlspecialchars($row["nama"]). '" data-bs-toggle="modal" data-bs-target="#menuModal' .htmlspecialchars($row["id"]). '">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between" style="font-size: 0.9em;">
                                <div><span>' .htmlspecialchars($row["nama"]). '</span>
                                    <div style="margin-top: 5px;">';
                        for ($i = 0; $i < count($cek_atribut); $i++) {
                            if (strpos($atribut, $cek_atribut[$i]) !== false) {
                                if ($i > 0) {
                                    echo '&nbsp;';
                                }

                                switch ($cek_atribut[$i]) {
                                    case "Baru": echo '<span class="badge rounded-pill text-bg-primary">' .$cek_atribut[$i]. '</span>'; break;
                                    case "Laris": echo '<span class="badge rounded-pill text-bg-warning">' .$cek_atribut[$i]. '</span>'; break;
                                    case "Promo": echo '<span class="badge rounded-pill text-bg-success">' .$cek_atribut[$i]. '</span>'; break;
                                    case "Bonus": echo '<span class="badge rounded-pill text-bg-info">' .$cek_atribut[$i]. '</span>'; break;
                                    case "Habis": echo '<span class="badge rounded-pill text-bg-danger">' .$cek_atribut[$i]. '</span>'; break;
                                }
                            }
                        }                  
                                        
            echo '                   </div>
                                </div>
                                <div class="text-right">';

                                if (htmlspecialchars($row["diskon"]) > 0 && htmlspecialchars($row["status_diskon"]) === "Berjalan") {
                                    echo '<span class="text-danger text-decoration-line-through" style="font-size: 0.8em;">Rp ' .htmlspecialchars(number_format($row["harga"], 0, ',', '.')). '</span>&nbsp;';
                                    echo '<span class="badge rounded-pill text-bg-success">' .htmlspecialchars($row["diskon"]). '%</span>';
                                    echo '<div style="margin-top: 2px;">';
                                    echo '<span class="text-dark fs-6" style="font-size: 0.8em;">Rp ' .htmlspecialchars(number_format($row["harga"]*(100-intval(htmlspecialchars($row["diskon"])))/100, 0, ',', '.')). '</span>';
                                    echo '</div>';
                                } else {
                                    echo '<span class="text-dark" style="font-size: 0.8em;">Rp ' .htmlspecialchars(number_format($row["harga"], 0, ',', '.')). '</span>';
                                }
            echo '              </div>
                            </h5>
                        </div>
                    </div>
                </div>';
            echo '<div class="modal fade" id="menuModal' .htmlspecialchars($row["id"]). '" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bolder" id="menuModalLabel">' .htmlspecialchars($row["nama"]). '</h1>
                                <div>';
                                for ($j = 0; $j < count($cek_atribut); $j++) {
                                    if (strpos($atribut, $cek_atribut[$j]) !== false) {
                                        if ($j > 0) {
                                            echo '&nbsp;';
                                        } else {
                                            echo '&ensp;';
                                        }
            
                                        switch ($cek_atribut[$j]) {
                                            case "Baru": echo '<span class="badge rounded-pill text-bg-primary">' .$cek_atribut[$j]. '</span>'; break;
                                            case "Laris": echo '<span class="badge rounded-pill text-bg-warning">' .$cek_atribut[$j]. '</span>'; break;
                                            case "Promo": echo '<span class="badge rounded-pill text-bg-success">' .$cek_atribut[$j]. '</span>'; break;
                                            case "Bonus": echo '<span class="badge rounded-pill text-bg-info">' .$cek_atribut[$j]. '</span>'; break;
                                            case "Habis": echo '<span class="badge rounded-pill text-bg-danger">' .$cek_atribut[$j]. '</span>'; break;
                                        }
                                    }
                                } 
            echo '              </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body ">
                                <img src="asset/img/' .htmlspecialchars($row["gambar"]). '" class="card-img-top mb-3" alt="' .htmlspecialchars($row["nama"]). '">
                                <p class="mb-2">' .htmlspecialchars($row["deskripsi"]). '</p>
                                <div class="d-flex align-items-center">';
                                if (htmlspecialchars($row["diskon"]) > 0 && htmlspecialchars($row["status_diskon"]) === "Berjalan") {
                                    echo '<span class="text-decoration-line-through text-danger mt-1">Rp ' .htmlspecialchars(number_format($row["harga"], 0, ',', '.')). '</span>&ensp;';
                                    echo '<span class="text-dark h5 fs-5 mt-1" >Rp ' .htmlspecialchars(number_format($row["harga"]*(100-intval(htmlspecialchars($row["diskon"])))/100, 0, ',', '.')). '</span>&ensp;';
                                    echo '<span class="badge rounded-pill text-bg-success">' .htmlspecialchars($row["diskon"]). '%</span>';
                                } else {
                                    echo '<p class="fs-5">Rp ' .htmlspecialchars(number_format($row["harga"], 0, ',', '.')). '</p>';
                                }
            echo '              </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>';
        }
    }
}

$stmt->close();
?>
