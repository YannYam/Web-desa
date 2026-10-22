<?php
/**
 * Admin Lokasi & Kontak Kantor — Desa Bragang
 */
$adminTitle = 'Kelola Lokasi Kantor';
require_once __DIR__ . '/includes/admin_header.php';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keys = ['alamat', 'telepon', 'email', 'latitude', 'longitude'];

    $stmt = $db->prepare('REPLACE INTO settings (`key`, `value`) VALUES (:key, :val)');

    foreach ($keys as $k) {
        if (isset($_POST[$k])) {
            $stmt->execute([
                ':key' => $k,
                ':val' => trim($_POST[$k])
            ]);
        }
    }

    setFlash('success', 'Informasi lokasi dan kontak kantor berhasil disimpan.');
    redirect('/admin/lokasi.php');
}

$settings = getAllSettings();
$lat = $settings['latitude'] ?? '-6.9378';
$lng = $settings['longitude'] ?? '112.9016';
?>

<div class="page-header-admin">
    <div>
        <h1>Kelola Lokasi & Kontak Kantor Desa</h1>
        <p>Atur alamat fisik, kontak pelayanan publik, dan titik koordinat GPS pada peta digital</p>
    </div>
</div>

<div class="grid-2">
    <!-- Form Card -->
    <div class="card">
        <div class="card-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
            Alamat & Koordinat Geografis
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label class="form-label" for="alamat">Alamat Lengkap Kantor Desa</label>
                <textarea id="alamat" name="alamat" class="form-control" rows="3" required><?= e($settings['alamat'] ?? 'Dsn Bragang Tengah, Desa Bragang, Kecamatan Klampis, Kabupaten Bangkalan') ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="telepon">Nomor Telepon / WhatsApp Pelayanan</label>
                    <input type="text" id="telepon" name="telepon" class="form-control" value="<?= e($settings['telepon'] ?? '') ?>" placeholder="Contoh: (031) 3041-xxx">
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email Resmi Desa</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= e($settings['email'] ?? '') ?>" placeholder="desa.bragang@gmail.com">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="latitude">Latitude (Garis Lintang)</label>
                    <input type="text" id="latitude" name="latitude" class="form-control" value="<?= e($lat) ?>" required placeholder="-6.9378">
                    <small style="color: var(--text-muted); font-size: 0.78rem;">Format desimal: -6.9378 (S)</small>
                </div>
                <div class="form-group">
                    <label class="form-label" for="longitude">Longitude (Garis Bujur)</label>
                    <input type="text" id="longitude" name="longitude" class="form-control" value="<?= e($lng) ?>" required placeholder="112.9016">
                    <small style="color: var(--text-muted); font-size: 0.78rem;">Format desimal: +112.9016 (E)</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 0.5rem;">
                Simpan Lokasi & Kontak
            </button>
        </form>
    </div>

    <!-- Map Preview Card -->
    <div class="card">
        <div class="card-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
            Pratinjau Peta Interaktif (OpenStreetMap)
        </div>
        <div style="border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border-color);">
            <iframe
                id="previewMap"
                width="100%"
                height="320"
                frameborder="0"
                scrolling="no"
                src="https://www.openstreetmap.org/export/embed.html?bbox=<?= ((float)$lng - 0.005) ?>%2C<?= ((float)$lat - 0.005) ?>%2C<?= ((float)$lng + 0.005) ?>%2C<?= ((float)$lat + 0.005) ?>&layer=mapnik&marker=<?= (float)$lat ?>%2C<?= (float)$lng ?>">
            </iframe>
        </div>
        <p style="margin-top: 0.75rem; font-size: 0.85rem; color: var(--text-muted);">
            Koordinat saat ini: <strong><?= e($lat) ?> S, <?= e($lng) ?> E</strong>. Peta diperbarui otomatis saat Anda menyimpan koordinat baru.
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
