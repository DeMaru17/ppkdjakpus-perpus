-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2024 at 05:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int(11) NOT NULL,
  `nisn` varchar(16) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `nisn`, `nama_lengkap`, `jenis_kelamin`, `no_telp`, `alamat`, `created_at`, `updated_at`) VALUES
(2, '1234563', 'Bhayu Bramastha', 'Laki-laki', '6285888722935', 'Rawamangun', '2024-08-06 07:07:17', '2024-08-06 07:07:17'),
(3, '132546', 'Zahra', 'Perempuan', '8143165464123', 'Rawamangun', '2024-08-06 07:26:37', '2024-08-07 07:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `penerbit` varchar(50) NOT NULL,
  `tahun_terbit` varchar(5) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `id_kategori`, `judul`, `jumlah`, `penerbit`, `tahun_terbit`, `penulis`, `created_at`, `updated_at`) VALUES
(2, 7, 'Buku Agama kelas XII', 5, 'Gramedia', '2021', 'Hartono', '2024-08-06 04:21:21', '2024-08-06 04:26:01'),
(3, 6, 'Buku Sejarah kelas X', 14, 'Erlangga', '2013', 'Maulana', '2024-08-06 04:22:26', '2024-08-07 07:53:32'),
(7, 8, 'Geografi kelas X', 7, 'Gramedia', '2021', 'Hartono', '2024-08-07 06:46:12', '2024-08-07 06:54:28'),
(8, 9, 'Biologi kelas IX', 15, 'Kompas', '2013', 'Riyan & Haris', '2024-08-07 07:01:03', '2024-08-07 07:04:52'),
(9, 9, 'Kimia kelas XI', 12, 'Erlangga', '2021', 'Hartono', '2024-08-07 07:13:20', '2024-08-07 07:13:20'),
(10, 8, 'Ekonomi kelas XI', 13, 'Gramedia', '2013', 'Hartono', '2024-08-07 07:16:06', '2024-08-07 07:16:06'),
(11, 6, 'Buku Sejarah kelas IX', 12, 'Kompas', '2013', 'Erlangga', '2024-08-07 07:17:00', '2024-08-07 07:53:18'),
(12, 7, 'Buku Agama kelas IX', 11, 'Kompas', '2021', 'Mansur', '2024-08-07 07:17:27', '2024-08-07 07:54:22');

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_peminjaman`
--

INSERT INTO `detail_peminjaman` (`id`, `id_peminjaman`, `id_buku`, `id_kategori`) VALUES
(4, 13, 7, 8),
(5, 14, 8, 9),
(6, 15, 7, 8),
(7, 15, 9, 9),
(8, 15, 2, 7),
(9, 16, 8, 9),
(10, 16, 2, 7),
(11, 16, 10, 8),
(12, 17, 11, 6);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `keterangan`, `created_at`, `updated_at`) VALUES
(6, 'Sejarah', 'Sejarah Indonesia', '2024-08-06 03:41:51', '2024-08-07 07:25:23'),
(7, 'Agama', 'Agama Islam', '2024-08-06 03:42:02', '2024-08-07 07:25:09'),
(8, 'Ilmu Sosial', 'Ilmu Pengetahuan Sosial', '2024-08-06 03:42:14', '2024-08-07 06:37:49'),
(9, 'Sains', 'Ilmu Pengetahuan Alam', '2024-08-06 03:42:26', '2024-08-07 06:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `nama_level` varchar(50) NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `nama_level`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', '', '2024-08-06 01:20:38', '2024-08-06 01:21:48'),
(2, 'Admin', '', '2024-08-06 01:20:38', '2024-08-06 01:21:53');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode_transaksi` varchar(30) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_anggota`, `id_user`, `kode_transaksi`, `tgl_pinjam`, `tgl_kembali`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(14, 2, 4, 'PJ12082024014', '2024-08-12', '2024-08-15', 2, '2024-08-12 07:28:19', '2024-08-16 07:17:21', 0),
(15, 3, 4, 'PJ12082024015', '2024-08-13', '2024-08-22', 2, '2024-08-12 07:32:11', '2024-08-16 07:23:35', 0),
(16, 3, 8, 'PJ16082024016', '2024-08-16', '2024-08-23', 2, '2024-08-16 06:05:04', '2024-08-16 07:34:08', 0),
(17, 3, 8, 'PJ16082024017', '2024-08-16', '2024-08-23', 2, '2024-08-16 06:43:46', '2024-08-16 06:55:02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `kode_pengembalian` varchar(30) NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `terlambat` int(9) NOT NULL,
  `denda` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id`, `id_peminjaman`, `kode_pengembalian`, `tgl_pengembalian`, `terlambat`, `denda`, `created_at`, `updated_at`) VALUES
(2, 17, '', '2024-08-16', 0, 0, '2024-08-16 06:44:34', '2024-08-16 06:44:34'),
(3, 17, '', '2024-08-16', 0, 0, '2024-08-16 06:55:02', '2024-08-16 06:55:02'),
(4, 14, 'KMBL16082024004', '2024-08-16', 1, 10000, '2024-08-16 07:17:21', '2024-08-16 07:17:21'),
(5, 15, 'KMBL16082024005', '2024-08-16', 0, 0, '2024-08-16 07:23:35', '2024-08-16 07:23:35'),
(6, 16, 'KMBL16082024006', '0000-00-00', 0, 0, '2024-08-16 07:34:08', '2024-08-16 07:34:08');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_level`, `nama_lengkap`, `email`, `password`, `created_at`, `updated_at`) VALUES
(4, 1, 'Bhayu Bramastha', 'bhayu_bramastha@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', '2024-07-31 02:51:14', '2024-08-07 07:28:32'),
(5, 1, 'Bramastha', 'bramastha@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', '2024-08-06 02:24:31', '2024-08-06 02:55:13'),
(8, 2, 'Dennis Bhayu', 'dennisbayu99@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', '2024-08-12 05:55:51', '2024-08-12 05:55:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
