-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2026 at 12:38 AM
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
-- Database: `penggajian_karyawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `ID_Karyawan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status_hadir` enum('Hadir','Sakit','Izin','Cuti','Alpa') DEFAULT 'Hadir'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `ID_Karyawan`, `tanggal`, `status_hadir`) VALUES
(1, 28, '2026-05-19', 'Hadir'),
(2, 29, '2026-05-19', 'Hadir'),
(5, 30, '2026-05-19', 'Izin'),
(6, 32, '2026-05-19', 'Cuti'),
(8, 34, '2026-05-19', 'Hadir'),
(11, 36, '2026-05-19', 'Hadir'),
(12, 37, '2026-05-19', 'Izin');

-- --------------------------------------------------------

--
-- Table structure for table `gaji`
--

CREATE TABLE `gaji` (
  `id_gaji` int(11) NOT NULL,
  `ID_Karyawan` int(11) NOT NULL,
  `gaji_pokok` int(11) DEFAULT 0,
  `tunjangan` int(11) DEFAULT 0,
  `lembur` int(11) DEFAULT 0,
  `potongan` int(11) DEFAULT 0,
  `status_pengajuan` enum('Belum Diajukan','Proses','Selesai') DEFAULT 'Belum Diajukan',
  `tanggal_input` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gaji`
--

INSERT INTO `gaji` (`id_gaji`, `ID_Karyawan`, `gaji_pokok`, `tunjangan`, `lembur`, `potongan`, `status_pengajuan`, `tanggal_input`) VALUES
(26, 28, 5000000, 200000, 50000, 0, 'Proses', '2026-05-19'),
(34, 30, 10000000, 0, 0, 0, 'Selesai', '2026-05-19'),
(35, 31, 1000000, 0, 0, 0, 'Selesai', '2026-05-19'),
(36, 34, 7000000, 1000000, 150000, 0, 'Proses', '2026-05-19'),
(37, 34, 10000000, 500000, 0, 0, 'Selesai', '2026-05-19'),
(38, 30, 10000000, 500000, 50000, 0, 'Selesai', '2026-05-19'),
(43, 36, 1000000, 200000, 50000, 0, 'Selesai', '2026-05-19'),
(44, 37, 5000000, 0, 150000, 0, 'Selesai', '2026-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `ID_Karyawan` int(11) NOT NULL,
  `Nama_Karyawan` varchar(50) NOT NULL,
  `Alamat` text NOT NULL,
  `agama` char(20) NOT NULL,
  `jenis_kelamin` enum('Pria','Wanita') NOT NULL,
  `jabatan` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`ID_Karyawan`, `Nama_Karyawan`, `Alamat`, `agama`, `jenis_kelamin`, `jabatan`) VALUES
(28, 'Nadip', 'Cimahi', 'Islam', 'Pria', 'Manajer'),
(29, 'Nanas', 'Cimahi', 'Islam', 'Wanita', 'Direktur'),
(30, 'Wirdan', 'Batujajar', 'Islam', 'Pria', 'Supervisor'),
(31, 'Anton', 'Cimahi', 'Islam', 'Pria', 'Staf'),
(32, 'Lutpi', 'Cimahi', 'Islam', 'Pria', 'Staf'),
(34, 'Boss Fadhlan', 'GBR', 'Islam', 'Pria', 'Supervisor'),
(36, 'Fauzan', 'Batujajar', 'Islam', 'Pria', 'Staf'),
(37, 'Nesayu', 'Batujajar', 'Islam', 'Wanita', 'Manajer');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `ID_Karyawan` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `level` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `ID_Karyawan`, `username`, `password`, `nama`, `level`) VALUES
(1, 0, 'admin', '0192023a7bbd73250516f069df18b500', 'Wirdan', 'admin'),
(10, 28, 'nadif', '202cb962ac59075b964b07152d234b70', 'Nadip', 'user'),
(11, 29, 'nanas', '202cb962ac59075b964b07152d234b70', 'Nanas', 'user'),
(12, 30, 'wirdan', '202cb962ac59075b964b07152d234b70', 'Wirdan', 'user'),
(13, 31, 'anton', '202cb962ac59075b964b07152d234b70', 'Anton', 'user'),
(14, 32, 'lutpi', '202cb962ac59075b964b07152d234b70', 'Lutpi', 'user'),
(16, 34, 'fadhlan', '122b4bcb6f324a4cea9028c18a412e5e', 'Boss Fadhlan', 'user'),
(18, 36, 'fauzan', '202cb962ac59075b964b07152d234b70', 'Fauzan', 'user'),
(19, 37, 'nesayu', '202cb962ac59075b964b07152d234b70', 'Nesayu', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indexes for table `gaji`
--
ALTER TABLE `gaji`
  ADD PRIMARY KEY (`id_gaji`),
  ADD KEY `ID_Karyawan` (`ID_Karyawan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`ID_Karyawan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `gaji`
--
ALTER TABLE `gaji`
  MODIFY `id_gaji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `ID_Karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gaji`
--
ALTER TABLE `gaji`
  ADD CONSTRAINT `gaji_ibfk_1` FOREIGN KEY (`ID_Karyawan`) REFERENCES `karyawan` (`ID_Karyawan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
