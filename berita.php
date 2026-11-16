<?php
$page_title = 'Berita | AgriVoice AI';
$page_desc  = 'Berita terbaru AgriVoice AI: penjelasan fitur, pembaruan aplikasi, dan kegiatan di lapangan.';
$nav_active = 'berita';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero">
 <div class="container">
  <?= breadcrumb('Berita') ?>

  <h1>Kabar terbaru AgriVoice AI.</h1>
  <p class="lead">Penjelasan fitur, pembaruan aplikasi, dan kegiatan di lapangan.</p>
 </div>
</section>

<?php $news = get_news(); ?>
<section class="section">
 <div class="container">
<?php if (!$news): ?>
  <p class="note">Belum ada berita.</p>
<?php else: ?>
<?php if (count($news) > 1): ?>
  <div class="news-grid">
<?php else: ?>
  <div class="news-grid" style="grid-template-columns:1fr">
<?php endif; ?>
<?php foreach ($news as $i => $item): ?>
<?php if ($i === 0): ?>
   <article class="news-card featured">
    <div class="news-thumb"><?php if ($item['image_url'] !== ''): ?><img src="<?= e($item['image_url']) ?>" alt="<?= e($item['image_alt']) ?>" width="1000" height="667" loading="lazy" onerror="this.remove()"><?php endif; ?></div>
    <div class="news-body">
     <time datetime="<?= e($item['published_at']) ?>"><?= e(tgl_indo($item['published_at'])) ?></time>
     <h3><?= e($item['title']) ?></h3>
<?php if ($item['summary'] !== ''): ?>
     <p><?= e($item['summary']) ?></p>
<?php endif; ?>
     <a class="news-link" href="<?= e($item['link_url']) ?>">Baca selengkapnya</a>
    </div>
   </article>
<?php else: ?>
<?php if ($i === 1): ?>
   <div class="news-side">
<?php endif; ?>
    <article class="news-card">
     <div class="news-thumb"><?php if ($item['image_url'] !== ''): ?><img src="<?= e($item['image_url']) ?>" alt="<?= e($item['image_alt']) ?>" width="600" height="400" loading="lazy" onerror="this.remove()"><?php endif; ?></div>
     <div class="news-body">
      <time datetime="<?= e($item['published_at']) ?>"><?= e(tgl_indo($item['published_at'])) ?></time>
      <h3><?= e($item['title']) ?></h3>
      <a class="news-link" href="<?= e($item['link_url']) ?>">Baca selengkapnya</a>
     </div>
    </article>
<?php endif; ?>
<?php endforeach; ?>
<?php if (count($news) > 1): ?>
   </div>
<?php endif; ?>
  </div>
<?php endif; ?>
<?php if (trim(setting('news_note')) !== ''): ?>
  <p class="note section-foot" style="margin-top:14px"><?= e(setting('news_note')) ?></p>
<?php endif; ?>
 </div>
</section>

<section class="section" style="padding-top:0">
 <div class="container">
  <div class="cta">
   <div><h2>Punya pertanyaan?</h2><p>Tim AgriVoice AI siap membantu menjawab.</p></div>
   <div class="cta-actions"><a class="btn btn-lime" href="kontak.php">Hubungi Kami</a><a class="btn btn-ghost-light" href="materi.php">Materi Promosi</a></div>
  </div>
 </div>
</section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
