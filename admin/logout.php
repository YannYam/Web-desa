<?php
/**
 * Admin Logout — Desa Bragang
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/helpers.php';

// Unset admin session
unset($_SESSION['admin_user']);
session_destroy();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

setFlash('success', 'Anda telah berhasil keluar dari panel admin.');
redirect('/admin/login.php');
