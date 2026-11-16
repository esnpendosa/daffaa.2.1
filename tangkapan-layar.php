<?php
$page_title = 'Tangkapan Layar | Materi Promosi | AgriVoice AI';
$page_desc  = 'Tangkapan layar aplikasi AgriVoice AI untuk presentasi.';
$nav_active = 'materi';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero">
 <div class="container">
  <?= breadcrumb('Tangkapan Layar', [['Materi', 'materi.php']]) ?>

  <h1>Tangkapan layar aplikasi.</h1>
  <p class="lead">Kumpulan tampilan layar untuk presentasi.</p>
 </div>
</section>

<section class="page-section"><div class="container"><?= subnav('tangkapan-layar') ?><div class="shots shots-light"><figure class="shot"><div class="phone"><img src="assets/app-1.webp" alt="Beranda aplikasi dengan pilihan mode online dan offline" width="540" height="1015" loading="lazy"></div><figcaption>Beranda dengan mode online dan offline</figcaption></figure><figure class="shot"><div class="phone"><img src="assets/app-3.webp" alt="Layar rekam suara kunjungan dengan transkripsi realtime" width="540" height="1015" loading="lazy"></div><figcaption>Rekam suara kunjungan</figcaption></figure><figure class="shot"><div class="phone"><img src="assets/app-2.webp" alt="Layar detail kegiatan dengan ringkasan AI" width="540" height="1015" loading="lazy"></div><figcaption>Detail kegiatan dengan ringkasan AI</figcaption></figure></div><div class="detail-actions" style="justify-content:center;margin-top:40px"><a class="btn" href="<?= e(material_link('link_screenshots')) ?>"><svg class="i"><use href="#i-image"/></svg>Unduh gambar</a> <a class="btn btn-outline" href="materi.php">Materi lainnya</a></div><p class="note section-foot" style="margin-top:22px">Tampilan prototipe dengan data contoh.</p></div></section>

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
