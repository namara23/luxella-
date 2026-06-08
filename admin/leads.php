<?php
require_once __DIR__ . '/../includes/config.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  csrf_check();
  if (($_POST['action'] ?? '') === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = db()->prepare('DELETE FROM leads WHERE id = ?');
    $stmt->bind_param('i', $id); $stmt->execute();
  }
  header('Location: ' . url('admin/leads.php')); exit;
}

$rows = db()->query('SELECT * FROM leads ORDER BY created_at DESC');
$pageTitle = 'Leads';
include __DIR__ . '/_layout.php';
?>

<div class="card">
  <h2>Recent leads (<?= $rows->num_rows ?>)</h2>
  <?php if ($rows->num_rows === 0): ?>
    <p class="muted">No leads yet.</p>
  <?php else: ?>
  <table class="table">
    <thead><tr><th>Date</th><th>Name</th><th>Contact</th><th>Interest</th><th>Message</th><th></th></tr></thead>
    <tbody>
    <?php while ($l = $rows->fetch_assoc()): ?>
      <tr>
        <td class="small muted"><?= e(date('M j, Y H:i', strtotime($l['created_at']))) ?></td>
        <td><strong><?= e($l['name']) ?></strong></td>
        <td class="small">
          <a href="tel:<?= e($l['phone']) ?>"><?= e($l['phone']) ?></a><br>
          <?php if ($l['email']): ?><a href="mailto:<?= e($l['email']) ?>" class="muted"><?= e($l['email']) ?></a><?php endif; ?>
        </td>
        <td class="small"><?= e($l['interest']) ?></td>
        <td class="small" style="max-width:380px"><?= nl2br(e($l['message'])) ?></td>
        <td>
          <form method="post" onsubmit="return confirm('Delete this lead?')">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int)$l['id'] ?>">
            <button class="del" style="padding:6px 12px;font-size:.7rem;letter-spacing:.15em;border:1px solid #e5b8b8;background:white;color:#c33;cursor:pointer">DELETE</button>
          </form>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/_footer.php'; ?>
