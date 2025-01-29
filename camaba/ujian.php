<?php
include '../koneksi.php';
session_start();
$id_peserta = $_GET['id_peserta'];

$query_peserta = "SELECT p.id_jenis_ujian, j.jenis_ujian, p.durasi_ujian 
                  FROM peserta p 
                  JOIN jenis_ujian j ON p.id_jenis_ujian = j.id_jenis_ujian 
                  WHERE p.id_peserta = " . intval($id_peserta);
$result_peserta = mysqli_query($konek, $query_peserta);

if (mysqli_num_rows($result_peserta) > 0) {
    $data_peserta = mysqli_fetch_assoc($result_peserta);
    $id_jenis_ujian = $data_peserta['id_jenis_ujian'];
    $jenis_ujian = $data_peserta['jenis_ujian'];
    $durasi_ujian = intval($data_peserta['durasi_ujian']);

    $query_soal = "SELECT * FROM soal_ujian WHERE id_jenis_ujian = '" . mysqli_real_escape_string($konek, $id_jenis_ujian) . "'";
    $result_soal = mysqli_query($konek, $query_soal);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ujian</title>
        <link rel="stylesheet" href="ujian.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Ujian: <?=($jenis_ujian); ?></h1>
                <div class="timer" id="timer">00:00:00</div>
            </div>
            <form id="ujianForm" method="POST" action="simpan_jawaban.php">
                <input type="hidden" name="id_peserta" value="<?= $id_peserta ?>">
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result_soal)) {
                    echo "<div class='soal'>";
                    echo "<p><strong>" . $no . ". " . $row['pertanyaan'] . "</strong></p>";
                    echo "<label><input type='radio' name='jawaban[" . $row['id_soal_ujian'] . "]' value='A' required> A. " . $row['a'] . "</label>";
                    echo "<label><input type='radio' name='jawaban[" . $row['id_soal_ujian'] . "]' value='B' required> B. " . $row['b'] . "</label>";
                    echo "<label><input type='radio' name='jawaban[" . $row['id_soal_ujian'] . "]' value='C' required> C. " . $row['c'] . "</label>";
                    echo "<label><input type='radio' name='jawaban[" . $row['id_soal_ujian'] . "]' value='D' required> D. " . $row['d'] . "</label>";
                    echo "<label><input type='radio' name='jawaban[" . $row['id_soal_ujian'] . "]' value='E' required> E. " . $row['e'] . "</label>";
                    echo "</div>";
                    $no++;
                }
                ?>
                <button type="submit">Selesai</button>
            </form>
        <div id="confirmationModal" style="display:none;" class="modal"> <!--konfirmasi mengakhiri ujian-->
            <div class="modal-content">
                <div class="header">
                    <h1>UKTS TestZone</h1>
                </div>
                <div class="content">
                    <h2>ANDA YAKIN MENGAKHIRI UJIAN INI?</h2>
                    <p>Setelah mengakhiri ujian ini anda tidak dapat<br>
                    meralat jawaban anda<br>
                    dan<br>
                    tidak dapat mengambil ujian ini lagi jika tidak diperkenankan.</p>
                    <button id="yesBtn">Ya, saya yakin!!</button>
                    <button id="noBtn">Tidak</button>
                </div>
            </div>
        </div>
    </div>

        <script>
/// Durasi ujian dari database (dalam menit)
let totalSeconds = <?= $durasi_ujian ?> * 60;

// Periksa apakah ada waktu tersisa di local storage
if (localStorage.getItem('timeLeft')) {
    totalSeconds = parseInt(localStorage.getItem('timeLeft'), 10);
}

let timerElement = document.getElementById('timer');

function updateTimer() {
    let hours = Math.floor(totalSeconds / 3600);
    let minutes = Math.floor((totalSeconds % 3600) / 60);
    let seconds = totalSeconds % 60;

    timerElement.textContent =
        String(hours).padStart(2, '0') + ":" +
        String(minutes).padStart(2, '0') + ":" +
        String(seconds).padStart(2, '0');

    if (totalSeconds <= 0) {
        clearInterval(timerInterval); // Hentikan timer
        alert("Waktu habis! Jawaban Anda otomatis terkumpul.");
        localStorage.removeItem('timeLeft'); // Hapus waktu dari local storage
        submitForm(); // Kirim form secara otomatis
    } else {
        totalSeconds--;
        localStorage.setItem('timeLeft', totalSeconds); // Simpan waktu tersisa
    }
}

