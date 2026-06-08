<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();
require_once __DIR__ . '/_upload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  csrf_check();
  $action = $_POST['action'] ?? '';
  if ($action === 'create') {
    $name = trim($_POST['name'] ?? '');
    $cat  = trim($_POST['category'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $price= $_POST['price_ugx'] !== '' ? (int)$_POST['price_ugx'] : null;
    $featured = isset($_POST['featured']) ? 1 : 0;
    $img = handle_upload('image');
    if ($name && $cat) {
      $stmt = db()->prepare('INSERT INTO products (name,category,description,price_ugx,image_url,featured) VALUES (?,?,?,?,?,?)');
      $stmt->bind_param('sssisi', $name, $cat, $desc, $price, $img, $featured);
      $stmt->execute();
    }
  } elseif ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = db()->prepare('DELETE FROM products WHERE id = ?');
    $stmt->bind_param('i', $id); $stmt->execute();
  } elseif ($action === 'toggle') {
    $id = (int)($_POST['id'] ?? 0);
    db()->query("UPDATE products SET published = 1 - published WHERE id = $id");
  }
  header('Location: ' . url('admin/index.php')); exit;
}

$rows = db()->query('SELECT * FROM products ORDER BY created_at DESC');
$pageTitle = 'Products';
include __DIR__ . '/_layout.php';
?>

<div class="card">
  <h2>Add product</h2>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="action" value="create">
    <div class="row">
      <div class="fld"><label>Name *</label><input name="name" required maxlength="160"></div>
      <div class="fld"><label>Category *</label><input name="category" required maxlength="80" placeholder="e.g. Living Room"></div>
    </div>
    <div class="fld"><label>Description</label><textarea name="description" maxlength="800"></textarea></div>
    <div class="row">
      <div class="fld"><label>Price (UGX, optional)</label><input name="price_ugx" type="number" min="0"></div>
      <div class="fld"><label>Image</label><input name="image" type="file" accept="image/*"></div>
    </div>
    <label style="display:flex;gap:10px;align-items:center;margin-bottom:18px"><input type="checkbox" name="featured"> Featured</label>
    <button class="btn btn-primary">Add product</button>
  </form>
</div>

<div class="card">
  <h2>All products (<?= $rows->num_rows ?>)</h2>
  <table class="table">
    <thead><tr><th></th><th>Name</th><th>Category</th><th>Price</th><th>Status</th><th></th></tr></thead>
    <tbody>
    <?php while ($p = $rows->fetch_assoc()): ?>
      <tr>
        <td><?php if ($p['image_url']): ?><img src="<?= url(e($p['image_url'])) ?>" alt=""><?php endif; ?></td>
        <td><strong><?= e($p['name']) ?></strong><?php if ($p['featured']): ?> <span style="color:var(--gold);font-size:.7rem;letter-spacing:.15em">★ FEATURED</span><?php endif; ?></td>
        <td><?= e($p['category']) ?></td>
        <td><?= $p['price_ugx'] ? 'UGX ' . number_format((int)$p['price_ugx']) : '—' ?></td>
        <td><?= $p['published'] ? '<span style="color:#2a8">Published</span>' : '<span class="muted">Hidden</span>' ?></td>
        <td><div class="actions">
          <form method="post" style="display:inline"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><button><?= $p['published']?'Hide':'Publish' ?></button></form>
          <form method="post" style="display:inline" onsubmit="return confirm('Delete this product?')"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><button class="del">Delete</button></form>
        </div></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/_footer.php'; ?>
