<?php
/**
 * Admin Wilayah Dusun — Desa Bragang
 */
$adminTitle = 'Kelola Wilayah Dusun';
require_once __DIR__ . '/includes/admin_header.php';

$db = getDB();

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $nama = trim($_POST['nama'] ?? '');
        $rt = (int)($_POST['jumlah_rt'] ?? 0);
        $rw = (int)($_POST['jumlah_rw'] ?? 0);
        $luas = trim($_POST['luas'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');

        if (!empty($nama)) {
            $stmt = $db->prepare('INSERT INTO wilayah (nama, jumlah_rt, jumlah_rw, luas, keterangan) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$nama, $rt, $rw, $luas, $keterangan]);
            setFlash('success', 'Dusun "' . $nama . '" berhasil ditambahkan.');
        } else {
            setFlash('danger', 'Nama dusun wajib diisi.');
        }
        redirect('/admin/wilayah.php');

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $nama = trim($_POST['nama'] ?? '');
        $rt = (int)($_POST['jumlah_rt'] ?? 0);
        $rw = (int)($_POST['jumlah_rw'] ?? 0);
        $luas = trim($_POST['luas'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');

        if ($id > 0 && !empty($nama)) {
            $stmt = $db->prepare('UPDATE wilayah SET nama = ?, jumlah_rt = ?, jumlah_rw = ?, luas = ?, keterangan = ? WHERE id = ?');
            $stmt->execute([$nama, $rt, $rw, $luas, $keterangan, $id]);
            setFlash('success', 'Data dusun "' . $nama . '" berhasil diperbarui.');
        } else {
            setFlash('danger', 'Data dusun tidak lengkap.');
        }
        redirect('/admin/wilayah.php');

    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $db->prepare('DELETE FROM wilayah WHERE id = ?');
            $stmt->execute([$id]);
            setFlash('success', 'Dusun berhasil dihapus.');
        }
        redirect('/admin/wilayah.php');
    }
}

// Fetch all dusun
$dusunList = $db->query('SELECT * FROM wilayah ORDER BY id ASC')->fetchAll();

// Edit state if ?edit=ID
$editItem = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $db->prepare('SELECT * FROM wilayah WHERE id = ?');
    $stmt->execute([$editId]);
    $editItem = $stmt->fetch();
}
?>

<div class="page-header-admin">
    <div>
        <h1>Kelola Wilayah Dusun</h1>
        <p>Manajemen wilayah administratif dusun, data RT/RW, dan luas daerah Desa Bragang</p>
    </div>
</div>

<div class="grid-2">
    <!-- Form Card: Add or Edit -->
    <div class="card">
        <div class="card-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <?= $editItem ? 'Edit Dusun: ' . e($editItem['nama']) : 'Tambah Dusun Baru' ?>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label class="form-label" for="nama">Nama Dusun</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Contoh: Dsn Bergunung" value="<?= e($editItem['nama'] ?? '') ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="jumlah_rt">Jumlah RT</label>
                    <input type="number" id="jumlah_rt" name="jumlah_rt" class="form-control" min="0" value="<?= (int)($editItem['jumlah_rt'] ?? 0) ?>">
                </div>
                <div class="form-group">
                    <label class="form-label" for="jumlah_rw">Jumlah RW</label>
                    <input type="number" id="jumlah_rw" name="jumlah_rw" class="form-control" min="0" value="<?= (int)($editItem['jumlah_rw'] ?? 0) ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="luas">Luas Wilayah</label>
                <input type="text" id="luas" name="luas" class="form-control" placeholder="Contoh: 120 Ha" value="<?= e($editItem['luas'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="keterangan">Keterangan / Letak Geografis</label>
                <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Contoh: Wilayah dataran tinggi di bagian utara desa"><?= e($editItem['keterangan'] ?? '') ?></textarea>
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <?= $editItem ? 'Simpan Perubahan' : 'Tambahkan Dusun' ?>
                </button>
                <?php if ($editItem): ?>
                <a href="<?= baseUrl('/admin/wilayah.php') ?>" class="btn btn-secondary">Batal Edit</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-title">
            Daftar Dusun (<?= count($dusunList) ?> Wilayah)
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dusun</th>
                        <th>RT / RW</th>
                        <th>Luas</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dusunList)): ?>
                    <tr><td colspan="5" style="text-align:center; color: var(--text-muted);">Belum ada data dusun.</td></tr>
                    <?php else: foreach ($dusunList as $i => $d): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <strong><?= e($d['nama']) ?></strong>
                            <?php if (!empty($d['keterangan'])): ?>
                            <div style="font-size: 0.8rem; color: var(--text-muted);"><?= e($d['keterangan']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td><?= (int)$d['jumlah_rt'] ?> RT / <?= (int)$d['jumlah_rw'] ?> RW</td>
                        <td><?= e($d['luas'] ?: '-') ?></td>
                        <td style="text-align: right;">
                            <div class="table-actions" style="justify-content: flex-end;">
                                <a href="<?= baseUrl('/admin/wilayah.php?edit=' . $d['id']) ?>" class="btn btn-sm btn-secondary" title="Edit">
                                    Edit
                                </a>
                                <form method="POST" action="<?= baseUrl('/admin/wilayah.php') ?>" style="display:inline-block;" onsubmit="return confirm('Hapus dusun <?= e($d['nama']) ?>?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
