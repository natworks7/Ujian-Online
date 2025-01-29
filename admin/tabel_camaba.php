<?php include '../koneksi.php'; 
session_start();
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
$id_admin = $_SESSION['id_admin']; 
date_default_timezone_set('Asia/Jakarta');

$query = "SELECT nik, email, nama_camaba, waktu, status_seleksi FROM camaba ORDER BY waktu DESC";
$result = mysqli_query($konek, $query);

if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($konek));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Camaba</title>
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
        <li><a href="menu_admin.php" ><span>🏠</span> Home</a></li>
        <li><a href="tabel_camaba.php" class="active"><span>📋</span> Data Camaba</a></li>
        <li><a href="kelola_soal.php"><span>📝</span> Kelola Soal</a></li>
        <li><a href="kelola_peserta.php"><span>⚙️</span> Kelola Peserta Ujian</a></li>
        <li><a href="ganti_sandi.php"><span>🔒</span> Ganti Password</a></li>
        <li><a href="logout.php"><span>🔓</span> Keluar Akun</a></li>
      </ul>
    </aside>

    <main class="content">
      <section class="main-content">
        <body>
          <h2>Data Calon Mahasiswa Baru</h2>
          <table>
              <thead>
                  <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>Waktu Pendaftaran</th>
                    <th>Status Seleksi</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  $no = 1;
                  if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                          $status_seleksi = ($row['status_seleksi'] === NULL) ? 'Belum Diperiksa' : ($row['status_seleksi'] == 1 ? 'Lolos' : 'Tidak Lolos');
                          echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['nik']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['nama_camaba']}</td>
                                <td>{$row['waktu']}</td>
                                <td>{$status_seleksi}</td>
                                  <td>
                                      <a href='detail_camaba.php?email={$row['email']}' class='action-btn'>Lihat</a>
                                  </td>
                              </tr>";
                              $no++;
                      }
                  } else {
                      echo "<tr><td colspan='6'>Tidak ada data tersedia</td></tr>";
                  }
                  ?>
              </tbody>
          </table>
        </body>
      </section>
    </main>
    <footer class="footer"></footer>
  </div>
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

.action-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 5px;
    text-decoration: none;
}

.action-btn:hover {
    background-color: #0056b3;
}


@media (max-width: 768px) {
    table {
        font-size: 12px;
    }

    thead th,
    tbody td {
        padding: 8px 6px;
    }
}


@media (max-width: 1200px) {
    th:nth-child(2), 
    th:nth-child(3), 
    th:nth-child(5), 
    td:nth-child(2), 
    td:nth-child(3), 
    td:nth-child(5) { 
        display: none;

    }
}

@media (max-width: 500px) {
    th:nth-child(2),
    th:nth-child(3), 
    th:nth-child(5), 
    td:nth-child(2), 
    td:nth-child(3), 
    td:nth-child(5) { 
        display: none;

    }
}


@media (max-width: 480px) {
    th, td {
        font-size: 12px;
        padding: 8px;
    }

    .action-btn {
        padding: 4px 8px;
        font-size: 12px;
    }
}
  </style>