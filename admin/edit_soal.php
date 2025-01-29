<?php include '../koneksi.php';
session_start();
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($konek, $_GET['id']);

    // Ambil data soal berdasarkan ID
    $query = "SELECT * FROM soal_ujian WHERE id_soal_ujian = '$id'";
    $result = mysqli_query($konek, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $id_jenis_ujian = $row['id_jenis_ujian'];
        $pertanyaan = $row['pertanyaan'];
        $a = $row['a'];
        $b = $row['b'];
        $c = $row['c'];
        $d = $row['d'];
        $e = $row['e'];
        $kunci_jawaban = $row['kunci_jawaban'];
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href = 'kelola_soal.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location.href = 'kelola_soal.php';</script>";
    exit;
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_jenis_ujian = mysqli_real_escape_string($konek, $_POST['id_jenis_ujian']);
    $pertanyaan = mysqli_real_escape_string($konek, $_POST['pertanyaan']);
    $a = mysqli_real_escape_string($konek, $_POST['a']);
    $b = mysqli_real_escape_string($konek, $_POST['b']);
    $c = mysqli_real_escape_string($konek, $_POST['c']);
    $d = mysqli_real_escape_string($konek, $_POST['d']);
    $e = mysqli_real_escape_string($konek, $_POST['e']);
    $kunci_jawaban = mysqli_real_escape_string($konek, $_POST['kunci_jawaban']);



    // Update data di database
    $updateQuery = "
        UPDATE soal_ujian
        SET 
            id_jenis_ujian = '$id_jenis_ujian',
            pertanyaan = '$pertanyaan',
            a = '$a',
            b = '$b',
            c = '$c',
            d = '$d',
            e = '$e',
            kunci_jawaban = '$kunci_jawaban'
        WHERE id_soal_ujian = '$id'
    ";

    if (mysqli_query($konek, $updateQuery)) {
        header("Location: kelola_soal.php?status=editsukses");
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui soal.');</script>";
    }    
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Soal Ujian</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Soal</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="id_jenis_ujian">ID Jenis Ujian:</label>
            <select name="id_jenis_ujian" id="id_jenis_ujian" required>
                <option value="" disabled>Pilih jenis ujian</option>
                <?php
                $jenisQuery = "SELECT id_jenis_ujian, jenis_ujian FROM jenis_ujian";
                $jenisResult = mysqli_query($konek, $jenisQuery);
                while ($jenisRow = mysqli_fetch_assoc($jenisResult)) {
                    $selected = $jenisRow['id_jenis_ujian'] == $id_jenis_ujian ? 'selected' : '';
                    echo "<option value='" . $jenisRow['id_jenis_ujian'] . "' $selected>" . $jenisRow['jenis_ujian'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="pertanyaan">Pertanyaan:</label>
            <textarea id="pertanyaan" name="pertanyaan" rows="3" required><?= htmlspecialchars($pertanyaan); ?></textarea>
        </div>

        <div class="form-group">
            <label for="a">Pilihan A:</label>
            <textarea id="a" name="a" rows="1" required><?= htmlspecialchars($a); ?></textarea>
        </div>

        <div class="form-group">
            <label for="b">Pilihan B:</label>
            <textarea id="b" name="b" rows="1" required><?= htmlspecialchars($b); ?></textarea>
        </div>

        <div class="form-group">
            <label for="c">Pilihan C:</label>
            <textarea id="c" name="c" rows="1" required><?= htmlspecialchars($c); ?></textarea>
        </div>

        <div class="form-group">
            <label for="d">Pilihan D:</label>
            <textarea id="d" name="d" rows="1" required><?= htmlspecialchars($d); ?></textarea>
        </div>

        <div class="form-group">
            <label for="e">Pilihan E:</label>
            <textarea id="e" name="e" rows="1" required><?= htmlspecialchars($e); ?></textarea>
        </div>

        <div class="form-group">
            <label for="kunci_jawaban">Kunci Jawaban:</label>
            <select id="kunci_jawaban" name="kunci_jawaban" required>
                <option value="A" <?= $kunci_jawaban === 'A' ? 'selected' : ''; ?>>A</option>
                <option value="B" <?= $kunci_jawaban === 'B' ? 'selected' : ''; ?>>B</option>
                <option value="C" <?= $kunci_jawaban === 'C' ? 'selected' : ''; ?>>C</option>
                <option value="D" <?= $kunci_jawaban === 'D' ? 'selected' : ''; ?>>D</option>
                <option value="E" <?= $kunci_jawaban === 'E' ? 'selected' : ''; ?>>E</option>
            </select>
        </div>

        <input type="submit" value="Simpan Perubahan">
    </form>
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
    select:hover {
        border-color: #007bff; 
        background-color: #e9f5ff;
    }
    option {
        padding: 10px;
        background-color: #fff; 
        color: #333;
    }
    option:hover {
        background-color: #007bff;
        color: #fff; 
    }
    option:checked, option[selected] {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
    }
    textarea {
        flex: 1;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box; 
    }
</style>