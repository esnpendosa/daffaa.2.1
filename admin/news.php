<?php
require __DIR__ . '/../includes/admin_bootstrap.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $id     = (int) ($_POST['id'] ?? 0);
    $action = (string) ($_POST['action'] ?? '');

    if ($id > 0 && $action === 'delete') {
        $st = db()->prepare('SELECT image_url FROM news WHERE id = ?');
        $st->execute([$id]);
        $image = $st->fetchColumn();
        db()->prepare('DELETE FROM news WHERE id = ?')->execute([$id]);
        if ($image) {
            delete_upload($image);
        }
        flash_set('ok', 'Berita dihapus.');
    } elseif ($id > 0 && $action === 'toggle') {
        db()->prepare('UPDATE news SET is_published = 1 - is_published WHERE id = ?')->execute([$id]);
        flash_set('ok', 'Status berita diperbarui.');
    }
    redirect('news.php');
}

$rows = get_news(false);

admin_header('Berita', 'news');
?>
  <div class="card">
   <div class="page-head" style="margin-bottom:8px">
    <div><h2>Daftar berita</h2><p class="hint" style="margin:0">Berita terbaru tampil sebagai berita utama (besar) di halaman Berita.</p></div>
    <a class="btn" href="news_edit.php">+ Tambah berita</a>
   </div>
<?php if (!$rows): ?>
   <p class="empty">Belum ada berita.</p>
<?php else: ?>
   <div class="table-wrap"><table>
    <thead><tr><th></th><th>Tanggal</th><th>Judul</th><th>Status</th><th></th></tr></thead>
    <tbody>
<?php foreach ($rows as $row): ?>
     <tr>
      <td><?php if ($row['image_url'] !== ''): ?><img class="thumb" src="<?= e(admin_asset_url($row['image_url'])) ?>" alt="" loading="lazy"><?php else: ?><span class="thumb"></span><?php endif; ?></td>
      <td><?= e(tgl_indo($row['published_at'])) ?></td>
      <td><?= e($row['title']) ?></td>
      <td><span class="badge <?= $row['is_published'] ? 'badge-on' : 'badge-off' ?>"><?= $row['is_published'] ? 'Tampil' : 'Draf' ?></span></td>
      <td class="actions">
       <a class="btn btn-sm btn-outline" href="news_edit.php?id=<?= (int) $row['id'] ?>">Edit</a>
       <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $row['id'] ?>"><input type="hidden" name="action" value="toggle"><button class="btn btn-sm btn-outline" type="submit"><?= $row['is_published'] ? 'Sembunyikan' : 'Tampilkan' ?></button></form>
       <form method="post" onsubmit="return confirm('Hapus berita ini secara permanen?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $row['id'] ?>"><input type="hidden" name="action" value="delete"><button class="btn btn-sm btn-danger" type="submit">Hapus</button></form>
      </td>
     </tr>
<?php endforeach; ?>
    </tbody>
   </table></div>
<?php endif; ?>
  </div>
<?php admin_footer(); ?>
