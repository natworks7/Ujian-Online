<?php
session_start();
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}

// Detail koneksi database
$host = 'localhost'; // Sesuaikan dengan host Anda
$username = 'root';  // Sesuaikan dengan username database Anda
$password = '';      // Sesuaikan dengan password database Anda
$database = 'ujianonline'; // Nama database Anda

// Lokasi file backup
$backupFile = 'ujianonline' . date('Y-m-d_H-i-s') . '.sql';

// Perintah mysqldump
$command = "mysqldump -u $username -p$password $database > $backupFile";

// Eksekusi perintah
exec($command, $output, $result);

if ($result == 0) {
    echo "<script>alert('Backup berhasil. File disimpan di: $backupFile'); window.location='utilitas.php';</script>";
} else {
    echo "<script>alert('Backup gagal. Silakan cek konfigurasi.'); window.location='utilitas.php';</script>";
}
?>
