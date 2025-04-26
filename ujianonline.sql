-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Mar 2025 pada 14.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ujianonline`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` varchar(16) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `password`) VALUES
('admin1', 'agustinamartha16@gmail.com', '$2y$10$FZ5.KVF/0c1VbB0VDQ8TWuRX3CGcT.V6uPOsyCsAG1pVoJWuKztme');


-- --------------------------------------------------------

--
-- Struktur dari tabel `camaba`
--

CREATE TABLE `camaba` (
  `nik` varchar(16) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_camaba` varchar(100) NOT NULL,
  `progdi` varchar(40) NOT NULL,
  `pas_foto` varchar(50) NOT NULL,
  `foto_ktp` varchar(50) NOT NULL,
  `foto_kk` varchar(50) NOT NULL,
  `foto_ijazah` varchar(50) NOT NULL,
  `bukti_pembayaran` varchar(50) NOT NULL,
  `waktu` datetime NOT NULL,
  `status_seleksi` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `camaba`
--

INSERT INTO `camaba` (`nik`, `email`, `password`, `nama_camaba`, `progdi`, `pas_foto`, `foto_ktp`, `foto_kk`, `foto_ijazah`, `bukti_pembayaran`, `waktu`, `status_seleksi`) VALUES
('4444444444444444', 'marthachr16@gmail.com', '$2y$10$wwK36u9nviIEAQ941xh97eql7GnBJhKNW8f3Z1iEEQHIgy2VLdzty', 'Woonhak', 'Akuntansi', '4444444444444444.jpg', '4444444444444444.jpg', '4444444444444444.jpg', '4444444444444444.jpg', '4444444444444444.jpg', '2024-12-09 10:30:28', 1),
('7777777777777777', 'esdeganmurni16@gmail.com', '$2y$10$eKUwX6y/IGc9JD3LeaVsCOLVXkzJUSLT8kUMnAfmpkPtPgHlMwGKS', 'Yuna', 'Teknik Informatika', '7777777777777777.jpg', '7777777777777777.jpg', '7777777777777777.jpg', '7777777777777777.jpg', '7777777777777777.jpg', '2024-12-09 10:08:25', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban`
--

CREATE TABLE `jawaban` (
  `id_jawaban` int(11) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `id_soal_ujian` int(11) NOT NULL,
  `jawaban` varchar(5) NOT NULL,
  `keterangan` enum('BENAR','SALAH') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jawaban`
--

INSERT INTO `jawaban` (`id_jawaban`, `id_peserta`, `id_soal_ujian`, `jawaban`, `keterangan`) VALUES
(304, 57, 13, 'A', 'SALAH'),
(305, 57, 14, 'D', 'SALAH'),
(306, 57, 15, 'B', 'SALAH'),
(307, 57, 19, 'D', 'SALAH'),
(308, 57, 22, 'E', 'SALAH'),
(309, 57, 23, 'B', 'SALAH'),
(310, 57, 24, 'D', 'SALAH'),
(311, 57, 27, 'B', 'SALAH'),
(312, 57, 28, 'D', 'SALAH'),
(313, 57, 29, 'C', 'BENAR'),
(314, 57, 31, 'E', 'SALAH'),
(315, 57, 33, 'D', 'SALAH'),
(316, 57, 34, 'C', 'SALAH'),
(317, 57, 35, 'D', 'SALAH'),
(318, 57, 40, 'A', 'SALAH'),
(319, 57, 44, 'C', 'SALAH'),
(320, 57, 45, 'A', 'SALAH');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_ujian`
--

CREATE TABLE `jenis_ujian` (
  `id_jenis_ujian` varchar(10) NOT NULL,
  `jenis_ujian` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_ujian`
--

INSERT INTO `jenis_ujian` (`id_jenis_ujian`, `jenis_ujian`) VALUES
('SR01', 'Tes Kemampuan Akademik'),
('SR02', 'Tes Potensi Skolastik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peserta`
--

CREATE TABLE `peserta` (
  `id_peserta` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `id_jenis_ujian` varchar(10) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `jam_ujian` time NOT NULL,
  `durasi_ujian` int(11) NOT NULL,
  `status_ujian` int(11) NOT NULL,
  `benar` varchar(20) NOT NULL,
  `salah` varchar(20) NOT NULL,
  `nilai` varchar(5) NOT NULL,
  `peserta_mulai` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peserta`
--

INSERT INTO `peserta` (`id_peserta`, `nik`, `id_jenis_ujian`, `tanggal_mulai`, `tanggal_selesai`, `jam_ujian`, `durasi_ujian`, `status_ujian`, `benar`, `salah`, `nilai`, `peserta_mulai`) VALUES
(57, '7777777777777777', 'SR02', '2024-12-09', '2024-12-09', '07:30:00', 10, 1, '1', '16', '5.88', '2024-12-09 10:12:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal_ujian`
--

CREATE TABLE `soal_ujian` (
  `id_soal_ujian` int(11) NOT NULL,
  `id_jenis_ujian` varchar(10) NOT NULL,
  `pertanyaan` text NOT NULL,
  `a` text NOT NULL,
  `b` text NOT NULL,
  `c` text NOT NULL,
  `d` text NOT NULL,
  `e` text NOT NULL,
  `kunci_jawaban` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `soal_ujian`
--

INSERT INTO `soal_ujian` (`id_soal_ujian`, `id_jenis_ujian`, `pertanyaan`, `a`, `b`, `c`, `d`, `e`, `kunci_jawaban`) VALUES
(13, 'SR02', 'Pilih pasangan kata yang memiliki hubungan yang sama dengan kata berikut:\r\nGuru : Mengajar', 'Petani : Sawah', 'Dokter : Mengobati', 'Polisi : Keamanan', 'Penulis : Buku', 'Koki : Masakan', 'B'),
(14, 'SR02', 'Jika 𝑥 = 3 dan 𝑦 = 2𝑥 + 4, maka nilai 𝑦 adalah:', '6', '8', '10', '12', '14', 'C'),
(15, 'SR02', 'Semua bunga mawar adalah tanaman. Sebagian tanaman adalah obat. Maka, pernyataan yang benar adalah:', 'Semua bunga mawar adalah obat.', 'Semua bunga mawar adalah obat.', 'Sebagian bunga mawar mungkin tanaman obat.', 'Semua tanaman adalah bunga mawar.', 'Semua bunga mawar adalah tanaman bukan obat.', 'C'),
(16, 'SR01', 'Jika 𝑓(𝑥) = 𝑥^2 + 2𝑥 - 3, maka akar-akar dari persamaan 𝑓(𝑥) = 0 adalah:', '-3 dan 1', '-1 dan 3', '-2 dan 3', '-3 dan -1', '-2 dan -1', 'A'),
(17, 'SR01', 'Sebuah benda bermassa 5 kg bergerak dengan kecepatan 10 m/s. Berapakah energi kinetik benda tersebut?', '250 J', '400 J', '500 J', '750 J', '1000 J', 'C'),
(18, 'SR01', 'Manakah organ yang merupakan tempat pertukaran gas oksigen dan karbon dioksida pada manusia?', 'Jantung', 'Paru-paru', 'Ginjal', 'Hati', 'Lambung', 'B'),
(19, 'SR02', 'Pilih kata yang tidak sesuai dalam kelompok berikut:\r\nKupu-kupu, Lebah, Semut, Kecoa, Burung', 'Kupu-kupu', 'Lebah', 'Semut', 'Kecoa', 'Burung', 'E'),
(20, 'SR01', 'Jika harga sebuah buku adalah Rp40.000,-, lalu diberi diskon sebesar 25%, maka harga setelah diskon adalah', 'Rp28.000', 'Rp30.000', 'Rp32.000', 'Rp35.000', 'Rp38.000', 'C'),
(21, 'SR01', 'Sebuah persegi memiliki keliling 64 cm. Berapakah panjang sisi persegi tersebut?', '8 cm', '12 cm', '16 cm', '20 cm', '24 cm', 'C'),
(22, 'SR02', 'Lima peserta ujian, yaitu Q, R, S, T, U mengikuti seleksi masuk PTN. Nilai TPA mereka sebagai berikut. Nilai U lebih tinggi dari R, tetapi U lebih rendah dari S. Nilai R lebih tinggi dari Q dan T lebih rendah dari Q.', 'Q', 'R', 'S', 'T', 'U', 'C'),
(23, 'SR02', 'Ada lima keranjang buah-buahan dengan berat yang berbeda. Keranjang salak lebih berat daripada jambu. Keranjang manggis lebih ringan daripada jambu. Keranjang pisang lebih berat daripada apel. Keranjang jambu lebih berat daripada pisang. Keranjang apel tidak lebih ringan daripada manggis.\r\n\r\nKeranjang buah terberat kedua adalah keranjang...', 'Jambu', 'Salak', 'Pisang', 'Manggis', 'Apel', 'A'),
(24, 'SR02', 'Rian, Rendy, Andi, Leo dan Wildan adalah seorang atlet basket, saat akan Latihan mereka terlebih dahulu mengukur tinggi badan. Wildan mempunyai tinggi badan 185 cm setelah diukur. Tinggi badan Andi lebih tinggi 4 cm dari Rendi dan lebih tinggi 8 cm dari Rian.\r\n\r\nJika tinggi badan Wildan 6 cm lebih tinggi dari Rian dan Leo, Tinggi yang paling pendek adalah....', '178 cm', '179 cm', '180 cm', '183 cm', '185 cm', 'B'),
(25, 'SR01', 'Manakah pernyataan yang benar jika |2x - 5|\r\n\r\n(1) HP = {1,2,3,4}\r\n(2) HP ={x|1 < x < 4, x∈Ζ}\r\n(3) Jumlah seluruh nilai x adalah 10\r\n(4) Hasil kali seluruh nilai x adalah 6', '(1), (2) dan (3) SAJA yang benar', '1) dan (3) SAJA yang benar', '(2) dan (4) SAJA yang benar', 'Hanya (4) SAJA yang benar', 'Semua pilihan jawaban benar', 'C'),
(26, 'SR01', 'Dalam suatu kelas terdapat 12 murid laki-laki dan 16 murid perempuan. Rata-rata nilai ulangan Matematika di kelas tersebut adalah 80. Setelah melihat hasil tersebut, guru Matematika memberikan kesempatan kepada 4 murid, dengan nilai masing-masing 52, 56, 62, dan 66, untuk melakukan remedial. Diketahui bahwa nilai rata-rata peserta remedial naik 7 poin.\r\n\r\nJika sebelum remedial, rata-rata nilai ulangan murid laki-laki di kelas tersebut adalah 78, rata-rata nilai ulangan murid perempuan adalah ...', '80,5', '81', '81,5', '82', '82,5', 'C'),
(27, 'SR02', 'Khasiat susu bagi tubuh kita sudah tidak diragukan lagi. Meskipun demikian, tidak setiap orang bersedia mengonsumsi susu. Ada dua kemungkinan penyebabnya: pertama, karena sifat yang terkandung dalam susu yang tidak disukai orang; kedua, karena sifat biologis orang yang bersangkutan (intoleran), yang ditandai dengan gangguan pencernaan seperti diare, perut kembung, dan sering buang angin setelah minum susu.\r\n\r\nPenyebab pertama dapat diatasi dengan penambahan sari jeruk, markisa, apel, atau lainnya sehingga rasa asli susu yang memualkan dapat dihilangkan. Sementara itu, penyebab kedua dapat diatasi dengan menggantinya dengan air susu yang telah mengalami perlakuan khusus, yaitu fermentasi. Secara biologis, penderita intoleran susu tidak mampu mencerna laktosa dari makanan atau minuman dalam susu sehingga terjadi penimbunan laktosa dalam usus. Penderita yang demikian dapat meminum susu bubuk dengan kadar laktosa rendah atau air susu fermentasi, seperti yoghurt, kefir, dan koumis.\r\n\r\nBerdasarkan bacaan di samping, bila seorang temanmu, Ari, mengeluh bahwa ia sebenarnya ingin minum susu seperti teman lainnya, tetapi selalu diare ketika minum susu. Apa yang akan kamu sarankan?', 'Ari dapat mencoba minum susu dengan menambah sari jeruk.', 'Ari dapat mencoba susu bubuk seperti susu yang diminum oleh balita.', 'Ari dapat mencoba minum yoghurt.', 'Ari tidak perlu minum susu sama sekali.', 'Ari dapat mencoba minum susu secara bertahap', 'C'),
(28, 'SR02', 'Kementerian Ketenagakerjaan (Kemnaker) mencatat tingkat pengangguran terbuka Indonesia saat ini berada di angka 5,01 persen. Jumlah ini merupakan angka pengangguran terendah dalam sejarah Indonesia. Selain itu, Kemnaker juga mencatat total lapangan kerja baru telah mencapai 11,1 juta sepanjang 2015-2019. Dengan demikian, target penciptaan 10 juta lapangan kerja baru Presiden Jokowi pada periode tersebut telah terlampaui.\r\n\r\nKendati demikian, pembangunan ketenagakerjaan masih membutuhkan kerja yang besar. Termasuk pada bidang penempatan kerja. Untuk itu, dalam menghadapi tantangan dunia ketenagakerjaan yang semakin kompleks dan berat, dibutuhkan kolaborasi, sinergi, kerja sama, serta menciptakan berbagai terobosan bersama berbagai pihak.\r\n\r\nKata kolaborasi pada paragraf 2 bermakna', 'Gabungan antara dua perusahaan atau lebih untuk memperoleh keuntungan', 'Penyatuan usaha sehingga tercapai pengawasan bersama', 'Kerja sama untuk membuat sesuatu', 'Penggabungan dua atau lebih perusahaan di bawah satu kepemilikan', 'Pengerjaan sesuatu dengan tekun atau cermat', 'C'),
(29, 'SR02', 'Jika semua mahasiswa adalah pelajar, dan beberapa pelajar adalah penulis, maka:', 'Semua mahasiswa adalah penulis.', 'Semua penulis adalah pelajar.', ' Beberapa mahasiswa adalah penulis.', 'Semua pelajar adalah mahasiswa.', 'Semua mahasiswa bukan penulis.', 'C'),
(30, 'SR01', 'Hasil dari 3𝑥 − 2 = 10 adalah:', 'x=2', 'x=3', 'x=4', 'x=5', 'x=6', 'D'),
(31, 'SR02', 'Jika hari ini adalah Jumat, maka 45 hari setelahnya adalah hari:', 'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'D'),
(32, 'SR01', 'Sebuah benda dengan massa 5 kg bergerak dengan kecepatan 10 m/s. Berapakah energi kinetiknya?', '125 J', '250 J', '300 J', '400 J', '500 J', 'E'),
(33, 'SR02', 'Pilih kata yang memiliki hubungan yang sama seperti pasangan berikut:\r\nGula : Manis', 'Garam : Laut', 'Asam : Jeruk', 'Garam : Asin', ' Air : Jernih', 'Kopi : Pahit', 'C'),
(34, 'SR02', 'Pilih kata yang tidak berhubungan dalam kelompok berikut:\r\nKayu, Papan, Jati, Plastik, Tiang', 'Kayu', 'Papan', 'Jati', 'Plastik', 'Tiang', 'D'),
(35, 'SR02', 'Sebuah pernyataan berbunyi:\r\n“Semua burung bisa terbang, kecuali burung unta.”\r\nJika pernyataan itu benar, maka:', 'Semua burung unta tidak bisa terbang.', 'Tidak ada burung lain yang tidak bisa terbang.', 'Beberapa burung unta bisa terbang.', 'Semua burung adalah burung unta.', 'Semua burung yang tidak bisa terbang adalah burung unta.', 'E'),
(37, 'SR01', 'Sebuah pegas dengan konstanta \r\n𝑘 = 200 N/m ditarik sejauh 0,1 m. Berapakah energi potensial elastisnya?', '0,5 J', '1 J', '2 J', '3 J', '4 J', 'A'),
(38, 'SR01', 'Organisme yang menggunakan senyawa kimia sebagai sumber energi disebut:', 'Fototrof', 'Kemotrof', 'Autotrof', 'Heterotrof', 'Saprotrof', 'B'),
(39, 'SR01', 'Jenis reaksi yang terjadi pada pembakaran hidrokarbon adalah:', 'Reaksi substitusi', 'Reaksi eliminasi', 'Reaksi oksidasi', 'Reaksi reduksi', 'Reaksi adisi', 'C'),
(40, 'SR02', 'Semua mahasiswa yang mengambil mata kuliah A adalah mahasiswa tingkat akhir. Sebagian mahasiswa tingkat akhir juga mengambil mata kuliah B. Maka pernyataan berikut yang benar adalah:', 'Semua mahasiswa tingkat akhir mengambil mata kuliah A dan B.', 'Sebagian mahasiswa tingkat akhir tidak mengambil mata kuliah B.', 'Semua mahasiswa yang mengambil mata kuliah B adalah mahasiswa tingkat akhir.', 'Mahasiswa tingkat akhir yang tidak mengambil mata kuliah A tidak mengambil mata kuliah B.', 'Sebagian mahasiswa tingkat akhir mengambil mata kuliah A tetapi tidak B.', 'B'),
(41, 'SR01', 'Jika harga barang X naik 10%, dan permintaan barang tersebut turun sebesar 20%, maka elastisitas harga permintaan untuk barang X adalah:', '0,5', '1', '1,5', '2', '2,5', 'D'),
(42, 'SR01', 'Perang Dingin ditandai dengan persaingan antara dua blok besar dunia, yaitu:', 'Inggris dan Jerman', 'Uni Soviet dan Amerika Serikat', 'Jepang dan Cina', 'Amerika Serikat dan Jepang', 'Uni Soviet dan Inggris', 'B'),
(43, 'SR01', 'Proses sosial yang mengarah pada pembentukan kelompok atau organisasi berdasarkan minat atau tujuan tertentu disebut:', 'Asimilasi', 'Akulturasi', 'Kompetisi', 'Organisasi sosial', 'Asosiasi', 'E'),
(44, 'SR02', 'Pernyataan berikut adalah sebuah deduksi logis:\r\nJika semua buku di rak adalah milik Dira, dan beberapa buku di rak ada yang berwarna merah, maka:', 'Semua buku berwarna merah adalah milik Dira.', 'Beberapa buku berwarna merah adalah milik Dira.', 'Semua buku yang tidak berwarna merah bukan milik Dira.', 'Tidak ada buku berwarna merah yang bukan milik Dira.', 'Semua buku milik Dira berwarna merah.', 'B'),
(45, 'SR02', 'Jika dua orang berlari dengan kecepatan yang sama, dan orang pertama berlari selama 10 menit lebih lama daripada orang kedua, maka orang pertama akan menempuh jarak:', 'Sama dengan orang kedua', 'Lebih jauh dari orang kedua', 'Sama dengan dua kali jarak orang kedua', 'Setengah jarak orang kedua', 'Tidak menempuh jarak sama sekali', 'B');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `camaba`
--
ALTER TABLE `camaba`
  ADD PRIMARY KEY (`nik`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_soal_ujian` (`id_soal_ujian`),
  ADD KEY ```jawaban_peserta_ibfk_1``` (`id_peserta`);

--
-- Indeks untuk tabel `jenis_ujian`
--
ALTER TABLE `jenis_ujian`
  ADD PRIMARY KEY (`id_jenis_ujian`),
  ADD UNIQUE KEY `id_jenis_ujian` (`id_jenis_ujian`);

--
-- Indeks untuk tabel `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id_peserta`),
  ADD KEY `nomor_induk` (`nik`,`id_jenis_ujian`),
  ADD KEY `id_peserta` (`id_peserta`),
  ADD KEY `id_jenis_ujian` (`id_jenis_ujian`);

--
-- Indeks untuk tabel `soal_ujian`
--
ALTER TABLE `soal_ujian`
  ADD PRIMARY KEY (`id_soal_ujian`),
  ADD KEY `id_jenis_ujian` (`id_jenis_ujian`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT untuk tabel `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `soal_ujian`
--
ALTER TABLE `soal_ujian`
  MODIFY `id_soal_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `jawaban_ibfk_1` FOREIGN KEY (`id_peserta`) REFERENCES `peserta` (`id_peserta`),
  ADD CONSTRAINT `jawaban_ibfk_2` FOREIGN KEY (`id_soal_ujian`) REFERENCES `soal_ujian` (`id_soal_ujian`);

--
-- Ketidakleluasaan untuk tabel `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `camaba` (`nik`),
  ADD CONSTRAINT `peserta_ibfk_2` FOREIGN KEY (`id_jenis_ujian`) REFERENCES `jenis_ujian` (`id_jenis_ujian`);

--
-- Ketidakleluasaan untuk tabel `soal_ujian`
--
ALTER TABLE `soal_ujian`
  ADD CONSTRAINT `soal_ujian_ibfk_1` FOREIGN KEY (`id_jenis_ujian`) REFERENCES `jenis_ujian` (`id_jenis_ujian`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
