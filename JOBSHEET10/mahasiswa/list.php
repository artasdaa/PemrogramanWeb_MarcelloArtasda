<?php
$page_title = "Daftar Mahasiswa";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarMahasiswa = $pdo->query("SELECT * FROM mahasiswa ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
        <section>
            <h2>Daftar Mahasiswa</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <div class="search-box">
                <label for="search-input">Cari Data Mahasiswa</label>
                <input type="text" id="search-input" placeholder="Ketik Nama Mahasiswa">
            </div>

            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Nim</th>
                        <th>Tahun Masuk</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarMahasiswa)): ?>
                    <tr>
                        <td colspan="5">Belum ada data mahasiswa. Silakan tambah lewat menu "Tambah Mahasiswa".</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($daftarMahasiswa as $mahasiswa): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($mahasiswa['nama']); ?></td>
                            <td><?php echo htmlspecialchars($mahasiswa['nim']); ?></td>
                            <td><?php echo htmlspecialchars($mahasiswa['tahun_masuk']); ?></td>
                            <td><?php echo htmlspecialchars($mahasiswa['kelas']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo urlencode($mahasiswa['id']); ?>" class="btn-edit">Edit</a>

                                <form method="post" action="hapus.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($mahasiswa['id']); ?>">
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>

        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
