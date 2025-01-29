<?php include '../koneksi.php';
date_default_timezone_set("Asia/jakarta");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = $_POST['nik'];
    $email = $_POST['email'];
    $namaCamaba = $_POST['nama_camaba'];
    $waktu = date("Y-m-d H:i:s");
    $progdi = $_POST["progdi"];

    // Validasi NIK
    if (!ctype_digit($nik) || strlen($nik) != 16) {
        echo "NIK harus berupa angka dan terdiri dari 16 digit.";
        exit;
    }
    
     // Validasi email
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Alamat email tidak valid.";
        exit;
    }

    $folderBerisiFile = [
        'photo' => 'pas_foto/',
        'ktp' => 'foto_ktp/',
        'kk' => 'foto_kk/',
        'ijazah' => 'foto_ijazah/',
        'payment' => 'bukti_pembayaran/'
    ];

    // Pastikan semua folder sudah ada, jika tidak buat folder
    foreach ($folderBerisiFile as $folder) {
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
    }

    $cekNikQuery = "SELECT * FROM camaba WHERE nik = '$nik'";
    $hasilCekNik = mysqli_query($konek, $cekNikQuery);
    if (mysqli_num_rows($hasilCekNik) > 0) {
        echo "Anda sudah terdaftar.";
        exit;
    }

    $fileBerhasilDiunggah = [];

    foreach ($folderBerisiFile as $kunciFile => $folder) {
        if (isset($_FILES[$kunciFile]) && $_FILES[$kunciFile]['error'] === UPLOAD_ERR_OK) {
            $jalurSementaraFile = $_FILES[$kunciFile]['tmp_name'];
            $namaFile = $_FILES[$kunciFile]['name'];
            $ekstensiFile = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
            $tipeMime = mime_content_type($jalurSementaraFile);

            // Validasi format file
            if (!in_array($ekstensiFile, ['jpg', 'jpeg', 'png', 'pdf']) || !in_array($tipeMime, ['image/jpeg', 'image/png', 'application/pdf'])) {
                echo "File $kunciFile harus berupa JPG, JPEG, PNG, atau PDF.<br>";
                exit;
            }

            // Ganti nama file dengan NIK
            $namaBaruFile = $nik . '.' . $ekstensiFile;

            // Path tujuan file
            $jalurTujuan = $folder . $namaBaruFile;


            if (move_uploaded_file($jalurSementaraFile, $jalurTujuan)) {
                $fileBerhasilDiunggah[$kunciFile] = $namaBaruFile;
            } else {
                echo "Gagal mengunggah file $kunciFile.<br>";
                exit;
            }
        }
    }

    if (count($fileBerhasilDiunggah) === count($folderBerisiFile)) {
        $query = "INSERT INTO camaba (nik, email, nama_camaba, pas_foto, foto_ktp, foto_kk, foto_ijazah, waktu, bukti_pembayaran, progdi) 
                  VALUES ('$nik', '$email', '$namaCamaba', '{$fileBerhasilDiunggah['photo']}', '{$fileBerhasilDiunggah['ktp']}', '{$fileBerhasilDiunggah['kk']}', '{$fileBerhasilDiunggah['ijazah']}', '$waktu', '{$fileBerhasilDiunggah['payment']}', '$progdi')";

        if (mysqli_query($konek, $query)) {
            echo "Data berhasil disimpan dan file berhasil diunggah.";
            header("Location: status_ajuan.php?nik=$nik");
            exit;
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($konek);
        }
    } else {
        echo "Beberapa file gagal diunggah. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Mahasiswa Baru</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <p>Selamat datang Mahasiswa Baru,</p>
            <p>silakan lengkapi berkas berikut ini</p>
            <hr>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" id="nik" maxlength="16" name="nik" placeholder="Masukkan NIK Anda" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" maxlength="100" name="email" placeholder="Masukkan Email Anda" required>
            </div>
            <div class="form-group">
                <label for="namaPengguna">Nama Lengkap</label>
                <input type="text" id="nama_camaba" maxlength="100" name="nama_camaba" placeholder="Masukkan Nama Pengguna" required>
            </div>
            <div class="form-group">
                <label for="prodi">Program Studi</label>
                    <select id="progdi" name="progdi" required>
                        <option value="" disabled selected>Pilih Program Studi</option>
                        <option value="Pendidikan Agama Kristen">Pendidikan Agama Kristen</option>
                        <option value="Pastoral Konseling">Pastoral Konseling</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Teknik Lingkungan">Teknik Lingkungan</option>
                        <option value="Akuntansi">Akuntansi</option>
                        <option value="Manajemen">Manajemen</option>
                    </select>
            </div>
            <div class="form-group">
                <label for="photo">Pas Foto</label>
                <input type="file" id="photo" accept=".jpg,.jpeg,.png,.pdf" name="photo" required>
                <button type="button" onclick="document.getElementById('photo').click()">Pilih File</button>
            </div>
            <div class="form-group">
                <label for="ktp">Foto KTP</label>
                <input type="file" id="ktp" accept=".jpg,.jpeg,.png,.pdf" name="ktp" required>
                <button type="button" onclick="document.getElementById('ktp').click()">Pilih File</button>
            </div>
            <div class="form-group">
                <label for="kk">Foto KK</label>
                <input type="file" id="kk" accept=".jpg,.jpeg,.png,.pdf" name="kk" required>
                <button type="button" onclick="document.getElementById('kk').click()">Pilih File</button>
            </div>
            <div class="form-group">
                <label for="ijazah">Ijazah</label>
                <input type="file" id="ijazah" accept=".jpg,.jpeg,.png,.pdf" name="ijazah" required>
                <button type="button" onclick="document.getElementById('ijazah').click()">Pilih File</button>
            </div>
            <div class="form-group">
                <label for="payment">Tanda Bukti Pembayaran</label>
                <input type="file" id="payment" accept=".jpg,.jpeg,.png,.pdf" name="payment" required>
                <button type="button" onclick="document.getElementById('payment').click()">Pilih File</button>
            </div>
            <div>
                <button type="submit" class="submit-button">Selesai</button>
            </div>
        </form>
    </div>
    <div class="footer"></div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        width: 600px;
        padding: 20px;
        background-color: #ffffff;
    }

    .header {
        text-align: left;
        font-size: 18px;
        margin-bottom: 20px;
    }

    .header p {
        font-size: 20px;
        font-weight: bold;
        color: #000000;
        margin: 0;
    }

    .header hr {
        margin: 10px 0 20px 0;
        width: 100%;
        border: 1px solid #000000;
    }

    .form-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        border: 1px solid #000000;
        border-radius: 5px;
        padding: 10px;
    }

    .form-group label {
        flex: 2;
        text-align: left;
        font-size: 16px;
        color: #000000;
    }

    .form-group input[type="text"], .form-group input[type="email"] {
        flex: 3;
        padding: 10px;
        border: 1px solid #000000;
        border-radius: 5px;
        font-size: 14px;
    }

    .form-group input[type="file"] {
        display: none;
    }

    .form-group button {
        flex: 1;
        padding: 10px;
        font-size: 14px;
        color: #000000;
        background-color: #f0f0f0;
        border: 1px solid #000000;
        border-radius: 5px;
        cursor: pointer;
    }

    .form-group button:hover {
        background-color: #e0e0e0;
    }

    .form-group select {
    flex: 3;
    padding: 10px;
    border: 1px solid #000000;
    border-radius: 5px;
    font-size: 14px;
    background-color: #ffffff;
    color: #000000;
}


    .submit-button {
        width: 100%;
        padding: 15px;
        font-size: 16px;
        background-color: #000080;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        font-weight: bold;
    }

    .submit-button:hover {
        background-color: #000060;
    }

    .footer {
        background-color: #000080;
        height: 20px;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
    }
</style>
