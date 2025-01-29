<?php
include '../koneksi.php'; // Koneksi ke database

// Cek apakah ada input NIK dari URL (setelah redirect atau form submission)
if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];

    // Query untuk memeriksa NIK dan status seleksi
    $query = "SELECT * FROM camaba WHERE nik = '$nik'";
    $result = mysqli_query($konek, $query);

    // Periksa apakah ada data
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); // Ambil data
        // Menentukan status seleksi berdasarkan nilai status_seleksi
        if ($row['status_seleksi'] === NULL) {
            $status = "DIPERIKSA";  // Status sedang diperiksa
        } elseif ($row['status_seleksi'] == 0) {
            $status = "TIDAK LOLOS";  // Status tidak lolos
        } elseif ($row['status_seleksi'] == 1) {
            $status = "LOLOS";  // Status lolos
        } else {
            $status = "STATUS TIDAK DITEMUKAN";  // Jika nilai status_seleksi tidak sesuai
        }
    } else {
        // Jika tidak ada data
        $status = "TIDAK ADA AJUAN ATAU NIK TIDAK VALID";
    }
} else {
    $status = "MASUKKAN NIK UNTUK MELIHAT STATUS";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UKTS TestZone</title>
</head>
<body>
  <header>UKTS TestZone</header>
  <main>
    <div class="status-icon">⏲️</div>
    <div class="status-text">STATUS AJUAN → <?php echo $status; ?> </div>
    <div class="instruction">
      *Tunggu selama 5 hari, Password dan Username akan segera dikirimkan ke emailmu!
    </div>
    <a href="../awal.html">
        <button type="button" class="submit-button">← back</button>
    </a>
  </main>
  <footer></footer>
</body>
</html>

<style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background-color: #fff;
      color: #000;
    }

    header {
      width: 100%;
      max-width: 1024px;
      text-align: left;
      padding: 10px 20px;
      box-sizing: border-box;
      font-size: 18px;
      font-weight: bold;
      color: #001f82;
      border-bottom: 1px solid #ddd;
    }

    main {
      width: 100%;
      max-width: 1024px;
      text-align: center;
      margin: 20px auto;
    }

    .status-icon {
      font-size: 50px;
      margin-bottom: 20px;
    }

    .status-text {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .instruction {
      font-size: 16px;
      color: #555;
      margin-bottom: 20px;
    }

    button {
      background-color: #fff;
      border: 1px solid #ddd;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
    }

    button:hover {
      background-color: #f0f0f0;
    }

    footer {
      width: 100%;
      max-width: 1024px;
      background-color: #001f82;
      height: 5px;
      margin-top: 30px;
    }
</style>
