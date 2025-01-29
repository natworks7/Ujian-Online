<?php 
include '../koneksi.php';
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
  <title>Utilitas</title>
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
        <li><a href="utilitas.php" class="active"><span>🔧</span> Utilitas</a></li>
        <li><a href="ganti_sandi.php"><span>🔒</span> Ganti Password</a></li>
        <li><a href="keluar_akun.php"><span>🔓</span> Keluar Akun</a></li>
      </ul>
    </aside>

    <main class="content">
      <section class="main-content">
        <h2>Utilitas</h2>
        <div class="utilitas-section">
          <div class="utilitas-buttons">
            <button onclick="cadangkan()">Cadangkan</button>
            <button onclick="aturUlang()">Atur Ulang</button>
            <button onclick="pulihkan()">Pulihkan</button>
          </div>

          <div class="file-upload">
            <input type="file" id="fileInput">
            <button onclick="cadangkan()">Cadangkan</button>
          </div>
        </div>
      </section>
    </main>
  </div>
  <div class="footer"></div>

  <script>
    function cadangkan() {
      window.location.href = "cadangkan.php";
    }
    function aturUlang() {
        alert("Fitur atur ulang belum diimplementasikan.");
    }

    function pulihkan() {
        alert("Fitur pulihkan belum diimplementasikan.");
    }

    document.addEventListener("DOMContentLoaded", function() {
      const hamburgerMenu = document.querySelector(".hamburger-menu");
      const sidebar = document.querySelector(".sidebar");
  
      hamburgerMenu.addEventListener("click", () => {
        sidebar.classList.toggle("active");
      });
    });
  </script>

</body>
</html>

<style>
  
.utilitas-section {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.utilitas-buttons {
  display: flex;
  justify-content: center;
  gap: 15px;
}

.utilitas-buttons button {
  padding: 10px 20px;
  background-color: white;
  border: 2px solid black;
  border-radius: 5px;
  cursor: pointer;
}

.utilitas-buttons button:hover {
  background-color: #ffe6cc;
}

.file-upload {
  display: flex;
  align-items: center;
  gap: 10px;
}

.file-upload input[type="file"] {
  padding: 5px;
  border: 1px solid #ddd;
}

.file-upload button {
  padding: 8px 15px;
  background-color: white;
  border: 2px solid black;
  border-radius: 5px;
  cursor: pointer;
}

.file-upload button:hover {
  background-color: #ffe6cc;
}

</style>