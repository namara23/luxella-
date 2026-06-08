<?php
// ============================================================
// Luxella Spaces — Configuration
// ============================================================

// Database (MySQL / MariaDB)
define('DB_HOST', 'localhost');
define('DB_NAME', 'luxella');
define('DB_USER', 'root');
define('DB_PASS', '');

// Business details (edit freely)
define('SITE_NAME', 'Luxella Spaces');
define('SITE_TAGLINE', 'Timeless elegance for modern living');
define('SITE_PHONE', '0776706980');
define('SITE_PHONE_INTL', '256776706980');
define('SITE_EMAIL', 'hello@luxellaspaces.com');
define('SITE_LOCATION', 'Kampala, Uganda');
define('SITE_DELIVERY', 'Nationwide delivery across Uganda');

define('SITE_INSTAGRAM', 'https://instagram.com/');
define('SITE_FACEBOOK', 'https://facebook.com/');
define('SITE_TIKTOK', 'https://tiktok.com/');
define('SITE_PINTEREST', 'https://pinterest.com/');

// Paths
define('BASE_URL', '/'); // change if hosted in subfolder e.g. '/luxella/'
define('UPLOADS_DIR', __DIR__ . '/../uploads');
define('UPLOADS_URL', BASE_URL . 'uploads/');

// Sessions
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CSRF token
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
function csrf_field(){ return '<input type="hidden" name="csrf" value="'.htmlspecialchars($_SESSION['csrf']).'">'; }
function csrf_check(){
    if (($_POST['csrf'] ?? '') !== ($_SESSION['csrf'] ?? '_')) {
        http_response_code(403); die('Invalid CSRF token');
    }
}

// DB connection
function db(): mysqli {
    static $mysqli = null;
    if ($mysqli === null) {
        $mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            die('Database connection failed: ' . htmlspecialchars($mysqli->connect_error));
        }
        $mysqli->set_charset('utf8mb4');
    }
    return $mysqli;
}

// Helpers
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function wa_link($msg = 'Hello Luxella Spaces, I would like to learn more about your collection.') {
    return 'https://wa.me/' . SITE_PHONE_INTL . '?text=' . rawurlencode($msg);
}
function is_admin(){ return !empty($_SESSION['admin_id']); }
function require_admin(){
    if (!is_admin()) { header('Location: ' . BASE_URL . 'admin/login.php'); exit; }
}
