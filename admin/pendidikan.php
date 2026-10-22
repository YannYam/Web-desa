<?php
/**
 * Admin Lembaga Pendidikan — Desa Bragang
 */
$adminTitle = 'Kelola Lembaga Pendidikan';
require_once __DIR__ . '/includes/admin_header.php';

$db = getDB();

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $nama = trim($_POST['nama'] ?? '');
        $jenis = trim($_POST['jenis'] ?? '');
        $dusun = trim($_POST['dusun'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        if (!empty($nama) && !empty($dusun)) {
            $stmt = $db->prepare('INSERT INTO pendidikan (nama, jenis, dusun, alamat, sort_order) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$nama, $jenis, $dusun, $alamat, $sortOrder]);
            setFlash('success', 'Lembaga pendidikan "' . $nama . '" berhasil ditambahkan.');
        } else {
            setFlash('danger', 'Nama lembaga dan lokasi dusun wajib diisi.');
        }
        redirect('/admin/pendidikan.php');

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $nama = trim($_POST['nama'] ?? '');
        $jenis = trim($_POST['jenis'] ?? '');
        $dusun = trim($_POST['dusun'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        if ($id > 0 && !empty($nama) && !empty($dusun)) {
            $stmt = $db->prepare('UPDATE pendidikan SET nama = ?, jenis = ?, dusun = ?, alamat = ?, sort_order = ? WHERE id = ?');
            $stmt->execute([$nama, $jenis, $dusun, $alamat, $sortOrder, $id]);
            setFlash('success', 'Data pendidikan "' . $nama . '" berhasil diperbarui.');
        } else {
            setFlash('danger', 'Data lembaga tidak lengkap.');
        }
        redirect('/admin/pendidikan.php');

    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $db->prepare('DELETE FROM pendidikan WHERE id = ?');
            $stmt->execute([$id]);
            setFlash('success', 'Lembaga pendidikan berhasil dihapus.');
        }
        redirect('/admin/pendidikan.php');
    }
}

// Fetch schools and dusun list
$pendidikanList = $db->query('SELECT * FROM pendidikan ORDER BY sort_order ASC, id ASC')->fetchAll();
$dusunRows = $db->query('SELECT nama FROM wilayah ORDER BY id ASC')->fetchAll();

// Edit state if ?edit=ID
$editItem = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $db->prepare('SELECT * FROM pendidikan WHERE id = ?');
    $stmt->execute([$editId]);
    $editItem = $stmt->fetch();
}

$jenisOptions = ['TK', 'SD', 'MI', 'SMP', 'SMK', 'Madrasah', 'Pondok Pesantren', 'Lainnya'];
?>

<div class="page-header-admin">
    <div>
        <h1>Kelola Lembaga Pendidikan</h1>
        <p>Daftar sarana pendidikan formal & non-formal di lingkungan Desa Bragang</p>
    </div>
</div>

<div class="grid-2">
    <!-- Form Card -->
    <div class="card">
        <div class="card-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 1.1 2.7 3 6 3s6-1.9 6-3v-5"/></svg>
            <?= $editItem ? 'Edit Lembaga: ' . e($editItem['nama']) : 'Tambah Lembaga Pendidikan Baru' ?>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label class="form-label" for="nama">Nama Lembaga Pendidikan</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Contoh: SMP Nurul Huda" value="<?= e($editItem['nama'] ?? '') ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="jenis">Tingkat / Jenis</label>
                    <select id="jenis" name="jenis" class="form-control" required>
                        <?php foreach ($jenisOptions as $opt): ?>
                        <option value="<?= e($opt) ?>" <?= ($editItem['jenis'] ?? '') === $opt ? 'selected' : '' ?>><?= e($opt) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="dusun">Lokasi Dusun</label>
                    <select id="dusun" name="dusun" class="form-control" required>
                        <option value="">-- Pilih Dusun --</option>
                        <?php foreach ($dusunRows as $dr): 
                            // Normalize "Dsn Tanggungan" to "Tanggungan" or vice versa
                            $cleanDsn = preg_replace('/^Dsn\s+/i', '', $dr['nama']);
                        ?>
                        <option value="<?= e($cleanDsn) ?>" <?= ($editItem['dusun'] ?? '') === $cleanDsn ? 'selected' : '' ?>>Dsn <?= e($cleanDsn) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="alamat">Alamat Lengkap</label>
                <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Contoh: Dsn Tanggungan, Desa Bragang" value="<?= e($editItem['alamat'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="sort_order">Nomor Urutan Tampil</label>
                <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= (int)($editItem['sort_order'] ?? (count($pendidikanList) + 1)) ?>">
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <?= $editItem ? 'Simpan Perubahan' : 'Tambahkan Lembaga' ?>
                </button>
                <?php if ($editItem): ?>
                <a href="<?= baseUrl('/admin/pendidikan.php') ?>" class="btn btn-secondary">Batal Edit</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-title">
            Daftar Sekolah & Madrasah (<?= count($pendidikanList) ?> Lembaga)
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Lembaga</th>
                        <th>Jenis</th>
                        <th>Dusun</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendidikanList)): ?>
                    <tr><td colspan="5" style="text-align:center; color: var(--text-muted);">Belum ada data lembaga pendidikan.</td></tr>
                    <?php else: foreach ($pendidikanList as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <strong><?= e($p['nama']) ?></strong>
                            <?php if (!empty($p['alamat'])): ?>
                            <div style="font-size: 0.8rem; color: var(--text-muted);"><?= e($p['alamat']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge badge-amber"><?= e($p['jenis']) ?></span></td>
                        <td>Dsn <?= e($p['dusun']) ?></td>
                        <td style="text-align: right;">
                            <div class="table-actions" style="justify-content: flex-end;">
                                <a href="<?= baseUrl('/admin/pendidikan.php?edit=' . $p['id']) ?>" class="btn btn-sm btn-secondary" title="Edit">
                                    Edit
                                </a>
                                <form method="POST" action="<?= baseUrl('/admin/pendidikan.php') ?>" style="display:inline-block;" onsubmit="return confirm('Hapus lembaga <?= e($p['nama']) ?>?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
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
