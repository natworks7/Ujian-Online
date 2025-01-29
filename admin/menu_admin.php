<?php include '../koneksi.php';
session_start();
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
$id_admin = $_SESSION['id_admin'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Admin</title>
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
        <li><a href="menu_admin.php" class="active"><span>🏠</span> Home</a></li>
        <li><a href="tabel_camaba.php"><span>📋</span> Data Camaba</a></li>
        <li><a href="kelola_soal.php"><span>📝</span> Kelola Soal</a></li>
        <li><a href="kelola_peserta.php"><span>⚙️</span> Kelola Peserta Ujian</a></li>
        <li><a href="ganti_sandi.php"><span>🔒</span> Ganti Password</a></li>
        <li><a href="logout.php"><span>🔓</span> Keluar Akun</a></li>
      </ul>
    </aside>


    <main class="content">
      <section class="main-content">
        <h2>Selamat Datang!</h2>
        <div class="instructions"> 
    <ol>
        <li><strong>Data Camaba 📋:</strong> Menampilkan dan memeriksa kelengkapan data calon mahasiswa baru (camaba) yang terdaftar. </li><br>
        <li><strong>Kelola Soal 📝:</strong> Mengelola soal ujian, yaitu menambah dan mengedit soal ujian.</li><br>
        <li><strong>Kelola Peserta Ujian ⚙️:</strong> Mengelola peserta ujian, yaitu menambah, menghapus, dan mengedit peserta yang akan mengikuti ujian.</li><br>
        <li><strong>Ganti Password 🔒:</strong> Mengganti password akun admin.</li><br>
    </ol>
</div>

      </section>
    </main>
  </div>
  <footer class="footer"></footer>
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

<style>
  .instructions{
    text-align: left;
  }
</style>