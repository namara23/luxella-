<?php
// Shared image upload helper. Returns relative path or null.
function handle_upload(string $field): ?string {
  if (empty($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
  $f = $_FILES[$field];
  $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/gif'=>'gif'];
  $mime = mime_content_type($f['tmp_name']);
  if (!isset($allowed[$mime])) return null;
  if ($f['size'] > 8 * 1024 * 1024) return null; // 8MB
  $name = bin2hex(random_bytes(8)) . '.' . $allowed[$mime];
  $dest = __DIR__ . '/../uploads/' . $name;
  if (!is_dir(dirname($dest))) @mkdir(dirname($dest), 0775, true);
  if (!move_uploaded_file($f['tmp_name'], $dest)) return null;
  return 'uploads/' . $name;
}
