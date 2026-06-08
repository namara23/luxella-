<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'Shop — Luxella Spaces';
$pageDesc  = 'Browse our curated collection of luxury interior décor, wall art, bathroom and kitchen accessories.';

$cat = $_GET['cat'] ?? '';
$products = [];
$cats = [];

if ($db = db()) {
    $res = $db->query("SELECT DISTINCT category FROM products WHERE active=1 ORDER BY category ASC");
    if ($res) while ($r = $res->fetch_assoc()) $cats[] = $r['category'];

    if ($cat !== '') {
        $stmt = $db->prepare('SELECT * FROM products WHERE active=1 AND category=? ORDER BY created_at DESC');
        $stmt->bind_param('s', $cat);
    } else {
        $stmt = $db->prepare('SELECT * FROM products WHERE active=1 ORDER BY created_at DESC');
    }
    $stmt->execute();
    $r = $stmt->get_result();
    while ($p = $r->fetch_assoc()) $products[] = $p;
}

include __DIR__ . '/includes/header.php';
?>

<section class="shop-hero">
  <div class="container">
    <span class="eyebrow">The Collection</span>
    <h1 style="margin-top:16px">Curated luxury, <em>delivered to your door.</em></h1>
    <p>Hand-picked décor, accessories and statement pieces — from our studio in Kampala to homes across Uganda.</p>
    <div class="filters">
      <button class="filter <?= $cat==='' ? 'active' : '' ?>" data-cat="">All</button>
      <?php foreach ($cats as $c): ?>
        <button class="filter" data-cat="<?= e($c) ?>"><?= e($c) ?></button>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section>
  <div class="container product-grid">
    <?php if (!$products): ?>
      <p style="grid-column:1/-1;text-align:center;color:var(--muted-fg);padding:80px 0">
        No products yet. Add them in the admin dashboard.
      </p>
    <?php endif; ?>
    <?php foreach ($products as $p):
        $img = $p['image_path'] ?: 'assets/images/cat-living.jpg';
        $imgUrl = (strpos($img,'http')===0 || strpos($img,'/')===0) ? $img : BASE_URL . $img;
        $wa = wa_link("Hi Luxella! I'd like to order: " . $p['name'] . " (UGX " . number_format($p['price']) . ")");
    ?>
      <a class="product" data-cat="<?= e($p['category']) ?>" href="<?= e($wa) ?>" target="_blank" rel="noopener">
        <div class="ph"><img src="<?= e($imgUrl) ?>" alt="<?= e($p['name']) ?>" loading="lazy"></div>
        <div class="meta">
          <div class="cat"><?= e($p['category']) ?></div>
          <div class="name"><?= e($p['name']) ?></div>
          <div class="price">UGX <?= number_format((float)$p['price']) ?></div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
