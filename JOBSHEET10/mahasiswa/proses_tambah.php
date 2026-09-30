<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$nama = trim($_POST['nama'] ?? '');
$nim = trim($_POST['nim'] ?? '');
$tahun_masuk = $_POST['tahun_masuk'] ?? '';
$kelas = trim($_POST['kelas'] ?? '');

// Validasi server-side — wajib ada meski sudah divalidasi JS di Jobsheet 5,
// karena validasi client bisa dilewati (nonaktifkan JS / kirim request manual).
$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($nim === '') {
    $errors[] = "Nim wajib diisi.";
}
if (!is_numeric($tahun_masuk) || $tahun_masuk < 1900 || $tahun_masuk > 2026) {
    $errors[] = "Tahun harus di antara 1900-2026.";
}
if ($kelas === '') {
    $errors[] = "Kelas wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO mahasiswa (nama, nim, tahun_masuk, kelas)
     VALUES (:nama, :nim, :tahun_masuk, :kelas)
     RETURNING id"
);
$stmt->execute([
    'nama' => $nama,
    'nim' => $nim,
    'tahun_masuk' => (int) $tahun_masuk,
    'kelas' => $kelas,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Mahasiswa berhasil ditambahkan.'];
header('Location: list.php');
exit;
