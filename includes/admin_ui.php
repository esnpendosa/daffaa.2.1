<?php
/** Kerangka halaman admin: admin_header() ... isi halaman ... admin_footer(). */

function admin_header($title, $active)
{
    $user  = current_admin();
    $flash = flash_pull();
    $menu  = [
        'index'    => ['Dashboard',        'index.php'],
        'news'     => ['Berita',           'news.php'],
        'settings' => ['Materi &amp; Kontak', 'settings.php'],
        'account'  => ['Akun',             'account.php'],
    ];
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex,nofollow">
<title><?= e($title) ?> | Admin AgriVoice AI</title>
<link rel="icon" href="../assets/icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/admin.css">
<link rel="stylesheet" href="assets/motion-admin.css">
<script>document.documentElement.classList.add('mo-admin');setTimeout(function(){if(!window.__moAdmin)document.documentElement.classList.remove('mo-admin')},2500)</script>
</head>
<body>
<div class="shell">
 <aside class="side">
  <a class="side-brand" href="index.php"><img src="../assets/logo-gelap.png" alt="AgriVoice AI" width="150" height="36"></a>
  <nav class="side-nav" aria-label="Menu admin">
<?php foreach ($menu as $key => $item): ?>
   <a href="<?= $item[1] ?>"<?= $key === $active ? ' aria-current="page"' : '' ?>><?= $item[0] ?></a>
<?php endforeach; ?>
  </nav>
  <div class="side-foot">
   <a href="../index.php" target="_blank" rel="noopener">Lihat situs &nearr;</a>
   <form method="post" action="logout.php"><?= csrf_field() ?><button type="submit" class="link-btn">Keluar (<?= e($user['username']) ?>)</button></form>
  </div>
 </aside>
 <main class="content">
  <header class="page-head"><h1><?= e($title) ?></h1></header>
<?php if ($flash): ?>
  <div class="alert alert-<?= $flash['type'] === 'ok' ? 'ok' : 'err' ?>" role="status"><?= e($flash['message']) ?></div>
<?php endif; ?>
<?php
}

function admin_footer()
{
    ?>
 </main>
</div>
<script src="assets/motion-admin.js"></script>
</body>
</html>
<?php
}

/** Tampilkan daftar error validasi. */
function admin_errors(array $errors)
{
    if (!$errors) {
        return;
    }
    echo '<div class="alert alert-err" role="alert"><strong>Periksa kembali:</strong><ul>';
    foreach ($errors as $msg) {
        echo '<li>' . e($msg) . '</li>';
    }
    echo '</ul></div>';
}
