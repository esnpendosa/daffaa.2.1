<?php
require __DIR__ . '/../includes/admin_bootstrap.php';
require_admin();

$id   = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$item = [
    'title' => '', 'summary' => '', 'image_url' => '', 'image_alt' => '',
    'link_url' => '#', 'published_at' => date('Y-m-d'), 'is_published' => 1,
];

if ($id > 0) {
    $st = db()->prepare('SELECT * FROM news WHERE id = ?');
    $st->execute([$id]);
    $row = $st->fetch();
    if (!$row) {
        flash_set('err', 'Berita tidak ditemukan.');
        redirect('news.php');
    }
    $item = $row;
}
$currentImage = $item['image_url'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $item['title']        = trim((string) ($_POST['title'] ?? ''));
    $item['summary']      = trim((string) ($_POST['summary'] ?? ''));
    $item['image_alt']    = trim((string) ($_POST['image_alt'] ?? ''));
    $item['link_url']     = trim((string) ($_POST['link_url'] ?? ''));
    $item['published_at'] = trim((string) ($_POST['published_at'] ?? ''));
    $item['is_published'] = isset($_POST['is_published']) ? 1 : 0;
    $imageText            = trim((string) ($_POST['image_url'] ?? ''));
    $removeImage          = isset($_POST['remove_image']);

    if ($item['title'] === '' || mb_strlen($item['title']) > 200) {
        $errors[] = 'Judul wajib diisi (maksimal 200 karakter).';
    }
    if (mb_strlen($item['summary']) > 500) {
        $errors[] = 'Ringkasan maksimal 500 karakter.';
    }
    if (mb_strlen($item['image_alt']) > 200) {
        $errors[] = 'Teks alternatif gambar maksimal 200 karakter.';
    }
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $item['published_at'], $m) || !checkdate((int) $m[2], (int) $m[3], (int) $m[1])) {
        $errors[] = 'Tanggal terbit tidak valid.';
    }
    if ($item['link_url'] === '') {
        $item['link_url'] = '#';
    }
    if (!valid_link($item['link_url'])) {
        $errors[] = 'Tautan "Baca selengkapnya" harus berupa #, alamat http(s)://, atau path relatif.';
    }

    // Gambar: unggahan baru > URL yang diketik > gambar lama. "Hapus gambar" mengosongkan.
    $newImage = $currentImage;
    $uploaded = null;
    try {
        $uploaded = handle_upload('image_file', upload_types('image'), 'berita');
    } catch (RuntimeException $ex) {
        $errors[] = $ex->getMessage();
    }
    if ($uploaded !== null) {
        $newImage = $uploaded;
    } elseif ($removeImage) {
        $newImage = '';
    } elseif ($imageText !== $currentImage) {
        if ($imageText === '' || valid_http_url($imageText)) {
            $newImage = $imageText;
        } else {
            $errors[] = 'Alamat gambar harus diawali http:// atau https://. Untuk gambar dari komputer, gunakan tombol pilih berkas.';
        }
    }

    if ($errors) {
        if ($uploaded !== null) {
            delete_upload($uploaded);   // jangan tinggalkan berkas yatim bila form gagal
        }
    } else {
        $item['image_url'] = $newImage;
        $params = [
            $item['title'], $item['summary'], $item['image_url'], $item['image_alt'],
            $item['link_url'], $item['published_at'], $item['is_published'],
        ];
        if ($id > 0) {
            $params[] = $id;
            db()->prepare('UPDATE news SET title=?, summary=?, image_url=?, image_alt=?, link_url=?, published_at=?, is_published=? WHERE id=?')->execute($params);
        } else {
            db()->prepare('INSERT INTO news (title, summary, image_url, image_alt, link_url, published_at, is_published) VALUES (?,?,?,?,?,?,?)')->execute($params);
        }
        if ($currentImage !== $newImage) {
            delete_upload($currentImage);   // hanya menghapus bila berupa berkas hasil unggahan
        }
        flash_set('ok', $id > 0 ? 'Berita diperbarui.' : 'Berita ditambahkan.');
        redirect('news.php');
    }
    $item['image_url'] = $currentImage;  // pratinjau tetap menampilkan gambar yang tersimpan
}

admin_header($id > 0 ? 'Edit berita' : 'Tambah berita', 'news');
admin_errors($errors);
?>
  <form class="card" method="post" enctype="multipart/form-data">
   <?= csrf_field() ?>
   <div class="field">
    <label for="title">Judul</label>
    <input type="text" id="title" name="title" maxlength="200" value="<?= e($item['title']) ?>" required>
   </div>
   <div class="field">
    <label for="summary">Ringkasan</label>
    <textarea id="summary" name="summary" maxlength="500"><?= e($item['summary']) ?></textarea>
    <span class="hint">Hanya ditampilkan pada berita terbaru (kartu besar). Boleh dikosongkan.</span>
   </div>
   <div class="grid-2">
    <div class="field">
     <label for="published_at">Tanggal terbit</label>
     <input type="date" id="published_at" name="published_at" value="<?= e($item['published_at']) ?>" required>
    </div>
    <div class="field">
     <label for="link_url">Tautan &ldquo;Baca selengkapnya&rdquo;</label>
     <input type="text" id="link_url" name="link_url" value="<?= e($item['link_url']) ?>" placeholder="https://...">
     <span class="hint">Isi <code>#</code> bila belum ada.</span>
    </div>
   </div>

   <div class="field">
    <label for="image_file">Gambar</label>
<?php if ($item['image_url'] !== ''): ?>
    <div class="preview"><img src="<?= e(admin_asset_url($item['image_url'])) ?>" alt=""><span>Gambar saat ini</span></div>
<?php endif; ?>
    <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/webp" style="margin-top:8px">
    <span class="hint">Unggah JPG/PNG/WebP (maks. <?= (int) round(app_config()['upload_max_bytes'] / 1048576) ?> MB), atau isi alamat gambar di bawah. Unggahan menggantikan alamat.</span>
   </div>
   <div class="field">
    <label for="image_url">Atau alamat gambar (URL)</label>
    <input type="text" id="image_url" name="image_url" value="<?= e($item['image_url']) ?>" placeholder="https://...">
   </div>
   <div class="field">
    <label for="image_alt">Teks alternatif gambar</label>
    <input type="text" id="image_alt" name="image_alt" maxlength="200" value="<?= e($item['image_alt']) ?>">
    <span class="hint">Deskripsi singkat gambar untuk pembaca layar.</span>
   </div>
<?php if ($item['image_url'] !== ''): ?>
   <div class="field"><label class="check"><input type="checkbox" name="remove_image" value="1"> Hapus gambar</label></div>
<?php endif; ?>

   <div class="field"><label class="check"><input type="checkbox" name="is_published" value="1"<?= $item['is_published'] ? ' checked' : '' ?>> Tampilkan di situs</label></div>
   <div class="form-actions">
    <button class="btn" type="submit">Simpan</button>
    <a class="btn btn-outline" href="news.php">Batal</a>
   </div>
  </form>
<?php admin_footer(); ?>
