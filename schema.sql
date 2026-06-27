-- Jalankan semua query ini di database Aiven kamu (lewat DBeaver / Aiven Console / mysql CLI)

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS pemasukan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    keterangan VARCHAR(255) NOT NULL,
    jumlah BIGINT NOT NULL
);

CREATE TABLE IF NOT EXISTS pengeluaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    keterangan VARCHAR(255) NOT NULL,
    jumlah BIGINT NOT NULL
);

-- Tabel baru: dipakai untuk menyimpan sesi login (pengganti session_start bawaan PHP)
CREATE TABLE IF NOT EXISTS sessions (
    token CHAR(64) PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    expires_at DATETIME NOT NULL
);

-- Akun login contoh (silakan ganti username/password sesuai kebutuhan)
-- Jika kamu sudah punya data users sebelumnya, lewati baris INSERT ini.
INSERT INTO users (username, password) VALUES ('admin', 'admin123');
