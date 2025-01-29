<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Ujian</title>
</head>
<body>
<?php
include '../koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_peserta'])) {
    $id_peserta = $_POST['id_peserta'];
    $query = "SELECT peserta.*, jenis_ujian.jenis_ujian
              FROM peserta
              INNER JOIN jenis_ujian ON peserta.id_jenis_ujian = jenis_ujian.id_jenis_ujian
              WHERE id_peserta = '$id_peserta'";
    $result = mysqli_query($konek, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_date = date("Y-m-d");
        $waktu_sekarang = date('Y-m-d H:i:s');

        // Validasi status ujian
        if ($row['status_ujian'] == 1) {
            echo "<p class='error'>Anda sudah menyelesaikan ujian ini dan tidak dapat mengulanginya lagi.</p>";
        } elseif ($current_date < $row['tanggal_mulai'] || $current_date > $row['tanggal_selesai']) {
            // Validasi tanggal ujian
            echo "<p class='error'>Tanggal ujian tidak sesuai. Ujian hanya bisa dimulai antara " . $row['tanggal_mulai'] . " dan " . $row['tanggal_selesai'] . ".</p>";
        } else {
            // Menampilkan detail ujian
            echo '<div class="exam-details">';
            echo '<h3>Anda akan memulai ujian berikut:</h3>';
            echo '<p><strong>Jenis Ujian:</strong> ' . $row['jenis_ujian'] . '</p>';
            echo '<p><strong>Durasi:</strong> ' . $row['durasi_ujian'] . ' menit</p>';
            
            echo '<form method="POST" action="" class="confirmation-form">';
            echo '<input type="hidden" name="id_peserta" value="' . $id_peserta . '">';
            echo '<button type="submit" name="konfirmasi" value="ya" class="btn btn-yes">Ya</button>';
            echo '<button type="submit" name="konfirmasi" value="tidak" class="btn btn-no">Tidak</button>';
            echo '</form>';
            echo '</div>';

            if (isset($_POST['konfirmasi'])) {
                $konfirmasi = $_POST['konfirmasi'];

                if ($konfirmasi == 'ya') {
                    // Update status ujian menjadi sudah ujian
                    $update_query = "UPDATE peserta 
                     SET status_ujian = 1, peserta_mulai = '$waktu_sekarang' 
                     WHERE id_peserta = '$id_peserta'";
                    mysqli_query($konek, $update_query);
                    echo "<div class='message'>Ujian dimulai untuk ID Peserta: " . ($id_peserta) . "</div>";
                    header("Location: ujian.php?id_peserta=$id_peserta");
                } else {
                    header("Location: halaman_utama.php");
                }
            }
        }
    } else {
        echo "<p class='error'>Data ujian tidak ditemukan.</p>";
    }
} else {
    echo "<p class='error'>Data tidak valid.</p>";
}
?>
  
</body>
</html>


<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    text-align: center;
}
.message {
    background-color: #e3f2fd;
    color: #1e88e5;
    border: 1px solid #64b5f6;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}
.error {
    color: #d32f2f;
    font-weight: bold;
}
.exam-details {
    width: 90%;
    max-width: 700px;
    background-color: #ffffff;
    padding: 20px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.exam-details h3 {
    color: #333;
    margin-bottom: 15px;
}
.exam-details p {
    margin: 10px 0;
    font-size: 16px;
    color: #555;
}
.confirmation-form {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px; 
    margin-top: 20px;
}

.btn {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn:hover {
    transform: scale(1.05);
}

.btn-yes {
    background-color: #4caf50;
    color: #fff;
}

.btn-yes:hover {
    background-color: #388e3c;
}

.btn-no {
    background-color: #f44336;
    color: #fff;
}

.btn-no:hover {
    background-color: #d32f2f;
}
</style>
