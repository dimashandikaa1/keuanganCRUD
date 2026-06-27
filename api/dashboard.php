<?php
require __DIR__ . '/koneksi.php';
require __DIR__ . '/auth.php';

$username = require_login($conn);

$masuk = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(jumlah) total FROM pemasukan")
);

$keluar = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(jumlah) total FROM pengeluaran")
);

$totalMasuk  = $masuk['total'] ?? 0;
$totalKeluar = $keluar['total'] ?? 0;
$saldo       = $totalMasuk - $totalKeluar;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Sistem Keuangan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page">
    <div class="page-header">
        <h2>Dashboard</h2>
        <p>Selamat datang, <?= htmlspecialchars($username) ?>!</p>
    </div>

    <div class="summary-grid">
        <div class="summary-box masuk">
            <p>Total Pemasukan</p>
            <h3>Rp <?= number_format($totalMasuk, 0, ',', '.') ?></h3>
        </div>
        <div class="summary-box keluar">
            <p>Total Pengeluaran</p>
            <h3>Rp <?= number_format($totalKeluar, 0, ',', '.') ?></h3>
        </div>
        <div class="summary-box saldo">
            <p>Saldo</p>
            <h3>Rp <?= number_format($saldo, 0, ',', '.') ?></h3>
        </div>
    </div>

    <div class="nav-links">
        <a href="pemasukan.php" class="btn btn-primary">Data Pemasukan</a>
        <a href="pengeluaran.php" class="btn btn-primary">Data Pengeluaran</a>
        <a href="logout.php" class="btn btn-outline">Logout</a>
    </div>
</div>

</body>
</html>
