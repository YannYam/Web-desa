<?php
/**
 * Admin Jam Kerja — Desa Bragang
 */
$adminTitle = 'Kelola Jam Kerja';
require_once __DIR__ . '/includes/admin_header.php';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $days = $_POST['days'] ?? [];

    $stmt = $db->prepare('UPDATE jam_kerja SET jam_masuk = ?, jam_keluar = ?, keterangan = ? WHERE id = ?');

    foreach ($days as $id => $data) {
        $masuk = trim($data['jam_masuk'] ?? '');
        $keluar = trim($data['jam_keluar'] ?? '');
        $ket = trim($data['keterangan'] ?? '');

        $stmt->execute([$masuk, $keluar, $ket ?: null, (int)$id]);
    }

    setFlash('success', 'Jadwal jam kerja pelayanan berhasil diperbarui.');
    redirect('/admin/jam-kerja.php');
}

$jamList = $db->query('SELECT * FROM jam_kerja ORDER BY id ASC')->fetchAll();
?>

<div class="page-header-admin">
    <div>
        <h1>Kelola Jadwal Jam Kerja Kantor</h1>
        <p>Atur jadwal pelayanan administrasi kantor Desa Bragang untuk setiap hari kerja dan libur</p>
    </div>
</div>

<div class="card">
    <div class="card-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Jadwal Pelayanan Mingguan
    </div>

    <form method="POST" action="">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 140px;">Hari</th>
                        <th style="width: 180px;">Jam Buka / Masuk</th>
                        <th style="width: 180px;">Jam Tutup / Keluar</th>
                        <th>Keterangan Tambahan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jamList as $j): ?>
                    <tr>
                        <td>
                            <strong style="color: var(--primary-dark); font-size: 1rem;"><?= e($j['hari']) ?></strong>
                        </td>
                        <td>
                            <input type="text" name="days[<?= $j['id'] ?>][jam_masuk]" class="form-control" value="<?= e($j['jam_masuk']) ?>" placeholder="08:00 atau -">
                        </td>
                        <td>
                            <input type="text" name="days[<?= $j['id'] ?>][jam_keluar]" class="form-control" value="<?= e($j['jam_keluar']) ?>" placeholder="16:00 atau -">
                        </td>
                        <td>
                            <input type="text" name="days[<?= $j['id'] ?>][keterangan]" class="form-control" value="<?= e($j['keterangan'] ?? '') ?>" placeholder="Libur / Jam pendek / etc.">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.75rem;">
                Simpan Seluruh Jadwal
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
