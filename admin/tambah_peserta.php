<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda belum login, silakan login terlebih dahulu.'); window.location='login_admin.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $jam_ujian = $_POST['jam_ujian'];
    $durasi_ujian = $_POST['durasi_ujian'];
    $id_jenis_ujian = $_POST['id_jenis_ujian'];
    $pilih_peserta = $_POST['pilih_peserta']; 

    // Cek apakah ada peserta yang dipilih
    if (!empty($pilih_peserta)) {
        foreach ($pilih_peserta as $nik) {
            $query = "INSERT INTO peserta 
                      (nik, id_jenis_ujian, tanggal_mulai, tanggal_selesai, jam_ujian, durasi_ujian, status_ujian) 
                      VALUES 
                      ('$nik', '$id_jenis_ujian', '$tanggal_mulai', '$tanggal_selesai', '$jam_ujian', '$durasi_ujian', 0)";

            // Eksekusi query
            if (mysqli_query($konek, $query)) {
                echo "Data peserta dengan NIK $nik berhasil disimpan.<br>";
            } else {
                echo "Gagal menyimpan data peserta dengan NIK $nik: " . mysqli_error($konek) . "<br>";
            }
        }
        echo "<a href='kelola_peserta.php'>Kembali ke menu Kelola Peseta Ujian</a>";
    } else {
        echo "Tidak ada peserta yang dipilih.<br>";
        echo "<a href='kelola_peserta.php'>Kembali</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Peserta</title>
</head>
<body>
    <div class="container">
        <h2>Tambah Peserta Ujian</h2>
        <form action="" method="POST">
            <label for="id_jenis_ujian">Jenis Ujian</label>
            <select id="id_jenis_ujian" name="id_jenis_ujian" required>
                <option value="" selected>- Pilih Jenis Ujian -</option>
                <option value="SR01">Tes Kemampuan Akademik</option>
                <option value="SR02">Tes Potensi Skolastik</option>
            </select>

            <label for="tanggal_mulai">Tanggal Mulai Ujian</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" required>

            <label for="tanggal_selesai">Tanggal Selesai Ujian</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" required>

            <label for="jam_ujian">Jam Ujian</label>
            <input type="time" id="jam_ujian" name="jam_ujian" required>

            <label for="durasi_ujian">Durasi Ujian (menit)</label>
            <input type="number" id="durasi_ujian" name="durasi_ujian" placeholder="Masukkan durasi dalam menit" required>

            <h4 style='text-align: center'>Tabel Peserta</h4>

            <!-- Search Box -->
            <div class="search-container">
                <input type="text" id="search" placeholder="Cari peserta..." onkeyup="searchTable()">
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Progdi</th>
                        <th>
                            <input type="checkbox" id="pilih-semua"> Pilih Semua
                        </th>
                    </tr>
                </thead>
                <tbody id="peserta-table-body">
                    <?php
                    $query = mysqli_query($konek, "SELECT * FROM camaba WHERE `status_seleksi` = 1");
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['nama_camaba']}</td>
                            <td>{$row['nik']}</td>
                            <td>{$row['progdi']}</td>
                            <td><input type='checkbox' class='checkbox-pilih' name='pilih_peserta[]' value='{$row['nik']}'></td>
                        </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>

            <div class="btn-row">
                <button type="button" onclick="window.history.back()">Kembali</button>
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        // Fitur Pilih Semua
        const pilihSemuaCheckbox = document.getElementById('pilih-semua');
        const individualCheckboxes = document.querySelectorAll('.checkbox-pilih');

        pilihSemuaCheckbox.addEventListener('change', function () {
            individualCheckboxes.forEach(checkbox => {
                checkbox.checked = pilihSemuaCheckbox.checked;
            });
        });

        // Fungsi Pencarian Tabel
        function searchTable() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('peserta-table-body');
            const rows = table.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const td = rows[i].getElementsByTagName('td');
                let match = false;

                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        const txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            match = true;
                        }
                    }
                }

                if (match) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>
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