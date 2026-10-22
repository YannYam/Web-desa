<?php
/**
 * Lokasi Kantor — Office Location
 */
$pageTitle = 'Lokasi Kantor';
$pageDescription = 'Lokasi dan peta kantor Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan';

require_once __DIR__ . '/includes/db.php';

$lat = getSetting('latitude', '-6.9378');
$lng = getSetting('longitude', '112.9016');
$alamat = getSetting('alamat', '');
$telepon = getSetting('telepon', '');
$email = getSetting('email', '');

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1 class="page-title">Lokasi Kantor Desa</h1>
        <p class="page-subtitle">Kantor Desa Bragang, Kecamatan Klampis</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="location-grid">
            <div class="location-map fade-in">
                <iframe
                    id="office-map"
                    width="100%"
                    height="400"
                    frameborder="0"
                    scrolling="no"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=<?= $lng - 0.005 ?>%2C<?= $lat - 0.005 ?>%2C<?= $lng + 0.005 ?>%2C<?= $lat + 0.005 ?>&layer=mapnik&marker=<?= $lat ?>%2C<?= $lng ?>"
                    style="border: 2px solid #DEE2E6; border-radius: 8px;">
                </iframe>
                <p class="map-link">
                    <a href="https://www.openstreetmap.org/?mlat=<?= $lat ?>&mlon=<?= $lng ?>#map=16/<?= $lat ?>/<?= $lng ?>" target="_blank" rel="noopener">
                        Lihat Peta Lebih Besar →
                    </a>
                </p>
            </div>
            <div class="location-info fade-in">
                <div class="contact-card">
                    <h2>Kantor Desa Bragang</h2>
                    <div class="contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <div>
                            <strong>Alamat</strong>
                            <p><?= e($alamat) ?></p>
                        </div>
                    </div>
                    <?php if ($telepon): ?>
                    <div class="contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <div>
                            <strong>Telepon</strong>
                            <p><?= e($telepon) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($email): ?>
                    <div class="contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <div>
                            <strong>Email</strong>
                            <p><?= e($email) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="1.5"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
                        <div>
                            <strong>Koordinat</strong>
                            <p><?= e($lat) ?>, <?= e($lng) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
