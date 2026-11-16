<?php
$page_title = 'Materi Promosi | AgriVoice AI';
$page_desc  = 'Materi promosi AgriVoice AI: poster, brosur, tangkapan layar, dan video untuk dibagikan.';
$nav_active = 'materi';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero">
 <div class="container">
  <?= breadcrumb('Materi') ?>

  <h1>Unduh dan bagikan.</h1>
  <p class="lead">Pilih jenis materi untuk memperkenalkan AgriVoice AI ke rekan dan kelompok tani. Setiap jenis punya halamannya sendiri.</p>
 </div>
</section>

<section class="page-section"><div class="container"><div class="materi-grid"><article class="materi-card"><div class="materi-thumb"><span class="tag">Poster</span><img src="https://images.pexels.com/photos/35544010/pexels-photo-35544010/free-photo-of-indonesian-farmer-planting-rice-in-jogja-field.jpeg?auto=compress&cs=tinysrgb&w=1100&w=600" alt="" width="600" height="400" loading="lazy" onerror="this.remove()"></div><div class="materi-body"><h3>Poster AgriVoice AI</h3><p>Gambar untuk dicetak atau dibagikan.</p><a class="btn btn-sm" href="poster.php">Lihat poster</a></div></article><article class="materi-card"><div class="materi-thumb pdf"><span class="tag">Brosur</span><svg class="i"><use href="#i-report"/></svg></div><div class="materi-body"><h3>Brosur penjelasan</h3><p>Ringkasan fitur dan cara kerja dalam format PDF.</p><a class="btn btn-sm" href="brosur.php">Lihat brosur</a></div></article><article class="materi-card"><div class="materi-thumb shotbg"><span class="tag">Aplikasi</span><img src="assets/app-1.webp" alt="" width="540" height="1015" loading="lazy"></div><div class="materi-body"><h3>Tangkapan layar aplikasi</h3><p>Kumpulan tampilan layar untuk presentasi.</p><a class="btn btn-sm" href="tangkapan-layar.php">Lihat tangkapan layar</a></div></article><article class="materi-card"><div class="materi-thumb"><span class="tag">Video</span><img src="https://images.unsplash.com/photo-1746964246729-3bcad599e959?auto=format&fit=crop&w=1200&q=75" alt="" width="600" height="400" loading="lazy" onerror="this.remove()"><span class="play"><svg class="i"><use href="#i-play"/></svg></span></div><div class="materi-body"><h3>Video pengenalan</h3><p>Penjelasan singkat cara memakai aplikasi.</p><a class="btn btn-sm" href="video.php">Lihat video</a></div></article></div></div></section>

<section class="section" style="padding-top:0">
 <div class="container">
  <div class="cta">
   <div><h2>Butuh materi lain?</h2><p>Hubungi kami jika Anda memerlukan materi tambahan.</p></div>
   <div class="cta-actions"><a class="btn btn-lime" href="kontak.php">Hubungi Kami</a><a class="btn btn-ghost-light" href="berita.php">Baca Berita</a></div>
  </div>
 </div>
</section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
