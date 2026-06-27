<?php
require __DIR__ . '/koneksi.php';
require __DIR__ . '/auth.php';

require_login($conn);

if (isset($_POST['simpan'])) {
    $tanggal    = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $jumlah     = (int) $_POST['jumlah'];

    $stmt = $conn->prepare(
        "INSERT INTO pengeluaran (tanggal, keterangan, jumlah) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("ssi", $tanggal, $keterangan, $jumlah);
    $stmt->execute();

    header("Location: pengeluaran.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengeluaran — Sistem Keuangan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page">
    <div class="page-header">
        <h2>Tambah Pengeluaran</h2>
        <p>Isi formulir di bawah untuk menambah data pengeluaran baru</p>
    </div>

    <div class="card" style="max-width:520px;">
        <form method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal"
                           value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan"
                           placeholder="Contoh: Belanja bulanan" required>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah (Rp)</label>
                    <input type="number" id="jumlah" name="jumlah"
                           placeholder="Contoh: 500000" min="0" required>
                </div>
                <div class="form-actions">
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    <a href="pengeluaran.php" class="btn btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>
