<?php
require __DIR__ . '/koneksi.php';
require __DIR__ . '/auth.php';

require_login($conn);

$id = (int) $_GET['id'];

$stmt = $conn->prepare("DELETE FROM pengeluaran WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: pengeluaran.php");
exit;
