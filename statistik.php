<?php
/**
 * Statistik Penduduk — Population Statistics
 */
$pageTitle = 'Statistik Penduduk';
$pageDescription = 'Data kependudukan Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan';

require_once __DIR__ . '/includes/db.php';

$db = getDB();
$stats = [];
$rows = $db->query('SELECT `key`, `value` FROM `statistik`')->fetchAll();
foreach ($rows as $r) {
    $stats[$r['key']] = $r['value'];
}

$total = (int)($stats['total_penduduk'] ?? 0);
$lakiLaki = (int)($stats['laki_laki'] ?? 0);
$perempuan = (int)($stats['perempuan'] ?? 0);
$jumlahKK = (int)($stats['jumlah_kk'] ?? 0);

// Age groups
$ageLabels = ['0-14 tahun', '15-24 tahun', '25-44 tahun', '45-64 tahun', '65+ tahun'];
$ageValues = [
    (int)($stats['usia_0_14'] ?? 0),
    (int)($stats['usia_15_24'] ?? 0),
    (int)($stats['usia_25_44'] ?? 0),
    (int)($stats['usia_45_64'] ?? 0),
    (int)($stats['usia_65_plus'] ?? 0),
];

// Religion
$religionLabels = ['Islam', 'Kristen', 'Lainnya'];
$religionValues = [
    (int)($stats['islam'] ?? 0),
    (int)($stats['kristen'] ?? 0),
    (int)($stats['lainnya'] ?? 0),
];

// Occupation
$occLabels = ['Petani', 'Pedagang', 'PNS', 'Wiraswasta', 'Lain-lain'];
$occValues = [
    (int)($stats['petani'] ?? 0),
    (int)($stats['pedagang'] ?? 0),
    (int)($stats['pns'] ?? 0),
    (int)($stats['wiraswasta'] ?? 0),
    (int)($stats['lain_lain'] ?? 0),
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1 class="page-title">Statistik Penduduk</h1>
        <p class="page-subtitle">Data kependudukan Desa Bragang</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card fade-in">
                <span class="stat-number"><?= formatNumber($total) ?></span>
                <span class="stat-label">Total Penduduk</span>
            </div>
            <div class="stat-card fade-in">
                <span class="stat-number"><?= formatNumber($lakiLaki) ?></span>
                <span class="stat-label">Laki-laki</span>
            </div>
            <div class="stat-card fade-in">
                <span class="stat-number"><?= formatNumber($perempuan) ?></span>
                <span class="stat-label">Perempuan</span>
            </div>
            <div class="stat-card fade-in">
                <span class="stat-number"><?= formatNumber($jumlahKK) ?></span>
                <span class="stat-label">Kepala Keluarga</span>
            </div>
        </div>
    </div>
</section>

<section class="section section-cream">
    <div class="container">
        <div class="charts-grid">
            <div class="chart-block fade-in">
                <h3 class="chart-title">Distribusi Usia</h3>
                <div class="chart-container">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>
            <div class="chart-block fade-in">
                <h3 class="chart-title">Agama</h3>
                <div class="chart-container">
                    <canvas id="religionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="chart-block chart-block-wide fade-in">
            <h3 class="chart-title">Mata Pencaharian</h3>
            <div class="chart-container">
                <canvas id="occupationChart"></canvas>
            </div>
        </div>
    </div>
</section>

<!-- Gender ratio bar -->
<section class="section section-cream">
    <div class="container content-narrow">
        <h3 class="chart-title" style="text-align:center; margin-bottom: 1.5rem;">Rasio Jenis Kelamin</h3>
        <div class="gender-bar">
            <?php $malePercent = $total > 0 ? round(($lakiLaki / $total) * 100) : 50; ?>
            <div class="gender-male" style="width: <?= $malePercent ?>%">
                <span>Laki-laki <?= $malePercent ?>%</span>
            </div>
            <div class="gender-female" style="width: <?= 100 - $malePercent ?>%">
                <span>Perempuan <?= 100 - $malePercent ?>%</span>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartFont = { family: 'Inter, sans-serif' };
    const greens = ['#1B4332', '#2D6A4F', '#40916C', '#52B788', '#74C69D'];
    const warm = ['#D4A373', '#E9C46A', '#FEFAE0'];

    // Age distribution
    new Chart(document.getElementById('ageChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($ageLabels) ?>,
            datasets: [{
                data: <?= json_encode($ageValues) ?>,
                backgroundColor: greens,
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { font: chartFont }, grid: { color: '#DEE2E6' } },
                x: { ticks: { font: chartFont }, grid: { display: false } }
            }
        }
    });

    // Religion donut
    new Chart(document.getElementById('religionChart'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($religionLabels) ?>,
            datasets: [{
                data: <?= json_encode($religionValues) ?>,
                backgroundColor: ['#1B4332', '#D4A373', '#DEE2E6'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { font: chartFont, padding: 16 } } }
        }
    });

    // Occupation horizontal bar
    new Chart(document.getElementById('occupationChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($occLabels) ?>,
            datasets: [{
                data: <?= json_encode($occValues) ?>,
                backgroundColor: ['#1B4332', '#2D6A4F', '#D4A373', '#E9C46A', '#95D5B2'],
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { font: chartFont }, grid: { color: '#DEE2E6' } },
                y: { ticks: { font: chartFont }, grid: { display: false } }
            }
        }
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
