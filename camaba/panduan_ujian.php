<?php 
include '../koneksi.php'; 
session_start();

if (!isset($_SESSION['nik'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_camaba.php';</script>";
    exit;
}

$nik = $_SESSION['nik'];

$query = mysqli_query($konek, "SELECT `nama_camaba`, `pas_foto` FROM camaba WHERE nik = '$nik'");
if ($query && mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    $nama_camaba = $row['nama_camaba'];  
    $pas_foto = $row['pas_foto'];  
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Ujian Calon Mahasiswa</title>
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
          <img src= pas_foto/<?php echo $pas_foto; ?> alt="Akun" class="account-icon">
        </div>
</nav>

    <aside class="sidebar">
        <div class="logo">
          <br>  <h2>PANDUAN UJIAN</h2>
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
                    <a href="panduan_ujian.php" class="active">
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
                    <a href="ganti_password.php">
                        <img src="icon/ganti-icon.png" alt="Ganti Password Icon">
                        Ganti Password
                    </a>
                </li>
                <li>
                    <a href="jadwal.php">
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
    <main class="content">
        <h1>Selamat Datang, <?php echo $nama_camaba; ?>!</h1><br><br>
        <div class="instructions">
            <ol>
                <li><strong>Masuk ke Ujian:</strong> Pilih jenis ujian, lalu klik Mulai Ujian.</li> <br>
                <li><strong>Waktu Ujian:</strong> Perhatikan sisa waktu di bagian atas halaman.</li> <br>
                <li><strong>Selesai Ujian:</strong> Hasil ujian dapat dilihat di menu Hasil Ujian setelah ujian selesai.</li> <br>
            </ol>
            <p>Selamat mengerjakan!</p>
        </div>
    <div class="footer"></div>
</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
      const hamburgerMenu = document.querySelector(".hamburger-menu");
      const sidebar = document.querySelector(".sidebar");
  
      hamburgerMenu.addEventListener("click", () => {
        sidebar.classList.toggle("active");
      });
    });
</script>
