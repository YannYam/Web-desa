<?php
/**
 * Admin Sejarah Desa & Linimasa — Desa Bragang
 */
$adminTitle = 'Sejarah Desa';
require_once __DIR__ . '/includes/admin_header.php';

$db = getDB();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_sejarah') {
        $content = trim($_POST['content'] ?? '');
        if (!empty($content)) {
            // Check if record exists
            $check = $db->query('SELECT id FROM sejarah LIMIT 1')->fetch();
            if ($check) {
                $stmt = $db->prepare('UPDATE sejarah SET content = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?');
                $stmt->execute([$content, $check['id']]);
            } else {
                $stmt = $db->prepare('INSERT INTO sejarah (content) VALUES (?)');
                $stmt->execute([$content]);
            }
            setFlash('success', 'Narasi sejarah desa berhasil disimpan.');
        } else {
            setFlash('danger', 'Teks sejarah tidak boleh kosong.');
        }
        redirect('/admin/sejarah.php');

    } elseif ($action === 'add_timeline') {
        $year = trim($_POST['year'] ?? '');
        $event = trim($_POST['event'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        if (!empty($year) && !empty($event)) {
            $stmt = $db->prepare('INSERT INTO timeline (year, event, sort_order) VALUES (?, ?, ?)');
            $stmt->execute([$year, $event, $sortOrder]);
            setFlash('success', 'Peristiwa linimasa baru berhasil ditambahkan.');
        } else {
            setFlash('danger', 'Tahun dan uraian peristiwa wajib diisi.');
        }
        redirect('/admin/sejarah.php');

    } elseif ($action === 'edit_timeline') {
        $id = (int)($_POST['id'] ?? 0);
        $year = trim($_POST['year'] ?? '');
        $event = trim($_POST['event'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        if ($id > 0 && !empty($year) && !empty($event)) {
            $stmt = $db->prepare('UPDATE timeline SET year = ?, event = ?, sort_order = ? WHERE id = ?');
            $stmt->execute([$year, $event, $sortOrder, $id]);
            setFlash('success', 'Peristiwa linimasa berhasil diperbarui.');
        } else {
            setFlash('danger', 'Data tidak valid.');
        }
        redirect('/admin/sejarah.php');

    } elseif ($action === 'delete_timeline') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $db->prepare('DELETE FROM timeline WHERE id = ?');
            $stmt->execute([$id]);
            setFlash('success', 'Peristiwa linimasa berhasil dihapus.');
        }
        redirect('/admin/sejarah.php');
    }
}

// Fetch current history and timeline
$sejarah = $db->query('SELECT * FROM sejarah ORDER BY id DESC LIMIT 1')->fetch();
$timeline = $db->query('SELECT * FROM timeline ORDER BY sort_order ASC, year ASC')->fetchAll();
?>

<div class="page-header-admin">
    <div>
        <h1>Sejarah Desa & Linimasa</h1>
        <p>Kelola teks sejarah resmi dan jejak peristiwa penting Desa Bragang</p>
    </div>
</div>

<div class="grid-2">
    <!-- Sejarah Text -->
    <div class="card">
        <div class="card-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Narasi Sejarah Resmi Desa
        </div>
        <form method="POST" action="">
            <input type="hidden" name="action" value="update_sejarah">

            <div class="form-group">
                <label class="form-label" for="content">Isi Teks Sejarah</label>
                <textarea id="content" name="content" class="form-control" rows="12" required><?= e($sejarah['content'] ?? '') ?></textarea>
                <small style="color: var(--text-muted); display: block; margin-top: 0.4rem;">Gunakan pemisah baris untuk membuat paragraf baru.</small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Narasi Sejarah</button>
        </form>
    </div>

    <!-- Timeline Management -->
    <div>
        <!-- Add Timeline Form -->
        <div class="card">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Peristiwa Linimasa
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add_timeline">

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="year">Tahun / Periode</label>
                        <input type="text" id="year" name="year" class="form-control" placeholder="Contoh: 1945" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="sort_order">Urutan Tampil</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= count($timeline) + 1 ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="event">Deskripsi Peristiwa</label>
                    <textarea id="event" name="event" class="form-control" rows="3" placeholder="Pembangunan atau peristiwa penting..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-sm">Tambah ke Linimasa</button>
            </form>
        </div>

        <!-- Timeline List Table -->
        <div class="card">
            <div class="card-title">
                Daftar Linimasa (<?= count($timeline) ?> Peristiwa)
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 70px;">Urutan</th>
                            <th style="width: 80px;">Tahun</th>
                            <th>Peristiwa</th>
                            <th style="width: 100px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($timeline)): ?>
                        <tr><td colspan="4" style="text-align:center; color: var(--text-muted);">Belum ada data linimasa.</td></tr>
                        <?php else: foreach ($timeline as $t): ?>
                        <tr>
                            <td><?= (int)$t['sort_order'] ?></td>
                            <td><strong style="color: var(--primary);"><?= e($t['year']) ?></strong></td>
                            <td><?= e($t['event']) ?></td>
                            <td style="text-align: right;">
                                <form method="POST" action="" style="display:inline-block;" onsubmit="return confirm('Hapus peristiwa tahun <?= e($t['year']) ?>?')">
                                    <input type="hidden" name="action" value="delete_timeline">
                                    <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
