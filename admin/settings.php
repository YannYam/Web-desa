<?php
/**
 * Admin Site Settings — Desa Bragang
 */
$adminTitle = 'Pengaturan Situs';
require_once __DIR__ . '/includes/admin_header.php';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'save_settings';

    if ($action === 'save_settings') {
        $allowedKeys = ['site_name', 'tagline', 'kecamatan', 'kabupaten', 'provinsi', 'kepala_desa', 'welcome_message'];
        
        $stmt = $db->prepare('REPLACE INTO settings (`key`, `value`) VALUES (:key, :val)');
        
        foreach ($allowedKeys as $key) {
            if (isset($_POST[$key])) {
                $stmt->execute([
                    ':key' => $key,
                    ':val' => trim($_POST[$key])
                ]);
            }
        }
        
        setFlash('success', 'Pengaturan situs berhasil diperbarui.');
        redirect('/admin/settings.php');
    } elseif ($action === 'change_password') {
        $oldPass = $_POST['old_password'] ?? '';
        $newPass = $_POST['new_password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';

        $userStmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $userStmt->execute([$currentUser['id']]);
        $user = $userStmt->fetch();

        if (!$user || !password_verify($oldPass, $user['password'])) {
            setFlash('danger', 'Kata sandi lama tidak sesuai.');
        } elseif (strlen($newPass) < 6) {
            setFlash('danger', 'Kata sandi baru minimal 6 karakter.');
        } elseif ($newPass !== $confirmPass) {
            setFlash('danger', 'Konfirmasi kata sandi baru tidak cocok.');
        } else {
            $newHash = password_hash($newPass, PASSWORD_BCRYPT);
            $upStmt = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
            $upStmt->execute([$newHash, $currentUser['id']]);
            setFlash('success', 'Kata sandi berhasil diganti.');
        }
        redirect('/admin/settings.php');
    }
}

$settings = getAllSettings();
?>

<div class="page-header-admin">
    <div>
        <h1>Pengaturan Situs</h1>
        <p>Sesuaikan identitas website, informasi umum desa, dan akun administrator</p>
    </div>
</div>

<div class="grid-2">
    <!-- General Settings Form -->
    <div class="card">
        <div class="card-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Identitas Website & Desa
        </div>
        <form method="POST" action="">
            <input type="hidden" name="action" value="save_settings">

            <div class="form-group">
                <label class="form-label" for="site_name">Nama Website / Portal Desa</label>
                <input type="text" id="site_name" name="site_name" class="form-control" value="<?= e($settings['site_name'] ?? 'Desa Bragang') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="tagline">Slogan / Tagline Desa</label>
                <input type="text" id="tagline" name="tagline" class="form-control" value="<?= e($settings['tagline'] ?? '') ?>" placeholder="Contoh: Melayani dengan Sepenuh Hati">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="kecamatan">Kecamatan</label>
                    <input type="text" id="kecamatan" name="kecamatan" class="form-control" value="<?= e($settings['kecamatan'] ?? 'Klampis') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="kabupaten">Kabupaten</label>
                    <input type="text" id="kabupaten" name="kabupaten" class="form-control" value="<?= e($settings['kabupaten'] ?? 'Bangkalan') ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="provinsi">Provinsi</label>
                <input type="text" id="provinsi" name="provinsi" class="form-control" value="<?= e($settings['provinsi'] ?? 'Jawa Timur') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="kepala_desa">Nama Kepala Desa</label>
                <input type="text" id="kepala_desa" name="kepala_desa" class="form-control" value="<?= e($settings['kepala_desa'] ?? 'Busiri') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="welcome_message">Sambutan Kepala Desa</label>
                <textarea id="welcome_message" name="welcome_message" class="form-control" rows="4"><?= e($settings['welcome_message'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <!-- Password Change Form -->
    <div class="card">
        <div class="card-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1B4332" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Ganti Kata Sandi Akun
        </div>
        <form method="POST" action="">
            <input type="hidden" name="action" value="change_password">

            <div class="form-group">
                <label class="form-label" for="old_password">Kata Sandi Saat Ini</label>
                <input type="password" id="old_password" name="old_password" class="form-control" required placeholder="••••••••">
            </div>

            <div class="form-group">
                <label class="form-label" for="new_password">Kata Sandi Baru</label>
                <input type="password" id="new_password" name="new_password" class="form-control" minlength="6" required placeholder="Minimal 6 karakter">
            </div>

            <div class="form-group">
                <label class="form-label" for="confirm_password">Konfirmasi Kata Sandi Baru</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" minlength="6" required placeholder="Ulangi kata sandi baru">
            </div>

            <button type="submit" class="btn btn-secondary">Perbarui Kata Sandi</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
