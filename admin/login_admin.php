<?php include '../koneksi.php';

$error_message = "";
if($_SERVER['REQUEST_METHOD']==='POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = mysqli_query($konek, "SELECT * FROM `admin` WHERE email = '$email'");

    if (mysqli_num_rows($query) > 0) { 
        $getData = mysqli_fetch_assoc($query);
        if ($getData['password'] === $password) {
            session_start();
            $_SESSION['id_admin'] = $getData['id_admin'];
            header("Location: menu_admin.php");
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
    <title>Login Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h2>Masuk</h2>
    <?php if (!empty($success_message)) { ?>
        <p class="success-message"><?php echo $success_message; ?></p>
    <?php } ?>
    <?php if (!empty($error_message)) { ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php } ?>
    <form action="" method="POST">
        <label for="Email">Email:</label>
        <input type="text" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Masuk">
    </form>
</div>
<div class="footer"></div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-image: url("img/logo-ukts-k.jpg");
        background-size: cover; 
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .login-container {
        background-color: rgba(255, 255, 255, 0.8); 
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
        width: 350px;
    }
    .login-container h2 {
        text-align: center;
    }
    .login-container label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    .login-container input[type="text"],
    .login-container input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .login-container input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .login-container input[type="submit"]:hover {
        background-color: #0056b3;
    }
    .message {
        margin-top: 10px;
        text-align: center;
        color: red;
    }

</style>