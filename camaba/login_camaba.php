<?php include '../koneksi.php';

$error_message = "";
if($_SERVER['REQUEST_METHOD']==='POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = mysqli_query($konek, "SELECT * FROM `camaba` WHERE email = '$email'");

    if (mysqli_num_rows($query) > 0) { 
        $getData = mysqli_fetch_assoc($query);
        if ($getData['password'] === $password) {
            session_start();
            $_SESSION['nik'] = $getData['nik'];
            header("Location: halaman_utama.php");
            exit();
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Email tidak terdaftar!";
    }
    
    }

    $success_message = "";
    if(isset($_GET['success'])) {
        $success_message = $_GET['success'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Camaba</title>
</head>
<body>
    <!-- Tambahkan logo -->
    <img src="img/logo-ukts-k.jpg" alt="Logo UKTS" class="logo">

    <div class="login-container">
        <h2>UKTS TestZone</h2>
    <?php if (!empty($success_message)) { ?>
        <p class="success-message"><?php echo $success_message; ?></p>
    <?php } ?>
    <?php if (!empty($error_message)) { ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php } ?>
        <form action="" method="POST">
            <label for="Email">Email:</label>
            <input type="text" id="email" name="email" placeholder="Email" required>
            <label for="password">Kata Sandi:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="submit" value="Masuk">
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
        background-color: #FFFFFF;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-container {
        background-color: #e1e1e1; /* Warna abu-abu terang sesuai gambar */
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        width: 400px;
        text-align: center;
    }

    .login-container h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #000080; /* Warna biru tua */
    }

    .login-container label {
        display: block;
        font-weight: bold;
        text-align: left;
        margin: 10px 0 5px;
        color: #663300; /* Warna cokelat lembut */
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .login-container input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #000080; /* Warna biru tua */
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }

    .login-container input[type="submit"]:hover {
        background-color: #004080; /* Warna biru lebih gelap saat hover */
    }

    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #000080; /* Warna biru tua untuk footer */
        height: 20px;
    }

    .logo {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 200px;
    }
</style>