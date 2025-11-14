<?php
    session_start();
    switch ($_GET['mod']) {
        case 'produk': include "page/produk.php"; break;
        case 'ulasan': include "page/ulasan.php"; break;
        case 'galeri': include "page/galeri.php"; break;
        case 'diskon': include "page/diskon.php"; break;
        case 'logout': 
            session_destroy();
            header('Location: ../'); 
            break;
    }
?>
