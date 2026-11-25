<?php
$errors = [];
$nama = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid()) {
        $errors[] = 'Token keamanan tidak valid. Muat ulang halaman.';
    } else {
        $nama  = trim((string) ($_POST['nama'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        if ($nama === '' || mb_strlen($nama) > 100) $errors[] = 'Nama wajib diisi (maks. 100 karakter).';
        if (!validasiEmail($email))                 $errors[] = 'Format email tidak valid.';

        if (!$errors) {
            try {
                $stmt = $pdo->prepare('INSERT INTO users (nama, email) VALUES (:nama, :email)');
                $stmt->execute([':nama' => $nama, ':email' => $email]);
                setFlash('sukses', 'Pengguna berhasil ditambahkan.');
                redirect('user/list');
            } catch (PDOException $ex) {
                if ($ex->getCode() === '23000') {
                    $errors[] = 'Email sudah terdaftar.';
                } else {
                    error_log($ex->getMessage());
                    $errors[] = 'Gagal menyimpan data.';
                }
            }
        }
    }
}
?>
<section>
 <h2>Tambah Pengguna</h2>
 <?php foreach ($errors as $err): ?><div class="alert alert-error"><?= e($err) ?></div><?php endforeach; ?>
 <form method="post" action="<?= e(url('user/add')) ?>">
  <?= csrfField() ?>
  <label>Nama</label>
  <input type="text" name="nama" value="<?= e($nama) ?>" required>
  <label>Email</label>
  <input type="email" name="email" value="<?= e($email) ?>" required>
  <p><button type="submit">Simpan</button>
  <a href="<?= e(url('user/list')) ?>">Batal</a></p>
 </form>
</section>
