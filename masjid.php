<?php
/**
 * Masjid — Mosques
 */
$pageTitle = 'Masjid';
$pageDescription = 'Daftar masjid di Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan';

require_once __DIR__ . '/includes/db.php';

$db = getDB();
$masjidList = $db->query('SELECT * FROM masjid ORDER BY sort_order ASC')->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1 class="page-title">Masjid</h1>
        <p class="page-subtitle">Tempat ibadah di lingkungan Desa Bragang</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card-grid">
            <?php foreach ($masjidList as $i => $m): ?>
            <div class="info-card fade-in">
                <div class="info-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5"/>
                        <path d="M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <h3 class="info-card-title"><?= e($m['nama']) ?></h3>
                <p class="info-card-meta">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Dsn <?= e($m['dusun']) ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
