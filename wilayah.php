<?php
/**
 * Wilayah Desa — Administrative Regions
 */
$pageTitle = 'Wilayah Desa';
$pageDescription = 'Data wilayah dan dusun Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan';

require_once __DIR__ . '/includes/db.php';

$db = getDB();
$wilayah = $db->query('SELECT * FROM wilayah ORDER BY id ASC')->fetchAll();

$totalRT = 0;
$totalRW = 0;
foreach ($wilayah as $w) {
    $totalRT += $w['jumlah_rt'];
    $totalRW += $w['jumlah_rw'];
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1 class="page-title">Wilayah Desa</h1>
        <p class="page-subtitle">Pembagian wilayah administratif Desa Bragang</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="stats-grid stats-grid-3">
            <div class="stat-card fade-in">
                <span class="stat-number"><?= count($wilayah) ?></span>
                <span class="stat-label">Dusun</span>
            </div>
            <div class="stat-card fade-in">
                <span class="stat-number"><?= $totalRT ?></span>
                <span class="stat-label">Rukun Tetangga (RT)</span>
            </div>
            <div class="stat-card fade-in">
                <span class="stat-number"><?= $totalRW ?></span>
                <span class="stat-label">Rukun Warga (RW)</span>
            </div>
        </div>
    </div>
</section>

<section class="section section-cream">
    <div class="container">
        <h2 class="section-title">Daftar Dusun</h2>
        <div class="table-wrapper">
            <table class="data-table" id="wilayah-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dusun</th>
                        <th>Jumlah RT</th>
                        <th>Jumlah RW</th>
                        <th>Luas</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($wilayah as $i => $w): ?>
                    <tr class="fade-in">
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= e($w['nama']) ?></strong></td>
                        <td><?= (int)$w['jumlah_rt'] ?></td>
                        <td><?= (int)$w['jumlah_rw'] ?></td>
                        <td><?= e($w['luas'] ?? '-') ?></td>
                        <td><?= e($w['keterangan'] ?? '-') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
