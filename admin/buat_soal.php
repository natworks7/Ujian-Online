<?php include '../koneksi.php'; 
session_start();
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}
$id_admin = $_SESSION['id_admin'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_jenis_ujian = mysqli_real_escape_string($konek, $_POST['id_jenis_ujian']);
    $pertanyaan = mysqli_real_escape_string($konek, $_POST['pertanyaan']);
    $a = mysqli_real_escape_string($konek, $_POST['a']);
    $b = mysqli_real_escape_string($konek, $_POST['b']);
    $c = mysqli_real_escape_string($konek, $_POST['c']);
    $d = mysqli_real_escape_string($konek, $_POST['d']);
    $e = mysqli_real_escape_string($konek, $_POST['e']);
    $kunci_jawaban = mysqli_real_escape_string($konek, $_POST['kunci_jawaban']);

    $query = "INSERT INTO soal_ujian (id_jenis_ujian, pertanyaan, a, b, c, d, e, kunci_jawaban) 
              VALUES ('$id_jenis_ujian', '$pertanyaan', '$a', '$b', '$c', '$d', '$e', '$kunci_jawaban')";

    if (mysqli_query($konek, $query)) {
        echo "<script>alert('Soal berhasil disimpan.'); window.location='kelola_soal.php'; </script>";
    } else {
        echo "Error: " . mysqli_error($konek);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Soal Ujian</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Buat Soal Ujian</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="id_jenis_ujian">ID Jenis Ujian:</label>
            <?php
                $query = "SELECT id_jenis_ujian, jenis_ujian FROM jenis_ujian";
                $result = mysqli_query($konek, $query);
                ?>

            <select name="id_jenis_ujian" id="id_jenis_ujian" required>
            <option value="" disabled selected>Pilih jenis ujian</option>
                <?php
                if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id_jenis_ujian'] . "'>" . $row['jenis_ujian'] . "</option>";
                }
                } else {
                    echo "0 results";
                }
                ?>
                </select>
        </div>


        <div class="form-group">
            <label for="pertanyaan">Pertanyaan:</label>
            <textarea id="pertanyaan" name="pertanyaan" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="a">Pilihan A:</label>
            <textarea id="a" name="a" rows="1" required></textarea>
        </div>

        <div class="form-group">
            <label for="b">Pilihan B:</label>
            <textarea id="b" name="b" rows="1" required></textarea>
        </div>

        <div class="form-group">
            <label for="c">Pilihan C:</label>
            <textarea id="c" name="c" rows="1" required></textarea>
        </div>

        <div class="form-group">
            <label for="d">Pilihan D:</label>
            <textarea id="d" name="d" rows="1" required></textarea>
        </div>

        <div class="form-group">
            <label for="e">Pilihan E:</label>
            <textarea id="e" name="e" rows="1" required></textarea>
        </div>

        <div class="form-group">
            <label for="kunci_jawaban">Kunci Jawaban:</label>
            <select id="kunci_jawaban" name="kunci_jawaban" required>
                <option value="" disabled selected>Pilih kunci jawaban</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>
        </div>

        <input type="submit" value="Simpan Soal">
    </form>

<div class="footer"></div>
</body>
</html>

<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        form {
    margin: 20px auto;
    width: 60%;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.form-group {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

label {
    width: 30%; /* Lebar label */
    margin-right: 10px;
    text-align: right; /* Teks label rata kanan */
}

input[type="text"], input[type="file"], select {
    flex: 1; /* Input menyesuaikan ukuran */
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

input[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

          /* Style untuk elemen select */
    select {
        width: 100%; 
        padding: 10px; 
        font-size: 14px; 
        border: 1px solid #ccc; 
        border-radius: 5px; 
        background-color: #f9f9f9; 
        color: #333; 
        box-sizing: border-box;
        cursor: pointer;
    }

    /* Ubah warna dan gaya border saat select di-hover */
    select:hover {
        border-color: #007bff; 
        background-color: #e9f5ff;
    }

    /* Style untuk elemen option */
    option {
        padding: 10px; /* Memberikan ruang pada setiap opsi */
        background-color: #fff; /* Warna dasar opsi */
        color: #333; /* Warna teks opsi */
    }

    /* Style untuk opsi saat disorot (dipilih dengan keyboard/mouse) */
    option:hover {
        background-color: #007bff; /* Ubah warna background saat di-hover */
        color: #fff; /* Warna teks menjadi putih */
    }

    /* Style untuk opsi yang dipilih */
    option:checked, option[selected] {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
    }

    textarea {
    flex: 1; /* Menyesuaikan ukuran dengan label */
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box; 
}

    </style>