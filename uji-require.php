<?php
echo "Sebelum pemanggilan<br>";
require __DIR__ . '/pesan.php';
echo "Sesudah pemanggilan<br>"; // tidak dijalankan jika pesan.php tidak ditemukan
