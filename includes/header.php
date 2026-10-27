<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

$settings = getAllSettings();
$siteName = $settings['site_name'] ?? 'Desa Bragang';
$tagline = $settings['tagline'] ?? '';
$pageTitle = isset($pageTitle) ? $pageTitle . ' — ' . $siteName : $siteName;
$pageDescription = isset($pageDescription) ? $pageDescription : $tagline;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($pageDescription) ?>">
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/jpeg" href="assets/images/logo.jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= baseUrl('/assets/css/style.css') ?>">
</head>
<body>
    <header class="site-header" id="site-header">
        <div class="container header-inner">
            <a href="<?= baseUrl('/') ?>" class="logo" id="logo">
                <img src="assets/images/logo.jpeg" alt="logo" style="width: 40px; height: 40px;">
                <span class="logo-text"><?= e($siteName) ?></span>
            </a>
            <button class="menu-toggle" id="menu-toggle" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>
            <nav class="main-nav" id="main-nav">
                <a href="<?= baseUrl('/') ?>" class="nav-link <?= isActivePage('index') ?>">Beranda</a>
                <a href="<?= baseUrl('/sejarah.php') ?>" class="nav-link <?= isActivePage('sejarah') ?>">Sejarah</a>
                <a href="<?= baseUrl('/wilayah.php') ?>" class="nav-link <?= isActivePage('wilayah') ?>">Wilayah</a>
                <a href="<?= baseUrl('/pendidikan.php') ?>" class="nav-link <?= isActivePage('pendidikan') ?>">Pendidikan</a>
                <a href="<?= baseUrl('/masjid.php') ?>" class="nav-link <?= isActivePage('masjid') ?>">Masjid</a>
                <a href="<?= baseUrl('/struktur.php') ?>" class="nav-link <?= isActivePage('struktur') ?>">Struktur</a>
                <a href="<?= baseUrl('/statistik.php') ?>" class="nav-link <?= isActivePage('statistik') ?>">Statistik</a>
                <a href="<?= baseUrl('/jam-kerja.php') ?>" class="nav-link <?= isActivePage('jam-kerja') ?>">Jam Kerja</a>
                <a href="<?= baseUrl('/lokasi.php') ?>" class="nav-link <?= isActivePage('lokasi') ?>">Lokasi</a>
            </nav>
        </div>
    </header>
    <main>
