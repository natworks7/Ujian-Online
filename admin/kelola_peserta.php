<?php 
include '../koneksi.php';
session_start();
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
$id_admin = $_SESSION['id_admin']; 

// Menentukan filter jika ada
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'all';

// Mengubah query sesuai filter
$query_str = "SELECT peserta.*, 
        (SELECT nama_camaba FROM camaba WHERE camaba.nik = peserta.nik) AS nama_camaba FROM peserta";

// Jika filter status sudah ujian atau belum ujian
if ($status_filter == 'belum') {
    $query_str .= " WHERE peserta.status_ujian = 0";
} elseif ($status_filter == 'sudah') {
    $query_str .= " WHERE peserta.status_ujian = 1";
}

$query_str .= " ORDER BY tanggal_mulai DESC";
$query = mysqli_query($konek, $query_str);

// Hapus peserta
if (isset($_GET['hapus'])) {
    $id_peserta = intval($_GET['hapus']);
    $query = "DELETE FROM peserta WHERE id_peserta = $id_peserta";

    if (mysqli_query($konek, $query)) {
        $status = 'hapussukses';
    } else {
        $status = 'hapusgagal';
    }
    header("Location: kelola_peserta.php?status=$status");
    exit();
}

$statusMessage = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'hapussukses') {
        $statusMessage = "<p style='color: green;'>Peserta dihapus.</p>";
    } elseif ($_GET['status'] === 'hapusgagal') {
        $statusMessage = "<p style='color: red;'>Terjadi kesalahan saat menghapus peserta.</p>";
    } elseif ($_GET['status'] === 'editsukses') {
        $statusMessage = "<p style='color: green;'>Peserta berhasil diperbarui.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Peserta Ujian</title>
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
            <li><a href="kelola_peserta.php" class="active"><span>⚙️</span> Kelola Peserta Ujian</a></li>
            <li><a href="ganti_sandi.php"><span>🔒</span> Ganti Password</a></li>
            <li><a href="logout.php"><span>🔓</span> Keluar Akun</a></li>
        </ul>
    </aside>

    <main class="content">
        <section class="main-content">
            <h2>Kelola Peserta Ujian</h2>

            <button class="tombol-tambah-peserta" onclick="window.location.href='tambah_peserta.php'">Tambah Peserta</button>

            <div class="status">
                <?= $statusMessage; ?>
            </div>

            <!-- Filter Status Ujian -->
            <form method="GET" action="kelola_peserta.php">
                <label for="status_filter">Filter Status Ujian:</label>
                <select name="status_filter" id="status_filter" onchange="this.form.submit()">
                    <option value="all" <?php echo $status_filter == 'all' ? 'selected' : ''; ?>>Semua Peserta</option>
                    <option value="belum" <?php echo $status_filter == 'belum' ? 'selected' : ''; ?>>Belum Ujian</option>
                    <option value="sudah" <?php echo $status_filter == 'sudah' ? 'selected' : ''; ?>>Sudah Ujian</option>
                </select>
            </form>

            <!-- Link Cetak -->
            <a href="cetakpeserta.php?status_filter=<?php echo $status_filter; ?>" target="_blank">
                <button>Cetak Data Peserta</button>
            </a>

            <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Calon Mahasiswa</th>
                    <th>Status Ujian</th>
                    <th>Jenis Ujian</th>
                    <th>Tanggal Mulai Ujian</th>
                    <th>Tanggal Selesai Ujian</th>
                    <th>Durasi Ujian</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($query && mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama_camaba']}</td>
                        <td>";
                        if ($row['status_ujian'] == 0) {
                            echo "<span style='color: red;'>Belum Ujian</span>";
                        } elseif ($row['status_ujian'] == 1) {
                            echo "<span style='color: green;'>Sudah Ujian</span>";
                        }
                        echo "</td>
                            <td>{$row['id_jenis_ujian']}</td>
                            <td>{$row['tanggal_mulai']}</td>
                            <td>{$row['tanggal_selesai']}</td>
                            <td>{$row['durasi_ujian']} menit</td>
                            <td>{$row['nilai']}</td>
                        </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='8'>Tidak ada data ditemukan.</td></tr>";
                }
                ?>
            </tbody>
            </table>
        </section>
    </main>
</div>
<footer class="footer"></footer>
<script>
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
h2{
  text-align: center;
}


.aksi button {
    padding: 5px 10px;
    margin: 2px;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.edit {
    background-color: #007bff;
    color: white;
}

.edit:hover {
    background-color: #0056b3;
}

.hapus {
    background-color: #dc3545;
    color: white;
}

.hapus:hover {
    background-color: #a71d2a;
}

.status {
    margin-bottom: 20px;
    font-size: 16px;
    text-align: center;
}


.tombol-tambah-peserta {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #000080;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 20px;
}

.tombol-tambah-peserta:hover {
    background-color:  #ff6600;
}

@media (max-width: 768px) {
    table {
        font-size: 12px;
    }

    thead th,
    tbody td {
        padding: 8px 6px;
    }
    th:nth-child(6),
    th:nth-child(8),
    td:nth-child(6),
    td:nth-child(8) { 
        display: none;

    }
}

@media (max-width: 500px) {
    th:nth-child(5),
    th:nth-child(6), 
    th:nth-child(7), 
    th:nth-child(8),
    td:nth-child(5), 
    td:nth-child(6), 
    td:nth-child(7),
    td:nth-child(8) { 
        display: none;

    }
}

</style>