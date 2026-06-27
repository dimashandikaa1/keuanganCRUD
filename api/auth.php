<?php
/**
 * Helper otentikasi berbasis token di database.
 *
 * Kenapa tidak pakai session_start() bawaan PHP?
 * Di Vercel, tiap request bisa dijalankan di "instance" serverless yang
 * berbeda dan filesystem-nya sementara. Artinya file session PHP yang
 * dibuat saat login bisa saja tidak terbaca lagi di request berikutnya,
 * sehingga user mendadak ke-logout sendiri. Solusinya: status login
 * disimpan di tabel `sessions` pada database, dan browser hanya membawa
 * sebuah token acak lewat cookie.
 */

function login_user(mysqli $conn, string $username): void
{
    $token   = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', time() + 86400); // berlaku 1 hari

    $stmt = $conn->prepare(
        "INSERT INTO sessions (token, username, expires_at) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $token, $username, $expires);
    $stmt->execute();

    setcookie('session_token', $token, [
        'expires'  => time() + 86400,
        'path'     => '/',
        'secure'   => true,     // hanya dikirim lewat HTTPS (Vercel selalu HTTPS)
        'httponly' => true,     // tidak bisa diakses JavaScript, mencegah XSS curi token
        'samesite' => 'Lax',
    ]);
}

function require_login(mysqli $conn): string
{
    if (!isset($_COOKIE['session_token'])) {
        header("Location: index.php");
        exit;
    }

    $token = $_COOKIE['session_token'];

    $stmt = $conn->prepare(
        "SELECT username FROM sessions WHERE token = ? AND expires_at > NOW()"
    );
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if (!$row) {
        header("Location: index.php");
        exit;
    }

    return $row['username'];
}

function logout_user(mysqli $conn): void
{
    if (isset($_COOKIE['session_token'])) {
        $token = $_COOKIE['session_token'];

        $stmt = $conn->prepare("DELETE FROM sessions WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        setcookie('session_token', '', time() - 3600, '/');
    }
}
