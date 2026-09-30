<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

// Hanya menerima POST agar penghapusan tidak terpicu lewat link/crawler.
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
    $stmt = $pdo->prepare("DELETE FROM pengajuan WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pengajuan berhasil dihapus.'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Pengajuan tidak ditemukan.'];
    }
} catch (PDOException $e) {
    error_log('pengajuan/hapus.php: ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus: ' . $e->getMessage()];
}

header('Location: list.php');
exit;
