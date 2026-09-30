<?php
$page_title = "Tambah Mahasiswa";
include __DIR__ . '/../includes/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Tambah Mahasiswa</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <p>
                    <label for="nama">Nama</label><br>
                    <input type="text" id="nama" name="nama" required>
                </p>
                <p>
                    <label for="nim">NIM</label><br>
                    <input type="text" id="nim" name="nim" required>
                </p>
                <p>
                    <label for="tahun_masuk">Tahun Masuk</label><br>
                    <input type="number" id="tahun_masuk" name="tahun_masuk" min="1900" max="2026" required>
                </p>
                <p>
                    <label for="kelas">Kelas</label><br>
                    <select id="kelas" name="kelas">
                        <option value="SIB-2A">SIB-2A</option>
                        <option value="SIB-2B">SIB-2B</option>
                        <option value="SIB-2C">SIB-2C</option>
                    </select>
                </p>
                <p>
                    <button type="submit">Simpan</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
