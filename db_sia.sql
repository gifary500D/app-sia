-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jul 2025 pada 05.24
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sia`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `akun_id` int(11) NOT NULL,
  `nama_akun` varchar(100) NOT NULL,
  `jenis_akun` varchar(50) NOT NULL,
  `tipe_saldo` enum('Debit','Kredit') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`akun_id`, `nama_akun`, `jenis_akun`, `tipe_saldo`) VALUES
(2, 'Kas', 'aset', 'Debit'),
(3, 'Kas', 'Aset', 'Kredit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `barang_id` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga_beli` decimal(10,2) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal`
--

CREATE TABLE `jurnal` (
  `jurnal_id` int(11) NOT NULL,
  `pembayaran_id` int(11) DEFAULT NULL,
  `pembelian_id` int(11) DEFAULT NULL,
  `penjualan_id` int(11) DEFAULT NULL,
  `tanggal_jurnal` date NOT NULL,
  `akun_id` int(11) DEFAULT NULL,
  `debit_total` decimal(15,2) DEFAULT NULL,
  `kredit_total` decimal(15,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `pelanggan_id` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `pembayaran_id` int(11) NOT NULL,
  `invoice_pembayaran` varchar(50) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `total_pembayaran` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`pembayaran_id`, `invoice_pembayaran`, `tanggal_pembayaran`, `total_pembayaran`, `keterangan`) VALUES
(1, 'BY110325', '2025-06-13', '250000.00', 'bayar wifi'),
(2, 'ha45t', '2025-06-13', '30000.00', 'bayarrrr'),
(3, 'hgauf7e', '2025-06-13', '3000.00', 'tes'),
(4, 'ddnjdkd', '2025-06-13', '4000.00', 'y6tewssss'),
(5, 'klfmff', '2025-06-13', '5000.00', 'tes'),
(6, 'ha45t222', '2025-06-13', '40000.00', 'cobaaa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `pembelian_id` int(11) NOT NULL,
  `invoice_pembelian` varchar(50) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `jumlah_pembelian` int(11) NOT NULL,
  `harga_pembelian` decimal(10,2) NOT NULL,
  `total_pembelian` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`pembelian_id`, `invoice_pembelian`, `tanggal_pembelian`, `supplier_id`, `jumlah_pembelian`, `harga_pembelian`, `total_pembelian`, `keterangan`) VALUES
(1, '01', '2025-06-01', 1, 25, '20000.00', '500000.00', 'bgus'),
(2, '0222', '2025-06-13', 4, 33, '30000.00', '990000.00', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `hak_akses` enum('admin','user','staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`user_id`, `username`, `password`, `nama_lengkap`, `email`, `jabatan`, `hak_akses`) VALUES
(4, 'admin', '$2y$10$l5Mror61R2kU1Xf4uUf.Tul6/6R59zBdG3oorcZA6C9YusExrSvIG', 'Administrator Web12', 'admin@gmail.com', 'Administrator', 'admin'),
(10, 'pimpinan', '$2y$10$pIFEERF2Nvmf39RjCNGJWObOoQyGQ2ikUusAzfDqrbHbiamh3/ALG', 'pim', 'Selvy22@gmail.com', 'pimpinan', ''),
(33, 'nairin', '$2y$10$HYYqIEGImLewRmHIkGvepux/XIuf2P/yHuatCVLQHf6e.b5axHHLy', 'nairin', 'nairin@gmail.com', 'admn', 'admin'),
(34, 'pimpinan11', '$2y$10$HYYqIEGImLewRmHIkGvepux/XIuf2P/yHuatCVLQHf6e.b5axHHLy', 'pim', 'nairin22@gmail.com', 'pimp', ''),
(39, 'melva', '$2y$10$FPB0cDDap2GuKl4.F6s89uMQjETbj4d/8scxvnX2GMWiO/00.8QZS', 'melva', 'melva@gmail.com', 'admn', 'admin'),
(40, 'Nur_siti', '$2y$10$FPB0cDDap2GuKl4.F6s89uMQjETbj4d/8scxvnX2GMWiO/00.8QZS', 'Siti', 'Sitin@gmail.com', 'admn', 'admin'),
(41, 'Inka', '$2y$10$FPB0cDDap2GuKl4.F6s89uMQjETbj4d/8scxvnX2GMWiO/00.8QZS', 'Inka', 'Inka@gmail.com', 'admn', 'admin'),
(42, 'Cindy', '$2y$10$FPB0cDDap2GuKl4.F6s89uMQjETbj4d/8scxvnX2GMWiO/00.8QZS', 'Cindy', 'Cindu@gmail.com', 'admn', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `penjualan_id` int(11) NOT NULL,
  `invoice_penjualan` varchar(50) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `jumlah_penjualan` int(11) NOT NULL,
  `total_penjualan` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `nama_supplier`, `alamat`, `telepon`, `email`) VALUES
(1, 'Pt Baju', 'medan', '085373522822', 'admin999@gmail.com'),
(3, 'Pt Baju', 'medan', '085373522811', 'admin96@gmail.com'),
(4, 'Pt Timah', 'binjai', '085373522811', 'critycraft024@gmail.com'),
(5, 'SAmsu', 'turiam', '085373522988', 'gifary111@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`akun_id`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`barang_id`);

--
-- Indeks untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`jurnal_id`),
  ADD KEY `pembayaran_id` (`pembayaran_id`),
  ADD KEY `pembelian_id` (`pembelian_id`),
  ADD KEY `penjualan_id` (`penjualan_id`),
  ADD KEY `akun_id` (`akun_id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`pelanggan_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`pembayaran_id`),
  ADD UNIQUE KEY `invoice_pembayaran` (`invoice_pembayaran`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`pembelian_id`),
  ADD UNIQUE KEY `invoice_pembelian` (`invoice_pembelian`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`penjualan_id`),
  ADD UNIQUE KEY `invoice_penjualan` (`invoice_penjualan`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `akun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `barang_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `jurnal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `pelanggan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `pembelian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `penjualan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD CONSTRAINT `jurnal_ibfk_1` FOREIGN KEY (`pembayaran_id`) REFERENCES `pembayaran` (`pembayaran_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `jurnal_ibfk_2` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`pembelian_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `jurnal_ibfk_3` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`penjualan_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `jurnal_ibfk_4` FOREIGN KEY (`akun_id`) REFERENCES `akun` (`akun_id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`barang_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`pelanggan_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
