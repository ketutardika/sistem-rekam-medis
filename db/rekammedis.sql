-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2021 at 06:06 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rekammedis`
--

-- --------------------------------------------------------

--
-- Table structure for table `diagnosa`
--

CREATE TABLE `diagnosa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_diagnosa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_diagnosa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diagnosa`
--

INSERT INTO `diagnosa` (`id`, `kode_diagnosa`, `nama_diagnosa`, `keterangan`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'M50.0', 'Cervical disc disorder with myelopathy ', 'dengan mielopati', '2021-12-24 16:56:59', '2021-12-24 16:56:59', '0'),
(2, 'M50.1', 'Cervical disc disorder with radiculopathy', 'dengan radikulopati', '2021-12-24 16:56:59', '2021-12-24 16:56:59', '0'),
(3, 'M50.2', 'Other cervical disc displacement', 'Displasmen diskus servikal lainnya', '2021-12-24 16:56:59', '2021-12-24 16:56:59', '0'),
(4, 'M50.3', 'Other cervical disc degeneration', 'Degenerasi diskus servikal lainnya', '2021-12-24 16:56:59', '2021-12-24 16:56:59', '0'),
(5, 'M50.8', 'Other cervical disc disorders', 'gangguan diskus servikal lainnya', '2021-12-24 16:56:59', '2021-12-24 16:56:59', '0'),
(6, 'M50.9', 'Cervical disc disorder, unspecified', 'gangguan diskus servikal, tidak spesifik', '2021-12-24 16:56:59', '2021-12-24 16:56:59', '0');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab`
--

