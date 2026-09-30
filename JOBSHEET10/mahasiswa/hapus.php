<?php
require __DIR__ . '/../includes/koneksi.php';
// session sudah dimulai oleh header.php di halaman lain; di sini mulai sendiri.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Penghapusan harus lewat tombol Hapus.'];
    header('Location: list.php');
    exit;
}

$id = trim($_POST['id'] ?? '');

if ($id === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID tidak dikirim.'];
    header('Location: list.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data berhasil dihapus.'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data tidak ditemukan.'];
    }
} catch (PDOException $e) {
    if ($e->getCode() === '23503') {
        // foreign_key_violation
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Mahasiswa ini tidak bisa dihapus karena masih dipakai di data Pengajuan. Hapus pengajuannya dulu.'];
    } else {
        error_log('hapus.php: ' . $e->getMessage());
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus: ' . $e->getMessage()];
    }
}

header('Location: list.php');
exit;
