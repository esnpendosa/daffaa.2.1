<?php
/**
 * Installer AgriVoice AI: membuat tabel, mengisi data awal, dan membuat akun admin pertama.
 * Setelah berhasil, HAPUS berkas ini dari server.
 */
require __DIR__ . '/includes/admin_bootstrap.php';

function install_connect()
{
    try {
        return db();
    } catch (PDOException $ex) {
        $code = isset($ex->errorInfo[1]) ? (int) $ex->errorInfo[1] : (int) $ex->getCode();
        if ($code !== 1049) {              // 1049 = database belum ada
            throw $ex;
        }
        $c = app_config()['db'];
        $server = new PDO(
            sprintf('mysql:host=%s;port=%d;charset=%s', $c['host'], $c['port'], $c['charset']),
            $c['user'], $c['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $server->exec('CREATE DATABASE IF NOT EXISTS `' . str_replace('`', '', $c['name']) . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        return db();
    }
}

function install_run_sql_file(PDO $pdo, $file)
{
    $sql = preg_replace('/^--.*$/m', '', file_get_contents($file));
    foreach (preg_split('/;\s*[\r\n]+/', $sql) as $statement) {
        $statement = trim($statement);
        if ($statement !== '') {
            $pdo->exec($statement);
        }
    }
}

$locked = false;
try {
    $locked = (int) db()->query('SELECT COUNT(*) FROM admins')->fetchColumn() > 0;
} catch (Throwable $ex) {
    // database/tabel belum ada: normal pada instalasi pertama
}

$errors = [];
$done   = false;
$username = '';

if (!$locked && $_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $confirm  = (string) ($_POST['confirm'] ?? '');

    if (!preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $username)) {
        $errors[] = 'Username 3–50 karakter: huruf, angka, titik, garis bawah, atau strip.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Kata sandi minimal 8 karakter.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Konfirmasi kata sandi tidak sama.';
    }

    if (!$errors) {
        try {
            $pdo = install_connect();
            install_run_sql_file($pdo, __DIR__ . '/database/schema.sql');

            $st = $pdo->prepare('INSERT IGNORE INTO settings (setting_key, setting_value) VALUES (?, ?)');
            foreach (setting_defaults() as $key => $value) {
                $st->execute([$key, $value]);
            }

            if ((int) $pdo->query('SELECT COUNT(*) FROM news')->fetchColumn() === 0) {
                $sample = json_decode(file_get_contents(__DIR__ . '/database/sample_news.json'), true);
                $ins = $pdo->prepare('INSERT INTO news (title, summary, image_url, image_alt, link_url, published_at, is_published) VALUES (?,?,?,?,?,?,1)');
                foreach ((array) $sample as $n) {
                    $ins->execute([$n['title'], $n['summary'], $n['image_url'], $n['image_alt'], $n['link_url'], $n['published_at']]);
                }
            }

            $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)')
                ->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
            $done = true;
        } catch (Throwable $ex) {
            error_log('[agrivoice] install: ' . $ex->getMessage());
            $errors[] = 'Instalasi gagal: ' . $ex->getMessage() . ' — periksa pengaturan database di config.php.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex,nofollow">
<title>Instalasi | AgriVoice AI</title>
<link rel="icon" href="assets/icon.png">
<link rel="stylesheet" href="admin/assets/admin.css">
<link rel="stylesheet" href="admin/assets/motion-admin.css">
<script>document.documentElement.classList.add('mo-admin');setTimeout(function(){if(!window.__moAdmin)document.documentElement.classList.remove('mo-admin')},2500)</script>
</head>
<body>
<div class="login-wrap">
 <div class="login-card" style="max-width:460px">
  <img src="assets/logo.png" alt="AgriVoice AI" width="170" height="36">
<?php if ($done): ?>
  <h1>Instalasi selesai</h1>
  <div class="alert alert-ok">Tabel dibuat dan akun admin <strong><?= e($username) ?></strong> siap dipakai.</div>
  <div class="alert alert-err"><strong>Penting:</strong> hapus berkas <code>install.php</code> dari server sekarang.</div>
  <a class="btn" href="admin/login.php">Masuk ke panel admin</a>
<?php elseif ($locked): ?>
  <h1>Sudah terpasang</h1>
  <div class="alert alert-err">Instalasi sudah pernah dijalankan. Hapus berkas <code>install.php</code> dari server.</div>
  <a class="btn" href="admin/login.php">Ke halaman login</a>
<?php else: ?>
  <h1>Instalasi AgriVoice AI</h1>
  <p class="hint" style="color:var(--muted);font-size:.92rem;margin-top:-8px">Pastikan data database di <code>config.php</code> sudah benar. Installer akan membuat tabel dan akun admin pertama.</p>
<?php admin_errors($errors); ?>
  <form method="post" autocomplete="off">
   <?= csrf_field() ?>
   <div class="field"><label for="username">Username admin</label><input type="text" id="username" name="username" value="<?= e($username) ?>" required></div>
   <div class="field"><label for="password">Kata sandi</label><input type="password" id="password" name="password" minlength="8" required autocomplete="new-password"></div>
   <div class="field"><label for="confirm">Ulangi kata sandi</label><input type="password" id="confirm" name="confirm" minlength="8" required autocomplete="new-password"></div>
   <button class="btn" type="submit">Pasang</button>
  </form>
<?php endif; ?>
 </div>
</div>
<script src="admin/assets/motion-admin.js"></script>
</body>
</html>
