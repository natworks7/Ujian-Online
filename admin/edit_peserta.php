<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}

// Ambil ID peserta dari URL
$id_peserta = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_peserta) {
    echo "ID peserta tidak ditemukan.";
    exit;
}

$query = mysqli_query($konek, "SELECT * FROM peserta WHERE id_peserta = '$id_peserta'");
$peserta = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $jam_ujian = $_POST['jam_ujian'];
    $durasi_ujian = $_POST['durasi_ujian'];
    $id_jenis_ujian = $_POST['id_jenis_ujian'];

    $query = "UPDATE peserta 
              SET id_jenis_ujian='$id_jenis_ujian', tanggal_mulai='$tanggal_mulai', 
                  tanggal_selesai='$tanggal_selesai', jam_ujian='$jam_ujian', 
                  durasi_ujian='$durasi_ujian', status_ujian='0' 
              WHERE id_peserta='$id_peserta'";

    if (mysqli_query($konek, $query)) {
        echo "Data peserta berhasil diperbarui.<br>";
        echo "<a href='kelola_peserta.php'>Kembali ke Kelola Peserta Ujian</a>";
    } else {
        echo "Gagal memperbarui data peserta: " . mysqli_error($konek);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peserta</title>
</head>
<body>
    <div class="container">
        <h2>Edit Peserta Ujian</h2>
        <form action="" method="POST">
            <label for="id_jenis_ujian">Jenis Ujian</label>
            <select id="id_jenis_ujian" name="id_jenis_ujian" required>
                <option value="SR01" <?php echo ($peserta['id_jenis_ujian'] == 'SR01') ? 'selected' : ''; ?>>Tes Kemampuan Akademik</option>
                <option value="SR02" <?php echo ($peserta['id_jenis_ujian'] == 'SR02') ? 'selected' : ''; ?>>Tes Potensi Skolastik</option>
            </select>

            <label for="tanggal_mulai">Tanggal Mulai Ujian</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $peserta['tanggal_mulai']; ?>" required>

            <label for="tanggal_selesai">Tanggal Selesai Ujian</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo $peserta['tanggal_selesai']; ?>" required>

            <label for="jam_ujian">Jam Ujian</label>
            <input type="time" id="jam_ujian" name="jam_ujian" value="<?php echo $peserta['jam_ujian']; ?>" required>

            <label for="durasi_ujian">Durasi Ujian (menit)</label>
            <input type="number" id="durasi_ujian" name="durasi_ujian" value="<?php echo $peserta['durasi_ujian']; ?>" placeholder="Masukkan durasi dalam menit" required>

            <div class="btn-row">
                <button type="button" onclick="window.history.back()">Kembali</button>
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>

<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2, h5 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn-row {
            display: flex;
            justify-content: space-between;
        }

        .search-container {
            margin-bottom: 10px;
            text-align: center;
        }

        .search-container input {
            width: 50%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>