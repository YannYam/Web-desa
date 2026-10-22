<?php
/**
 * Admin Authentication Middleware — Desa Bragang
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';

/**
 * Check if the user is authenticated, redirect to login if not.
 */
function requireAuth() {
    if (empty($_SESSION['admin_user'])) {
        setFlash('danger', 'Silakan masuk terlebih dahulu untuk mengakses panel admin.');
        redirect('/admin/login.php');
    }
}

/**
 * Return current authenticated admin details.
 */
function currentUser() {
    return $_SESSION['admin_user'] ?? null;
}

/**
 * Check if user is logged in without redirecting.
 */
function isLoggedIn() {
    return !empty($_SESSION['admin_user']);
}
