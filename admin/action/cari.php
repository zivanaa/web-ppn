<?php
$cari = $_POST['cari'];

if ($cari === '') {
    header('Location: ../produk');
} else {
    header('Location: ../produk&cari=' .$cari);
}
exit;
?>