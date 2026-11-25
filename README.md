# Lab9Web – Praktikum 9: PHP Modular

## 1. Tujuan Project
Project ini adalah hasil Praktikum 9 Pemrograman Web (PHP Modular). Tujuannya:
1. Memahami konsep dan manfaat modularisasi program.
2. Membedakan `include`, `require`, `include_once`, dan `require_once`.
3. Membuat template halaman (header dan footer) yang dipakai bersama.
4. Membuat dan memakai function PHP dengan parameter dan nilai return.
5. Menyusun struktur direktori aplikasi PHP secara modular.
6. Menerapkan routing sederhana berbasis parameter URL dengan whitelist dan halaman 404.
7. Mengintegrasikan modularisasi dan routing ke aplikasi CRUD database (data pengguna).

## 2. Kebutuhan Perangkat
- Web server lokal Apache (XAMPP atau Laragon)
- PHP 8.0 atau lebih baru dengan ekstensi PDO MySQL
- MySQL/MariaDB dan phpMyAdmin
- Browser (Chrome, Firefox, atau Edge)
- Editor kode (Visual Studio Code)
- Git untuk mengelola repository

## 3. Cara Menjalankan Aplikasi
1. Salin folder `Lab9Web` ke docroot web server (XAMPP: `C:\xampp\htdocs\`).
2. Jalankan **Apache** dan **MySQL** dari XAMPP Control Panel.
3. Buka `http://localhost/phpmyadmin`, pilih tab **Import**, pilih `database.sql`, lalu klik **Import**.
   Database `db_latihan` dengan tabel `users` akan terbentuk.
4. Jika perlu, sesuaikan user dan password di `project/config/database.php`.
5. Buka di browser:
   - Latihan dasar: `http://localhost/Lab9Web/lab9_php_modular/home.php`
   - Aplikasi modular: `http://localhost/Lab9Web/project/index.php`

## 4. Struktur Direktori
```
Lab9Web/
├── database.sql
├── README.md
├── lab9_php_modular/          # Latihan bagian C–E
│   ├── pesan.php, uji-include.php, uji-require.php
│   ├── header.php, footer.php, style.css
│   ├── home.php, about.php, profil.php, kontak.php
│   └── helpers.php, contoh-panggil.php, latihan-function.php, latihan-function2.php
└── project/                   # Router + CRUD modular
    ├── index.php              # router / titik masuk aplikasi
    ├── .htaccess              # opsional: URL rewrite
    ├── config/database.php    # satu-satunya koneksi database (PDO)
    ├── views/                 # header, footer, dashboard, profil, kontak, 404
    ├── helpers/functions.php  # function umum
    ├── modules/user/          # list, add, edit, delete
    └── assets/css, assets/js
```

## 5. Daftar Rute
Diakses lewat `index.php?page=<rute>`.

| Rute (`page`) | File | Keterangan |
|---|---|---|
| `dashboard` (default) | views/dashboard.php | Ringkasan dan contoh helper |
| `profil` | views/profil.php | Halaman profil |
| `kontak` | views/kontak.php | Halaman kontak |
| `user/list` | modules/user/list.php | Daftar pengguna |
| `user/add` | modules/user/add.php | Tambah pengguna |
| `user/edit` | modules/user/edit.php | Ubah pengguna (`&id=...`) |
| `user/delete` | modules/user/delete.php | Hapus pengguna (hanya POST + token CSRF) |
| selain di atas | views/404.php | Status HTTP 404 |

## 6. Langkah Praktikum
1. **Include dan require**: buat `pesan.php`, `uji-include.php`, `uji-require.php`. Ubah nama `pesan.php` sementara, lalu amati perbedaannya.
2. **Template**: buat `header.php`, `footer.php`, `style.css`, lalu halaman Home, Tentang, Profil, Kontak yang memanggil template dengan `require_once __DIR__ . '/header.php'`.
3. **Function**: coba function tanpa parameter, dengan parameter, dengan return, dan dengan nilai default. Pindahkan ke `helpers.php` dan panggil dari dua halaman.
4. **Struktur direktori**: buat `config`, `views`, `helpers`, `modules`, `assets` pada folder `project`.
5. **Router**: buat `index.php` dengan array whitelist rute, validasi `is_string()`, dan halaman `views/404.php`.
6. **Integrasi CRUD**: pindahkan koneksi ke `config/database.php`, header/footer ke `views/`, function umum ke `helpers/functions.php`, halaman CRUD ke `modules/user/`, lalu ubah semua tautan menjadi `index.php?page=...`.
7. **Pengujian**: buka `index.php`, `?page=user/list`, `?page=user/add`; uji `?page=admin/rahasia`, `?page=` (kosong), dan `?page[]=x` (harus 404); uji tambah, ubah, hapus data.
8. **Tantangan**: menu aktif, pesan flash sukses/gagal, dan `.htaccess` untuk URL ringkas (butuh `mod_rewrite` dan `AllowOverride All`).

## 7. Kendala dan Solusi
| Kendala | Solusi |
|---|---|
| `Not Found` saat membuka halaman | Pastikan folder `Lab9Web` ada di `htdocs` dan tidak bertingkat ganda |
| `Failed opening required` | Periksa struktur folder dan gunakan `__DIR__` untuk path |
| `Function already declared` | Gunakan `require_once` agar file tidak dimuat dua kali |
| CSS tidak tampil | Gunakan path aset yang konsisten (`$basePath` di `views/header.php`) |
| Koneksi database gagal | Pastikan MySQL menyala, `database.sql` sudah diimpor, dan kredensial benar |
| URL rewrite tidak jalan | Aktifkan `mod_rewrite` dan `AllowOverride All`, cek lokasi `.htaccess` |

## 8. Jawaban Pertanyaan Pemahaman

**1. Pengertian modularisasi dan tiga manfaatnya**
Modularisasi adalah teknik membagi aplikasi menjadi bagian-bagian kecil (file atau modul) berdasarkan tanggung jawabnya, sehingga tiap bagian bisa dipakai ulang. Manfaatnya:
- Kode tidak ditulis berulang (header, footer, koneksi, dan function dipakai bersama).
- Perubahan lebih mudah karena cukup mengubah satu modul, misalnya menu di `header.php`.
- Aplikasi lebih mudah dipelihara, dibaca, dan diuji karena tanggung jawab tiap file jelas.
- Pekerjaan tim dapat dibagi per modul sehingga mengurangi konflik file.

**2. Perbedaan include dan require**
Jika file tidak ditemukan, `include` hanya menghasilkan peringatan (warning) dan eksekusi tetap berlanjut. `require` menghasilkan error fatal dan eksekusi dihentikan. Karena itu `require` dipakai untuk file wajib, `include` untuk file tambahan yang tidak kritis.

**3. Mengapa require_once untuk konfigurasi database**
- `require`: konfigurasi database wajib ada. Tanpanya aplikasi tidak boleh berjalan, jadi lebih aman berhenti dengan error fatal.
- `_once`: file hanya dimuat satu kali, sehingga koneksi atau variabel tidak dibuat ulang dan tidak terjadi error deklarasi ganda, walaupun dipanggil dari beberapa file.

**4. Parameter, argumen, dan nilai return**
- Parameter: variabel yang didefinisikan pada deklarasi function, misalnya `$panjang` dan `$lebar` pada `hitungLuas($panjang, $lebar)`.
- Argumen: nilai yang dikirim saat function dipanggil, misalnya `8` dan `5` pada `hitungLuas(8, 5)`.
- Nilai return: nilai yang dikembalikan function ke pemanggil dengan `return`. Nilai ini dapat disimpan, dihitung lagi, atau dipakai dalam kondisi (berbeda dengan `echo` yang hanya menampilkan).

**5. Mengapa header dan footer dipisahkan dari konten**
Karena bagian itu sama di semua halaman. Dengan memisahkannya, tidak ada kode yang disalin berulang, tampilan konsisten, dan perubahan (misalnya menu navigasi) cukup dilakukan di satu tempat. File halaman juga menjadi ringkas dan hanya berisi konten khususnya.

**6. Fungsi index.php pada routing**
`index.php` adalah titik masuk (front controller) sekaligus router. Ia membaca parameter `page`, memeriksanya terhadap daftar rute yang diizinkan, memuat `header.php`, file konten yang sesuai, dan `footer.php`, serta menampilkan halaman 404 jika rute tidak dikenal.

**7. Mengapa router memakai whitelist**
Whitelist hanya mengizinkan halaman yang sudah didaftarkan aplikasi. Pengguna tidak bisa meminta file sembarangan. Nilai tidak dikenal (kosong, bukan string, atau halaman yang tidak ada) langsung ditolak dengan 404. Selain aman, daftar rute juga menjadi dokumentasi halaman yang tersedia.

**8. Risiko menggabungkan input page langsung menjadi path require**
Contohnya `require $_GET['page'] . '.php'`. Penyerang dapat memakai path traversal (`../`) untuk membuka file di luar folder yang dimaksud, memuat file yang tidak seharusnya diakses (konfigurasi, kredensial), atau mengeksekusi file PHP lain yang tidak dimaksudkan. Pada konfigurasi tertentu, ini bisa mengarah ke eksekusi kode (Local/Remote File Inclusion).

**9. Fungsi RewriteCond dan RewriteRule**
- `RewriteCond %{REQUEST_FILENAME} !-f` dan `!-d`: syarat agar aturan hanya berlaku jika permintaan bukan file dan bukan direktori yang benar-benar ada (CSS, JS, dan gambar tetap dilayani langsung).
- `RewriteRule ^(.+)$ index.php?page=$1 [QSA,L]`: mengarahkan permintaan lainnya ke `index.php` dengan path menjadi nilai `page`, sehingga `/user/list` diteruskan ke `index.php?page=user/list`. `QSA` mempertahankan query string, `L` menandai aturan terakhir.

**10. Pembagian bagian aplikasi CRUD**
| Folder | Bagian yang dipindahkan |
|---|---|
| `config/` | Koneksi database (`database.php`: host, nama database, user, password, objek PDO) |
| `views/` | Komponen tampilan bersama: `header.php`, `footer.php`, `dashboard.php`, `404.php` |
| `helpers/` | Function umum: `e()` (escape), `formatRupiah()`, `validasiEmail()`, `ringkasTeks()`, flash message, CSRF, `url()`/`redirect()` |
| `modules/` | Fitur CRUD per domain: `modules/user/list.php`, `add.php`, `edit.php`, `delete.php` |

## 9. Catatan Keamanan
- Router memakai whitelist, bukan path dari input URL.
- Query memakai prepared statement (PDO), output di-escape dengan `e()`.
- Penghapusan data hanya lewat POST dengan token CSRF.
- Detail error koneksi database dicatat ke log, tidak ditampilkan ke pengguna.

## 10. Screenshoot
<img width="959" height="506" alt="Screenshot 2026-11-25 055949" src="https://github.com/user-attachments/assets/9a3202dd-6c57-4c36-81c1-2313163b30a9" />
<img width="959" height="503" alt="Screenshot 2026-11-25 060330" src="https://github.com/user-attachments/assets/97cc4d95-9bb2-4ca7-ac81-c87806ee846e" />
<img width="957" height="502" alt="Screenshot 2026-11-25 060356" src="https://github.com/user-attachments/assets/f6902e50-98f1-4abb-86df-b3791eecb2bd" />
<img width="959" height="501" alt="Screenshot 2026-11-25 060423" src="https://github.com/user-attachments/assets/be500d3c-d3a9-4786-a1a9-5d599ed9ceb0" />
<img width="958" height="505" alt="Screenshot 2026-11-25 060452" src="https://github.com/user-attachments/assets/cea08b80-06a5-445f-ab4f-5f5a0f421742" />
<img width="959" height="503" alt="Screenshot 2026-11-25 061006" src="https://github.com/user-attachments/assets/82fcd873-547f-42d2-a523-cd36ab9bea34" />
<img width="959" height="497" alt="Screenshot 2026-11-25 061202" src="https://github.com/user-attachments/assets/10dead2b-cee1-4c78-97bb-1cace1308959" />
<img width="959" height="503" alt="Screenshot 2026-11-25 061128" src="https://github.com/user-attachments/assets/8115b4b2-0326-4404-81fb-dc50cc6c22d0" />
<img width="959" height="503" alt="Screenshot 2026-11-25 061006" src="https://github.com/user-attachments/assets/bcbdebee-77ab-4468-b90d-9929c45e222c" />
<img width="959" height="504" alt="Screenshot 2026-11-25 061020" src="https://github.com/user-attachments/assets/afaed4f0-2c46-4ac6-96af-72bb1b471d7a" />
