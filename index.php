<?php
/**
 * Beranda — Home Page
 */
$pageTitle = 'Beranda';
$pageDescription = 'Website Resmi Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan';

require_once __DIR__ . '/includes/db.php';

// Fetch data for home page
$db = getDB();
$wilayahCount = $db->query('SELECT COUNT(*) FROM wilayah')->fetchColumn();
$pendidikanCount = $db->query('SELECT COUNT(*) FROM pendidikan')->fetchColumn();
$masjidCount = $db->query('SELECT COUNT(*) FROM masjid')->fetchColumn();
$totalPenduduk = $db->query("SELECT `value` FROM `statistik` WHERE `key` = 'total_penduduk'")->fetchColumn() ?: '0';
$kepalaDesa = getSetting('kepala_desa', 'Kepala Desa');
$welcomeMsg = getSetting('welcome_message', '');

require_once __DIR__ . '/includes/header.php';
?>

<section class="hero" id="hero">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <p class="hero-label">Website Resmi</p>
        <h1 class="hero-title"><?= e($siteName) ?></h1>
        <p class="hero-subtitle">Kecamatan <?= e($settings['kecamatan'] ?? '') ?>, Kabupaten <?= e($settings['kabupaten'] ?? '') ?></p>
        <p class="hero-tagline"><?= e($tagline) ?></p>
        <a href="<?= baseUrl('/struktur.php') ?>" class="hero-cta">Lihat Profil Desa</a>
    </div>
</section>

<section class="section" id="sambutan">
    <div class="container">
        <div class="welcome-block">
            <div class="welcome-icon">
                <img src="./assets/images/kepdes.jpeg" alt="Kepala Desa" style="border-radius: 10%;">
            </div>
            <div class="welcome-text">
                <h2>Sambutan Kepala Desa</h2>
                <blockquote>
                    <p>"<?= e($welcomeMsg) ?>"</p>
                    <cite>— <?= e($kepalaDesa) ?>, Kepala Desa Bragang</cite>
                </blockquote>
            </div>
        </div>
    </div>
</section>

<section class="section section-cream" id="stats-overview">
    <div class="container">
        <h2 class="section-title">Sekilas Desa Bragang</h2>
        <div class="stats-grid">
            <div class="stat-card fade-in">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="stat-number"><?= formatNumber($totalPenduduk) ?></span>
                <span class="stat-label">Jumlah Penduduk</span>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <span class="stat-number"><?= $wilayahCount ?></span>
                <span class="stat-label">Dusun</span>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <span class="stat-number"><?= $pendidikanCount ?></span>
                <span class="stat-label">Lembaga Pendidikan</span>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                </div>
                <span class="stat-number"><?= $masjidCount ?></span>
                <span class="stat-label">Masjid</span>
            </div>
        </div>
    </div>
</section>

<section class="section" id="quick-links">
    <div class="container">
        <h2 class="section-title">Informasi Desa</h2>
        <p class="section-subtitle">Akses cepat ke layanan dan informasi desa</p>
        <div class="links-grid">
            <a href="<?= baseUrl('/sejarah.php') ?>" class="link-card fade-in">
                <div class="link-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3>Sejarah Desa</h3>
                <p>Perjalanan dan sejarah Desa Bragang</p>
            </a>
            <a href="<?= baseUrl('/wilayah.php') ?>" class="link-card fade-in">
                <div class="link-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <h3>Wilayah Desa</h3>
                <p>Peta dan data wilayah dusun</p>
            </a>
            <a href="<?= baseUrl('/pendidikan.php') ?>" class="link-card fade-in">
                <div class="link-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 1.1 2.7 3 6 3s6-1.9 6-3v-5"/></svg>
                </div>
                <h3>Pendidikan</h3>
                <p>Lembaga pendidikan di desa</p>
            </a>
            <a href="<?= baseUrl('/masjid.php') ?>" class="link-card fade-in">
                <div class="link-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                </div>
                <h3>Masjid</h3>
                <p>Tempat ibadah di lingkungan desa</p>
            </a>
            <a href="<?= baseUrl('/struktur.php') ?>" class="link-card fade-in">
                <div class="link-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <h3>Struktur Organisasi</h3>
                <p>Pemerintahan Desa Bragang</p>
            </a>
            <a href="<?= baseUrl('/statistik.php') ?>" class="link-card fade-in">
                <div class="link-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                </div>
                <h3>Statistik Penduduk</h3>
                <p>Data kependudukan terkini</p>
            </a>
            <a href="<?= baseUrl('/jam-kerja.php') ?>" class="link-card fade-in">
                <div class="link-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3>Jam Kerja</h3>
                <p>Jadwal pelayanan kantor desa</p>
            </a>
            <a href="<?= baseUrl('/lokasi.php') ?>" class="link-card fade-in">
                <div class="link-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
                </div>
                <h3>Lokasi Kantor</h3>
                <p>Alamat dan peta kantor desa</p>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
