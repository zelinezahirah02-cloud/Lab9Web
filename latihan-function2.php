<?php
// Latihan function: memanggil helpers.php (halaman 2)
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/header.php';
?>
<section class="content">
 <h2>Latihan Function (Halaman 2)</h2>
 <p>Harga Rp 200.000 setelah diskon 15%: <?= formatRupiah(200000 - hitungDiskon(200000, 15)) ?></p>
 <p>0&deg;C = <?= konversiCelciusKeFahrenheit(0) ?>&deg;F</p>
 <p>Nilai 90 = predikat <?= tentukanStatusNilai(90) ?></p>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
