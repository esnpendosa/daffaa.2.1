<?php
require __DIR__ . '/../includes/admin_bootstrap.php';

if (current_admin()) {
    redirect('index.php');
}

$error = '';
$username = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    try {
        if (login_blocked()) {
            $error = 'Terlalu banyak percobaan gagal. Coba lagi dalam ' . LOGIN_WINDOW_MIN . ' menit.';
        } elseif (attempt_login($username, $password)) {
            redirect('index.php');
        } else {
            $error = 'Username atau kata sandi salah.';
        }
    } catch (Throwable $ex) {
        error_log('[agrivoice] login: ' . $ex->getMessage());
        $error = 'Tidak dapat terhubung ke database. Periksa config.php dan pastikan install.php sudah dijalankan.';
    }
}
$flash = flash_pull();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex,nofollow">
<title>Masuk | Admin AgriVoice AI</title>
<link rel="icon" href="../assets/icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/admin.css">
<link rel="stylesheet" href="assets/motion-admin.css">
<script>document.documentElement.classList.add('mo-admin');setTimeout(function(){if(!window.__moAdmin)document.documentElement.classList.remove('mo-admin')},2500)</script>
</head>
<body>
<div class="login-wrap">
 <form class="login-card" method="post" autocomplete="on">
  <img src="../assets/logo.png" alt="AgriVoice AI" width="170" height="36">
  <h1>Masuk ke panel admin</h1>
<?php if ($flash): ?>
  <div class="alert alert-err" role="alert"><?= e($flash['message']) ?></div>
<?php endif; ?>
<?php if ($error !== ''): ?>
  <div class="alert alert-err" role="alert"><?= e($error) ?></div>
<?php endif; ?>
  <?= csrf_field() ?>
  <div class="field"><label for="username">Username</label><input type="text" id="username" name="username" value="<?= e($username) ?>" required autofocus autocomplete="username"></div>
  <div class="field"><label for="password">Kata sandi</label><input type="password" id="password" name="password" required autocomplete="current-password"></div>
  <button class="btn" type="submit">Masuk</button>
 </form>
</div>
<script src="assets/motion-admin.js"></script>
</body>
</html>
