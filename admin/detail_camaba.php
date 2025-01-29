<?php include '../koneksi.php';
session_start();
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}

$id_admin = $_SESSION['id_admin'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../library/PHPMailer.php";
require_once "../library/Exception.php";
require_once "../library/SMTP.php";
include '../koneksi.php';

if (isset($_GET['email'])) {
    $email = mysqli_real_escape_string($konek, $_GET['email']);

    // Ambil data camaba
    $query = "SELECT * FROM camaba WHERE email = '$email'";
    $result = mysqli_query($konek, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $data = mysqli_fetch_assoc($result);
        $nama = $data['nama_camaba'];
        $status_seleksi = $data['status_seleksi'];
    } else {
        die("Data camaba tidak ditemukan!");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status_seleksi = mysqli_real_escape_string($konek, $_POST['status_seleksi']);

    // Update status seleksi
    $update_query = "UPDATE camaba SET status_seleksi = '$status_seleksi' WHERE email = '$email'";
    if (mysqli_query($konek, $update_query)) {
        if ($status_seleksi === '1') {
            $password = bin2hex(random_bytes(4)); 
            $update_password_query = "UPDATE camaba SET password = '$password' WHERE email = '$email'";
            mysqli_query($konek, $update_password_query);

            // Konfigurasi PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Username = "agustinamartha16@gmail.com"; 
                $mail->Password = "vdfufsauupjglyje"; 
                $mail->SMTPSecure = "tls";
                $mail->Port = 587;

                $mail->setFrom("agustinamartha16@gmail.com", "Panitia Seleksi Mahasiswa Baru");
                $mail->addAddress($email, $nama);

                $mail->isHTML(true);
                $mail->Subject = "Selamat, Anda Lolos Seleksi Pendaftaran!";
                $mail->Body = "
                    <p>Halo, $nama!</p>
                    <p>Selamat, Anda dinyatakan lolos seleksi pendaftaran. Berikut adalah detail akun UKTS TestZone Anda:</p>
                    <ul>
                        <li><strong>Email:</strong> $email</li>
                        <li><strong>Password:</strong> $password</li>
                    </ul>
                    <p>Silakan login ke sistem menggunakan akun Anda.</p>
                ";
                $mail->AltBody = "Halo, $nama! Selamat, Anda lolos seleksi. Gunakan email: $email dan password: $password untuk login.";

                $mail->send();
                echo "Status berhasil diperbarui dan email telah dikirim.";
            } catch (Exception $e) {
                echo "Status berhasil diperbarui, tetapi email gagal dikirim: {$mail->ErrorInfo}";
            }
        } else {
            echo "Status berhasil diperbarui.";
        }
        header("Location: detail_camaba.php?email=" . urlencode($email));
        exit;
    } else {
        echo "Gagal mengupdate status seleksi: " . mysqli_error($konek);
    }
}

// Array direktori untuk kolom gambar
$image_columns = [
    'foto_ktp' => '../camaba/foto_ktp/',
    'foto_ijazah' => '../camaba/foto_ijazah/',
    'foto_kk' => '../camaba/foto_kk/',
    'pas_foto' => '../camaba/pas_foto/',
    'bukti_pembayaran' => '../camaba/bukti_pembayaran/'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Camaba</title>
</head>
<body>
    <h1 style="text-align: center;">Detail Data Camaba</h1>
    <table>
        <tr>
            <th>Kolom</th>
            <th>Isi</th>
        </tr>
        <?php
        foreach ($data as $key => $value) {
            if ($key === 'status_seleksi') {
                $is_disabled = ($value !== null) ? 'disabled' : '';
                echo "<tr>
                        <td>Status Seleksi Syarat Pendaftaran</td>
                        <td>
                            <form method='POST' action=''>
                                <input type='hidden' name='email' value='$email'>
                                <input type='hidden' name='status_seleksi' value='1'>
                                <button 
                                    type='submit' 
                                    class='status-btn lolos' 
                                    $is_disabled>
                                    Lolos
                                </button>
                            </form>
                            <form method='POST' action=''>
                                <input type='hidden' name='email' value='$email'>
                                <input type='hidden' name='status_seleksi' value='0'>
                                <button 
                                    type='submit' 
                                    class='status-btn tidak-lolos' 
                                    $is_disabled>
                                    Tidak Lolos
                                </button>
                            </form>
                        </td>
                      </tr>";
            } elseif (array_key_exists($key, $image_columns)) {
                $image_path = $image_columns[$key] . $value;
                echo "<tr>
                        <td>" . ucfirst(str_replace('_', ' ', $key)) . "</td>
                        <td>
                            <a href='$image_path' target='_blank'>
                                <img src='$image_path' alt='$key' class='image-preview'>
                            </a>
                        </td>
                      </tr>";
            } else {
                echo "<tr>
                        <td>" . ucfirst(str_replace('_', ' ', $key)) . "</td>
                        <td>$value</td>
                      </tr>";
            }
        }
        ?>
    </table>
    <a href="tabel_camaba.php" class="back-btn">Kembali ke Tabel</a>
</body>
</html>

<style>
    table {
        width: 50%;
        margin: 20px auto;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 12px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .back-btn, .status-btn {
        display: inline-block;
        margin: 5px 5px;
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        text-align: center;
        border: none;
        cursor: pointer;
    }
    .back-btn {
        background-color: #007bff;
    }
    .back-btn:hover {
        background-color: #0056b3;
    }
    .status-btn.lolos {
        background-color: #28a745;
    }
    .status-btn.lolos:hover {
        background-color: #218838;
    }
    .status-btn.tidak-lolos {
        background-color: #ED2939;
    }
    .status-btn.tidak-lolos:hover {
        background-color: #C82333;
    }
    .status-btn:disabled {
        background-color: #d6d6d6;
        cursor: not-allowed;
    }
    .image-preview {
        width: 100px;
        height: auto;
        cursor: pointer;
    }
</style>
