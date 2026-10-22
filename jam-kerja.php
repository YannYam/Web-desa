<?php
/**
 * Jam Kerja — Working Hours
 */
$pageTitle = 'Jam Kerja';
$pageDescription = 'Jadwal jam kerja kantor Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan';

require_once __DIR__ . '/includes/db.php';

$db = getDB();
$jamKerja = $db->query('SELECT * FROM jam_kerja ORDER BY id ASC')->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1 class="page-title">Jam Kerja</h1>
        <p class="page-subtitle">Jadwal pelayanan Kantor Desa Bragang</p>
    </div>
</section>

<section class="section">
    <div class="container content-narrow">
        <div class="schedule-card fade-in">
            <div class="schedule-header">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <h2>Jadwal Pelayanan</h2>
            </div>
            <table class="schedule-table" id="jam-kerja-table">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jamKerja as $j): ?>
                    <tr class="<?= ($j['keterangan'] === 'Libur') ? 'row-holiday' : '' ?>">
                        <td><strong><?= e($j['hari']) ?></strong></td>
                        <td><?= e($j['jam_masuk']) ?></td>
                        <td><?= e($j['jam_keluar']) ?></td>
                        <td><?= e($j['keterangan'] ?? '-') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="notice fade-in">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D4A373" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <p>Jadwal dapat berubah sewaktu-waktu pada hari libur nasional dan hari besar keagamaan. Silakan hubungi kantor desa untuk informasi lebih lanjut.</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
