<?php
require __DIR__ . '/koneksi.php';
require __DIR__ . '/auth.php';

logout_user($conn);

header("Location: index.php");
exit;
