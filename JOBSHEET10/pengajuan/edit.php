<?php
$page_title = "Edit Pengajuan";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM pengajuan WHERE id = :id");
$stmt->execute(['id' => $id]);
$pengajuan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pengajuan) {
    header('Location: list.php');
    exit;
}
?>
        <section>
            <h2>Edit Pengajuan</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_edit.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($pengajuan['id']); ?>">
                <p>
                    <label for="keperluan_surat">Keperluan Surat</label><br>
                    <input type="text" id="keperluan_surat" name="keperluan_surat" value="<?php echo htmlspecialchars($pengajuan['keperluan_surat']); ?>" required>
                </p>
                <p>
                    <label for="nama">Nama</label><br>
                    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($pengajuan['nama']); ?>" required>
                </p>
                <p>
                    <label for="nim">NIM</label><br>
                    <input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars($pengajuan['nim']); ?>" required>
                </p>
                <p>
                    <label for="no_hp">No. HP</label><br>
                    <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($pengajuan['no_hp']); ?>" required>
                </p>
                <p>
                    <button type="submit">Update</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
