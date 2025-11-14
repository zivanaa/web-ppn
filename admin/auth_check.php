<?php

session_start();


if (empty($_SESSION['user']) || empty($_SESSION['user']['is_admin'])) {
   
    $_SESSION['login_error'] = 'Silakan login terlebih dahulu.';
    header('Location: /'); 
    exit;
}
