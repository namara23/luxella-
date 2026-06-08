<?php
// Vercel entrypoint for the PHP runtime.
// It maps public routes back to the existing PHP files at the repo root.

$root = dirname(__DIR__);
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = trim($path, '/');

if ($path === '') {
    $path = 'index.php';
}

if (substr($path, -1) === '/') {
    $path .= 'index.php';
}

$allowed = [
    'index.php',
    'shop.php',
    'admin/index.php',
    'admin/login.php',
    'admin/logout.php',
    'admin/gallery.php',
    'admin/leads.php',
];

$path = str_replace('\\', '/', $path);

if (!in_array($path, $allowed, true)) {
    http_response_code(404);
    echo 'Not found';
    exit;
}

chdir($root);
require $root . '/' . $path;
