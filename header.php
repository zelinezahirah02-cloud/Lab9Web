<?php
// Path aset dibuat absolut terhadap lokasi aplikasi agar tetap benar jika URL di-rewrite
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/') . '/';
$menu = [
    'dashboard' => 'Dashboard',
    'user/list' => 'Pengguna',
    'profil'    => 'Profil',
    'kontak'    => 'Kontak',
];
$group = static fn(string $p): string => explode('/', $p)[0];
?>
<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title><?= e($pageTitle ?? 'Aplikasi') ?> - Aplikasi PHP Modular</title>
 <link rel="stylesheet" href="<?= e($basePath) ?>assets/css/style.css">
</head>
<body>
<div class="container">
 <header>
  <h1>Aplikasi PHP Modular</h1>
  <p>CRUD Pengguna dengan template, helper, dan router</p>
 </header>
 <nav>
  <?php foreach ($menu as $route => $label): ?>
   <a class="<?= $group($route) === $group($page) ? 'active' : '' ?>"
      href="<?= e($basePath . url($route)) ?>"><?= e($label) ?></a>
  <?php endforeach; ?>
 </nav>
 <main>
  <?php tampilkanFlash(); ?>