// Mendengarkan event submit form
document.getElementById('ujianForm').addEventListener('submit', function (event) {
    // Periksa apakah masih ada waktu tersisa
    if (totalSeconds > 0) {
        event.preventDefault(); // Batalkan pengiriman form sementara

        // Tampilkan modal konfirmasi
        document.getElementById('confirmationModal').style.display = 'flex';
        
        // Tangani klik "Ya"
        document.getElementById('yesBtn').addEventListener('click', function() {
            // Kirimkan form jika pengguna memilih "Ya"
            submitForm();
            document.getElementById('confirmationModal').style.display = 'none'; // Tutup modal
        });

        // Tangani klik "Tidak"
        document.getElementById('noBtn').addEventListener('click', function() {
            // Tutup modal tanpa mengirimkan form jika pengguna memilih "Tidak"
            document.getElementById('confirmationModal').style.display = 'none'; 
        });
    }
});

// Fungsi untuk mengirimkan form
function submitForm() {
    let form = document.getElementById('ujianForm');
    if (!form.submitted) {
        form.submitted = true;

        // Salin jawaban dari localStorage ke dalam form
        let jawaban = JSON.parse(localStorage.getItem('jawaban_' + '<?= $id_peserta ?>'));
        if (jawaban) {
            for (let idSoal in jawaban) {
                let inputRadio = document.querySelector(`input[name="jawaban[${idSoal}]"][value="${jawaban[idSoal]}"]`);
                if (inputRadio) {
                    inputRadio.checked = true;
                }
            }
        }

        localStorage.removeItem('jawaban_' + '<?= $id_peserta ?>'); // Hapus jawaban setelah form dikirim
        localStorage.removeItem('timeLeft'); // Hapus waktu dari local storage
        form.submit();
    }
}

// Fungsi untuk menangani perubahan jawaban
document.querySelectorAll('input[type="radio"]').forEach(function(input) {
    input.addEventListener('change', function() {
        let jawaban = {};
        // Ambil semua jawaban yang sudah dipilih
        document.querySelectorAll('input[type="radio"]:checked').forEach(function(checkedInput) {
            let idSoal = checkedInput.name.replace('jawaban[', '').replace(']', ''); // Ambil ID soal dari name attribute
            jawaban[idSoal] = checkedInput.value;
        });
        // Simpan jawaban di localStorage
        localStorage.setItem('jawaban_' + '<?= $id_peserta ?>', JSON.stringify(jawaban));
    });
});

// Memuat jawaban yang disimpan di localStorage
window.onload = function() {
    let jawaban = JSON.parse(localStorage.getItem('jawaban_' + '<?= $id_peserta ?>'));

    if (jawaban) {
        // Iterasi melalui jawaban yang sudah disimpan dan tandai pilihan yang sesuai
        for (let idSoal in jawaban) {
            let nilaiJawaban = jawaban[idSoal];
            let inputRadio = document.querySelector(`input[name="jawaban[${idSoal}]"][value="${nilaiJawaban}"]`);
            if (inputRadio) {
                inputRadio.checked = true;
            }
        }
    }
};

// Fungsi untuk mengirimkan form ke simpan_jawaban.php
function submitForm() {
    let form = document.getElementById('ujianForm');
    if (!form.submitted) {
        form.submitted = true;
        localStorage.removeItem('timeLeft'); // Hapus waktu dari local storage
        form.submit();
    }
}


// Fungsi untuk menangani tombol "Selesai"
document.getElementById('ujianForm').addEventListener('submit', function () {
    localStorage.removeItem('timeLeft'); // Hapus waktu dari local storage saat form dikirim
});

let timerInterval = setInterval(updateTimer, 1000);

</script>
  </body>
    </html>
    <?php
} else {
    echo "Peserta dengan ID " . htmlspecialchars($id_peserta) . " tidak ditemukan.";
}
?>

