<?php
/**
 * Admin Masjid & Tempat Ibadah — Desa Bragang
 */
$adminTitle = 'Kelola Masjid';
require_once __DIR__ . '/includes/admin_header.php';

$db = getDB();

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $nama = trim($_POST['nama'] ?? '');
        $dusun = trim($_POST['dusun'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        if (!empty($nama) && !empty($dusun)) {
            $stmt = $db->prepare('INSERT INTO masjid (nama, dusun, alamat, sort_order) VALUES (?, ?, ?, ?)');
            $stmt->execute([$nama, $dusun, $alamat, $sortOrder]);
            setFlash('success', 'Masjid "' . $nama . '" berhasil ditambahkan.');
        } else {
            setFlash('danger', 'Nama masjid dan lokasi dusun wajib diisi.');
        }
        redirect('/admin/masjid.php');

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $nama = trim($_POST['nama'] ?? '');
        $dusun = trim($_POST['dusun'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        if ($id > 0 && !empty($nama) && !empty($dusun)) {
            $stmt = $db->prepare('UPDATE masjid SET nama = ?, dusun = ?, alamat = ?, sort_order = ? WHERE id = ?');
            $stmt->execute([$nama, $dusun, $alamat, $sortOrder, $id]);
            setFlash('success', 'Data masjid "' . $nama . '" berhasil diperbarui.');
        } else {
            setFlash('danger', 'Data masjid tidak lengkap.');
        }
        redirect('/admin/masjid.php');

    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $db->prepare('DELETE FROM masjid WHERE id = ?');
            $stmt->execute([$id]);
            setFlash('success', 'Masjid berhasil dihapus.');
        }
        redirect('/admin/masjid.php');
    }
}

// Fetch mosques and dusun options
$masjidList = $db->query('SELECT * FROM masjid ORDER BY sort_order ASC, id ASC')->fetchAll();
$dusunRows = $db->query('SELECT nama FROM wilayah ORDER BY id ASC')->fetchAll();

// Edit state if ?edit=ID
$editItem = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $db->prepare('SELECT * FROM masjid WHERE id = ?');
    $stmt->execute([$editId]);
    $editItem = $stmt->fetch();
}
?>

<div class="page-header-admin">
    <div>
        <h1>Kelola Masjid & Tempat Ibadah</h1>
        <p>Daftar masjid dan sarana peribadatan masyarakat di lingkungan Desa Bragang</p>
    </div>
</div>

<div class="grid-2">
    <!-- Form Card -->
    <div class="card">
        <div class="card-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            <?= $editItem ? 'Edit Masjid: ' . e($editItem['nama']) : 'Tambah Masjid Baru' ?>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label class="form-label" for="nama">Nama Masjid</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Contoh: Masjid Al-Istiqomah" value="<?= e($editItem['nama'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="dusun">Lokasi Dusun</label>
                <select id="dusun" name="dusun" class="form-control" required>
                    <option value="">-- Pilih Dusun --</option>
                    <?php foreach ($dusunRows as $dr): 
                        $cleanDsn = preg_replace('/^Dsn\s+/i', '', $dr['nama']);
                    ?>
                    <option value="<?= e($cleanDsn) ?>" <?= ($editItem['dusun'] ?? '') === $cleanDsn ? 'selected' : '' ?>>Dsn <?= e($cleanDsn) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="alamat">Alamat / Keterangan Lokasi</label>
                <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Contoh: Dsn Tanggungan, Desa Bragang" value="<?= e($editItem['alamat'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="sort_order">Urutan Tampil</label>
                <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= (int)($editItem['sort_order'] ?? (count($masjidList) + 1)) ?>">
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <?= $editItem ? 'Simpan Perubahan' : 'Tambahkan Masjid' ?>
                </button>
                <?php if ($editItem): ?>
                <a href="<?= baseUrl('/admin/masjid.php') ?>" class="btn btn-secondary">Batal Edit</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-title">
            Daftar Masjid (<?= count($masjidList) ?> Tempat Ibadah)
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Masjid</th>
                        <th>Dusun</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($masjidList)): ?>
                    <tr><td colspan="4" style="text-align:center; color: var(--text-muted);">Belum ada data masjid.</td></tr>
                    <?php else: foreach ($masjidList as $i => $m): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <strong><?= e($m['nama']) ?></strong>
                            <?php if (!empty($m['alamat'])): ?>
                            <div style="font-size: 0.8rem; color: var(--text-muted);"><?= e($m['alamat']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge badge-green">Dsn <?= e($m['dusun']) ?></span></td>
                        <td style="text-align: right;">
                            <div class="table-actions" style="justify-content: flex-end;">
                                <a href="<?= baseUrl('/admin/masjid.php?edit=' . $m['id']) ?>" class="btn btn-sm btn-secondary" title="Edit">
                                    Edit
                                </a>
                                <form method="POST" action="<?= baseUrl('/admin/masjid.php') ?>" style="display:inline-block;" onsubmit="return confirm('Hapus masjid <?= e($m['nama']) ?>?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $m['id'] ?>">
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
