<?php
// ============================================================
// Luxella Spaces - Configuration
// ============================================================

// Database (MySQL / MariaDB)
define('DB_HOST', $_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? $_SERVER['DB_NAME'] ?? getenv('DB_NAME') ?: 'luxella');
define('DB_USER', $_ENV['DB_USER'] ?? $_SERVER['DB_USER'] ?? getenv('DB_USER') ?: 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? $_SERVER['DB_PASS'] ?? getenv('DB_PASS') ?: '');
define('DB_PORT', (int)($_ENV['DB_PORT'] ?? $_SERVER['DB_PORT'] ?? getenv('DB_PORT') ?: 3306));

// Business details (edit freely)
define('SITE_NAME', 'Luxella Spaces');
define('SITE_TAGLINE', 'Timeless elegance for modern living');
define('SITE_PHONE', getenv('SITE_PHONE') ?: '0776706980');
define('SITE_PHONE_INTL', getenv('SITE_PHONE_INTL') ?: '256776706980');
define('SITE_EMAIL', getenv('SITE_EMAIL') ?: 'hello@luxellaspaces.com');
define('SITE_LOCATION', getenv('SITE_LOCATION') ?: 'Kampala, Uganda');
define('SITE_DELIVERY', getenv('SITE_DELIVERY') ?: 'Nationwide delivery across Uganda');

define('SITE_INSTAGRAM', getenv('SITE_INSTAGRAM') ?: 'https://instagram.com/');
define('SITE_FACEBOOK', getenv('SITE_FACEBOOK') ?: 'https://facebook.com/');
define('SITE_TIKTOK', getenv('SITE_TIKTOK') ?: 'https://tiktok.com/');
define('SITE_PINTEREST', getenv('SITE_PINTEREST') ?: 'https://pinterest.com/');

// Paths
define('BASE_URL', getenv('BASE_URL') ?: '/'); // Vercel normally uses '/'
define('UPLOADS_DIR', __DIR__ . '/../uploads');
define('UPLOADS_URL', (rtrim(BASE_URL, '/') === '' ? '' : rtrim(BASE_URL, '/')) . '/uploads/');

// Sessions
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CSRF token
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
function csrf_token(){ return $_SESSION['csrf']; }
function csrf_field(){ return '<input type="hidden" name="csrf" value="'.e(csrf_token()).'">'; }
function csrf_check(){
    if (($_POST['csrf'] ?? '') !== ($_SESSION['csrf'] ?? '_')) {
        http_response_code(403); die('Invalid CSRF token');
    }
}

// DB connection
function db(): mysqli {
    static $mysqli = null;
    if ($mysqli === null) {
        $mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        if ($mysqli->connect_errno) {
            die('Database connection failed: ' . htmlspecialchars($mysqli->connect_error));
        }
        $mysqli->set_charset('utf8mb4');
    }
    return $mysqli;
}

// Helpers
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function url($path = '') {
    $base = rtrim(BASE_URL, '/');
    $path = ltrim((string)$path, '/');
    return ($base === '' ? '' : $base) . '/' . $path;
}
function asset_url($path) {
    $path = (string)$path;
    if (preg_match('~^(https?:)?//~i', $path) || strpos($path, '/') === 0) {
        return $path;
    }
    return url($path);
}
function wa_link($msg = 'Hello Luxella Spaces, I would like to learn more about your collection.') {
    return 'https://wa.me/' . SITE_PHONE_INTL . '?text=' . rawurlencode($msg);
}
function is_admin(){ return !empty($_SESSION['admin_id']); }
function require_admin(){
    if (!is_admin()) { header('Location: ' . url('admin/login.php')); exit; }
}
