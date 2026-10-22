<?php
require_once __DIR__ . '/auth.php';
requireAuth();

$currentUser = currentUser();
$settings = getAllSettings();
$siteName = $settings['site_name'] ?? 'Desa Bragang';
$adminTitle = isset($adminTitle) ? $adminTitle . ' — Admin ' . $siteName : 'Admin Panel — ' . $siteName;

// Helper to determine active sidebar item
$currentAdminPage = basename($_SERVER['PHP_SELF'], '.php');
function isAdminActive($pageName) {
    global $currentAdminPage;
    return $currentAdminPage === $pageName ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($adminTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= baseUrl('/assets/css/admin.css') ?>">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <a href="<?= baseUrl('/admin/index.php') ?>" class="sidebar-logo">
                    <svg width="28" height="28" viewBox="0 0 32 32" fill="none">
                        <rect width="32" height="32" rx="6" fill="#1B4332"/>
                        <path d="M16 6L8 12V26H24V12L16 6Z" fill="#D4A373"/>
                        <rect x="13" y="18" width="6" height="8" rx="1" fill="#1B4332"/>
                    </svg>
                    <span><?= e($siteName) ?></span>
                    <span class="tag">ADMIN</span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-category">Utama</div>
                <a href="<?= baseUrl('/admin/index.php') ?>" class="sidebar-link <?= isAdminActive('index') ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Dashboard
                </a>
                <a href="<?= baseUrl('/admin/settings.php') ?>" class="sidebar-link <?= isAdminActive('settings') ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Pengaturan Web
                </a>

                <div class="nav-category">Konten Profil</div>
                <a href="<?= baseUrl('/admin/sejarah.php') ?>" class="sidebar-link <?= isAdminActive('sejarah') ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Sejarah Desa
                </a>
                <a href="<?= baseUrl('/admin/wilayah.php') ?>" class="sidebar-link <?= isAdminActive('wilayah') ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Wilayah Dusun
                </a>
                <a href="<?= baseUrl('/admin/struktur.php') ?>" class="sidebar-link <?= isAdminActive('struktur') ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Struktur Organisasi
                </a>

                <div class="nav-category">Fasilitas & Data</div>
                <a href="<?= baseUrl('/admin/pendidikan.php') ?>" class="sidebar-link <?= isAdminActive('pendidikan') ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 1.1 2.7 3 6 3s6-1.9 6-3v-5"/></svg>
                    Pendidikan
                </a>
                <a href="<?= baseUrl('/admin/masjid.php') ?>" class="sidebar-link <?= isAdminActive('masjid') ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                    Masjid
                </a>
                <a href="<?= baseUrl('/admin/statistik.php') ?>" class="sidebar-link <?= isAdminActive('statistik') ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    Statistik Penduduk
                </a>

                <div class="nav-category">Layanan</div>
                <a href="<?= baseUrl('/admin/jam-kerja.php') ?>" class="sidebar-link <?= isAdminActive('jam-kerja') ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Jam Kerja
                </a>
                <a href="<?= baseUrl('/admin/lokasi.php') ?>" class="sidebar-link <?= isAdminActive('lokasi') ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
                    Lokasi Kantor
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="<?= baseUrl('/admin/logout.php') ?>" class="sidebar-link" style="padding-left: 0; color: #ff8585;" onclick="return confirm('Apakah Anda yakin ingin keluar dari admin panel?')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Keluar (Logout)
                </a>
            </div>
        </aside>

        <!-- Main Body -->
        <div class="admin-main">
            <!-- Topbar -->
            <header class="admin-topbar">
                <div class="topbar-left">
                    <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle Sidebar">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </button>
                    <span class="topbar-title">Panel Administrasi Desa</span>
                </div>
                <div class="topbar-right">
                    <a href="<?= baseUrl('/') ?>" target="_blank" class="btn-public-view">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        Lihat Website
                    </a>
                    <div class="user-profile">
                        <div class="user-avatar"><?= strtoupper(substr($currentUser['nama'] ?? 'A', 0, 1)) ?></div>
                        <div class="user-info">
                            <div class="user-name"><?= e($currentUser['nama'] ?? 'Admin') ?></div>
                            <div class="user-role">@<?= e($currentUser['username'] ?? 'admin') ?></div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Body Content -->
            <main class="admin-content">
                <?php $flash = getFlash(); if ($flash): ?>
                <div class="alert alert-<?= $flash['type'] === 'danger' ? 'danger' : 'success' ?>">
                    <?php if ($flash['type'] === 'danger'): ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <?php else: ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <?php endif; ?>
                    <span><?= e($flash['message']) ?></span>
                </div>
                <?php endif; ?>
