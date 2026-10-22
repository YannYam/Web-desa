<?php
/**
 * Database Connection — Desa Bragang
 * Mendukung MySQL (phpMyAdmin / XAMPP / Laragon / cPanel) dan SQLite.
 */

// ========================================================
// KONFIGURASI DATABASE
// ========================================================
// Ubah DB_DRIVER ke 'mysql' jika ingin menggunakan phpMyAdmin / XAMPP / Laragon.
// Ubah ke 'sqlite' jika ingin database file lokal tanpa server database.
if (!defined('DB_DRIVER')) {
    define('DB_DRIVER', 'mysql'); 
}

// Konfigurasi MySQL (hanya dipakai jika DB_DRIVER = 'mysql')
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_PORT')) define('DB_PORT', '3306');
if (!defined('DB_NAME')) define('DB_NAME', 'desa_bragang_mysql');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');

/**
 * Mendapatkan koneksi PDO (Singleton)
 */
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        if (DB_DRIVER === 'mysql') {
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            try {
                $pdo = new PDO($dsn, DB_USER, DB_PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('<strong>Koneksi MySQL Gagal:</strong> ' . htmlspecialchars($e->getMessage()) . '<br><br>Pastikan MySQL di XAMPP/Laragon aktif dan database <code>' . DB_NAME . '</code> sudah di-import di phpMyAdmin.');
            }
        } else {
            // Driver SQLite
            $dbPath = __DIR__ . '/../database/desa_bragang.db';
            if (!file_exists($dbPath)) {
                die('Database SQLite belum ditemukan. Jalankan perintah: <code>php database/install.php</code>');
            }
            $pdo = new PDO('sqlite:' . $dbPath);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
    }
    return $pdo;
}

/**
 * Get a setting value by key.
 */
function getSetting($key, $default = '') {
    $db = getDB();
    $stmt = $db->prepare('SELECT `value` FROM `settings` WHERE `key` = ?');
    $stmt->execute([$key]);
    $row = $stmt->fetch();
    return $row ? $row['value'] : $default;
}

/**
 * Get all settings as key => value array.
 */
function getAllSettings() {
    $db = getDB();
    $stmt = $db->query('SELECT `key`, `value` FROM `settings`');
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['key']] = $row['value'];
    }
    return $settings;
}
