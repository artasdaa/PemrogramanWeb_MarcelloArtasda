<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

$id = trim($_POST['id'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$nim = trim($_POST['nim'] ?? '');
$tahun_masuk = $_POST['tahun_masuk'] ?? '';
$kelas = trim($_POST['kelas'] ?? '');

if ($id === '') {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($nim === '') {
    $errors[] = "NIM wajib diisi.";
}
if (!is_numeric($tahun_masuk) || $tahun_masuk < 1900 || $tahun_masuk > 2026) {
    $errors[] = "Tahun harus di antara 1900-2026.";
}
if ($kelas === '') {
    $errors[] = "Kelas wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE mahasiswa SET nama = :nama, nim = :nim, tahun_masuk = :tahun_masuk, kelas = :kelas WHERE id = :id"
);
$stmt->execute([
    'nama' => $nama,
    'nim' => $nim,
    'tahun_masuk' => (int) $tahun_masuk,
    'kelas' => $kelas,
    'id' => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data mahasiswa berhasil diperbarui.'];
header('Location: list.php');
exit;
