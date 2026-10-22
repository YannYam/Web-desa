<?php
/**
 * Admin Statistik Penduduk — Desa Bragang
 */
$adminTitle = 'Edit Statistik Penduduk';
require_once __DIR__ . '/includes/admin_header.php';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $statKeys = [
        'total_penduduk', 'laki_laki', 'perempuan', 'jumlah_kk',
        'usia_0_14', 'usia_15_24', 'usia_25_44', 'usia_45_64', 'usia_65_plus',
        'islam', 'kristen', 'lainnya',
        'petani', 'pedagang', 'pns', 'wiraswasta', 'lain_lain'
    ];

    $stmt = $db->prepare('REPLACE INTO statistik (`key`, `value`) VALUES (:key, :val)');

    foreach ($statKeys as $k) {
        if (isset($_POST[$k])) {
            $stmt->execute([
                ':key' => $k,
                ':val' => (string)(int)$_POST[$k]
            ]);
        }
    }

    setFlash('success', 'Data statistik kependudukan berhasil diperbarui.');
    redirect('/admin/statistik.php');
}

// Fetch current statistics
$stats = [];
$rows = $db->query('SELECT `key`, `value` FROM statistik')->fetchAll();
foreach ($rows as $r) {
    $stats[$r['key']] = $r['value'];
}
?>

<div class="page-header-admin">
    <div>
        <h1>Edit Statistik Penduduk</h1>
        <p>Perbarui angka sensus dan data demografi yang ditampilkan pada grafik website Desa Bragang</p>
    </div>
</div>

<form method="POST" action="">
    <div class="grid-2">
        <!-- Demografi Utama -->
        <div class="card">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Data Penduduk Utama
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="total_penduduk">Total Penduduk (Jiwa)</label>
                    <input type="number" id="total_penduduk" name="total_penduduk" class="form-control" value="<?= (int)($stats['total_penduduk'] ?? 0) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="jumlah_kk">Jumlah Kepala Keluarga (KK)</label>
                    <input type="number" id="jumlah_kk" name="jumlah_kk" class="form-control" value="<?= (int)($stats['jumlah_kk'] ?? 0) ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="laki_laki">Jumlah Laki-laki</label>
                    <input type="number" id="laki_laki" name="laki_laki" class="form-control" value="<?= (int)($stats['laki_laki'] ?? 0) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="perempuan">Jumlah Perempuan</label>
                    <input type="number" id="perempuan" name="perempuan" class="form-control" value="<?= (int)($stats['perempuan'] ?? 0) ?>" required>
                </div>
            </div>
        </div>

        <!-- Agama -->
        <div class="card">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                Komposisi Agama
            </div>
            <div class="form-group">
                <label class="form-label" for="islam">Islam (Jiwa)</label>
                <input type="number" id="islam" name="islam" class="form-control" value="<?= (int)($stats['islam'] ?? 0) ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="kristen">Kristen (Jiwa)</label>
                <input type="number" id="kristen" name="kristen" class="form-control" value="<?= (int)($stats['kristen'] ?? 0) ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="lainnya">Agama Lainnya (Jiwa)</label>
                <input type="number" id="lainnya" name="lainnya" class="form-control" value="<?= (int)($stats['lainnya'] ?? 0) ?>" required>
            </div>
        </div>

        <!-- Distribusi Kelompok Usia -->
        <div class="card">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Distribusi Kelompok Usia
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="usia_0_14">0 - 14 Tahun (Anak-anak)</label>
                    <input type="number" id="usia_0_14" name="usia_0_14" class="form-control" value="<?= (int)($stats['usia_0_14'] ?? 0) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="usia_15_24">15 - 24 Tahun (Remaja/Pemuda)</label>
                    <input type="number" id="usia_15_24" name="usia_15_24" class="form-control" value="<?= (int)($stats['usia_15_24'] ?? 0) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="usia_25_44">25 - 44 Tahun (Dewasa)</label>
                    <input type="number" id="usia_25_44" name="usia_25_44" class="form-control" value="<?= (int)($stats['usia_25_44'] ?? 0) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="usia_45_64">45 - 64 Tahun (Paruh Baya)</label>
                    <input type="number" id="usia_45_64" name="usia_45_64" class="form-control" value="<?= (int)($stats['usia_45_64'] ?? 0) ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="usia_65_plus">65+ Tahun (Lanjut Usia)</label>
                <input type="number" id="usia_65_plus" name="usia_65_plus" class="form-control" value="<?= (int)($stats['usia_65_plus'] ?? 0) ?>" required>
            </div>
        </div>

        <!-- Mata Pencaharian -->
        <div class="card">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Mata Pencaharian Utama
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="petani">Petani / Pekebun</label>
                    <input type="number" id="petani" name="petani" class="form-control" value="<?= (int)($stats['petani'] ?? 0) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="pedagang">Pedagang</label>
                    <input type="number" id="pedagang" name="pedagang" class="form-control" value="<?= (int)($stats['pedagang'] ?? 0) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="pns">PNS / TNI / POLRI</label>
                    <input type="number" id="pns" name="pns" class="form-control" value="<?= (int)($stats['pns'] ?? 0) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="wiraswasta">Wiraswasta / Jasa</label>
                    <input type="number" id="wiraswasta" name="wiraswasta" class="form-control" value="<?= (int)($stats['wiraswasta'] ?? 0) ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="lain_lain">Lain-lain / Belum Bekerja</label>
                <input type="number" id="lain_lain" name="lain_lain" class="form-control" value="<?= (int)($stats['lain_lain'] ?? 0) ?>" required>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem; margin-bottom: 2rem;">
        <button type="submit" class="btn btn-primary" style="padding: 0.8rem 2rem; font-size: 1rem;">
            Simpan Seluruh Data Statistik
        </button>
    </div>
</form>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
