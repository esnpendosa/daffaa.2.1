<?php
$page_title = 'Video | Materi Promosi | AgriVoice AI';
$page_desc  = 'Tonton video pengenalan AgriVoice AI.';
$nav_active = 'materi';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero">
 <div class="container">
  <?= breadcrumb('Video', [['Materi', 'materi.php']]) ?>

  <h1>Video pengenalan.</h1>
  <p class="lead">Penjelasan singkat cara memakai aplikasi.</p>
 </div>
</section>

<section class="page-section"><div class="container"><?= subnav('video') ?><div class="detail"><div class="detail-media video"><img src="https://images.unsplash.com/photo-1746964246729-3bcad599e959?auto=format&fit=crop&w=1200&q=75" alt="Pratinjau video pengenalan AgriVoice AI" width="1200" height="675" onerror="this.remove()"><span class="play"><svg class="i"><use href="#i-play"/></svg></span></div><div class="detail-copy"><h2>Video pengenalan AgriVoice AI</h2><p>Penjelasan singkat cara memakai aplikasi, dari merekam dialog dengan petani sampai laporan siap dicetak.</p><div class="detail-actions"><a class="btn" href="<?= e(material_link('link_video')) ?>"><svg class="i"><use href="#i-play"/></svg>Tonton video</a> <a class="btn btn-outline" href="materi.php">Materi lainnya</a></div></div></div><p class="note" style="margin-top:28px">Contoh tampilan. Berkas dan tautan diisi setelah materi tersedia.</p></div></section>

<section class="section" style="padding-top:0">
 <div class="container">
  <div class="cta">
   <div><h2>Butuh materi lain?</h2><p>Hubungi kami jika Anda memerlukan materi tambahan.</p></div>
   <div class="cta-actions"><a class="btn btn-lime" href="kontak.php">Hubungi Kami</a><a class="btn btn-ghost-light" href="materi.php">Semua Materi</a></div>
  </div>
 </div>
</section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
