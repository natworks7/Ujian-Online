<?php 
include '../koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}

$id_admin = $_SESSION['id_admin']; 
$statusMessage = "";

// Proses ganti kata sandi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sandi_lama = $_POST['sandi_lama'];
    $sandi_baru = $_POST['sandi_baru'];
    $ulangi_sandi_baru = $_POST['ulangi_sandi_baru'];

    // Validasi input
    if (trim($sandi_lama) === "" || trim($sandi_baru) === "" || trim($ulangi_sandi_baru) === "") {
        $statusMessage = "<p style='color: red;'>Semua kolom harus diisi.</p>";
    } elseif ($sandi_baru !== $ulangi_sandi_baru) {
        $statusMessage = "<p style='color: red;'>Password baru tidak cocok.</p>";
    } else {
        // Periksa kata sandi lama
        $query = "SELECT password FROM admin WHERE id_admin = '$id_admin'";
        $result = mysqli_query($konek, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row && $row['password'] === $sandi_lama) {
            // Update kata sandi
            $update_query = "UPDATE admin SET password = '$sandi_baru' WHERE id_admin = '$id_admin'";
            if (mysqli_query($konek, $update_query)) {
                $statusMessage = "<p style='color: green;'>Password berhasil diperbarui.</p>";
            } else {
                $statusMessage = "<p style='color: red;'>Terjadi kesalahan saat memperbarui password.</p>";
            }
        } else {
            $statusMessage = "<p style='color: red;'>Password lama tidak valid.</p>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="top-navbar">
        <div class="hamburger-menu">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div class="logo">
          <h2><span><?php echo $id_admin; ?></span></h2>
        </div>
        <div class="account">
          <img src="icon/account-icon.png" alt="Akun" class="account-icon">
        </div>
      </nav>

<div class="admin-panel">
    <aside class="sidebar">
        <h2>ADMIN</h2>
        <ul>
            <li><a href="menu_admin.php"><span>🏠</span> Home</a></li>
            <li><a href="tabel_camaba.php"><span>📋</span> Data Camaba</a></li>
            <li><a href="kelola_soal.php"><span>📝</span> Kelola Soal</a></li>
            <li><a href="kelola_peserta.php"><span>⚙️</span> Kelola Peserta Ujian</a></li>
            <li><a href="ganti_sandi.php" class="active"><span>🔒</span> Ganti Password</a></li>
            <li><a href="logout.php"><span>🔓</span> Keluar Akun</a></li>
        </ul>
    </aside>
    <main class="password-reset">
    <div class="form-container">
        <h2>Ganti Password</h2> <br>
        <?= $statusMessage; ?>
        <form method="POST" action="">
            <input type="password" name="sandi_lama" placeholder="Masukkan Password Saat Ini" required>
            <input type="password" name="sandi_baru" placeholder="Masukkan Password Baru" required>
            <input type="password" name="ulangi_sandi_baru" placeholder="Ulangi Password Baru" required>
            <button type="submit">Selesai</button>
        </form>
    </div>
</main>
    <footer class="footer"></footer>
</body>
</html>



<style>
/* Bagian form ganti password */
.password-reset {
    flex: 1;
    display: flex;
    justify-content: center;
    margin-left: 270px;
    align-items: center;
    background-color: #fff;
}

.form-container {
    width: 350px;
    padding: 30px;
    background-color: #d3d3d3; /* Warna abu-abu */
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

form input {
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
}

form input::placeholder {
    color: #8b0000;
    font-weight: bold;
}

form button {
    background-color: #000080;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #001a4d;
}

.footer {
    background-color: #000080;
    height: 20px;
    width: 100%;
}

@media (max-width: 768px) {
    .password-reset {
    flex: 1;
    padding: 3.5rem 2rem; 
    margin-left: auto;
  }
}
</style>