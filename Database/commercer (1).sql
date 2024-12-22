-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 03:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `commercer`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat_musik`
--

CREATE TABLE `alat_musik` (
  `id` int(11) NOT NULL,
  `produk_id` int(111) DEFAULT NULL,
  `kategori_id` int(111) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alat_musik`
--

INSERT INTO `alat_musik` (`id`, `produk_id`, `kategori_id`, `kategori`, `merk`, `model`, `jenis`) VALUES
(2, 19, 9, 'Gitar', 'Yamaha', 'FG8000', 'Akustik'),
(3, 23, 9, 'gitar', 'yamaha', 'px-160', 'akustik');

-- --------------------------------------------------------

--
-- Table structure for table `buku_media`
--

CREATE TABLE `buku_media` (
  `id` int(111) NOT NULL,
  `produk_id` int(111) DEFAULT NULL,
  `kategori_id` int(111) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku_media`
--

INSERT INTO `buku_media` (`id`, `produk_id`, `kategori_id`, `kategori`, `penulis`, `penerbit`, `tahun_terbit`, `isbn`) VALUES
(1, 22, 12, 'Buku cerita rakyat', 'Nusantara', 'Gramedia', '2024', '978-623-09-1502-4');

-- --------------------------------------------------------

--
-- Table structure for table `elektronik`
--

CREATE TABLE `elektronik` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `screen_size` varchar(50) DEFAULT NULL,
  `resolution` varchar(50) DEFAULT NULL,
  `battery_type` varchar(50) DEFAULT NULL,
  `operating_system` varchar(50) DEFAULT NULL,
  `spesial_fitur` text DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `produk_id` int(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `furniture`
--

CREATE TABLE `furniture` (
  `id` int(111) NOT NULL,
  `produk_id` int(111) DEFAULT NULL,
  `kategori_id` int(111) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `bahan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `furniture`
--

INSERT INTO `furniture` (`id`, `produk_id`, `kategori_id`, `kategori`, `merk`, `bahan`) VALUES
(1, 20, 10, 'kursi', 'Ikea', 'kulit');

-- --------------------------------------------------------

--
-- Table structure for table `kesehatan_kecantikan`
--

CREATE TABLE `kesehatan_kecantikan` (
  `id` int(111) NOT NULL,
  `produk_id` int(111) DEFAULT NULL,
  `kategori_id` int(111) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `bahan_aktif` text DEFAULT NULL,
  `volume` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kesehatan_kecantikan`
--

INSERT INTO `kesehatan_kecantikan` (`id`, `produk_id`, `kategori_id`, `kategori`, `merk`, `jenis`, `bahan_aktif`, `volume`) VALUES
(1, 12, 4, 'Kosmetik', 'L\'Oreal', 'Serum', 'Vitamin C', '50 tablet');

-- --------------------------------------------------------

--
-- Table structure for table `mainan_hobi`
--

CREATE TABLE `mainan_hobi` (
  `id` int(111) NOT NULL,
  `produk_id` int(111) DEFAULT NULL,
  `kategori_id` int(111) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `bahan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mainan_hobi`
--

INSERT INTO `mainan_hobi` (`id`, `produk_id`, `kategori_id`, `kategori`, `merk`, `jenis`, `bahan`) VALUES
(1, 15, 6, '', 'Lego', 'set bangunan', 'Plastik');

-- --------------------------------------------------------

--
-- Table structure for table `makanan_minuman`
--

CREATE TABLE `makanan_minuman` (
  `id` int(111) NOT NULL,
  `produk_id` int(111) DEFAULT NULL,
  `kategori_id` int(111) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `berat_volume` varchar(50) DEFAULT NULL,
  `tanggal_kadaluarsa` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `makanan_minuman`
--

INSERT INTO `makanan_minuman` (`id`, `produk_id`, `kategori_id`, `kategori`, `merk`, `jenis`, `berat_volume`, `tanggal_kadaluarsa`) VALUES
(3, 8, 7, 'Makanan', 'Indomie', 'Makanan Berat', '500gr', '2024-08-31'),
(4, 9, 7, 'Makanan', 'Indomie', 'Makanan Berat', '500gr', '2024-08-31'),
(5, 10, 7, 'Makanan', 'Indomie', 'Makanan Berat', '500gr', '2024-09-14');

-- --------------------------------------------------------

--
-- Table structure for table `otomotif`
--

CREATE TABLE `otomotif` (
  `id` int(111) NOT NULL,
  `produk_id` int(111) DEFAULT NULL,
  `kategori_id` int(111) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `jenis_kendaraan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pakaian`
--

CREATE TABLE `pakaian` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `produk_id` int(111) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `instruksi_perawatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pakaian`
--

INSERT INTO `pakaian` (`id`, `kategori_id`, `produk_id`, `nama`, `type`, `instruksi_perawatan`) VALUES
(3, 2, 24, 'Baju Polos', 'Kain', 'Di cuci');

-- --------------------------------------------------------

--
-- Table structure for table `perhiasan`
--

CREATE TABLE `perhiasan` (
  `id` int(111) NOT NULL,
  `produk_id` int(111) DEFAULT NULL,
  `kategori_id` int(111) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `bahan` varchar(255) DEFAULT NULL,
  `jenis_batu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perhiasan`
--

INSERT INTO `perhiasan` (`id`, `produk_id`, `kategori_id`, `kategori`, `merk`, `bahan`, `jenis_batu`) VALUES
(2, 17, 8, 'Kalung', 'Tiffany', '24K', 'Emas');

-- --------------------------------------------------------

--
-- Table structure for table `perlengkapan_rumah_tangga`
--

CREATE TABLE `perlengkapan_rumah_tangga` (
  `id` int(11) NOT NULL,
  `produk_id` int(111) DEFAULT NULL,
  `kategori_id` int(111) DEFAULT NULL,
  `jenis` varchar(255) NOT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `bahan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perlengkapan_rumah_tangga`
--

INSERT INTO `perlengkapan_rumah_tangga` (`id`, `produk_id`, `kategori_id`, `jenis`, `merk`, `bahan`) VALUES
(1, 13, 3, 'Dapur', 'Cosmos', 'besi'),
(2, 25, 3, 'Dapur', 'Cosmos', 'besi');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `nama`, `username`, `password`) VALUES
(1, 'Admin1', 'Admin1', 'admin1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_transaksi`
--

CREATE TABLE `tbl_detail_transaksi` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `ukuran` varchar(255) NOT NULL,
  `warna` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_detail_transaksi`
--

INSERT INTO `tbl_detail_transaksi` (`id`, `transaksi_id`, `produk_id`, `quantity`, `ukuran`, `warna`, `harga`) VALUES
(124, 92, 25, 1, 'Standar', 'Hitam', 4000000.00),
(125, 92, 24, 2, 'XL', 'Hitam', 300000.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gambar`
--

CREATE TABLE `tbl_gambar` (
  `id` int(111) NOT NULL,
  `produk_id` int(111) NOT NULL,
  `gambar_detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_gambar`
--

INSERT INTO `tbl_gambar` (`id`, `produk_id`, `gambar_detail`) VALUES
(22, 3, '66c5ea2a1f120laptop3.jpg'),
(23, 3, '66c5ea2a200d7laptop2.jpg'),
(24, 3, '66c5ea2a20b29laptop1.jpg'),
(52, 13, '66cf09c130567blender1.jpg'),
(53, 13, '66cf09c130dafblender2.jpg'),
(54, 13, '66cf09c131db6blender3.jpg'),
(93, 5, 'laptop1.jpg'),
(94, 5, 'laptop2.jpg'),
(95, 5, 'laptop3.jpg'),
(101, 24, '66f2a8ec1d414Baju 1.jpg'),
(102, 24, '66f2a8ec1dd84Baju 2.jpg'),
(103, 24, '66f2a8ec1e4caBaju 3.jpg'),
(104, 25, '66f2af48611a7blender2.jpg'),
(105, 25, '66f2af4861ae7blender3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id` int(10) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `gambar_kategori` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id`, `nama_kategori`, `gambar_kategori`) VALUES
(1, 'Elektronik', 'laptop dan hp.jpg'),
(2, 'Pakaian', 'Pakaian.jpg'),
(3, 'Perlengkapan Rumah Tangga', 'RumahTangga.jpg'),
(4, 'Kesehatan dan Kecantikan', 'KesehatanKecantikan.jpg'),
(5, 'Otomotif', 'Otomatif.jpg'),
(6, 'Mainan dan Hobi', 'Mainan.jpg'),
(7, 'Makanan dan Minuman', 'makanan.jpg'),
(8, 'Perhiasan', 'Perhiasan.jpg'),
(9, 'Alat Musik', 'alatmusik.jpg'),
(10, 'Furniture', 'furniture.jpg'),
(12, 'Buku dan Media', 'buku.jpg'),
(13, 'Lain-Lain', 'lain-lain.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kupon`
--

CREATE TABLE `tbl_kupon` (
  `kupon_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `jumlah_diskon` int(10) NOT NULL,
  `tgl_exp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pesanan`
--

CREATE TABLE `tbl_pesanan` (
  `id` int(111) NOT NULL,
  `user_id` int(111) NOT NULL,
  `produk_id` int(111) NOT NULL,
  `transaksi_id` int(111) NOT NULL,
  `detail_transaksi_id` int(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pesanan`
--

INSERT INTO `tbl_pesanan` (`id`, `user_id`, `produk_id`, `transaksi_id`, `detail_transaksi_id`) VALUES
(63, 2, 25, 92, 124),
(64, 2, 24, 92, 125);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id` int(111) NOT NULL,
  `user_id` int(111) NOT NULL,
  `id_kategori` int(111) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `stok` int(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_produk`
--

INSERT INTO `tbl_produk` (`id`, `user_id`, `id_kategori`, `nama_produk`, `deskripsi`, `harga`, `gambar`, `stok`) VALUES
(24, 1, 2, 'Baju Polos', 'ini baju', 300000.00, 'Baju.jpg', 300),
(25, 1, 3, 'Blender', 'ini blender', 4000000.00, 'blender1.jpg', 200);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transaksi`
--

INSERT INTO `tbl_transaksi` (`id`, `user_id`, `tanggal`, `status`) VALUES
(92, 2, '2024-09-24 12:49:56', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ulasan_produk`
--

CREATE TABLE `tbl_ulasan_produk` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ulasan_produk`
--

INSERT INTO `tbl_ulasan_produk` (`id`, `user_id`, `produk_id`, `komentar`, `date`) VALUES
(17, 2, 25, 'Tess', '2024-09-25 14:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `foto_profil` text NOT NULL,
  `duit` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `nama`, `username`, `password`, `alamat`, `no_telepon`, `foto_profil`, `duit`) VALUES
(1, 'feler', 'plare', '123', 'jalan', '089827837282', 'pngtree-user-vector-avatar-png-image_1541962.jpg', 51396999.99),
(2, 'humanoid', 'haha', '1234', 'dwada', '089827837282', 'avatar.jpg', 53632999.00),
(3, 'Admin', 'admin', 'admin', 'jalan tidak tau', '089787827718', 'sg-11134201-22100-7aoyvztvl9ive1.jpg', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wishlist`
--

CREATE TABLE `tbl_wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_wishlist`
--

INSERT INTO `tbl_wishlist` (`id`, `user_id`, `produk_id`) VALUES
(4, 2, 24),
(5, 2, 25);

-- --------------------------------------------------------

--
-- Table structure for table `ukuran`
--

CREATE TABLE `ukuran` (
  `id` int(111) NOT NULL,
  `produk_id` int(111) NOT NULL,
  `ukuran` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ukuran`
--

INSERT INTO `ukuran` (`id`, `produk_id`, `ukuran`, `harga`, `stok`) VALUES
(37, 24, 'XL', 300000.00, 298),
(38, 24, 'L', 200000.00, 400),
(39, 24, 'S', 100000.00, 500),
(40, 25, 'Standar', 4000000.00, 199),
(41, 25, 'Besar', 5000000.00, 300);

-- --------------------------------------------------------

--
-- Table structure for table `warna`
--

CREATE TABLE `warna` (
  `id` int(111) NOT NULL,
  `produk_id` int(111) NOT NULL,
  `warna` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warna`
--

INSERT INTO `warna` (`id`, `produk_id`, `warna`) VALUES
(32, 24, 'Hitam'),
(33, 24, 'Putih'),
(34, 24, 'Merah'),
(35, 24, 'Hijau'),
(36, 25, 'Hitam'),
(37, 25, 'Putih'),
(38, 25, 'Hijau');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat_musik`
--
ALTER TABLE `alat_musik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buku_media`
--
ALTER TABLE `buku_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elektronik`
--
ALTER TABLE `elektronik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `fk_produk` (`produk_id`);

--
-- Indexes for table `furniture`
--
ALTER TABLE `furniture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kesehatan_kecantikan`
--
ALTER TABLE `kesehatan_kecantikan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mainan_hobi`
--
ALTER TABLE `mainan_hobi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `makanan_minuman`
--
ALTER TABLE `makanan_minuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otomotif`
--
ALTER TABLE `otomotif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pakaian`
--
ALTER TABLE `pakaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `fk_pakaian_produk_id` (`produk_id`);

--
-- Indexes for table `perhiasan`
--
ALTER TABLE `perhiasan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perlengkapan_rumah_tangga`
--
ALTER TABLE `perlengkapan_rumah_tangga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_detail_transaksi`
--
ALTER TABLE `tbl_detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `tbl_gambar`
--
ALTER TABLE `tbl_gambar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_kupon`
--
ALTER TABLE `tbl_kupon`
  ADD PRIMARY KEY (`kupon_id`);

--
-- Indexes for table `tbl_pesanan`
--
ALTER TABLE `tbl_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_pesanan` (`user_id`),
  ADD KEY `fk_produk_id_pesanan` (`produk_id`),
  ADD KEY `fk_transaksi_id_pesanan` (`transaksi_id`),
  ADD KEY `fk_detail_transaksi_id_pesanan` (`detail_transaksi_id`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_ulasan_produk`
--
ALTER TABLE `tbl_ulasan_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ukuran`
--
ALTER TABLE `ukuran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produk_id_ukuran` (`produk_id`);

--
-- Indexes for table `warna`
--
ALTER TABLE `warna`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_warna_produk_id` (`produk_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat_musik`
--
ALTER TABLE `alat_musik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `buku_media`
--
ALTER TABLE `buku_media`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `elektronik`
--
ALTER TABLE `elektronik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `furniture`
--
ALTER TABLE `furniture`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kesehatan_kecantikan`
--
ALTER TABLE `kesehatan_kecantikan`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mainan_hobi`
--
ALTER TABLE `mainan_hobi`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `makanan_minuman`
--
ALTER TABLE `makanan_minuman`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `otomotif`
--
ALTER TABLE `otomotif`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pakaian`
--
ALTER TABLE `pakaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `perhiasan`
--
ALTER TABLE `perhiasan`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `perlengkapan_rumah_tangga`
--
ALTER TABLE `perlengkapan_rumah_tangga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_detail_transaksi`
--
ALTER TABLE `tbl_detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `tbl_gambar`
--
ALTER TABLE `tbl_gambar`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_kupon`
--
ALTER TABLE `tbl_kupon`
  MODIFY `kupon_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pesanan`
--
ALTER TABLE `tbl_pesanan`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `tbl_ulasan_produk`
--
ALTER TABLE `tbl_ulasan_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ukuran`
--
ALTER TABLE `ukuran`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `warna`
--
ALTER TABLE `warna`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `elektronik`
--
ALTER TABLE `elektronik`
  ADD CONSTRAINT `elektronik_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `tbl_kategori` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_produk` FOREIGN KEY (`produk_id`) REFERENCES `tbl_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pakaian`
--
ALTER TABLE `pakaian`
  ADD CONSTRAINT `fk_pakaian_produk_id` FOREIGN KEY (`produk_id`) REFERENCES `tbl_produk` (`id`),
  ADD CONSTRAINT `pakaian_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `tbl_kategori` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_detail_transaksi`
--
ALTER TABLE `tbl_detail_transaksi`
  ADD CONSTRAINT `tbl_detail_transaksi_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `tbl_transaksi` (`id`),
  ADD CONSTRAINT `tbl_detail_transaksi_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `tbl_produk` (`id`);

--
-- Constraints for table `tbl_pesanan`
--
ALTER TABLE `tbl_pesanan`
  ADD CONSTRAINT `fk_detail_transaksi_id_pesanan` FOREIGN KEY (`detail_transaksi_id`) REFERENCES `tbl_detail_transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_produk_id_pesanan` FOREIGN KEY (`produk_id`) REFERENCES `tbl_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksi_id_pesanan` FOREIGN KEY (`transaksi_id`) REFERENCES `tbl_transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_pesanan` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`);

--
-- Constraints for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD CONSTRAINT `tbl_transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`);

--
-- Constraints for table `ukuran`
--
ALTER TABLE `ukuran`
  ADD CONSTRAINT `fk_produk_id_ukuran` FOREIGN KEY (`produk_id`) REFERENCES `tbl_produk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `warna`
--
ALTER TABLE `warna`
  ADD CONSTRAINT `fk_warna_produk_id` FOREIGN KEY (`produk_id`) REFERENCES `tbl_produk` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
