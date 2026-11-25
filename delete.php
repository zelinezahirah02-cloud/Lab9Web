<?php
// Penghapusan hanya lewat POST + CSRF; membuka URL GET tidak menghapus data.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    setFlash('gagal', 'Metode tidak diizinkan. Gunakan tombol Hapus.');
    redirect('user/list');
}
if (!csrfValid()) {
    http_response_code(403);
    setFlash('gagal', 'Token keamanan tidak valid.');
    redirect('user/list');
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    setFlash('gagal', 'ID pengguna tidak valid.');
    redirect('user/list');
}

$stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
$stmt->execute([':id' => $id]);
setFlash($stmt->rowCount() ? 'sukses' : 'gagal',
         $stmt->rowCount() ? 'Pengguna berhasil dihapus.' : 'Pengguna tidak ditemukan.');
redirect('user/list');
