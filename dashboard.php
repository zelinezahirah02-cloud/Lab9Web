<?php
$total = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
?>
<section>
 <h2>Dashboard</h2>
 <p>Selamat datang di aplikasi PHP modular.</p>
 <p>Jumlah pengguna terdaftar: <strong><?= $total ?></strong></p>
 <p><a class="btn" href="<?= e(url('user/list')) ?>">Kelola Pengguna</a></p>
 <h3>Contoh pemakaian helper</h3>
 <ul>
  <li>formatRupiah(150000) &rarr; <?= e(formatRupiah(150000)) ?></li>
  <li>hitungDiskon(200000, 15) &rarr; <?= e(formatRupiah(hitungDiskon(200000, 15))) ?></li>
  <li>validasiEmail('a@b.com') &rarr; <?= validasiEmail('a@b.com') ? 'valid' : 'tidak valid' ?></li>
  <li>ringkasTeks(...) &rarr; <?= e(ringkasTeks('Modularisasi membagi aplikasi menjadi bagian kecil yang bertanggung jawab jelas.', 40)) ?></li>
 </ul>
</section>
