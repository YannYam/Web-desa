# 🏛️ Website Resmi Desa Bragang

Portal website resmi dan sistem informasi manajemen Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan, Provinsi Jawa Timur.

Dibangun dengan **PHP Native** dan database **SQLite** — cepat, mandiri, tanpa ketergantungan framework berat, dan dirancang dengan standar estetika portal pemerintahan modern (tanpa desain artificial/AI slop yang berlebihan).

---

## 🌟 Fitur Utama

### Halaman Publik
1. **Beranda (`index.php`)**: Hero profil desa, sambutan resmi Kepala Desa Busiri, kartu ringkasan sensus & fasilitas, serta tautan cepat ke seluruh layanan.
2. **Sejarah Desa (`sejarah.php`)**: Narasi sejarah asal-usul Desa Bragang dan linimasa peristiwa penting.
3. **Wilayah Dusun (`wilayah.php`)**: Data 5 dusun (Bergunung, Duko Nangka, Bragang Tengah, Tanggungan, Mursenjang) beserta jumlah RT, RW, dan luas wilayah.
4. **Lembaga Pendidikan (`pendidikan.php`)**: Daftar 8 lembaga pendidikan (SDN 01, SDN 02, SMP & SMK Nurul Huda, TK, MI, Madrasah) dilengkapi visualisasi grafik distribusi jenis pendidikan.
5. **Masjid & Tempat Ibadah (`masjid.php`)**: Direktori 4 masjid di wilayah dusun Desa Bragang.
6. **Struktur Organisasi (`struktur.php`)**: Bagan organisasi hierarkis Kepala Desa, Sekretaris Desa, Kasi, Kaur, dan para Kepala Dusun (Kadus).
7. **Statistik Kependudukan (`statistik.php`)**: Grafik interaktif komposisi demografi, rasio jenis kelamin, kelompok usia, agama, dan mata pencaharian penduduk.
8. **Jam Kerja Pelayanan (`jam-kerja.php`)**: Jadwal jam buka dan tutup pelayanan kantor desa Senin s/d Minggu.
9. **Lokasi Kantor Desa (`lokasi.php`)**: Peta interaktif OpenStreetMap terintegrasi titik koordinat GPS (-6.9378 S, 112.9016 E) dan kontak kantor desa.

### Panel Administrasi (`/admin/`)
- **Autentikasi Session**: Dilindungi login berbasis session PHP & kata sandi terenkripsi `bcrypt`.
- **Dashboard Ringkasan**: Menampilkan metrik data dan pintasan cepat.
- **CRUD Penuh**:
  - Pengaturan nama website, tagline, sambutan kades, dan ubah password.
  - Kelola narasi sejarah dan linimasa peristiwa.
  - Kelola data dusun (RT/RW/Luas).
  - Kelola lembaga sekolah & madrasah.
  - Kelola masjid & tempat ibadah.
  - Kelola susunan aparatur pemerintah desa.
  - Edit angka statistik kependudukan langsung update ke Chart.js.
  - Atur jam kerja kantor per hari.
  - Atur alamat, kontak, dan koordinat GPS kantor.

---

## 🚀 Panduan Menjalankan

### Persyaratan
- **PHP 7.4+** atau **PHP 8.x** dengan ekstensi `pdo_sqlite` aktif (bawaan PHP).

### 1. Inisialisasi Database
Jalankan skrip installer satu kali untuk membuat file database SQLite (`database/desa_bragang.db`) dan mengisinya dengan data riil Desa Bragang:

```bash
php database/install.php
```

### 2. Jalankan Server Lokal
Jalankan built-in web server PHP dari direktori `app_build/`:

```bash
php -S localhost:8000
```

Buka peramban (browser) di:
- **Halaman Publik**: [http://localhost:8000](http://localhost:8000)
- **Panel Admin**: [http://localhost:8000/admin/](http://localhost:8000/admin/)

### Kredensial Default Admin
- **Username**: `admin`
- **Password**: `admin123`
*(Dapat diganti kapan saja melalui menu Pengaturan Web)*

---

## 📂 Struktur Berkas

```
app_build/
├── index.php                # Halaman Beranda Publik
├── sejarah.php              # Profil Sejarah & Linimasa
├── wilayah.php              # Data Wilayah Dusun
├── pendidikan.php           # Sarana Pendidikan & Grafik
├── masjid.php               # Data Masjid Desa
├── struktur.php             # Bagan Organisasi Pemerintah Desa
├── statistik.php            # Visualisasi Data Kependudukan
├── jam-kerja.php            # Jadwal Operasional Kantor
├── lokasi.php               # Peta GPS & Kontak Kantor
│
├── admin/                   # Panel Administrasi
│   ├── index.php            # Dashboard Admin
│   ├── login.php            # Halaman Masuk
│   ├── logout.php           # Handler Keluar
│   ├── settings.php         # Identitas & Akun Admin
│   ├── sejarah.php          # Manajemen Sejarah & Linimasa
│   ├── wilayah.php          # CRUD Dusun
│   ├── pendidikan.php       # CRUD Lembaga Pendidikan
│   ├── masjid.php           # CRUD Masjid
│   ├── struktur.php         # CRUD Perangkat Desa
│   ├── statistik.php        # Formulir Update Statistik
│   ├── jam-kerja.php        # Formulir Jam Pelayanan
│   ├── lokasi.php           # Koordinat & Kontak Kantor
│   └── includes/
│       ├── auth.php         # Middleware Proteksi Session
│       ├── admin_header.php # Tata Letak Header & Sidebar
│       └── admin_footer.php # Tata Letak Footer & Skrip
│
├── includes/                # Templating Publik
│   ├── db.php               # Koneksi Singleton SQLite (PDO)
│   ├── helpers.php          # Fungsi Sanitasi & Utilitas
│   ├── header.php           # Navigasi & Header Publik
│   └── footer.php           # Footer & Navigasi Cepat
│
├── database/                # Skema & Penyimpanan Data
│   ├── schema.sql           # Skema Tabel SQLite
│   ├── seed.sql             # Data Awal Riil Desa Bragang
│   └── install.php          # Skrip Instalasi Otomatis
│
└── assets/                  # Sumber Daya Statis
    ├── css/
    │   ├── style.css        # Gaya Tampilan Publik
    │   └── admin.css        # Gaya Tampilan Panel Admin
    └── js/
        └── main.js          # Interaktivitas Menu & Scroll
```
