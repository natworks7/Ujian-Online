<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['nik'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_camaba.php';</script>";
    exit;
}

$nik = $_SESSION['nik'];
$id_peserta = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_peserta) {
    $query = "SELECT peserta.*, jenis_ujian.jenis_ujian 
              FROM peserta 
              INNER JOIN jenis_ujian ON peserta.id_jenis_ujian = jenis_ujian.id_jenis_ujian
              WHERE peserta.id_peserta = '$id_peserta'";
    $result = mysqli_query($konek, $query);

    
    $queryb = mysqli_query($konek, "SELECT * FROM camaba WHERE nik = '$nik'");
    $rowb = mysqli_fetch_assoc($queryb);  

    if ($result) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Data tidak ditemukan.'); window.location='hasil.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID peserta tidak ditemukan.'); window.location='hasil.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Hasil Ujian</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>UKTS TestZone</h2>
            <p>Berikut adalah hasil ujian seleksi Anda</p>
        </div>
        
        <div class="exam-info">
            <table>
                <tr>
                    <th>NIK</th>
                    <td><?php echo ($row['nik']); ?></td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td><?php echo ($rowb['nama_camaba']); ?></td>
                </tr>
                <tr>
                    <th>Jenis Ujian</th>
                    <td><?php echo ($row['jenis_ujian']); ?></td>
                </tr>
                <tr>
                    <th>Nilai</th>
                    <td><?php echo ($row['nilai']); ?></td>
                </tr>
                <tr>
                    <th>Waktu Ujian Peserta</th>
                    <td><?php echo date("H:i", strtotime($row['peserta_mulai'])); ?></td>
                </tr>
                <tr>
                    <th>Durasi Ujian</th>
                    <td><?php echo ($row['durasi_ujian']); ?> menit</td>
                </tr>
                <tr>
                    <th>Status Ujian</th>
                    <td><?php echo $row['status_ujian'] == 1 ? 'Selesai' : 'Belum Selesai'; ?></td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            <button class="print-button" onclick="window.print()">Cetak Hasil</button>
        </div>
    </div>
</body>
</html>

<style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
        }
        .exam-info {
            margin-bottom: 20px;
        }
        .exam-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .exam-info th, .exam-info td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .exam-info th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .print-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-button:hover {
            background-color: #45a049;
        }
    </style>
