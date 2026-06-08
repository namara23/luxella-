<?php
require_once __DIR__ . '/../includes/config.php';
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  csrf_check();
  $email = trim($_POST['email'] ?? '');
  $pass  = $_POST['password'] ?? '';
  $stmt = db()->prepare('SELECT id, password_hash, name FROM admins WHERE email = ? LIMIT 1');
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if ($row && password_verify($pass, $row['password_hash'])) {
    session_regenerate_id(true);
    $_SESSION['admin_id'] = (int)$row['id'];
    $_SESSION['admin_name'] = $row['name'] ?: $email;
    header('Location: ' . url('admin/index.php')); exit;
  }
  $error = 'Invalid email or password.';
}
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin - <?= e(SITE_NAME) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500&family=Inter:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head><body>
<div class="login-wrap">
  <div class="login-card">
    <h1>Luxella Admin</h1>
    <p class="muted">Sign in to manage products, gallery & leads.</p>
    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <div class="fld"><label>Email</label><input name="email" type="email" required autofocus></div>
      <div class="fld"><label>Password</label><input name="password" type="password" required></div>
      <button class="btn btn-primary" style="width:100%">Sign in</button>
    </form>
    <p class="muted small" style="margin-top:24px;text-align:center"><a href="<?= url('index.php') ?>">&lt;- Back to site</a></p>
  </div>
</div>
</body></html>
