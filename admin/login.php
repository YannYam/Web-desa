<?php
/**
 * Admin Login — Desa Bragang
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';

// Redirect if already logged in
if (!empty($_SESSION['admin_user'])) {
    redirect('/admin/index.php');
}

$error = '';
$settings = getAllSettings();
$siteName = $settings['site_name'] ?? 'Desa Bragang';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Nama pengguna dan kata sandi wajib diisi.';
    } else {
        try {
            $db = getDB();
            $stmt = $db->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Successful login
                $_SESSION['admin_user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'nama' => $user['nama']
                ];
                setFlash('success', 'Selamat datang kembali, ' . $user['nama'] . '!');
                redirect('/admin/index.php');
            } else {
                $error = 'Nama pengguna atau kata sandi tidak sesuai.';
            }
        } catch (Exception $e) {
            $error = 'Terjadi kesalahan sistem: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin — <?= e($siteName) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= baseUrl('/assets/css/admin.css') ?>">
</head>
<body class="login-body">
    <div class="login-card">
        <div class="login-header">
            <svg width="40" height="40" viewBox="0 0 32 32" fill="none">
                <rect width="32" height="32" rx="8" fill="#FFFFFF" fill-opacity="0.15"/>
                <path d="M16 6L8 12V26H24V12L16 6Z" fill="#D4A373"/>
                <rect x="13" y="18" width="6" height="8" rx="1" fill="#1B4332"/>
            </svg>
            <h1>Portal Administrasi</h1>
            <p><?= e($siteName) ?>, Kec. <?= e($settings['kecamatan'] ?? '') ?></p>
        </div>

        <div class="login-body-content">
            <?php $flash = getFlash(); ?>
            <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] === 'danger' ? 'danger' : 'success' ?>">
                <?= e($flash['message']) ?>
            </div>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="alert alert-danger">
                <?= e($error) ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label" for="username">Nama Pengguna (Username)</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="admin" required autofocus value="<?= isset($username) ? e($username) : '' ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi (Password)</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem; padding: 0.75rem;">
                    Masuk ke Panel Admin
                </button>
            </form>

            <div class="login-footer-links">
                <a href="<?= baseUrl('/') ?>">← Kembali ke Halaman Utama Desa</a>
            </div>
        </div>
    </div>
</body>
</html>
