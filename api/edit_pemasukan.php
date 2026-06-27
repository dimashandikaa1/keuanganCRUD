<?php
require __DIR__ . '/koneksi.php';
require __DIR__ . '/auth.php';

require_login($conn);

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM pemasukan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header("Location: pemasukan.php");
    exit;
}

if (isset($_POST['update'])) {
    $tanggal    = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $jumlah     = (int) $_POST['jumlah'];

    $upd = $conn->prepare(
        "UPDATE pemasukan SET tanggal = ?, keterangan = ?, jumlah = ? WHERE id = ?"
    );
    $upd->bind_param("ssii", $tanggal, $keterangan, $jumlah, $id);
    $upd->execute();

    header("Location: pemasukan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemasukan — Sistem Keuangan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page">
    <div class="page-header">
        <h2>Edit Pemasukan</h2>
        <p>Perbarui data pemasukan yang dipilih</p>
    </div>

    <div class="card" style="max-width:520px;">
        <form method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal"
                           value="<?= htmlspecialchars($data['tanggal']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan"
                           value="<?= htmlspecialchars($data['keterangan']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah (Rp)</label>
                    <input type="number" id="jumlah" name="jumlah"
                           value="<?= htmlspecialchars($data['jumlah']) ?>" min="0" required>
                </div>
                <div class="form-actions">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <a href="pemasukan.php" class="btn btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>
