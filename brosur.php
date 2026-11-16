<?php
$page_title = 'Brosur | Materi Promosi | AgriVoice AI';
$page_desc  = 'Unduh brosur penjelasan AgriVoice AI dalam format PDF.';
$nav_active = 'materi';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero">
 <div class="container">
  <?= breadcrumb('Brosur', [['Materi', 'materi.php']]) ?>

  <h1>Brosur penjelasan.</h1>
  <p class="lead">Ringkasan fitur dan cara kerja dalam format PDF.</p>
 </div>
</section>

<section class="page-section"><div class="container"><?= subnav('brosur') ?><div class="detail"><div class="detail-media pdf"><svg class="i"><use href="#i-report"/></svg></div><div class="detail-copy"><h2>Brosur AgriVoice AI</h2><p>Ringkasan yang mudah dibaca tentang fitur dan cara kerja AgriVoice AI, cocok untuk dibawa saat sosialisasi.</p><ul class="check-list"><li><span><svg class="i"><use href="#i-check"/></svg></span>Apa itu AgriVoice AI</li><li><span><svg class="i"><use href="#i-check"/></svg></span>Fitur utama untuk penyuluh dan pimpinan</li><li><span><svg class="i"><use href="#i-check"/></svg></span>Lima langkah cara kerja</li></ul><div class="detail-meta"><span>Format: PDF</span></div><div class="detail-actions"><a class="btn" href="<?= e(material_link('link_brosur')) ?>"><svg class="i"><use href="#i-download"/></svg>Unduh PDF</a> <a class="btn btn-outline" href="materi.php">Materi lainnya</a></div></div></div><p class="note" style="margin-top:28px">Contoh tampilan. Berkas dan tautan diisi setelah materi tersedia.</p></div></section>

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
