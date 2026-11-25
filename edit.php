<?php
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    setFlash('gagal', 'ID pengguna tidak valid.');
    redirect('user/list');
}

$stmt = $pdo->prepare('SELECT id, nama, email FROM users WHERE id = :id');
$stmt->execute([':id' => $id]);
$user = $stmt->fetch();
if (!$user) {
    setFlash('gagal', 'Pengguna tidak ditemukan.');
    redirect('user/list');
}

$errors = [];
$nama  = $user['nama'];
$email = $user['email'];

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
                $upd = $pdo->prepare('UPDATE users SET nama = :nama, email = :email WHERE id = :id');
                $upd->execute([':nama' => $nama, ':email' => $email, ':id' => $id]);
                setFlash('sukses', 'Data pengguna berhasil diperbarui.');
                redirect('user/list');
            } catch (PDOException $ex) {
                if ($ex->getCode() === '23000') {
                    $errors[] = 'Email sudah digunakan pengguna lain.';
                } else {
                    error_log($ex->getMessage());
                    $errors[] = 'Gagal memperbarui data.';
                }
            }
        }
    }
}
?>
<section>
 <h2>Ubah Pengguna</h2>
 <?php foreach ($errors as $err): ?><div class="alert alert-error"><?= e($err) ?></div><?php endforeach; ?>
 <form method="post" action="<?= e(url('user/edit', ['id' => $id])) ?>">
  <?= csrfField() ?>
  <label>Nama</label>
  <input type="text" name="nama" value="<?= e($nama) ?>" required>
  <label>Email</label>
  <input type="email" name="email" value="<?= e($email) ?>" required>
  <p><button type="submit">Perbarui</button>
  <a href="<?= e(url('user/list')) ?>">Batal</a></p>
 </form>
</section>
