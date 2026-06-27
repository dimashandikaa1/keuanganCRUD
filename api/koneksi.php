<?php
/**
 * Koneksi database.
 *
 * PENTING: kredensial TIDAK ditulis langsung di sini.
 * Saat di Vercel, nilai-nilai ini diambil dari Environment Variables
 * yang diatur di dashboard Vercel (Settings > Environment Variables).
 * Saat dites di komputer sendiri (localhost), nilai-nilai ini bisa
 * diisi lewat file .env.local + package "vlucas/phpdotenv", tapi
 * supaya tetap sederhana, kita pakai getenv() dengan fallback ke
 * konfigurasi localhost XAMPP/Laragon yang biasa kamu pakai.
 */

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'keuangan_db';
$db_port = (int) (getenv('DB_PORT') ?: 3306);

$conn = mysqli_init();

// Kalau DB_HOST mengarah ke Aiven (mengandung "aivencloud.com"),
// aktifkan SSL karena Aiven MEWAJIBKAN koneksi terenkripsi.
$isAiven = strpos($db_host, 'aivencloud.com') !== false;

if ($isAiven) {
    $caPath = __DIR__ . '/ca.pem';
    mysqli_ssl_set($conn, NULL, NULL, $caPath, NULL, NULL);
    $ok = @mysqli_real_connect(
        $conn,
        $db_host,
        $db_user,
        $db_pass,
        $db_name,
        $db_port,
        NULL,
        MYSQLI_CLIENT_SSL
    );
} else {
    $ok = @mysqli_real_connect($conn, $db_host, $db_user, $db_pass, $db_name, $db_port);
}

if (!$ok) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
