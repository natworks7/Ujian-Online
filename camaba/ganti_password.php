<?php include '../koneksi.php'; 
session_start();
if (!isset($_SESSION['nik'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_camaba.php';</script>";
    exit;
}
$nik = $_SESSION['nik'];
$queryfoto = mysqli_query($konek, "SELECT `pas_foto` FROM camaba WHERE nik = '$nik'");
if ($queryfoto && mysqli_num_rows($queryfoto) > 0) {
    $row = mysqli_fetch_assoc($queryfoto); 
    $pas_foto = $row['pas_foto'];  
}

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
        $query = "SELECT password FROM camaba WHERE nik = '$nik'";
        $result = mysqli_query($konek, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row && $row['password'] === $sandi_lama) {
            // Update kata sandi
            $update_query = "UPDATE camaba SET password = '$sandi_baru' WHERE nik = '$nik'";
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
        </div>
        <div class="account">
          <img src=pas_foto/<?php echo $pas_foto; ?> alt="Akun" class="account-icon">
        </div>
</nav>

    <aside class="sidebar">
        <div class="logo">
        <br>   <h2>GANTI PASSWORD</h2>
        </div>
        <nav class="menu">
            <ul>
            <li>
                    <a href="halaman_utama.php">
                        <img src="icon/home-icon.png" alt="Home Icon">
                        Menu Utama
                    </a>
                </li>
                <li>
                    <a href="panduan_ujian.php">
                        <img src="icon/panduan-icon.png" alt="Panduan Icon">
                        Panduan Ujian
                    </a>
                </li>
                <li>
                    <a href="hasil.php">
                        <img src="icon/hasil-icon.png" alt="Hasil Icon">
                        Hasil Ujian
                    </a>
                </li>
                <li>
                    <a href="ganti_password.php" class="active">
                        <img src="icon/ganti-icon.png" alt="Ganti Password Icon">
                        Ganti Password
                    </a>
                </li>
                <li>
                    <a href="jadwal.php" >
                        <img src="icon/jadwal-icon.png" alt="Jadwal Icon">
                        Jadwal Ujian
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <img src="icon/logout-icon.png" alt="Logout Icon">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
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
    flex-direction: column;
    background-color: #fff;
    padding: 3.5rem 2rem;
    margin-top: 150px;
    align-items: center;
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