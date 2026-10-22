<?php
/**
 * Admin Struktur Organisasi Pemerintah Desa — Desa Bragang
 */
$adminTitle = 'Kelola Struktur Organisasi';
require_once __DIR__ . '/includes/admin_header.php';

$db = getDB();

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $nama = trim($_POST['nama'] ?? '');
        $jabatan = trim($_POST['jabatan'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        if (!empty($nama) && !empty($jabatan)) {
            $stmt = $db->prepare('INSERT INTO struktur (nama, jabatan, sort_order) VALUES (?, ?, ?)');
            $stmt->execute([$nama, $jabatan, $sortOrder]);
            setFlash('success', 'Aparatur desa "' . $nama . '" (' . $jabatan . ') berhasil ditambahkan.');
        } else {
            setFlash('danger', 'Nama dan jabatan wajib diisi.');
        }
        redirect('/admin/struktur.php');

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $nama = trim($_POST['nama'] ?? '');
        $jabatan = trim($_POST['jabatan'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        if ($id > 0 && !empty($nama) && !empty($jabatan)) {
            $stmt = $db->prepare('UPDATE struktur SET nama = ?, jabatan = ?, sort_order = ? WHERE id = ?');
            $stmt->execute([$nama, $jabatan, $sortOrder, $id]);
            setFlash('success', 'Data pejabat "' . $nama . '" berhasil diperbarui.');
        } else {
            setFlash('danger', 'Data pejabat tidak lengkap.');
        }
        redirect('/admin/struktur.php');

    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $db->prepare('DELETE FROM struktur WHERE id = ?');
            $stmt->execute([$id]);
            setFlash('success', 'Data pejabat berhasil dihapus.');
        }
        redirect('/admin/struktur.php');
    }
}

// Fetch all officials
$strukturList = $db->query('SELECT * FROM struktur ORDER BY sort_order ASC, id ASC')->fetchAll();

// Edit state if ?edit=ID
$editItem = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $db->prepare('SELECT * FROM struktur WHERE id = ?');
    $stmt->execute([$editId]);
    $editItem = $stmt->fetch();
}

$commonRoles = [
    'Kepala Desa',
    'Sekretaris Desa',
    'Kasi Pemerintahan dan Kemasyarakatan',
    'Kasi Pelaksanaan dan Kesejahteraan Masyarakat',
    'Kaur Keuangan',
    'Kaur Umum Dan Perencanaan',
    'Kadus Senjang',
    'Kadus Tanggungan',
    'Kadus Bragang Tengah',
    'Kadus Duko Nangka',
    'Kadus Bagunung'
];
?>

<div class="page-header-admin">
    <div>
        <h1>Kelola Struktur Organisasi Desa</h1>
        <p>Susunan aparatur dan perangkat Pemerintah Desa Bragang</p>
    </div>
</div>

<div class="grid-2">
    <!-- Form Card -->
    <div class="card">
        <div class="card-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <?= $editItem ? 'Edit Pejabat: ' . e($editItem['nama']) : 'Tambah Perangkat Desa Baru' ?>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label class="form-label" for="nama">Nama Lengkap Pejabat</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Contoh: Busiri" value="<?= e($editItem['nama'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="jabatan">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" list="roleList" class="form-control" placeholder="Pilih atau ketik jabatan..." value="<?= e($editItem['jabatan'] ?? '') ?>" required>
                <datalist id="roleList">
                    <?php foreach ($commonRoles as $cr): ?>
                    <option value="<?= e($cr) ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>

            <div class="form-group">
                <label class="form-label" for="sort_order">Urutan Hierarki (1 = Teratas)</label>
                <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= (int)($editItem['sort_order'] ?? (count($strukturList) + 1)) ?>" required>
                <small style="color: var(--text-muted); display: block; margin-top: 0.3rem;">Urutan: 1 (Kepala Desa), 2 (Sekdes), 3-6 (Kasi/Kaur), 7+ (Kadus)</small>
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <?= $editItem ? 'Simpan Perubahan' : 'Tambahkan Perangkat' ?>
                </button>
                <?php if ($editItem): ?>
                <a href="<?= baseUrl('/admin/struktur.php') ?>" class="btn btn-secondary">Batal Edit</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-title">
            Daftar Perangkat Desa (<?= count($strukturList) ?> Orang)
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Urutan</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($strukturList)): ?>
                    <tr><td colspan="4" style="text-align:center; color: var(--text-muted);">Belum ada data perangkat desa.</td></tr>
                    <?php else: foreach ($strukturList as $i => $s): ?>
                    <tr>
                        <td><span class="badge" style="background: #E2E8F0;"><?= (int)$s['sort_order'] ?></span></td>
                        <td><strong><?= e($s['nama']) ?></strong></td>
                        <td>
                            <?php 
                            $jab = strtolower($s['jabatan']);
                            $bClass = 'badge';
                            if (strpos($jab, 'kepala desa') !== false) $bClass = 'badge badge-green';
                            elseif (strpos($jab, 'sekretaris') !== false) $bClass = 'badge badge-amber';
                            ?>
                            <span class="<?= $bClass ?>"><?= e($s['jabatan']) ?></span>
                        </td>
                        <td style="text-align: right;">
                            <div class="table-actions" style="justify-content: flex-end;">
                                <a href="<?= baseUrl('/admin/struktur.php?edit=' . $s['id']) ?>" class="btn btn-sm btn-secondary" title="Edit">
                                    Edit
                                </a>
                                <form method="POST" action="<?= baseUrl('/admin/struktur.php') ?>" style="display:inline-block;" onsubmit="return confirm('Hapus perangkat <?= e($s['nama']) ?>?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $s['id'] ?>">
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
