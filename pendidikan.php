<?php
/**
 * Pendidikan — Education Institutions
 */
$pageTitle = 'Pendidikan';
$pageDescription = 'Lembaga pendidikan di Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan';

require_once __DIR__ . '/includes/db.php';

$db = getDB();
$pendidikan = $db->query('SELECT * FROM pendidikan ORDER BY sort_order ASC')->fetchAll();

// Group by dusun
$byDusun = [];
foreach ($pendidikan as $p) {
    $byDusun[$p['dusun']][] = $p;
}

// Count by type for chart
$byJenis = [];
foreach ($pendidikan as $p) {
    $jenis = $p['jenis'] ?? 'Lainnya';
    $byJenis[$jenis] = ($byJenis[$jenis] ?? 0) + 1;
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-header page-header-pendidikan">
    <div class="container">
        <h1 class="page-title">Pendidikan</h1>
        <p class="page-subtitle">Lembaga pendidikan di Desa Bragang</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="stats-grid stats-grid-3">
            <div class="stat-card fade-in">
                <span class="stat-number"><?= count($pendidikan) ?></span>
                <span class="stat-label">Lembaga Pendidikan</span>
            </div>
            <div class="stat-card fade-in">
                <span class="stat-number"><?= count($byDusun) ?></span>
                <span class="stat-label">Dusun Terlayani</span>
            </div>
            <div class="stat-card fade-in">
                <span class="stat-number"><?= count($byJenis) ?></span>
                <span class="stat-label">Jenis Institusi</span>
            </div>
        </div>
    </div>
</section>

<section class="section section-cream">
    <div class="container">
        <h2 class="section-title">Daftar Lembaga Pendidikan</h2>
        <div class="table-wrapper">
            <table class="data-table" id="pendidikan-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lembaga</th>
                        <th>Jenis</th>
                        <th>Lokasi Dusun</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendidikan as $i => $p): ?>
                    <tr class="fade-in">
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= e($p['nama']) ?></strong></td>
                        <td><span class="badge badge-<?= strtolower($p['jenis'] ?? 'lain') ?>"><?= e($p['jenis'] ?? '-') ?></span></td>
                        <td><?= e($p['dusun']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Distribusi Jenis Pendidikan</h2>
        <div class="chart-container">
            <canvas id="pendidikanChart" width="600" height="300"></canvas>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('pendidikanChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($byJenis)) ?>,
            datasets: [{
                label: 'Jumlah',
                data: <?= json_encode(array_values($byJenis)) ?>,
                backgroundColor: ['#1B4332', '#2D6A4F', '#40916C', '#52B788', '#74C69D', '#95D5B2', '#D4A373', '#E9C46A'],
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { family: 'Inter' } },
                    grid: { color: '#DEE2E6' }
                },
                x: {
                    ticks: { font: { family: 'Inter' } },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
