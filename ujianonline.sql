-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Des 2024 pada 17.34
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
  `password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `password`) VALUES
('admin1', 'agustinamartha16@gmail.com', 'hihihi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `camaba`
--

CREATE TABLE `camaba` (
  `nik` varchar(16) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(16) DEFAULT NULL,
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
('1234567890123456', 'marthachistianti@gmail.com', 'hahaha', 'Irene Sukmawijaya', 'Manajemen', '1234567890123456.jpg', '1234567890123456.jpg', '1234567890123456.jpg', '1234567890123456.jpg', '1234567890123456.jpg', '2024-11-22 08:55:53', 1),
('7777777777777777', 'esdeganmurni16@gmail.com', 'hahaha', 'Agustina M C.', 'Teknik Informatika', '7777777777777777.jpg', '7777777777777777.jpg', '7777777777777777.jpg', '7777777777777777.jpg', '7777777777777777.jpg', '2024-12-06 19:46:59', 1);

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
(42, '1234567890123456', 'SR01', '2024-12-06', '2024-12-06', '19:49:00', 30, 0, '', '', '', NULL),
(43, '7777777777777777', 'SR01', '2024-12-06', '2024-12-06', '19:49:00', 30, 1, '1', '3', '25', '2024-12-06 19:52:11'),
(44, '1234567890123456', 'SR02', '2024-12-06', '2024-12-06', '22:54:00', 30, 0, '', '', '', NULL),
(45, '7777777777777777', 'SR02', '2024-12-06', '2024-12-06', '22:54:00', 30, 0, '', '', '', NULL);

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
(20, 'SR01', 'Jika harga sebuah buku adalah Rp40.000,-, lalu diberi diskon sebesar 25%, maka harga setelah diskon adalah', 'Rp28.000', 'Rp30.000', 'Rp32.000', 'Rp35.000', 'Rp38.000', 'C');

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
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT untuk tabel `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `soal_ujian`
--
ALTER TABLE `soal_ujian`
  MODIFY `id_soal_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
