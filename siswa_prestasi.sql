-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Agu 2023 pada 06.19
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siswa_prestasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` varchar(60) NOT NULL,
  `level_user` varchar(30) DEFAULT NULL,
  `nama_admin` varchar(50) DEFAULT NULL,
  `nip_admin` varchar(15) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `level_user`, `nama_admin`, `nip_admin`, `email`, `password`) VALUES
('ADM23080400000005', 'admin', 'admin', '-', 'admin@gmail.com', '$2y$10$kqo4zaFaPOMSJNYlbEL1sOh/nb7QAu8g85vfs7JPwFFChXQFCBXmW'),
('ADM23080440000001', 'guru', 'Guru', '-', 'rian071020@gmail.com', '$2y$10$3KS/XWN/0BemT90Dt7c8kuwV/wcCPmsUEC0GGex/012l7vesW5xnq');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` varchar(30) NOT NULL,
  `nama_kelas` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`) VALUES
('GR23080300000001', '11 IPS 1'),
('GR23080300000002', '11 IPS 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_nilai`
--

CREATE TABLE `tb_nilai` (
  `id_nilai` varchar(50) NOT NULL,
  `id_siswa` varchar(50) DEFAULT NULL,
  `nilai_rata_rata` varchar(30) DEFAULT NULL,
  `nilai_rangking` varchar(30) DEFAULT NULL,
  `nilai_sikap` varchar(20) DEFAULT NULL,
  `nilai_ekstrakurikuler` varchar(20) DEFAULT NULL,
  `nilai_prestasi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_nilai`
--

INSERT INTO `tb_nilai` (`id_nilai`, `id_siswa`, `nilai_rata_rata`, `nilai_rangking`, `nilai_sikap`, `nilai_ekstrakurikuler`, `nilai_prestasi`) VALUES
('NL23072600000001', 'SW23070800000001', '91-100', 'Sangat Tinggi', 'A', 'A', 'Banyak'),
('NL23072600000002', 'SW23070800000002', '91-100', 'Tinggi', 'B', 'B', 'Cukup'),
('NL23072600000003', 'SW23070800000003', '91-100', 'Tinggi', 'C', 'A', 'Sangat banyak'),
('NL23072600000004', 'SW23070800000004', '91-100', 'Tinggi', 'A', 'A', 'Banyak'),
('NL23072600000005', 'SW23070800000005', '91-100', 'Menengah', 'A', 'A', 'Cukup'),
('NL23072600000006', 'SW23070800000006', '91-100', 'Tinggi', 'C', 'A', 'Sangat banyak'),
('NL23072700000007', 'SW23070800000015', '71-80', 'Rendah', 'D', 'D', 'Tidak ada'),
('NL23080400000008', 'SW23080300000033', '91-100', 'Sangat Tinggi', 'A', 'A', 'Sangat banyak'),
('NL23080400000009', 'SW23070800000007', '81-90', 'Sangat Tinggi', 'A', 'A', 'Sangat banyak'),
('NL23080400000010', 'SW23080300000032', '51-70', 'Sangat Rendah', 'A', 'A', 'Sangat banyak'),
('NL23080500000011', 'SW23070800000008', '81-90', 'Sangat Tinggi', 'B', 'B', 'Banyak'),
('NL23080500000012', 'SW23070800000031', '91-100', 'Menengah', 'B', 'B', 'Sangat banyak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rating_kecocokan`
--

CREATE TABLE `tb_rating_kecocokan` (
  `id_rating_kecocokan` varchar(50) NOT NULL,
  `id_nilai` varchar(30) NOT NULL,
  `id_siswa` varchar(50) DEFAULT NULL,
  `rating_kecocokan_rata` double DEFAULT NULL,
  `rating_kecocokan_rangking` double DEFAULT NULL,
  `rating_kecocokan_sikap` double DEFAULT NULL,
  `rating_kecocokan_ekstrakurikuler` double DEFAULT NULL,
  `rating_kecocokan_prestasi` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_rating_kecocokan`
--

INSERT INTO `tb_rating_kecocokan` (`id_rating_kecocokan`, `id_nilai`, `id_siswa`, `rating_kecocokan_rata`, `rating_kecocokan_rangking`, `rating_kecocokan_sikap`, `rating_kecocokan_ekstrakurikuler`, `rating_kecocokan_prestasi`) VALUES
('RK23072600000001', 'NL23072600000001', 'SW23070800000001', 1, 1, 1, 1, 0.75),
('RK23072600000002', 'NL23072600000002', 'SW23070800000002', 1, 0.8, 0.8, 0.8, 0.55),
('RK23072600000003', 'NL23072600000003', 'SW23070800000003', 1, 0.8, 0.6, 1, 1),
('RK23072600000004', 'NL23072600000004', 'SW23070800000004', 1, 0.8, 1, 1, 0.75),
('RK23072600000005', 'NL23072600000005', 'SW23070800000005', 1, 0.6, 1, 1, 0.55),
('RK23072600000006', 'NL23072600000006', 'SW23070800000006', 1, 0.8, 0.6, 1, 1),
('RK23072700000007', 'NL23072700000007', 'SW23070800000015', 0.6, 0.4, 0.4, 0.4, 0),
('RK23080400000008', 'NL23080400000008', 'SW23080300000033', 1, 1, 1, 1, 1),
('RK23080400000009', 'NL23080400000009', 'SW23070800000007', 0.8, 1, 1, 1, 1),
('RK23080400000010', 'NL23080400000010', 'SW23080300000032', 0.4, 0.2, 1, 1, 1),
('RK23080500000011', 'NL23080500000011', 'SW23070800000008', 0.8, 1, 0.8, 0.8, 0.75),
('RK23080500000012', 'NL23080500000012', 'SW23070800000031', 1, 0.6, 0.8, 0.8, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` varchar(50) NOT NULL,
  `id_kelas` varchar(30) DEFAULT NULL,
  `nama_siswa` varchar(60) DEFAULT NULL,
  `nisn_siswa` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `id_kelas`, `nama_siswa`, `nisn_siswa`) VALUES
('SW23070800000001', 'GR23080300000001', 'Aditya Ramadhani', 'S1'),
('SW23070800000002', 'GR23080300000001', 'Agung Rizqan Adillah', 'S2'),
('SW23070800000003', 'GR23080300000001', 'Aldo Guntur Saputra', 'S3'),
('SW23070800000004', 'GR23080300000001', 'Alfina Khusnul Fitriah', 'S4'),
('SW23070800000005', 'GR23080300000001', 'Alia Wulandari', 'S5'),
('SW23070800000006', 'GR23080300000001', 'Aliya', 'S6'),
('SW23070800000008', 'GR23080300000001', 'Annisa', 'S8'),
('SW23070800000009', 'GR23080300000001', 'Arista Dwi Anggr', 'S9'),
('SW23070800000010', 'GR23080300000001', 'Bima Oktafian', 'S10'),
('SW23070800000011', 'GR23080300000001', 'Deli Irawati', 'S11'),
('SW23070800000012', 'GR23080300000001', 'Elsya Alvionita', 'S12'),
('SW23070800000013', 'GR23080300000001', 'Erna Fitriani', 'S13'),
('SW23070800000014', 'GR23080300000001', 'Fatta Al Aliyyi', 'S14'),
('SW23070800000015', 'GR23080300000001', 'Grista Julianto', 'S15'),
('SW23070800000016', 'GR23080300000001', 'Herlina Trinovita Sari', 'S16'),
('SW23070800000017', 'GR23080300000001', 'Hidayanti', 'S17'),
('SW23070800000018', 'GR23080300000001', 'Latifah Nur Apriyani', 'S18'),
('SW23070800000019', 'GR23080300000001', 'Lisa Aprimulia', 'S19'),
('SW23070800000020', 'GR23080300000001', 'Lodi Naim Hidayah', 'S20'),
('SW23070800000021', 'GR23080300000001', 'Muhammad Fahrezi Purtika', 'S21'),
('SW23070800000022', 'GR23080300000001', 'Muhammad Galih Aldiano', 'S22'),
('SW23070800000023', 'GR23080300000001', 'Marchisa Aulia', 'S23'),
('SW23070800000024', 'GR23080300000001', 'Novita Claudia Maoz', 'S24'),
('SW23070800000025', 'GR23080300000001', 'Novita Elsa Putri', 'S25'),
('SW23070800000026', 'GR23080300000001', 'Nur Aryanti', 'S26'),
('SW23070800000027', 'GR23080300000001', 'Putri Dea Ananta', 'S27'),
('SW23070800000028', 'GR23080300000001', 'Reva Febriani', 'S28'),
('SW23070800000029', 'GR23080300000001', 'Salsabila Putri R', 'S29'),
('SW23070800000030', 'GR23080300000001', 'Sandi Auliya', 'S30'),
('SW23070800000031', 'GR23080300000001', 'Wahyudi', 'S31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indeks untuk tabel `tb_rating_kecocokan`
--
ALTER TABLE `tb_rating_kecocokan`
  ADD PRIMARY KEY (`id_rating_kecocokan`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
