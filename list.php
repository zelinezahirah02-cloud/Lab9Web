<?php
$users = $pdo->query('SELECT id, nama, email FROM users ORDER BY id DESC')->fetchAll();
?>
<section>
 <h2>Data Pengguna</h2>
 <a class="btn" href="<?= e(url('user/add')) ?>">Tambah Pengguna</a>
 <table>
  <thead><tr><th>No</th><th>Nama</th><th>Email</th><th>Aksi</th></tr></thead>
  <tbody>
  <?php if (!$users): ?>
   <tr><td colspan="4">Belum ada data.</td></tr>
  <?php endif; ?>
  <?php foreach ($users as $i => $u): ?>
   <tr>
    <td><?= $i + 1 ?></td>
    <td><?= e($u['nama']) ?></td>
    <td><?= e($u['email']) ?></td>
    <td>
     <a class="btn" href="<?= e(url('user/edit', ['id' => $u['id']])) ?>">Ubah</a>
     <form class="inline" method="post" action="<?= e(url('user/delete')) ?>"
           onsubmit="return confirm('Hapus pengguna ini?');">
      <?= csrfField() ?>
      <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
      <button type="submit" class="btn-danger">Hapus</button>
     </form>
    </td>
   </tr>
  <?php endforeach; ?>
  </tbody>
 </table>
</section>
