<?php
/**
 * Sejarah Desa — Village History
 */
$pageTitle = 'Sejarah Desa';
$pageDescription = 'Sejarah dan perjalanan Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan';

require_once __DIR__ . '/includes/db.php';

$db = getDB();
$sejarah = $db->query('SELECT content FROM sejarah ORDER BY id DESC LIMIT 1')->fetch();
$timeline = $db->query('SELECT * FROM timeline ORDER BY sort_order ASC')->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-header page-header-sejarah">
    <div class="container">
        <h1 class="page-title">Sejarah Desa</h1>
        <p class="page-subtitle">Perjalanan panjang Desa Bragang dari masa ke masa</p>
    </div>
</section>

<section class="section">
    <div class="container content-narrow">
        <?php if ($sejarah): ?>
        <div class="prose">
            <?= nl2br(e($sejarah['content'])) ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php if (!empty($timeline)): ?>
<section class="section section-cream">
    <div class="container">
        <h2 class="section-title">Linimasa</h2>
        <div class="timeline">
            <?php foreach ($timeline as $i => $item): ?>
            <div class="timeline-item fade-in <?= $i % 2 === 0 ? 'left' : 'right' ?>">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <span class="timeline-year"><?= e($item['year']) ?></span>
                    <p><?= e($item['event']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
