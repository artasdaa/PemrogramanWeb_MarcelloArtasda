<?php
$page_title = "Edit Data Mahasiswa";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE id = :id");
$stmt->execute(['id' => $id]);
$mahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mahasiswa) {
    header('Location: list.php');
    exit;
}

$daftarKelas = ['SIB-2A', 'SIB-2B', 'SIB-2C'];
?>
        <section>
            <h2>Edit Data Mahasiswa</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_edit.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($mahasiswa['id']); ?>">
                <p>
                    <label for="nama">Nama</label><br>
                    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($mahasiswa['nama']); ?>" required>
                </p>
                <p>
                    <label for="nim">NIM</label><br>
                    <input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars($mahasiswa['nim']); ?>" required>
                </p>
                <p>
                    <label for="tahun_masuk">Tahun Masuk</label><br>
                    <input type="number" id="tahun_masuk" name="tahun_masuk" min="1900" max="2026" value="<?php echo htmlspecialchars($mahasiswa['tahun_masuk']); ?>" required>
                </p>
                <p>
                    <label for="kelas">Kelas</label><br>
                    <select id="kelas" name="kelas">
                        <?php foreach ($daftarKelas as $k): ?>
                            <option value="<?php echo $k; ?>" <?php echo $mahasiswa['kelas'] === $k ? 'selected' : ''; ?>><?php echo $k; ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <button type="submit">Update</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
