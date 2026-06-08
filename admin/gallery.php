<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();
require_once __DIR__ . '/_upload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  csrf_check();
  $action = $_POST['action'] ?? '';
  if ($action === 'upload' && !empty($_FILES['images']['name'][0])) {
    $count = count($_FILES['images']['name']);
    for ($i = 0; $i < $count; $i++) {
      // Reshape into single-file array
      $f = ['name'=>$_FILES['images']['name'][$i],'type'=>$_FILES['images']['type'][$i],'tmp_name'=>$_FILES['images']['tmp_name'][$i],'error'=>$_FILES['images']['error'][$i],'size'=>$_FILES['images']['size'][$i]];
      $_FILES['_one'] = $f;
      $url = handle_upload('_one');
      if ($url) {
        $cap = pathinfo($f['name'], PATHINFO_FILENAME);
        $stmt = db()->prepare('INSERT INTO gallery_images (image_url, caption) VALUES (?,?)');
        $stmt->bind_param('ss', $url, $cap); $stmt->execute();
      }
    }
  } elseif ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = db()->prepare('DELETE FROM gallery_images WHERE id = ?');
    $stmt->bind_param('i', $id); $stmt->execute();
  }
  header('Location: ' . url('admin/gallery.php')); exit;
}

$rows = db()->query('SELECT * FROM gallery_images ORDER BY sort_order, created_at DESC');
$pageTitle = 'Gallery';
include __DIR__ . '/_layout.php';
?>

<div class="card">
  <h2>Upload gallery images</h2>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="action" value="upload">
    <div class="fld"><label>Select one or more images</label><input type="file" name="images[]" accept="image/*" multiple required></div>
    <button class="btn btn-primary">Upload</button>
  </form>
</div>

<div class="card">
  <h2>Gallery (<?= $rows->num_rows ?>)</h2>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px">
    <?php while ($g = $rows->fetch_assoc()): ?>
      <div style="position:relative;aspect-ratio:1;background:var(--beige)">
        <img src="<?= url(e($g['image_url'])) ?>" style="width:100%;height:100%;object-fit:cover" alt="">
        <form method="post" style="position:absolute;top:6px;right:6px" onsubmit="return confirm('Remove?')">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= (int)$g['id'] ?>">
          <button class="del" style="background:rgba(255,255,255,.95);border:none;padding:6px 10px;font-size:.7rem;letter-spacing:.15em;color:#c33;cursor:pointer">DELETE</button>
        </form>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include __DIR__ . '/_footer.php'; ?>
