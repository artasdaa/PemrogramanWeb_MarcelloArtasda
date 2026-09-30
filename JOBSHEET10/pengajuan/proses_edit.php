<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = trim($_POST['id'] ?? '');
$keperluan_surat = trim($_POST['keperluan_surat'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$nim = trim($_POST['nim'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

if ($id === '') {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($keperluan_surat === '') {
    $errors[] = "Keperluan surat wajib diisi.";
}
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($nim === '') {
    $errors[] = "NIM wajib diisi.";
}
if ($noHp === '') {
    $errors[] = "Nomor HP wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE pengajuan
     SET keperluan_surat = :keperluan_surat, nama = :nama, nim = :nim, no_hp = :no_hp
     WHERE id = :id"
);
$stmt->execute([
    'keperluan_surat' => $keperluan_surat,
    'nama' => $nama,
    'nim' => $nim,
    'no_hp' => $noHp,
    'id' => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pengajuan berhasil diperbarui.'];
header('Location: list.php');
exit;
