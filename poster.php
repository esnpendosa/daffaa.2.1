<?php
$page_title = 'Poster | Materi Promosi | AgriVoice AI';
$page_desc  = 'Unduh poster AgriVoice AI untuk dicetak atau dibagikan.';
$nav_active = 'materi';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero">
 <div class="container">
  <?= breadcrumb('Poster', [['Materi', 'materi.php']]) ?>

  <h1>Poster AgriVoice AI.</h1>
  <p class="lead">Gambar untuk dicetak di kantor BPP atau dibagikan ke kelompok tani.</p>
 </div>
</section>

<section class="page-section"><div class="container"><?= subnav('poster') ?><div class="detail"><div class="detail-media"><img src="https://images.pexels.com/photos/35544010/pexels-photo-35544010/free-photo-of-indonesian-farmer-planting-rice-in-jogja-field.jpeg?auto=compress&cs=tinysrgb&w=1100" alt="Pratinjau poster AgriVoice AI" width="1100" height="760" onerror="this.remove()"></div><div class="detail-copy"><h2>Poster AgriVoice AI</h2><p>Poster yang memperkenalkan AgriVoice AI secara singkat: apa gunanya, siapa yang memakainya, dan bagaimana laporan kunjungan dibuat lewat suara.</p><div class="detail-meta"><span>Format: gambar (PNG/JPG)</span><span>Cocok untuk cetak dan bagikan digital</span></div><div class="detail-actions"><a class="btn" href="<?= e(material_link('link_poster')) ?>"><svg class="i"><use href="#i-download"/></svg>Unduh poster</a> <a class="btn btn-outline" href="materi.php">Materi lainnya</a></div></div></div><p class="note" style="margin-top:28px">Contoh tampilan. Berkas dan tautan diisi setelah materi tersedia.</p></div></section>

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
