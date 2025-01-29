<?php 
include '../koneksi.php';
session_start();
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}

$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'all';

$query_str = "SELECT peserta.*, 
        (SELECT nama_camaba FROM camaba WHERE camaba.nik = peserta.nik) AS nama_camaba FROM peserta";

// Filter berdasarkan status ujian
if ($status_filter == 'belum') {
    $query_str .= " WHERE peserta.status_ujian = 0";
} elseif ($status_filter == 'sudah') {
    $query_str .= " WHERE peserta.status_ujian = 1";
}

$query_str .= " ORDER BY tanggal_mulai DESC";
$query = mysqli_query($konek, $query_str);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Data Peserta Ujian</title>
</head>
<body>
    <h2>Data Peserta Ujian</h2>
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
                        echo "Belum Ujian";
                    } elseif ($row['status_ujian'] == 1) {
                        echo "Sudah Ujian";
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

    <script>
        window.onload = function() {
            window.print(); // Auto print after the page loads
        };
    </script>
</body>
</html>

<style>
    @media print {
      body {
        font-family: Arial, sans-serif;
        margin: 20px;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
      }
      th, td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
      }
      th {
        background-color: #f2f2f2;
      }
      h2 {
        text-align: center;
      }
    }
  </style>