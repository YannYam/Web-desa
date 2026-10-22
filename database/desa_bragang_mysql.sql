-- =======================================================
-- Database MySQL/MariaDB: Website Profil Desa Bragang
-- Siap di-import langsung melalui phpMyAdmin
-- =======================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- 1. Table structure for table `settings`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `settings` (
    `key` VARCHAR(100) NOT NULL,
    `value` TEXT NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 2. Table structure for table `sejarah`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sejarah` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `content` TEXT NOT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 3. Table structure for table `timeline`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `timeline` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `year` VARCHAR(20) NOT NULL,
    `event` TEXT NOT NULL,
    `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 4. Table structure for table `wilayah`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wilayah` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(150) NOT NULL,
    `jumlah_rt` INT DEFAULT 0,
    `jumlah_rw` INT DEFAULT 0,
    `luas` VARCHAR(50) DEFAULT NULL,
    `keterangan` TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 5. Table structure for table `pendidikan`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pendidikan` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(200) NOT NULL,
    `jenis` VARCHAR(50) DEFAULT NULL,
    `dusun` VARCHAR(100) NOT NULL,
    `alamat` TEXT DEFAULT NULL,
    `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 6. Table structure for table `masjid`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `masjid` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(200) NOT NULL,
    `dusun` VARCHAR(100) NOT NULL,
    `alamat` TEXT DEFAULT NULL,
    `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 7. Table structure for table `struktur`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `struktur` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(150) NOT NULL,
    `jabatan` VARCHAR(150) NOT NULL,
    `foto` VARCHAR(255) DEFAULT NULL,
    `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 8. Table structure for table `statistik`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `statistik` (
    `key` VARCHAR(100) NOT NULL,
    `value` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 9. Table structure for table `jam_kerja`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `jam_kerja` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `hari` VARCHAR(50) NOT NULL,
    `jam_masuk` VARCHAR(20) NOT NULL,
    `jam_keluar` VARCHAR(20) NOT NULL,
    `keterangan` TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 10. Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `nama` VARCHAR(150) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =======================================================
-- SEED DATA AWAL
-- =======================================================

-- Site Settings
INSERT INTO `settings` (`key`, `value`) VALUES
('site_name', 'Desa Bragang'),
('tagline', 'Melayani dengan Sepenuh Hati'),
('kecamatan', 'Klampis'),
('kabupaten', 'Bangkalan'),
('provinsi', 'Jawa Timur'),
('welcome_message', 'Selamat datang di Website Resmi Desa Bragang. Kami berkomitmen untuk memberikan pelayanan terbaik kepada seluruh masyarakat desa.'),
('kepala_desa', 'Busiri'),
('alamat', 'Dsn Bragang Tengah, Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan'),
('telepon', '(031) 000-0000'),
('email', 'desa.bragang@gmail.com'),
('latitude', '-6.9378'),
('longitude', '112.9016')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);

-- Sejarah
INSERT INTO `sejarah` (`id`, `content`) VALUES
(1, 'Desa Bragang merupakan salah satu desa yang terletak di Kecamatan Klampis, Kabupaten Bangkalan, Provinsi Jawa Timur. Desa ini memiliki sejarah panjang yang erat kaitannya dengan perkembangan masyarakat Madura. Nama "Bragang" berasal dari bahasa Madura yang menggambarkan karakteristik wilayah dan budaya setempat.\r\n\r\nSejak masa kemerdekaan, Desa Bragang telah mengalami berbagai perkembangan signifikan baik dalam bidang infrastruktur, pendidikan, maupun kesejahteraan masyarakat. Masyarakat Desa Bragang dikenal sebagai masyarakat yang religius, gotong royong, dan menjunjung tinggi nilai-nilai kebersamaan.\r\n\r\nDesa Bragang terdiri dari lima dusun yang masing-masing memiliki keunikan dan potensi tersendiri. Pemerintah desa terus berupaya meningkatkan kualitas pelayanan publik dan pembangunan desa demi kesejahteraan seluruh warga.')
ON DUPLICATE KEY UPDATE `content` = VALUES(`content`);

-- Timeline
INSERT INTO `timeline` (`year`, `event`, `sort_order`) VALUES
('1945', 'Desa Bragang resmi terbentuk sebagai bagian dari wilayah administrasi Kecamatan Klampis', 1),
('1970', 'Pembangunan infrastruktur jalan desa pertama yang menghubungkan antar dusun', 2),
('1985', 'Pembangunan SDN Bragang 01 dan SDN Bragang 02 sebagai sarana pendidikan dasar', 3),
('1995', 'Berdirinya lembaga pendidikan SMP dan SMK Nurul Huda', 4),
('2005', 'Renovasi kantor desa dan peningkatan fasilitas pelayanan publik', 5),
('2020', 'Digitalisasi administrasi desa dan pelayanan online', 6);

-- Wilayah (5 Dusun)
INSERT INTO `wilayah` (`nama`, `jumlah_rt`, `jumlah_rw`, `luas`, `keterangan`) VALUES
('Dsn Bergunung', 4, 2, '120 Ha', 'Wilayah dataran tinggi di bagian utara desa'),
('Dsn Duko Nangka', 3, 1, '85 Ha', 'Wilayah di bagian barat desa'),
('Dsn Bragang Tengah', 5, 2, '150 Ha', 'Pusat pemerintahan dan ekonomi desa'),
('Dsn Tanggungan', 4, 2, '110 Ha', 'Wilayah di bagian selatan desa'),
('Dsn Mursenjang', 3, 1, '95 Ha', 'Wilayah di bagian timur desa');

-- Pendidikan (8 Lembaga)
INSERT INTO `pendidikan` (`nama`, `jenis`, `dusun`, `alamat`, `sort_order`) VALUES
('Madrasah Raudlatul Muhibbin', 'Madrasah', 'Tanggungan', 'Dsn Tanggungan, Desa Bragang', 1),
('TK Tarbiyatul Athfal', 'TK', 'Tanggungan', 'Dsn Tanggungan, Desa Bragang', 2),
('SDN Bragang 02', 'SD', 'Tanggungan', 'Dsn Tanggungan, Desa Bragang', 3),
('SMP Nurul Huda', 'SMP', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 4),
('SMK Nurul Huda', 'SMK', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 5),
('TK Muslimat Nurul Huda', 'TK', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 6),
('SDN Bragang 01', 'SD', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 7),
('MI Miftahul Ulum', 'MI', 'Bagunung', 'Dsn Bagunung, Desa Bragang', 8);

-- Masjid (4 Masjid)
INSERT INTO `masjid` (`nama`, `dusun`, `alamat`, `sort_order`) VALUES
('Masjid Al-Istiqomah', 'Tanggungan', 'Dsn Tanggungan, Desa Bragang', 1),
('Masjid Hidayatur Rohman', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 2),
('Masjid Nurul Huda', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 3),
('Masjid Al-Ikhlas', 'Bagunung', 'Dsn Bagunung, Desa Bragang', 4);

-- Struktur Pemerintahan (11 Aparatur)
INSERT INTO `struktur` (`nama`, `jabatan`, `sort_order`) VALUES
('Busiri', 'Kepala Desa', 1),
('Ahmad Mutamtam', 'Sekretaris Desa', 2),
('Abdul Aziz', 'Kasi Pemerintahan dan Kemasyarakatan', 3),
('Aizi Syafira Aini', 'Kasi Pelaksanaan dan Kesejahteraan Masyarakat', 4),
('Syaiful Anam', 'Kaur Keuangan', 5),
('Alfian Ainul Yaqin', 'Kaur Umum Dan Perencanaan', 6),
('Moh Mufinda Firdaus', 'Kadus Senjang', 7),
('Muhammad Mahrom', 'Kadus Tanggungan', 8),
('As\'ad Ulil Albab', 'Kadus Bragang Tengah', 9),
('Saibanurro\'i', 'Kadus Duko Nangka', 10),
('Moh. Bahri', 'Kadus Bagunung', 11);

-- Statistik Penduduk
INSERT INTO `statistik` (`key`, `value`) VALUES
('total_penduduk', '4250'),
('laki_laki', '2100'),
('perempuan', '2150'),
('jumlah_kk', '1180'),
('usia_0_14', '850'),
('usia_15_24', '720'),
('usia_25_44', '1200'),
('usia_45_64', '900'),
('usia_65_plus', '580'),
('islam', '4230'),
('kristen', '10'),
('lainnya', '10'),
('petani', '1800'),
('pedagang', '650'),
('pns', '80'),
('wiraswasta', '520'),
('lain_lain', '1200')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);

-- Jam Kerja Pelayanan
INSERT INTO `jam_kerja` (`hari`, `jam_masuk`, `jam_keluar`, `keterangan`) VALUES
('Senin', '08:00', '16:00', NULL),
('Selasa', '08:00', '16:00', NULL),
('Rabu', '08:00', '16:00', NULL),
('Kamis', '08:00', '16:00', NULL),
('Jumat', '08:00', '11:30', 'Jam kerja pendek (Jumat)'),
('Sabtu', '-', '-', 'Libur'),
('Minggu', '-', '-', 'Libur');

-- Akun Default Administrator (username: admin / password: admin123)
INSERT INTO `users` (`username`, `password`, `nama`) VALUES
('admin', '$2y$12$r15tiBcpVpoXm1IEoKDcBuoOf.VMK8inTakMn/RZYaYuMEJjibdAe', 'Administrator')
ON DUPLICATE KEY UPDATE `nama` = VALUES(`nama`);

COMMIT;
