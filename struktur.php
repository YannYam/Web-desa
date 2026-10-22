<?php
/**
 * Struktur Organisasi — Government Structure
 */
$pageTitle = 'Struktur Organisasi';
$pageDescription = 'Struktur pemerintahan Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan';

require_once __DIR__ . '/includes/db.php';

$db = getDB();
$struktur = $db->query('SELECT * FROM struktur ORDER BY sort_order ASC')->fetchAll();

// Group by role type
$kepalaDesa = null;
$sekdes = null;
$kasi = [];
$kaur = [];
$kadus = [];

foreach ($struktur as $s) {
    $jab = strtolower($s['jabatan']);
    if (strpos($jab, 'kepala desa') !== false) {
        $kepalaDesa = $s;
    } elseif (strpos($jab, 'sekretaris') !== false || strpos($jab, 'sekdes') !== false) {
        $sekdes = $s;
    } elseif (strpos($jab, 'kasi') !== false) {
        $kasi[] = $s;
    } elseif (strpos($jab, 'kaur') !== false) {
        $kaur[] = $s;
    } elseif (strpos($jab, 'kadus') !== false) {
        $kadus[] = $s;
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1 class="page-title">Struktur Organisasi</h1>
        <p class="page-subtitle">Pemerintahan Desa Bragang</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="org-chart">
            <!-- Kepala Desa -->
            <?php if ($kepalaDesa): ?>
            <div class="org-level org-level-1">
                <div class="org-node org-node-primary fade-in">
                    <div class="org-avatar">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3 class="org-name"><?= e($kepalaDesa['nama']) ?></h3>
                    <p class="org-position"><?= e($kepalaDesa['jabatan']) ?></p>
                </div>
            </div>
            <div class="org-connector"></div>
            <?php endif; ?>

            <!-- Sekretaris Desa -->
            <?php if ($sekdes): ?>
            <div class="org-level org-level-2">
                <div class="org-node org-node-secondary fade-in">
                    <div class="org-avatar org-avatar-sm">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3 class="org-name"><?= e($sekdes['nama']) ?></h3>
                    <p class="org-position"><?= e($sekdes['jabatan']) ?></p>
                </div>
            </div>
            <div class="org-connector"></div>
            <?php endif; ?>

            <!-- Kasi & Kaur -->
            <?php if (!empty($kasi) || !empty($kaur)): ?>
            <div class="org-level org-level-3">
                <?php foreach ($kasi as $k): ?>
                <div class="org-node fade-in">
                    <div class="org-avatar org-avatar-sm">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3 class="org-name"><?= e($k['nama']) ?></h3>
                    <p class="org-position"><?= e($k['jabatan']) ?></p>
                </div>
                <?php endforeach; ?>
                <?php foreach ($kaur as $k): ?>
                <div class="org-node fade-in">
                    <div class="org-avatar org-avatar-sm">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3 class="org-name"><?= e($k['nama']) ?></h3>
                    <p class="org-position"><?= e($k['jabatan']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="org-connector"></div>
            <?php endif; ?>

            <!-- Kadus -->
            <?php if (!empty($kadus)): ?>
            <div class="org-level org-level-4">
                <?php foreach ($kadus as $k): ?>
                <div class="org-node org-node-outline fade-in">
                    <div class="org-avatar org-avatar-sm org-avatar-outline">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3 class="org-name"><?= e($k['nama']) ?></h3>
                    <p class="org-position"><?= e($k['jabatan']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Full list table -->
<section class="section section-cream">
    <div class="container">
        <h2 class="section-title">Daftar Lengkap Perangkat Desa</h2>
        <div class="table-wrapper">
            <table class="data-table" id="struktur-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($struktur as $i => $s): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= e($s['nama']) ?></strong></td>
                        <td><?= e($s['jabatan']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
