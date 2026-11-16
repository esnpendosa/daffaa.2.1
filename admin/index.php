<?php
require __DIR__ . '/../includes/admin_bootstrap.php';
require_admin();

$total     = (int) db()->query('SELECT COUNT(*) FROM news')->fetchColumn();
$published = (int) db()->query('SELECT COUNT(*) FROM news WHERE is_published = 1')->fetchColumn();
$latest    = db()->query('SELECT id, title, published_at, is_published FROM news ORDER BY published_at DESC, id DESC LIMIT 5')->fetchAll();

admin_header('Dashboard', 'index');
?>
  <div class="stats">
   <div class="stat"><b><?= $total ?></b><span>Total berita</span></div>
   <div class="stat"><b><?= $published ?></b><span>Berita tampil di situs</span></div>
   <div class="stat"><b><?= $total - $published ?></b><span>Draf (disembunyikan)</span></div>
  </div>

  <div class="card">
   <h2>Berita terbaru</h2>
   <p class="hint">Lima berita terakhir berdasarkan tanggal terbit.</p>
<?php if (!$latest): ?>
   <p class="empty">Belum ada berita. <a href="news_edit.php">Tambah berita pertama</a>.</p>
<?php else: ?>
   <div class="table-wrap"><table>
    <thead><tr><th>Tanggal</th><th>Judul</th><th>Status</th><th></th></tr></thead>
    <tbody>
<?php foreach ($latest as $row): ?>
     <tr>
      <td><?= e(tgl_indo($row['published_at'])) ?></td>
      <td><?= e($row['title']) ?></td>
      <td><span class="badge <?= $row['is_published'] ? 'badge-on' : 'badge-off' ?>"><?= $row['is_published'] ? 'Tampil' : 'Draf' ?></span></td>
      <td class="actions"><a class="btn btn-sm btn-outline" href="news_edit.php?id=<?= (int) $row['id'] ?>">Edit</a></td>
     </tr>
<?php endforeach; ?>
    </tbody>
   </table></div>
<?php endif; ?>
   <div class="form-actions"><a class="btn" href="news_edit.php">Tambah berita</a><a class="btn btn-outline" href="news.php">Semua berita</a></div>
  </div>

  <div class="card">
   <h2>Pengaturan situs</h2>
   <p class="hint">Kontak yang tampil di halaman Kontak dan tautan unduhan di halaman Materi.</p>
   <div class="form-actions"><a class="btn btn-outline" href="settings.php">Ubah kontak &amp; tautan materi</a></div>
  </div>
<?php admin_footer(); ?>