CREATE TABLE `lab` (
  `id` int(11) NOT NULL,
  `nama` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab`
--

INSERT INTO `lab` (`id`, `nama`, `satuan`, `harga`, `created_time`, `updated_time`, `deleted`) VALUES
(1, 'Kolesterol', 'mg/dl', 150000, '2021-12-24 16:57:06', '2021-12-24 16:57:06', 0),
(2, 'Asam Urat', 'mg/dl', 150000, '2021-12-24 16:57:06', '2021-12-24 16:57:06', 0),
(3, 'Gula Darah Sewaktu', 'mg/dl', 150000, '2021-12-24 16:57:06', '2021-12-24 16:57:06', 0),
(4, 'Gula Darah Puasa', 'mg/dl', 150000, '2021-12-24 16:57:06', '2021-12-24 16:57:06', 0),
(5, 'Gula Darah 2 Jam PP', 'mg/dl', 150000, '2021-12-24 16:57:06', '2021-12-24 16:57:06', 0),
(6, 'Hemoglobin', 'mg/dl', 150000, '2021-12-24 16:57:06', '2021-12-24 16:57:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `metadata`
--

CREATE TABLE `metadata` (
  `id` int(11) NOT NULL,
  `Judul` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metadata`
--

INSERT INTO `metadata` (`id`, `Judul`, `Deskripsi`) VALUES
(1, 'Daftar Pasien', 'Merupakan list pasien yang sudah terdaftar di klinik anda.'),
(2, 'Tambah Pasien', 'Isi biodata berikut untuk menambah pasien baru.'),
(3, 'Edit Pasien', 'Lakukan pengeditan pasien sesuai kolom yang tertera.'),
(4, 'Daftar Obat', 'Daftar obat-obatan yang terdaftar di klinik.'),
(5, 'Tambah Obat Baru', 'Tambahkan obat baru kedalam database dengan mengisi formulir berikut'),
(6, 'Edit Obat', 'lakukan perubahan informasi mengenai obat yang anda inginkan dengan menuliskannya di formulir berikut.'),
(7, 'Daftar Pemeriksaan Lab', 'Daftar pemeriksaan lab yang tersedia di klinik.'),
(8, 'Tambah Pemeriksaan Lab', 'Tabahkan fasilitas lab kedalam database dengan mengisi formulir berikut.'),
(9, 'Edit Lab', 'lakukan perubahan informasi mengenai obat yang anda inginkan dengan menuliskannya di formulir berikut.'),
(10, 'Lihat Rekam Medis', 'Lihat rekam medis yang tersdia pada pasien yang dipilih.'),
(11, 'Tambah Rekam Medis', 'Tambahkan rekam medis pada pasien yang dipilih.'),
(12, 'List Rekam Medis Pasien', 'Jejak rekam medis pasien di klinik anda.'),
(13, 'Edit Rekam Medis', 'Lakukan Pengeditan rekam medis.'),
(14, 'Buat Tagihan Kunjungan', 'Berikut adalah tagihan tehadap pasien yang diperiksa.'),
(15, 'Lihat rekam Medis', 'Lihat Rekam Medis Pasien Yang Dipilih'),
(16, 'Pengaturan', 'Pengaturan yang tersedia untuk klinik anda'),
(17, 'Dashboard', 'Halaman muka dari klinik anda, overview hal-hal mengenai klinik anda.'),
(18, 'Daftar Pengguna', 'Daftar pengguna atau pegawai yang dapat log-in di klinik anda.'),
(19, 'Laporan Rekam Medis', 'Laporan Rekam Medis'),
(20, 'Backup', 'Backup'),
(21, 'Tindakan', 'Daftar Tindakan yang tersedia di klinik.'),
(22, 'Diagnosa', 'Daftar Diagnosa.'),
(23, 'Update Database', 'Update Database.');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_12_17_210258_create_diagnosa_table', 1),
(2, '2021_12_17_210258_create_failed_jobs_table', 1),
(3, '2021_12_17_210258_create_lab_table', 1),
(4, '2021_12_17_210258_create_metadata_table', 1),
(5, '2021_12_17_210258_create_obat_table', 1),
(6, '2021_12_17_210258_create_pasien_table', 1),
(7, '2021_12_17_210258_create_password_resets_table', 1),
(8, '2021_12_17_210258_create_pemasukan_table', 1),
(9, '2021_12_17_210258_create_pengaturan_table', 1),
(10, '2021_12_17_210258_create_rm_table', 1),
(11, '2021_12_17_210258_create_tagihan_table', 1),
(12, '2021_12_17_210258_create_tindakan_table', 1),
(13, '2021_12_17_210258_create_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama_obat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sediaan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dosis` int(11) NOT NULL,
  `satuan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `created_time` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_time` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `sediaan`, `dosis`, `satuan`, `stok`, `harga`, `created_time`, `updated_time`, `deleted`) VALUES
(1, 'Metronidazole', 'Tablet', 500, 'mg', 99, 100000, '2021-12-25 00:57:26', '2021-12-25 00:57:26', 0),
(2, 'Amoxicillin', 'Tablet', 500, 'mg', 100, 100000, '2021-12-25 00:57:26', '2021-12-25 00:57:26', 0),
(3, 'Cefixime', 'Kapsul', 200, 'mg', 100, 100000, '2021-12-25 00:57:26', '2021-12-25 00:57:26', 0),
(4, 'Cefixime', 'Kapsul', 100, 'mg', 100, 100000, '2021-12-25 00:57:26', '2021-12-25 00:57:26', 0),
(5, 'Paracetamol', 'Tablet', 500, 'mg', 100, 100000, '2021-12-25 00:57:26', '2021-12-25 00:57:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int(10) UNSIGNED NOT NULL,
  `no_pasien` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lhr` date NOT NULL,
  `jk` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hp` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pendidikan` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_asuransi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_bpjs` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alergi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tb` int(11) DEFAULT NULL,
  `bb` int(11) DEFAULT NULL,
  `lp` int(11) DEFAULT NULL,
  `imt` double DEFAULT NULL,
  `stole` int(11) DEFAULT NULL,
  `dtole` int(11) DEFAULT NULL,
  `rr` int(11) DEFAULT NULL,
  `hr` int(11) DEFAULT NULL,
  `created_time` datetime NOT NULL,
  `updated_time` datetime NOT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `no_pasien`, `nama`, `tgl_lhr`, `jk`, `alamat`, `hp`, `pendidikan`, `pekerjaan`, `jenis_asuransi`, `no_bpjs`, `alergi`, `tb`, `bb`, `lp`, `imt`, `stole`, `dtole`, `rr`, `hr`, `created_time`, `updated_time`, `deleted`) VALUES
(1, 'PSUM001', 'Ketut Ardika', '1988-02-01', 'Laki-laki', 'Denpasar', '081236772522', 'Perguruan Tinggi', 'Swasta', 'Umum', NULL, 'Tidak Ada', 175, 70, 120, NULL, 120, 120, 120, 120, '2021-12-25 00:56:49', '2021-12-25 00:56:49', 0),
(2, 'PSUM002', 'Made Suyana', '1994-03-01', 'Laki-laki', 'Denpasar', '081236772522', 'Perguruan Tinggi', 'Swasta', 'Umum', NULL, 'Tidak Ada', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-25 00:56:49', '2021-12-25 00:56:49', 0),
(3, 'PSUM003', 'Putu Aska', '1997-08-11', 'Laki-laki', 'Denpasar', '085739778882', 'Perguruan Tinggi', 'Swasta', 'Umum', NULL, 'Tidak Ada', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-25 00:56:49', '2021-12-25 00:56:49', 0),
(4, 'PSBP001', 'Putri Yani J', '1986-02-01', 'Perempuan', 'Denpasar', '081236772522', 'Perguruan Tinggi', 'PNS', 'BPJS', '112233445', 'Tidak Ada', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-25 00:56:49', '2021-12-25 00:56:49', 0),
(5, 'PSBP002', 'Made Dewi Adnyani', '1996-03-01', 'Perempuan', 'Denpasar', '081236772522', 'Perguruan Tinggi', 'PNS', 'BPJS', '223344556', 'Tidak Ada', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-25 00:56:49', '2021-12-25 00:56:49', 0),
(6, 'PSBP003', 'Putu Dewata', '2008-08-11', 'Laki-laki', 'Denpasar', '085739778882', 'Perguruan Tinggi', 'PNS', 'BPJS', '556677889', 'Tidak Ada', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-25 00:56:49', '2021-12-25 00:56:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan`
--

CREATE TABLE `pemasukan` (
  `id` int(11) NOT NULL,
  `no_pemasukan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_akun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_jurnal` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `nama_pemasukan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_pembayaran` int(11) DEFAULT NULL,
  `status_pembayaran` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `n_Klinik` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Slogan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambarbool` tinyint(1) NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jasa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `n_Klinik`, `Slogan`, `logo`, `gambarbool`, `gambar`, `jasa`) VALUES
(1, 'MM Klinik', 'Pelayanan Terbaik', 'fa-briefcase-medical', 0, 'logo1639106046.jpg', 150000);

-- --------------------------------------------------------

--
-- Table structure for table `rm`
--

CREATE TABLE `rm` (
  `id` int(11) NOT NULL,
  `no_rm` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idpasien` int(11) NOT NULL,
  `ku` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anamnesis` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pxfisik` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tb` int(11) DEFAULT NULL,
  `bb` int(11) DEFAULT NULL,
  `lp` int(11) DEFAULT NULL,
  `imt` double DEFAULT NULL,
  `stole` int(11) DEFAULT NULL,
  `dtole` int(11) DEFAULT NULL,
  `rr` int(11) DEFAULT NULL,
  `hr` int(11) DEFAULT NULL,
  `tindakan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tindakan_kd` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lab` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hasil` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosa` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosa_kd` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosis` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resep` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aturan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokter` int(11) DEFAULT NULL,
  `status_tagihan` int(11) DEFAULT NULL,
  `created_time` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_time` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rm`
--

INSERT INTO `rm` (`id`, `no_rm`, `idpasien`, `ku`, `anamnesis`, `pxfisik`, `tb`, `bb`, `lp`, `imt`, `stole`, `dtole`, `rr`, `hr`, `tindakan`, `tindakan_kd`, `lab`, `hasil`, `diagnosa`, `diagnosa_kd`, `diagnosis`, `resep`, `jumlah`, `aturan`, `dokter`, `status_tagihan`, `created_time`, `updated_time`, `deleted`) VALUES
(1, 'RM-UM-XII-2021-001', 1, 'Pusing', 'Pusing', 'Pusing', 175, 70, 120, NULL, 120, 120, 120, 120, '5|1', NULL, '2', '90.4', '5|3', NULL, NULL, '1', '1', '1x2', 2, NULL, '2021-12-25 00:59:19', '2021-12-25 00:59:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id` int(11) NOT NULL,
  `no_tagihan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_akun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_rm` int(11) DEFAULT NULL,
  `id_pasien` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `total_tagihan` int(11) DEFAULT NULL,
  `kode_jurnal` int(11) DEFAULT NULL,
  `jenis_pembayaran` int(11) DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` int(11) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tindakan`
--

CREATE TABLE `tindakan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_tindakan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tindakan`
--

INSERT INTO `tindakan` (`id`, `no_tindakan`, `nama`, `satuan`, `harga`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'TD-001', 'Pemeriksaan Umum', NULL, 100000, '2021-12-24 16:57:17', '2021-12-24 16:57:17', '0'),
(2, 'TD-002', 'Pemeriksaan Darah', NULL, 200000, '2021-12-24 16:57:17', '2021-12-24 16:57:17', '0'),
(3, 'TD-003', 'Pemeriksaan Jantung', NULL, 150000, '2021-12-24 16:57:17', '2021-12-24 16:57:17', '0'),
(4, 'TD-004', 'Pemeriksaan Pernapasan', NULL, 250000, '2021-12-24 16:57:17', '2021-12-24 16:57:17', '0'),
(5, 'TD-005', 'Pemeriksaan Paru Paru', NULL, 300000, '2021-12-24 16:57:17', '2021-12-24 16:57:17', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profesi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `profesi`, `name`, `email`, `email_verified_at`, `password`, `avatar`, `remember_token`, `admin`, `created_at`, `updated_at`, `deleted`) VALUES
(2, 'Dokter Gede', 'Dokter', 'Dokter Gede', 'gede@amantrabali.com', NULL, '$2a$12$UKhwmA4V4kfwaIapXr5g5.F0.n2lvCw.lwIWl/CvImLODDiufbryS', 'avatar1639103401.jpg', NULL, 1, '2020-04-22 02:54:12', '2021-12-09 18:30:01', 0),
(4, 'Dokter Wayan', 'Dokter', 'Dokter Wayan', 'wayan@amantrabali.com', NULL, '$2a$12$nD6X0Ik9SvTN.rJOI.kZgu4FwInScV5pvma96xK9NXMGvfKwq56c.', 'default.jpg', NULL, 1, '2020-04-22 21:43:07', '2020-04-24 22:43:18', 0),
(9, 'Made Staff', 'Staff', 'Staff Made', 'made@amantrabali.com', NULL, '$2a$12$L4WulcSYW0co1CGOkIYjnuUy9BPn6xJzmNfpOKysYTrykqqzNimUm', 'avatar1587961527.jpg', NULL, 0, '2020-04-24 22:40:12', '2020-04-26 21:33:32', 0),
(10, 'Web Developer', 'Dokter', 'Web Developer', 'ardika@amantrabali.com', NULL, '$2y$10$hfq6T5QcKGNoM4iMxWjO6.WjTCqzuiTygHhiJZ8IN7TOiHEd2lnuW', 'avatar1639109019.jpg', NULL, 1, '2021-12-09 20:55:43', '2021-12-11 18:51:57', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diagnosa`
--
ALTER TABLE `diagnosa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab`
--
ALTER TABLE `lab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metadata`
--
ALTER TABLE `metadata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rm`
--
ALTER TABLE `rm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tindakan`
--
ALTER TABLE `tindakan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `users_username_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diagnosa`
--
ALTER TABLE `diagnosa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab`
--
ALTER TABLE `lab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `metadata`
--
ALTER TABLE `metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rm`
--
ALTER TABLE `rm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tindakan`
--
ALTER TABLE `tindakan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
