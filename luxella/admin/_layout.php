<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($pageTitle ?? 'Admin') ?> · <?= e(SITE_NAME) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500&family=Inter:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head><body class="admin-wrap">
<header class="admin-header"><div class="container">
  <a href="<?= url('admin/index.php') ?>" class="brand">Luxella <span style="color:var(--gold)">Admin</span></a>
  <div>
    <span class="muted small"><?= e($_SESSION['admin_name'] ?? '') ?></span>
    &nbsp;·&nbsp; <a href="<?= url('index.php') ?>" class="small">View site</a>
    &nbsp;·&nbsp; <a href="<?= url('admin/logout.php') ?>" class="small">Sign out</a>
  </div>
</div></header>
<nav class="admin-nav"><div class="container" style="display:flex;gap:4px">
  <a href="<?= url('admin/index.php') ?>" class="<?= $current==='index.php'?'active':'' ?>">Products</a>
  <a href="<?= url('admin/gallery.php') ?>" class="<?= $current==='gallery.php'?'active':'' ?>">Gallery</a>
  <a href="<?= url('admin/leads.php') ?>" class="<?= $current==='leads.php'?'active':'' ?>">Leads</a>
</div></nav>
<main class="admin-main"><div class="container">
