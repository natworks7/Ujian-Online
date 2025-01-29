<?php 
include '../koneksi.php'; 
session_start();

if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}

$id_admin = $_SESSION['id_admin'];
date_default_timezone_set('Asia/Jakarta');

// Status pesan
$statusMessage = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'editsukses') {
        $statusMessage = "<p style='color: green;'>Soal berhasil diperbarui.</p>";
    }
}

// Ambil data filter
$filter_jenis_ujian = isset($_GET['filter_jenis_ujian']) ? mysqli_real_escape_string($konek, $_GET['filter_jenis_ujian']) : '';

// Query dropdown jenis ujian
$query_jenis = "SELECT id_jenis_ujian, jenis_ujian FROM jenis_ujian";
$result_jenis = mysqli_query($konek, $query_jenis);

// Query soal ujian dengan filter
$query_soal = "SELECT soal_ujian.*, jenis_ujian.jenis_ujian AS nama_jenis_ujian 
               FROM soal_ujian 
               LEFT JOIN jenis_ujian ON soal_ujian.id_jenis_ujian = jenis_ujian.id_jenis_ujian";

if (!empty($filter_jenis_ujian)) {
    $query_soal .= " WHERE soal_ujian.id_jenis_ujian = '$filter_jenis_ujian'";
}

$result_soal = mysqli_query($konek, $query_soal);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Soal Ujian</title>
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
      <h2><span><?= htmlspecialchars($id_admin); ?></span></h2>
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
            <li><a href="kelola_soal.php" class="active"><span>📝</span> Kelola Soal</a></li>
            <li><a href="kelola_peserta.php"><span>⚙️</span> Kelola Peserta Ujian</a></li>
            <li><a href="ganti_sandi.php"><span>🔒</span> Ganti Password</a></li>
            <li><a href="logout.php"><span>🔓</span> Keluar Akun</a></li>
        </ul>
    </aside>

    <main class="content">
        <section class="main-content">
            <h2>Kelola Soal Ujian</h2>
            <button class="tombol-buat-soal" onclick="window.location.href='buat_soal.php'">Buat Soal Baru</button>

            <div class="status">
                <?= $statusMessage; ?>
            </div>

            <form method="GET" action="kelola_soal.php" style="margin-bottom: 20px;">
                <label for="filter_jenis_ujian">Filter Jenis Ujian:</label>
                <select name="filter_jenis_ujian" id="filter_jenis_ujian" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <?php while ($row_jenis = mysqli_fetch_assoc($result_jenis)): ?>
                        <option value="<?= $row_jenis['id_jenis_ujian']; ?>" <?= $row_jenis['id_jenis_ujian'] === $filter_jenis_ujian ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($row_jenis['jenis_ujian']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </form>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Ujian</th>
                            <th>Pertanyaan</th>
                            <th>Kunci Jawaban</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result_soal)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_jenis_ujian']); ?></td>
                                <td><?= htmlspecialchars($row['pertanyaan']); ?></td>
                                <td><?= htmlspecialchars($row['kunci_jawaban']); ?></td>
                                <td class="aksi">
                                    <button class="edit" onclick="window.location.href='edit_soal.php?id=<?= $row['id_soal_ujian']; ?>'">Edit</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <footer class="footer"></footer>
</div>

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

table tbody td:nth-child(3) { 
    word-wrap: break-word; 
    white-space: pre-wrap; 
    overflow-wrap: anywhere;
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

.status {
    margin-bottom: 20px;
    font-size: 16px;
    text-align: center;
}

.tombol-buat-soal {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #000080;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 20px;
}

.tombol-buat-soal:hover {
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
}

</style>