<?php
session_start();

require __DIR__ . '/../includes/koneksi.php';

$keperluan_surat = trim($_POST['keperluan_surat'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$nim = trim($_POST['nim'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

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
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO pengajuan (keperluan_surat, nama, nim, no_hp)
     VALUES (:keperluan_surat, :nama, :nim, :no_hp)
     RETURNING id"
);
$stmt->execute([
    'keperluan_surat' => $keperluan_surat,
    'nama' => $nama,
    'nim' => $nim,
    'no_hp' => $noHp,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pengajuan berhasil ditambahkan.'];
header('Location: list.php');
exit;
