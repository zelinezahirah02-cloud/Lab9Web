<?php
// Latihan function: memanggil helpers.php (halaman 1 dari minimal 2)
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/header.php';
?>
<section class="content">
 <h2>Latihan Function</h2>
 <ul>
  <li>36&deg;C = <?= konversiCelciusKeFahrenheit(36) ?>&deg;F</li>
  <li>Nilai 78 = predikat <?= tentukanStatusNilai(78) ?></li>
  <li>Total belanja 3 x Rp 25.000 = <?= formatRupiah(hitungTotal(25000, 3)) ?></li>
 </ul>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
