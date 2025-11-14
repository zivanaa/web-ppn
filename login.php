<?php
session_start();

$ADMIN_USERNAME = 'admin';
$ADMIN_PASSWORD = 'admin';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === $ADMIN_USERNAME && $password === $ADMIN_PASSWORD) {
    $_SESSION['user'] = [
        'username' => $ADMIN_USERNAME,
        'is_admin' => true
    ];

    // Redirect setelah login
    header('Location: admin/template/sidebar.php');
    exit;
} else {
    $_SESSION['login_error'] = 'Username atau password salah.';
    header('Location: index.php');
    exit;
}
