<?php
/**
 * Helper Functions — Desa Bragang
 */

// Ensure session is started and output buffering is enabled to prevent "headers already sent"
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!ob_get_level()) {
    ob_start();
}

/**
 * Sanitize output for HTML.
 */
function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Get project base URL path relative to the domain host.
 * E.g. returns '/bragang' when in XAMPP htdocs/bragang, or '' when at domain root.
 */
function getBasePath() {
    static $basePath = null;
    if ($basePath !== null) {
        return $basePath;
    }

    $appRoot = str_replace('\\', '/', realpath(dirname(__DIR__)));
    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])
        ? str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']))
        : '';

    if ($docRoot && stripos($appRoot, $docRoot) === 0) {
        $sub = substr($appRoot, strlen($docRoot));
        $basePath = '/' . ltrim(str_replace('\\', '/', $sub), '/');
        $basePath = rtrim($basePath, '/');
    } else {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $scriptDir = preg_replace('#/(admin|includes)(/.*)?$#i', '', $scriptDir);
        $basePath = rtrim($scriptDir, '/');
    }

    return $basePath;
}

/**
 * Generate a full URL path from root, prepended with project base path.
 * e.g. baseUrl('/assets/css/style.css') => '/bragang/assets/css/style.css'
 */
function baseUrl($path = '') {
    $base = getBasePath();
    if ($path === '' || $path === '/') {
        return $base !== '' ? $base . '/' : '/';
    }
    return ($base !== '' ? $base : '') . '/' . ltrim($path, '/');
}

/**
 * Alias for baseUrl().
 */
function url($path = '') {
    return baseUrl($path);
}

/**
 * Redirect to a URL. Automatically handles project subfolders, cleans buffers, and falls back if headers were sent.
 */
function redirect($url) {
    if (!preg_match('#^https?://#i', $url)) {
        $base = getBasePath();
        if ($base !== '' && strpos($url, $base . '/') !== 0 && $url !== $base) {
            $url = baseUrl($url);
        }
    }

    // Discard any buffered HTML output so clean headers can be sent
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    if (!headers_sent()) {
        header('Location: ' . $url, true, 302);
    }

    // Bulletproof fallback so browser never stays blank
    echo '<!DOCTYPE html><html lang="id"><head><meta charset="utf-8">';
    echo '<meta http-equiv="refresh" content="0;url=' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">';
    echo '<script>window.location.replace(' . json_encode($url) . ');</script>';
    echo '<title>Mengalihkan...</title></head><body>';
    echo '<p>Sedang dialihkan ke <a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '</a>...</p>';
    echo '</body></html>';
    exit;
}

/**
 * Get the current page name from the URL.
 */
function currentPage() {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
    $base = getBasePath();
    if ($base !== '' && strpos($path, $base) === 0) {
        $path = substr($path, strlen($base));
    }
    $trimmed = trim($path, '/');
    if ($trimmed === '' || $trimmed === 'index.php') {
        return 'index';
    }
    return basename($trimmed, '.php');
}

/**
 * Check if current page matches.
 */
function isActivePage($page) {
    return currentPage() === $page ? 'active' : '';
}

/**
 * Flash message helpers using sessions.
 */
function setFlash($type, $message) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Format number with Indonesian thousands separator.
 */
function formatNumber($num) {
    return number_format((int)$num, 0, ',', '.');
}
