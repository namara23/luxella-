<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle ?? SITE_NAME . ' — ' . SITE_TAGLINE) ?></title>
<meta name="description" content="<?= e($pageDesc ?? 'Luxella Spaces — luxury interior décor, wall art, bathroom & kitchen accessories, living room and bedroom styling. Nationwide delivery across Uganda.') ?>">
<meta name="theme-color" content="#f7f3ec">
<link rel="canonical" href="<?= e((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>">
<meta property="og:title" content="<?= e($pageTitle ?? SITE_NAME) ?>">
<meta property="og:description" content="<?= e($pageDesc ?? SITE_TAGLINE) ?>">
<meta property="og:type" content="website">
<meta property="og:image" content="<?= BASE_URL ?>assets/images/hero-living.jpg">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"HomeAndConstructionBusiness",
"name":"<?= e(SITE_NAME) ?>","telephone":"+<?= SITE_PHONE_INTL ?>",
"areaServed":"Uganda","address":{"@type":"PostalAddress","addressLocality":"Kampala","addressCountry":"UG"},
"description":"Interior design studio and home décor store in Uganda."}
</script>
</head>
<body>
<header class="nav" id="nav">
  <div class="container nav-inner">
    <a href="<?= BASE_URL ?>" class="brand">Luxella<span> Spaces</span></a>
    <ul class="nav-links">
      <li><a href="<?= BASE_URL ?>#about">About</a></li>
      <li><a href="<?= BASE_URL ?>#categories">Collection</a></li>
      <li><a href="<?= BASE_URL ?>shop.php">Shop</a></li>
      <li><a href="<?= BASE_URL ?>#gallery">Gallery</a></li>
      <li><a href="<?= BASE_URL ?>#services">Services</a></li>
      <li><a href="<?= BASE_URL ?>#faq">FAQ</a></li>
      <li><a href="<?= BASE_URL ?>#contact">Contact</a></li>
    </ul>
    <div class="nav-cta">
      <a href="tel:<?= e(SITE_PHONE) ?>" class="phone">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        <?= e(SITE_PHONE) ?>
      </a>
      <a href="<?= e(wa_link()) ?>" target="_blank" rel="noopener" class="btn btn-primary" style="padding:10px 20px">WhatsApp</a>
    </div>
    <button class="menu-btn" id="menuBtn" aria-label="Menu">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
  </div>
  <div class="mobile-menu" id="mobileMenu">
    <div class="container">
      <ul>
        <li><a href="<?= BASE_URL ?>#about">About</a></li>
        <li><a href="<?= BASE_URL ?>#categories">Collection</a></li>
        <li><a href="<?= BASE_URL ?>shop.php">Shop</a></li>
        <li><a href="<?= BASE_URL ?>#gallery">Gallery</a></li>
        <li><a href="<?= BASE_URL ?>#services">Services</a></li>
        <li><a href="<?= BASE_URL ?>#faq">FAQ</a></li>
        <li><a href="<?= BASE_URL ?>#contact">Contact</a></li>
        <li><a href="<?= e(wa_link()) ?>" target="_blank" rel="noopener" class="btn btn-primary btn-block">WhatsApp Us</a></li>
      </ul>
    </div>
  </div>
</header>
