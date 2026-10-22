-- ============================================
-- Website Desa Bragang — Seed Data
-- ============================================

-- Site Settings
INSERT INTO settings (key, value) VALUES ('site_name', 'Desa Bragang');
INSERT INTO settings (key, value) VALUES ('tagline', 'Melayani dengan Sepenuh Hati');
INSERT INTO settings (key, value) VALUES ('kecamatan', 'Klampis');
INSERT INTO settings (key, value) VALUES ('kabupaten', 'Bangkalan');
INSERT INTO settings (key, value) VALUES ('provinsi', 'Jawa Timur');
INSERT INTO settings (key, value) VALUES ('welcome_message', 'Selamat datang di Website Resmi Desa Bragang. Kami berkomitmen untuk memberikan pelayanan terbaik kepada seluruh masyarakat desa.');
INSERT INTO settings (key, value) VALUES ('kepala_desa', 'Busiri');
INSERT INTO settings (key, value) VALUES ('alamat', 'Dsn Bragang Tengah, Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan');
INSERT INTO settings (key, value) VALUES ('telepon', '(031) 000-0000');
INSERT INTO settings (key, value) VALUES ('email', 'desa.bragang@gmail.com');
INSERT INTO settings (key, value) VALUES ('latitude', '-6.9378');
INSERT INTO settings (key, value) VALUES ('longitude', '112.9016');

