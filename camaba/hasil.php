<?php
include '../koneksi.php'; 
session_start();
if (!isset($_SESSION['nik'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_camaba.php';</script>";
    exit;
}
$nik = $_SESSION['nik'];

$query = "SELECT peserta.*, jenis_ujian.jenis_ujian
FROM peserta
INNER JOIN jenis_ujian ON peserta.id_jenis_ujian = jenis_ujian.id_jenis_ujian
WHERE peserta.nik = '$nik'";
$result = mysqli_query($konek, $query);

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
    <title>Hasil Ujian Calon Mahasiswa</title>
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
          <br>  <h2>HASIL UJIAN</h2>
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
                    <a href="hasil.php"  class="active">
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
                <section class="exam-results">
                    <h2 class="section-title">Hasil Ujian</h2>
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Ujian</th>
                                <th>Jenis Ujian</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['id_jenis_ujian']); ?></td>
                                    <td><?php echo htmlspecialchars($row['jenis_ujian']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nilai']); ?></td>
                                    <td><a href="cetak.php?id=<?php echo $row['id_peserta']; ?>" class="print-button">Cetak</a></td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='4'>Tidak ada data hasil ujian.</td></tr>";
                        }
                        ?>
                    </tbody>
                    </table>
                </section>
            
                <footer class="footer"></footer>
            </main>            
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

<style>
.section-title {
    font-size: 24px;
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
}

.results-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    text-align: center;
}

.results-table th, .results-table td {
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 16px;
}

.results-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.results-table td button.print-button {
    background-color: #ff6600;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.results-table td button.print-button:hover {
    background-color: #d35400;
}

.print-button {
    background-color: #ff6600;
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.print-button:hover {
    background-color: #d35400;
}

.footer {
        background-color: #000080;
        height: 10px;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
    }
   
</style>