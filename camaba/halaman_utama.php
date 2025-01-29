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
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halo Mahasiswa Baru!</title>
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
          <br>  <h2>MENU UTAMA</h2>
        </div>
        <nav class="menu">
            <ul>
            <li>
                    <a href="halaman_utama.php"  class="active">
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
        <section class="exam-menu">
        <?php 
        // Query untuk mengambil data berdasarkan NIK
$query = "SELECT peserta.*, jenis_ujian.jenis_ujian
FROM peserta
INNER JOIN jenis_ujian ON peserta.id_jenis_ujian = jenis_ujian.id_jenis_ujian
WHERE peserta.nik = '$nik'";
$result = mysqli_query($konek, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="exam-card">';
        echo '<h3>' . $row['jenis_ujian'] . '</h3>';
        echo '<form method="POST" action="mulai_ujian.php">';
        echo '<input type="hidden" name="id_peserta" value="' . $row['id_peserta'] . '">';
        echo '<button type="submit">Mulai ujian →</button>';
        echo '</form>';
        echo '</div>';
    }
}else {
    echo "<p>Tidak ada ujian yang ditemukan.</p>";
}
?>
        </section>
    </main>
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

<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    display: flex;
    height: auto;
    background-color: #f8f9fa;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
}

.container {
        display: flex;
        width: 80%;
    }
    
.sidebar {
    width: 250px;
    background-color: #ff6600;
    padding-top: 3.5rem 4rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    border-right: 1px solid #ddd;
}

.logo {
    text-align: center;
    font-weight: bold;
    color: white;
    margin-bottom: 20px;
}

.menu ul {
        list-style: none;
        padding: 0;
    }
    
    .menu ul li {
        margin: 20px 0;
        text-align: center;
    }
    
    .menu ul li a {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: #333;
        padding: 20px;
        font-size: 18px;
        border: 1px solid #333; /*nNoteeeee: ini itu Menambahkan garis tepi */
        border-radius: 5px; /*Noteeee: ini menambahkan sudut yang sedikit melengkung */
        transition: background-color 0.3s ease, border-color 0.3s ease; /*Noteee: Animasi perubahan warna */
    }

    .menu ul li a img {
        width: 40px;
        height: auto;
        margin-bottom: 10px;
    }

.menu ul li a:hover,
.menu ul li a.active {
    background-color: #d35400;
}

.content {
    flex: 1;
    display: flex;
    flex-direction: column;
    background-color: white;
    padding: 3.5rem 2rem;
    margin-top: 30px;
}

.header {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    margin-bottom: 20px;
}

.account img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #ddd;
}

.exam-menu {
    display: flex;
    justify-content: center;
    gap: 100px;
}

.exam-card {
    width: 350px;
    height: 200px; 
    padding: 20px; 
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #f8f9fa;
    transition: box-shadow 0.3s ease;
    overflow: hidden; 
}


.exam-card:hover {
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
}

.exam-card h3 {
    margin-bottom: 10px;
    font-size: 18px;
    color: #333;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis; 
    width: 100%; 
}

.exam-card button {
    background-color: #ff6600;
    color: white;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 10px;
    width: 100%; 
}

.exam-card button:hover {
    background-color: #d35400;
}

.hamburger-menu {
  display: none;
  flex-direction: column;
  justify-content: space-between;
  width: 25px;
  height: 20px;
  cursor: pointer;
}

.hamburger-menu span {
  display: block;
  height: 3px;
  background-color: black;
  border-radius: 2px;
  transition: all 0.3s ease;
}

.top-navbar {
  position: fixed; 
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #d1d1d1;
  color: black;
  padding: 0.5rem 1rem; 
  border-bottom: 1px solid #000000;
}


.top-navbar .logo h1 {
  font-size: 1.2rem; 
}


@media (max-width: 768px) {
  .hamburger-menu {
    display: flex;
    left: 10px;
  }

  .exam-menu {
    display: flex; 
    flex-direction: column; 
    gap: 40px; 
    align-items: center;
  }

  .exam-card {
    width: 60%; 
  }


  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 250px;
    z-index: 1000;
    transform: translateX(-100%);
    background-color: #ff6600;
    padding: 1.5rem 1rem;
  }

  .sidebar.active {
    transform: translateX(0);
  }

  .top-navbar {
    justify-content: flex-start;
    position: fixed;
  }

  .logo{
    text-align: center;
    flex:1;
  }
  .account{
    margin-left:auto;
  }

  .content {
    flex: 1;
    padding: 3.5rem 2rem; 
    margin-left: auto;
  }
}

.footer {
        background-color: #000080;
        height: 10px;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
    }

    @media (max-width: 768px) {
    .exam-card {
        width: 90%; 
        height: 200px;
    }

    .exam-card h3 {
        font-size: 16px; 
    }

    .exam-card button {
        font-size: 14px; 
    }
}

</style>