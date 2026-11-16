<?php
require __DIR__ . '/../includes/admin_bootstrap.php';
require_admin();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $current = (string) ($_POST['current_password'] ?? '');
    $new     = (string) ($_POST['new_password'] ?? '');
    $confirm = (string) ($_POST['confirm_password'] ?? '');

    $st = db()->prepare('SELECT password_hash FROM admins WHERE id = ?');
    $st->execute([current_admin()['id']]);
    $hash = $st->fetchColumn();

    if (!$hash || !password_verify($current, $hash)) {
        $errors[] = 'Kata sandi saat ini salah.';
    }
    if (strlen($new) < 8) {
        $errors[] = 'Kata sandi baru minimal 8 karakter.';
    }
    if ($new !== $confirm) {
        $errors[] = 'Konfirmasi kata sandi tidak sama.';
    }
    if (!$errors) {
        db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')
            ->execute([password_hash($new, PASSWORD_DEFAULT), current_admin()['id']]);
        session_regenerate_id(true);
        flash_set('ok', 'Kata sandi diperbarui.');
        redirect('account.php');
    }
}

admin_header('Akun', 'account');
admin_errors($errors);
?>
  <form class="card" method="post" autocomplete="off" style="max-width:520px">
   <?= csrf_field() ?>
   <h2>Ganti kata sandi</h2>
   <p class="hint">Masuk sebagai <strong><?= e(current_admin()['username']) ?></strong>.</p>
   <div class="field"><label for="current_password">Kata sandi saat ini</label><input type="password" id="current_password" name="current_password" required autocomplete="current-password"></div>
   <div class="field"><label for="new_password">Kata sandi baru</label><input type="password" id="new_password" name="new_password" minlength="8" required autocomplete="new-password"><span class="hint">Minimal 8 karakter.</span></div>
   <div class="field"><label for="confirm_password">Ulangi kata sandi baru</label><input type="password" id="confirm_password" name="confirm_password" minlength="8" required autocomplete="new-password"></div>
   <div class="form-actions"><button class="btn" type="submit">Simpan kata sandi</button></div>
  </form>
<?php admin_footer(); ?>
