<?php
require __DIR__ . '/../includes/admin_bootstrap.php';
require_admin();

// Tautan unduhan materi: kunci setting => [label, nama field berkas, jenis unggahan, keterangan]
$links = [
    'link_poster'      => ['Poster',          'file_poster',      'image',     'Gambar poster (JPG/PNG/WebP).'],
    'link_brosur'      => ['Brosur',          'file_brosur',      'pdf',       'Berkas PDF brosur.'],
    'link_screenshots' => ['Tangkapan layar', 'file_screenshots', 'image_zip', 'Gambar (JPG/PNG/WebP) atau ZIP berisi semua tangkapan layar.'],
    'link_video'       => ['Video',           null,               null,        'Alamat video (misalnya YouTube).'],
];

$cur    = setting_all(true);   // nilai saat ini (bawaan + database)
$form   = $cur;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $new      = [];
    $uploaded = [];

    // --- Kontak ---
    $new['wa_display'] = trim((string) ($_POST['wa_display'] ?? ''));
    $new['wa_number']  = preg_replace('/\D+/', '', (string) ($_POST['wa_number'] ?? ''));
    $new['email']      = trim((string) ($_POST['email'] ?? ''));
    $new['location']   = trim((string) ($_POST['location'] ?? ''));
    $new['news_note']  = trim((string) ($_POST['news_note'] ?? ''));

    if (!preg_match('/^\d{8,15}$/', $new['wa_number'])) {
        $errors[] = 'Nomor WhatsApp harus 8–15 digit, diawali kode negara tanpa tanda +, misalnya 6281234567890.';
    }
    if ($new['wa_display'] === '' || mb_strlen($new['wa_display']) > 40) {
        $errors[] = 'Tampilan nomor WhatsApp wajib diisi (maksimal 40 karakter).';
    }
    if (!filter_var($new['email'], FILTER_VALIDATE_EMAIL) || strlen($new['email']) > 120) {
        $errors[] = 'Alamat email tidak valid.';
    }
    if ($new['location'] === '' || mb_strlen($new['location']) > 120) {
        $errors[] = 'Lokasi wajib diisi (maksimal 120 karakter).';
    }
    if (mb_strlen($new['news_note']) > 300) {
        $errors[] = 'Catatan di halaman Berita maksimal 300 karakter.';
    }

    // --- Tautan materi ---
    foreach ($links as $key => $def) {
        $text = trim((string) ($_POST[$key] ?? ''));
        $new[$key] = $cur[$key];
        $file = null;
        if ($def[1] !== null) {
            try {
                $file = handle_upload($def[1], upload_types($def[2]), preg_replace('/^link_/', '', $key));
            } catch (RuntimeException $ex) {
                $errors[] = $def[0] . ': ' . $ex->getMessage();
            }
        }
        if ($file !== null) {
            $new[$key] = $file;
            $uploaded[] = $file;
        } elseif ($text !== $cur[$key]) {
            // path "uploads/..." hanya boleh dari unggahan, bukan diketik manual
            if ($text === '' || (valid_link($text) && !is_upload_path($text) && strpos($text, 'uploads/') !== 0)) {
                $new[$key] = $text === '#' ? '' : $text;
            } else {
                $errors[] = $def[0] . ': tautan harus berupa alamat http(s):// atau dikosongkan. Gunakan tombol pilih berkas untuk mengunggah.';
            }
        }
    }

    if ($errors) {
        foreach ($uploaded as $path) {
            delete_upload($path);
        }
        $form = array_merge($cur, $new);
        foreach ($links as $key => $def) {
            $form[$key] = $cur[$key];
        }
    } else {
        try {
            $pdo = db();
            $pdo->beginTransaction();
            $st = $pdo->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');
            foreach ($new as $key => $value) {
                $st->execute([$key, $value]);
            }
            $pdo->commit();
        } catch (Throwable $ex) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            foreach ($uploaded as $path) {
                delete_upload($path);
            }
            error_log('[agrivoice] settings: ' . $ex->getMessage());
            flash_set('err', 'Gagal menyimpan pengaturan ke database.');
            redirect('settings.php');
        }
        // hapus berkas lama yang tergantikan
        foreach ($links as $key => $def) {
            if ($cur[$key] !== $new[$key]) {
                delete_upload($cur[$key]);
            }
        }
        flash_set('ok', 'Pengaturan disimpan.');
        redirect('settings.php');
    }
}

admin_header('Materi & Kontak', 'settings');
admin_errors($errors);
?>
  <form method="post" enctype="multipart/form-data">
   <?= csrf_field() ?>

   <div class="card">
    <h2>Kontak</h2>
    <p class="hint">Tampil di halaman Kontak.</p>
    <div class="grid-2">
     <div class="field">
      <label for="wa_number">Nomor WhatsApp (untuk tautan)</label>
      <input type="text" id="wa_number" name="wa_number" inputmode="numeric" value="<?= e($form['wa_number']) ?>" required>
      <span class="hint">Format 62xxxxxxxxxx, tanpa spasi dan tanda +.</span>
     </div>
     <div class="field">
      <label for="wa_display">Nomor WhatsApp (yang ditampilkan)</label>
      <input type="text" id="wa_display" name="wa_display" maxlength="40" value="<?= e($form['wa_display']) ?>" required>
      <span class="hint">Contoh: +62 815-5419-0997</span>
     </div>
     <div class="field">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e($form['email']) ?>" required>
     </div>
     <div class="field">
      <label for="location">Lokasi</label>
      <input type="text" id="location" name="location" maxlength="120" value="<?= e($form['location']) ?>" required>
     </div>
    </div>
   </div>

   <div class="card">
    <h2>Tautan unduhan materi</h2>
    <p class="hint">Dipakai pada tombol &ldquo;Unduh&rdquo; / &ldquo;Tonton&rdquo; di halaman Poster, Brosur, Tangkapan Layar, dan Video. Kosongkan bila belum ada.</p>
<?php foreach ($links as $key => $def): ?>
    <div class="field">
     <label for="<?= e($key) ?>"><?= e($def[0]) ?></label>
     <input type="text" id="<?= e($key) ?>" name="<?= e($key) ?>" value="<?= e($form[$key]) ?>" placeholder="https://...">
<?php if ($def[1] !== null): ?>
     <input type="file" name="<?= e($def[1]) ?>" style="margin-top:8px">
<?php endif; ?>
     <span class="hint"><?= e($def[3]) ?><?= $def[1] !== null ? ' Berkas yang diunggah menggantikan alamat.' : '' ?> Maks. <?= (int) round(app_config()['upload_max_bytes'] / 1048576) ?> MB.</span>
<?php if (is_upload_path($form[$key])): ?>
     <span class="hint">Berkas saat ini: <a href="<?= e(admin_asset_url($form[$key])) ?>" target="_blank" rel="noopener"><?= e($form[$key]) ?></a></span>
<?php endif; ?>
    </div>
<?php endforeach; ?>
   </div>

   <div class="card">
    <h2>Halaman Berita</h2>
    <div class="field">
     <label for="news_note">Catatan di bawah daftar berita</label>
     <input type="text" id="news_note" name="news_note" maxlength="300" value="<?= e($form['news_note']) ?>">
     <span class="hint">Kosongkan untuk menyembunyikan catatan &ldquo;Contoh tampilan&rdquo; setelah berita asli diisi.</span>
    </div>
   </div>

   <div class="form-actions"><button class="btn" type="submit">Simpan pengaturan</button></div>
  </form>
<?php admin_footer(); ?>
