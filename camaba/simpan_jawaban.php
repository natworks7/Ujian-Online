<?php
include '../koneksi.php'; 
session_start();

if (!isset($_POST['id_peserta'])) {
    echo "ID Peserta tidak ditemukan.";
    exit;
}

$id_peserta = $_POST['id_peserta'];

if (isset($_POST['jawaban'])) {
    $jawaban = $_POST['jawaban'];
} else {
    $jawaban = []; // Jika tidak ada jawaban, inisialisasi sebagai array kosong
}

$benar = 0;
$salah = 0;

if (!mysqli_begin_transaction($konek)) {
    echo "Gagal memulai transaksi.";
    exit;
}

try {
    // Ambil semua soal untuk peserta ini
    $query_total_soal = "SELECT id_soal_ujian, kunci_jawaban 
                         FROM soal_ujian 
                         WHERE id_jenis_ujian = 
                               (SELECT id_jenis_ujian FROM peserta WHERE id_peserta = '$id_peserta')";

    $result_total_soal = mysqli_query($konek, $query_total_soal);

    if (!$result_total_soal) {
        throw new Exception("Error pada query total soal: " . mysqli_error($konek));
    }

    $total_soal = mysqli_num_rows($result_total_soal);

    if ($total_soal == 0) {
        throw new Exception("Jumlah soal tidak ditemukan untuk peserta ini.");
    }

    while ($soal = mysqli_fetch_assoc($result_total_soal)) {
        $id_soal_ujian = $soal['id_soal_ujian'];
        $kunci_jawaban = $soal['kunci_jawaban'];

        // Cek apakah soal ini dijawab peserta
        if (isset($jawaban[$id_soal_ujian])) {
            $jawaban_peserta = $jawaban[$id_soal_ujian];
            $keterangan = ($jawaban_peserta == $kunci_jawaban) ? 'BENAR' : 'SALAH';
        } else {
            // Jika soal tidak dijawab, otomatis salah
            $jawaban_peserta = null;
            $keterangan = 'SALAH';
        }

        // Simpan jawaban peserta ke tabel jawaban
        $query = "INSERT INTO jawaban (id_peserta, id_soal_ujian, jawaban, keterangan) 
                  VALUES ('$id_peserta', '$id_soal_ujian', '$jawaban_peserta', '$keterangan') 
                  ON DUPLICATE KEY UPDATE jawaban = '$jawaban_peserta', keterangan = '$keterangan'";

        if (!mysqli_query($konek, $query)) {
            throw new Exception("Gagal menyimpan jawaban: " . mysqli_error($konek));
        }

        // Hitung jawaban benar dan salah
        if ($keterangan == 'BENAR') {
            $benar++;
        } else {
            $salah++;
        }
    }

    // Menghitung nilai akhir berdasarkan jumlah total soal
    $nilai = round(($benar / $total_soal) * 100, 2); 

    // Update data peserta dengan jumlah jawaban benar, salah, dan nilai
    $update_peserta = "UPDATE peserta 
                       SET benar = '$benar', salah = '$salah', nilai = '$nilai', status_ujian = 1 
                       WHERE id_peserta = '$id_peserta'";

    if (!mysqli_query($konek, $update_peserta)) {
        throw new Exception("Gagal mengupdate data peserta: " . mysqli_error($konek));
    }

    mysqli_commit($konek);

    // Redirect ke halaman hasil ujian
    header("Location: hasil.php");
    exit;

} catch (Exception $e) {
    mysqli_rollback($konek);

    // Menampilkan pesan error
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>