-- Sejarah
INSERT INTO sejarah (content) VALUES ('Desa Bragang merupakan salah satu desa yang terletak di Kecamatan Klampis, Kabupaten Bangkalan, Provinsi Jawa Timur. Desa ini memiliki sejarah panjang yang erat kaitannya dengan perkembangan masyarakat Madura. Nama "Bragang" berasal dari bahasa Madura yang menggambarkan karakteristik wilayah dan budaya setempat.

Sejak masa kemerdekaan, Desa Bragang telah mengalami berbagai perkembangan signifikan baik dalam bidang infrastruktur, pendidikan, maupun kesejahteraan masyarakat. Masyarakat Desa Bragang dikenal sebagai masyarakat yang religius, gotong royong, dan menjunjung tinggi nilai-nilai kebersamaan.

Desa Bragang terdiri dari lima dusun yang masing-masing memiliki keunikan dan potensi tersendiri. Pemerintah desa terus berupaya meningkatkan kualitas pelayanan publik dan pembangunan desa demi kesejahteraan seluruh warga.');

-- Timeline
INSERT INTO timeline (year, event, sort_order) VALUES ('1945', 'Desa Bragang resmi terbentuk sebagai bagian dari wilayah administrasi Kecamatan Klampis', 1);
INSERT INTO timeline (year, event, sort_order) VALUES ('1970', 'Pembangunan infrastruktur jalan desa pertama yang menghubungkan antar dusun', 2);
INSERT INTO timeline (year, event, sort_order) VALUES ('1985', 'Pembangunan SDN Bragang 01 dan SDN Bragang 02 sebagai sarana pendidikan dasar', 3);
INSERT INTO timeline (year, event, sort_order) VALUES ('1995', 'Berdirinya lembaga pendidikan SMP dan SMK Nurul Huda', 4);
INSERT INTO timeline (year, event, sort_order) VALUES ('2005', 'Renovasi kantor desa dan peningkatan fasilitas pelayanan publik', 5);
INSERT INTO timeline (year, event, sort_order) VALUES ('2020', 'Digitalisasi administrasi desa dan pelayanan online', 6);

-- Wilayah (5 Dusun)
INSERT INTO wilayah (nama, jumlah_rt, jumlah_rw, luas, keterangan) VALUES ('Dsn Bergunung', 4, 2, '120 Ha', 'Wilayah dataran tinggi di bagian utara desa');
INSERT INTO wilayah (nama, jumlah_rt, jumlah_rw, luas, keterangan) VALUES ('Dsn Duko Nangka', 3, 1, '85 Ha', 'Wilayah di bagian barat desa');
INSERT INTO wilayah (nama, jumlah_rt, jumlah_rw, luas, keterangan) VALUES ('Dsn Bragang Tengah', 5, 2, '150 Ha', 'Pusat pemerintahan dan ekonomi desa');
INSERT INTO wilayah (nama, jumlah_rt, jumlah_rw, luas, keterangan) VALUES ('Dsn Tanggungan', 4, 2, '110 Ha', 'Wilayah di bagian selatan desa');
INSERT INTO wilayah (nama, jumlah_rt, jumlah_rw, luas, keterangan) VALUES ('Dsn Mursenjang', 3, 1, '95 Ha', 'Wilayah di bagian timur desa');

-- Pendidikan (8 Institutions)
INSERT INTO pendidikan (nama, jenis, dusun, alamat, sort_order) VALUES ('Madrasah Raudlatul Muhibbin', 'Madrasah', 'Tanggungan', 'Dsn Tanggungan, Desa Bragang', 1);
INSERT INTO pendidikan (nama, jenis, dusun, alamat, sort_order) VALUES ('TK Tarbiyatul Athfal', 'TK', 'Tanggungan', 'Dsn Tanggungan, Desa Bragang', 2);
INSERT INTO pendidikan (nama, jenis, dusun, alamat, sort_order) VALUES ('SDN Bragang 02', 'SD', 'Tanggungan', 'Dsn Tanggungan, Desa Bragang', 3);
INSERT INTO pendidikan (nama, jenis, dusun, alamat, sort_order) VALUES ('SMP Nurul Huda', 'SMP', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 4);
INSERT INTO pendidikan (nama, jenis, dusun, alamat, sort_order) VALUES ('SMK Nurul Huda', 'SMK', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 5);
INSERT INTO pendidikan (nama, jenis, dusun, alamat, sort_order) VALUES ('TK Muslimat Nurul Huda', 'TK', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 6);
INSERT INTO pendidikan (nama, jenis, dusun, alamat, sort_order) VALUES ('SDN Bragang 01', 'SD', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 7);
INSERT INTO pendidikan (nama, jenis, dusun, alamat, sort_order) VALUES ('MI Miftahul Ulum', 'MI', 'Bagunung', 'Dsn Bagunung, Desa Bragang', 8);

-- Masjid (4 Mosques)
INSERT INTO masjid (nama, dusun, alamat, sort_order) VALUES ('Masjid Al-Istiqomah', 'Tanggungan', 'Dsn Tanggungan, Desa Bragang', 1);
INSERT INTO masjid (nama, dusun, alamat, sort_order) VALUES ('Masjid Hidayatur Rohman', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 2);
INSERT INTO masjid (nama, dusun, alamat, sort_order) VALUES ('Masjid Nurul Huda', 'Bragang Tengah', 'Dsn Bragang Tengah, Desa Bragang', 3);
INSERT INTO masjid (nama, dusun, alamat, sort_order) VALUES ('Masjid Al-Ikhlas', 'Bagunung', 'Dsn Bagunung, Desa Bragang', 4);

-- Struktur Pemerintahan (11 Officials)
INSERT INTO struktur (nama, jabatan, sort_order) VALUES ('Busiri', 'Kepala Desa', 1);
INSERT INTO struktur (nama, jabatan, sort_order) VALUES ('Ahmad Mutamtam', 'Sekretaris Desa', 2);
INSERT INTO struktur (nama, jabatan, sort_order) VALUES ('Abdul Aziz', 'Kasi Pemerintahan dan Kemasyarakatan', 3);
INSERT INTO struktur (nama, jabatan, sort_order) VALUES ('Aizi Syafira Aini', 'Kasi Pelaksanaan dan Kesejahteraan Masyarakat', 4);
INSERT INTO struktur (nama, jabatan, sort_order) VALUES ('Syaiful Anam', 'Kaur Keuangan', 5);
INSERT INTO struktur (nama, jabatan, sort_order) VALUES ('Alfian Ainul Yaqin', 'Kaur Umum Dan Perencanaan', 6);
INSERT INTO struktur (nama, jabatan, sort_order) VALUES ('Moh Mufinda Firdaus', 'Kadus Senjang', 7);
INSERT INTO struktur (nama, jabatan, sort_order) VALUES ('Muhammad Mahrom', 'Kadus Tanggungan', 8);
INSERT INTO struktur (nama, jabatan, sort_order) VALUES ('As''ad Ulil Albab', 'Kadus Bragang Tengah', 9);
INSERT INTO struktur (nama, jabatan, sort_order) VALUES ('Saibanurro''i', 'Kadus Duko Nangka', 10);
INSERT INTO struktur (nama, jabatan, sort_order) VALUES ('Moh. Bahri', 'Kadus Bagunung', 11);

-- Statistik Penduduk
INSERT INTO statistik (key, value) VALUES ('total_penduduk', '4250');
INSERT INTO statistik (key, value) VALUES ('laki_laki', '2100');
INSERT INTO statistik (key, value) VALUES ('perempuan', '2150');
INSERT INTO statistik (key, value) VALUES ('jumlah_kk', '1180');
INSERT INTO statistik (key, value) VALUES ('usia_0_14', '850');
INSERT INTO statistik (key, value) VALUES ('usia_15_24', '720');
INSERT INTO statistik (key, value) VALUES ('usia_25_44', '1200');
INSERT INTO statistik (key, value) VALUES ('usia_45_64', '900');
INSERT INTO statistik (key, value) VALUES ('usia_65_plus', '580');
INSERT INTO statistik (key, value) VALUES ('islam', '4230');
INSERT INTO statistik (key, value) VALUES ('kristen', '10');
INSERT INTO statistik (key, value) VALUES ('lainnya', '10');
INSERT INTO statistik (key, value) VALUES ('petani', '1800');
INSERT INTO statistik (key, value) VALUES ('pedagang', '650');
INSERT INTO statistik (key, value) VALUES ('pns', '80');
INSERT INTO statistik (key, value) VALUES ('wiraswasta', '520');
INSERT INTO statistik (key, value) VALUES ('lain_lain', '1200');

-- Jam Kerja
INSERT INTO jam_kerja (hari, jam_masuk, jam_keluar, keterangan) VALUES ('Senin', '08:00', '16:00', NULL);
INSERT INTO jam_kerja (hari, jam_masuk, jam_keluar, keterangan) VALUES ('Selasa', '08:00', '16:00', NULL);
INSERT INTO jam_kerja (hari, jam_masuk, jam_keluar, keterangan) VALUES ('Rabu', '08:00', '16:00', NULL);
INSERT INTO jam_kerja (hari, jam_masuk, jam_keluar, keterangan) VALUES ('Kamis', '08:00', '16:00', NULL);
INSERT INTO jam_kerja (hari, jam_masuk, jam_keluar, keterangan) VALUES ('Jumat', '08:00', '11:30', 'Jam kerja pendek (Jumat)');
INSERT INTO jam_kerja (hari, jam_masuk, jam_keluar, keterangan) VALUES ('Sabtu', '-', '-', 'Libur');
INSERT INTO jam_kerja (hari, jam_masuk, jam_keluar, keterangan) VALUES ('Minggu', '-', '-', 'Libur');
