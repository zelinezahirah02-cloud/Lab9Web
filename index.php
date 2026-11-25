<?php
// index.php - titik masuk aplikasi dan router
session_start();
ob_start(); // memungkinkan redirect dari modul setelah header dimuat

require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/config/database.php';

// Whitelist rute: hanya halaman ini yang boleh dimuat
$routes = [
    'dashboard'   => __DIR__ . '/views/dashboard.php',
    'profil'      => __DIR__ . '/views/profil.php',
    'kontak'      => __DIR__ . '/views/kontak.php',
    'user/list'   => __DIR__ . '/modules/user/list.php',
    'user/add'    => __DIR__ . '/modules/user/add.php',
    'user/edit'   => __DIR__ . '/modules/user/edit.php',
    'user/delete' => __DIR__ . '/modules/user/delete.php',
];

$titles = [
    'dashboard' => 'Dashboard', 'profil' => 'Profil', 'kontak' => 'Kontak',
    'user/list' => 'Data Pengguna', 'user/add' => 'Tambah Pengguna',
    'user/edit' => 'Ubah Pengguna', 'user/delete' => 'Hapus Pengguna',
];

$page = $_GET['page'] ?? 'dashboard';

if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $page = '404';
    $pageTitle = '404 - Tidak Ditemukan';
    $contentFile = __DIR__ . '/views/404.php';
} else {
    $pageTitle = $titles[$page];
    $contentFile = $routes[$page];
}

require_once __DIR__ . '/views/header.php';
require $contentFile;
require_once __DIR__ . '/views/footer.php';
ob_end_flush();
