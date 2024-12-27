-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Des 2024 pada 05.18
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dealer_mobil`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT curdate(),
  `status` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nama`, `alamat`, `no_telepon`, `email`, `password`, `foto`, `tanggal_daftar`, `status`) VALUES
(1, 'AHMAD JABBAR', 'padat karya', '09865', '123@gmail.com', '', '1733833039_download (27).jpeg', '2024-12-10', 'Aktif'),
(2, 'yudi', 'padat karya', '09237655410', '123@gmail.com', '', '1734009490_Icikiwir.jpeg', '2024-12-12', 'Aktif'),
(3, 'yudi', 'argamakmur', '09876', '123@gmail.com', '', '1734397378_download (27).jpeg', '2024-12-17', 'Aktif'),
(4, 'AHMAD JABBAR', 'ajjj', '09865', '123@gmail.com', '', '1734397514_download (27).jpeg', '2024-12-17', 'Aktif'),
(5, 'AHMAD JABBAR', 'hhhhj', '09876', '123@gmail.com', '', '1734512090_download (28).jpeg', '2024-12-18', 'Aktif'),
(6, 'ade setiawan', 'manna top juara brung kicau', '098654', '123@gmail.com', '', '1734682073_images (9).jpeg', '2024-12-20', 'Aktif'),
(7, 'ade setiawan', 'manna top juara brung kicau', '098654', '123@gmail.com', '', '1734682087_images (9).jpeg', '2024-12-20', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobil`
--

CREATE TABLE `mobil` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `merek` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mobil`
--

INSERT INTO `mobil` (`id`, `nama`, `merek`, `harga`, `tahun`, `deskripsi`, `gambar`, `stok`) VALUES
(3, 'xenia', 'daihatsu', 70000000, 0, 'generasi baru', 'img_6756fdf836c815.23532367.jpeg', 52),
(4, 'avanza', 'toyota', 100000000, 0, 'generasi baru', 'img_6757f36f5f4ab1.12059123.jpeg', 11),
(5, 'xenia', 'toyota', 10000000, 0, 'generasi baru', 'img_6757f3c2c8bfd7.47357723.jpeg', 1),
(6, 'carry', 'mitshubisi', 100000000, 0, 'generasi 3', 'img_675a6cd420cfc3.93436594.jpeg', 0),
(7, 'icikiwir', 'karatan', 1000, 0, 'icikiwirrr', 'img_675adbcb3d5883.10183819.jpeg', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(11) NOT NULL,
  `mobil_id` int(11) NOT NULL,
  `nama_pembeli` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` decimal(15,2) NOT NULL,
  `tanggal_penjualan` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id`, `mobil_id`, `nama_pembeli`, `alamat`, `jumlah`, `total_harga`, `tanggal_penjualan`, `tanggal`) VALUES
(20, 3, 'jabbar', 'uhiu', 1, 70000000.00, '2024-12-09 14:26:18', '2024-12-09 14:26:18'),
(21, 3, 'jabbar', 'padat karya', 1, 70000000.00, '2024-12-10 03:41:04', '2024-12-10 03:41:04'),
(22, 3, 'jabbar', 'padatkarya', 1, 70000000.00, '2024-12-10 04:02:57', '2024-12-10 04:02:57'),
(23, 3, 'jabbar', 'jj', 1, 70000000.00, '2024-12-10 04:08:48', '2024-12-10 04:08:48'),
(24, 3, 'jabbar', 'jhjhjh', 1, 70000000.00, '2024-12-10 04:13:06', '2024-12-10 04:13:06'),
(25, 3, 'jabbar', 'jjhjh', 1, 70000000.00, '2024-12-10 07:21:58', '2024-12-10 07:21:58'),
(26, 6, 'biliy gaminng', 'muko muko', 1, 100000000.00, '2024-12-12 04:56:30', '2024-12-12 04:56:30'),
(27, 5, 'biliy gaminng', 'vhjhj', 1, 10000000.00, '2024-12-12 04:57:03', '2024-12-12 04:57:03'),
(28, 6, 'biliy gaminng', 'hghghg', 1, 100000000.00, '2024-12-12 05:04:04', '2024-12-12 05:04:04'),
(29, 3, 'biliy gaminng', 'kjjj', 1, 70000000.00, '2024-12-12 07:09:09', '2024-12-12 07:09:09'),
(30, 6, 'biliy gaminng', 'hghghg', 1, 100000000.00, '2024-12-12 07:11:22', '2024-12-12 07:11:22'),
(31, 6, 'biliy gaminng', 'hghghg', 1, 100000000.00, '2024-12-12 07:11:41', '2024-12-12 07:11:41'),
(32, 3, 'jabbar', 'padat karya', 1, 70000000.00, '2024-12-12 07:12:16', '2024-12-12 07:12:16'),
(33, 5, 'biliy gaminng', 'ajajajaj', 1, 10000000.00, '2024-12-12 12:22:02', '2024-12-12 12:22:02'),
(34, 5, 'burik gaming', 'tebing kaning', 1, 10000000.00, '2024-12-12 12:27:04', '2024-12-12 12:27:04'),
(35, 5, 'burik gaming', 'tebing kaning', 1, 10000000.00, '2024-12-12 12:27:42', '2024-12-12 12:27:42'),
(36, 5, 'burik gaming', 'tebing kaning', 1, 10000000.00, '2024-12-12 12:32:27', '2024-12-12 12:32:27'),
(37, 5, 'burik gaming', 'tebing kaning', 1, 10000000.00, '2024-12-12 12:32:31', '2024-12-12 12:32:31'),
(38, 5, 'burik gaming', 'tebing kaning', 1, 10000000.00, '2024-12-12 12:32:38', '2024-12-12 12:32:38'),
(39, 5, 'burik gaming', 'arga makmur', 1, 10000000.00, '2024-12-12 12:40:03', '2024-12-12 12:40:03'),
(40, 3, 'yuda', 'karang anyar 2', 20, 1400000000.00, '2024-12-12 12:43:30', '2024-12-12 12:43:30'),
(41, 3, 'yuda', 'karang anyar 2', 20, 1400000000.00, '2024-12-12 12:43:33', '2024-12-12 12:43:33'),
(42, 5, 'yuda', 'desa karang anyar', 1, 10000000.00, '2024-12-12 12:44:24', '2024-12-12 12:44:24'),
(43, 5, 'burik gaming', 'arga makmur', 1, 10000000.00, '2024-12-12 12:45:01', '2024-12-12 12:45:01'),
(44, 5, 'yuda', 'arga makmur', 1, 10000000.00, '2024-12-12 12:45:18', '2024-12-12 12:45:18'),
(45, 7, 'lori penakluk jando dusun', 'arma jaya', 1, 1000.00, '2024-12-12 12:50:09', '2024-12-12 12:50:09'),
(46, 4, 'yuda', 'karang anyar 2', 10, 1000000000.00, '2024-12-15 15:24:38', '2024-12-15 15:24:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_pendapatan` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indeks untuk tabel `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mobil_id` (`mobil_id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`mobil_id`) REFERENCES `mobil` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
