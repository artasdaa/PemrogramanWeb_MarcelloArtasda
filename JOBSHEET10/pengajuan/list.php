<?php
$page_title = "Daftar Pengajuan";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarPengajuan = $pdo->query("SELECT * FROM pengajuan ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
        <section>
            <h2>Daftar Pengajuan</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <div class="search-box">
                <label for="search-input">Cari Pengajuan</label>
                <input type="text" id="search-input" placeholder="Cari Pengajuan...">
            </div>

            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Keperluan Surat</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarPengajuan)): ?>
                    <tr>
                        <td colspan="5">Belum ada data pengajuan. Silakan tambah lewat menu "Tambah Pengajuan".</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($daftarPengajuan as $pengajuan): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pengajuan['keperluan_surat']); ?></td>
                            <td><?php echo htmlspecialchars($pengajuan['nama']); ?></td>
                            <td><?php echo htmlspecialchars($pengajuan['nim']); ?></td>
                            <td><?php echo htmlspecialchars($pengajuan['no_hp']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo urlencode($pengajuan['id']); ?>" class="btn-edit">Edit</a>

                                <form method="post" action="hapus.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($pengajuan['id']); ?>">
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
