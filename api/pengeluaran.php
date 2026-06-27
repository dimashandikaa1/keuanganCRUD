<?php
require __DIR__ . '/koneksi.php';
require __DIR__ . '/auth.php';

require_login($conn);

$data = mysqli_query($conn, "SELECT * FROM pengeluaran ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengeluaran — Sistem Keuangan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page">
    <div class="page-header">
        <h2>Data Pengeluaran</h2>
    </div>

    <div class="card">
        <div class="table-toolbar">
            <a href="tambah_pengeluaran.php" class="btn btn-primary">
                Tambah Pengeluaran
            </a>
            <a href="dashboard.php" class="btn btn-outline">Kembali</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $rowCount = mysqli_num_rows($data);
                if ($rowCount === 0): ?>
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <p>Belum ada data pengeluaran. Silakan tambah data baru.</p>
                            </div>
                        </td>
                    </tr>
                <?php else:
                    while ($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars(date('d M Y', strtotime($row['tanggal']))) ?></td>
                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                        <td class="jumlah-cell out">Rp <?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                        <td>
                            <div class="action-group">
                                <a href="edit_pengeluaran.php?id=<?= $row['id'] ?>" class="btn-action btn-edit">Edit</a>
                                <a href="hapus_pengeluaran.php?id=<?= $row['id'] ?>"
                                   class="btn-action btn-delete"
                                   onclick="return confirm('Hapus data ini?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile;
                endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
