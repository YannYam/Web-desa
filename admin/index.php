<?php
/**
 * Admin Dashboard — Desa Bragang
 */
$adminTitle = 'Dashboard';
require_once __DIR__ . '/includes/admin_header.php';

$db = getDB();

// Fetch summary metrics
$dusunCount = $db->query('SELECT COUNT(*) FROM wilayah')->fetchColumn();
$pendidikanCount = $db->query('SELECT COUNT(*) FROM pendidikan')->fetchColumn();
$masjidCount = $db->query('SELECT COUNT(*) FROM masjid')->fetchColumn();
$strukturCount = $db->query('SELECT COUNT(*) FROM struktur')->fetchColumn();
$totalPenduduk = $db->query("SELECT `value` FROM `statistik` WHERE `key` = 'total_penduduk'")->fetchColumn() ?: '0';
$jumlahKK = $db->query("SELECT `value` FROM `statistik` WHERE `key` = 'jumlah_kk'")->fetchColumn() ?: '0';
?>

<div class="page-header-admin">
    <div>
        <h1>Dashboard Administrasi</h1>
        <p>Ringkasan data publik dan pusat manajemen portal <?= e($siteName) ?></p>
    </div>
    <div>
        <a href="<?= baseUrl('/admin/settings.php') ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Pengaturan Situs
        </a>
    </div>
</div>

<!-- Stat counters -->
<div class="grid-4" style="margin-bottom: 2rem;">
    <div class="admin-stat-card">
        <div class="admin-stat-info">
            <h3>Total Penduduk</h3>
            <div class="stat-val"><?= formatNumber($totalPenduduk) ?></div>
        </div>
        <div class="admin-stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-info">
            <h3>Wilayah Dusun</h3>
            <div class="stat-val"><?= $dusunCount ?></div>
        </div>
        <div class="admin-stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-info">
            <h3>Lembaga Pendidikan</h3>
            <div class="stat-val"><?= $pendidikanCount ?></div>
        </div>
        <div class="admin-stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 1.1 2.7 3 6 3s6-1.9 6-3v-5"/></svg>
        </div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-info">
            <h3>Perangkat Desa</h3>
            <div class="stat-val"><?= $strukturCount ?></div>
        </div>
        <div class="admin-stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </div>
    </div>
</div>

<!-- Quick Link Grid -->
<div class="card">
    <div class="card-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Kelola Konten & Data Desa
    </div>
    <div class="grid-3">
        <div class="card" style="margin-bottom: 0; background: #FAFDFB;">
            <h3 style="font-size: 1.05rem; margin-bottom: 0.5rem; color: var(--primary);">Sejarah & Linimasa</h3>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1rem;">Perbarui narasi sejarah desa Bragang dan catatan peristiwa penting.</p>
            <a href="<?= baseUrl('/admin/sejarah.php') ?>" class="btn btn-sm btn-secondary">Kelola Sejarah →</a>
        </div>

        <div class="card" style="margin-bottom: 0; background: #FAFDFB;">
            <h3 style="font-size: 1.05rem; margin-bottom: 0.5rem; color: var(--primary);">Wilayah Dusun</h3>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1rem;">Tambah, edit atau hapus data dusun, jumlah RT/RW, dan luas wilayah.</p>
            <a href="<?= baseUrl('/admin/wilayah.php') ?>" class="btn btn-sm btn-secondary">Kelola Dusun →</a>
        </div>

        <div class="card" style="margin-bottom: 0; background: #FAFDFB;">
            <h3 style="font-size: 1.05rem; margin-bottom: 0.5rem; color: var(--primary);">Lembaga Pendidikan</h3>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1rem;">Kelola daftar sekolah TK, SD, SMP, SMK, MI, dan Madrasah.</p>
            <a href="<?= baseUrl('/admin/pendidikan.php') ?>" class="btn btn-sm btn-secondary">Kelola Sekolah →</a>
        </div>

        <div class="card" style="margin-bottom: 0; background: #FAFDFB;">
            <h3 style="font-size: 1.05rem; margin-bottom: 0.5rem; color: var(--primary);">Masjid & Tempat Ibadah</h3>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1rem;">Kelola data 4 masjid di wilayah Dusun Tanggungan, Bragang Tengah, Bagunung.</p>
            <a href="<?= baseUrl('/admin/masjid.php') ?>" class="btn btn-sm btn-secondary">Kelola Masjid →</a>
        </div>

        <div class="card" style="margin-bottom: 0; background: #FAFDFB;">
            <h3 style="font-size: 1.05rem; margin-bottom: 0.5rem; color: var(--primary);">Struktur Organisasi</h3>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1rem;">Kelola nama pejabat: Kepala Desa, Sekdes, Kasi, Kaur, dan para Kadus.</p>
            <a href="<?= baseUrl('/admin/struktur.php') ?>" class="btn btn-sm btn-secondary">Kelola Aparatur →</a>
        </div>

        <div class="card" style="margin-bottom: 0; background: #FAFDFB;">
            <h3 style="font-size: 1.05rem; margin-bottom: 0.5rem; color: var(--primary);">Statistik Penduduk</h3>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1rem;">Perbarui data sensus warga, jenis kelamin, usia, agama, dan pekerjaan.</p>
            <a href="<?= baseUrl('/admin/statistik.php') ?>" class="btn btn-sm btn-secondary">Update Statistik →</a>
        </div>

        <div class="card" style="margin-bottom: 0; background: #FAFDFB;">
            <h3 style="font-size: 1.05rem; margin-bottom: 0.5rem; color: var(--primary);">Jadwal Jam Kerja</h3>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1rem;">Ubah jam pelayanan kantor desa untuk hari Senin sampai Minggu.</p>
            <a href="<?= baseUrl('/admin/jam-kerja.php') ?>" class="btn btn-sm btn-secondary">Atur Jam Kerja →</a>
        </div>

        <div class="card" style="margin-bottom: 0; background: #FAFDFB;">
            <h3 style="font-size: 1.05rem; margin-bottom: 0.5rem; color: var(--primary);">Lokasi & Kontak Kantor</h3>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1rem;">Perbarui alamat, nomor telepon, email, dan titik koordinat GPS map.</p>
            <a href="<?= baseUrl('/admin/lokasi.php') ?>" class="btn btn-sm btn-secondary">Atur Lokasi →</a>
        </div>

        <div class="card" style="margin-bottom: 0; background: #FAFDFB;">
            <h3 style="font-size: 1.05rem; margin-bottom: 0.5rem; color: var(--primary);">Pengaturan Identitas</h3>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1rem;">Atur judul website, slogan, sambutan Kades, dan data umum desa.</p>
            <a href="<?= baseUrl('/admin/settings.php') ?>" class="btn btn-sm btn-secondary">Pengaturan →</a>
        </div>
    </div>
</div>

<!-- System Status -->
<div class="card">
    <div class="card-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        Status Sistem & Database
    </div>
    <div style="font-size: 0.9rem; color: var(--text-dark); display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem;">
        <div><strong>Database Engine:</strong> SQLite 3 (File-based)</div>
        <div><strong>PHP Version:</strong> <?= phpversion() ?></div>
        <div><strong>Server Waktu:</strong> <?= date('d M Y, H:i') ?> WIB</div>
        <div><strong>Status Autentikasi:</strong> <span class="badge badge-green">Aktif (Session)</span></div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
