<?php
$page_title = 'Tentang | AgriVoice AI';
$page_desc  = 'Tentang AgriVoice AI: aplikasi dan dasbor web yang membantu penyuluh pertanian lapangan mencatat kunjungan ke petani.';
$nav_active = 'tentang';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero">
 <div class="container">
  <?= breadcrumb('Tentang') ?>

  <h1>Mencatat kunjungan penyuluh dengan lebih cepat.</h1>
  <p class="lead">Aplikasi Android dan dasbor web untuk Penyuluh Pertanian Lapangan (PPL).</p>
 </div>
</section>

<section class="section">
 <div class="container about-grid">
  <!-- FOTO 2: petani menanam padi, Yogyakarta (Pexels) -->
  <div class="about-image"><img src="https://images.pexels.com/photos/35544010/pexels-photo-35544010/free-photo-of-indonesian-farmer-planting-rice-in-jogja-field.jpeg?auto=compress&cs=tinysrgb&w=1100" alt="Petani menanam padi di sawah" width="1100" height="760" loading="lazy" onerror="this.remove()"></div>
  <div class="about-copy">
   <h2>Apa itu AgriVoice AI?</h2>
   <p>AgriVoice AI adalah aplikasi Android dan dasbor web yang membantu Penyuluh Pertanian Lapangan (PPL) mencatat kunjungan ke petani. Penyuluh cukup berdialog seperti biasa dengan petani, lalu aplikasi merekamnya dan mengubahnya menjadi teks serta data laporan.</p>
   <p>Selama ini penyuluh sering terbebani pencatatan manual dan mengetik ulang hasil kunjungan, sehingga waktu untuk mendampingi petani berkurang. Rekaman percakapan jarang tersimpan, dan di banyak lahan sinyal internet sulit didapat.</p>
   <ul class="check-list">
    <li><span><svg class="i"><use href="#i-check"/></svg></span>Foto, lokasi GPS, dan waktu tercatat otomatis</li>
    <li><span><svg class="i"><use href="#i-check"/></svg></span>Tetap berjalan tanpa internet, data terkirim saat sinyal kembali</li>
    <li><span><svg class="i"><use href="#i-check"/></svg></span>AI memberi saran sesuai pedoman PHT, penyuluh yang memutuskan</li>
   </ul>
   <a class="btn" href="cara-kerja.php">Lihat Cara Kerja</a>
  </div>
 </div>
</section>

<section class="section section-soft">
 <div class="container">
  <div class="section-head"><h2>Lebih sedikit mengetik, lebih banyak bukti lapangan.</h2><p>Empat hal yang berubah bagi penyuluh dan pimpinan.</p></div>
  <div class="why-grid">
   <div class="why-item"><strong>Catatan manual berkurang</strong><p>Penyuluh berbicara, aplikasi yang mengisi data laporan.</p></div>
   <div class="why-item"><strong>Ada bukti kunjungan</strong><p>Rekaman, foto, titik GPS, dan waktu tersimpan terarsip.</p></div>
   <div class="why-item"><strong>Tetap jalan tanpa sinyal</strong><p>Data disimpan di HP dan terkirim sendiri saat koneksi ada.</p></div>
   <div class="why-item"><strong>Laporan sampai ke pimpinan</strong><p>Dashboard dan peta membantu memantau kunjungan per wilayah.</p></div>
  </div>
 </div>
</section>

<section class="section" style="padding-top:0">
 <div class="container">
  <div class="cta">
   <div><h2>Ingin tahu bagaimana cara kerjanya?</h2><p>Lihat lima langkah dari rekam dialog sampai laporan disahkan.</p></div>
   <div class="cta-actions"><a class="btn btn-lime" href="cara-kerja.php">Lihat Cara Kerja</a><a class="btn btn-ghost-light" href="kontak.php">Hubungi Kami</a></div>
  </div>
 </div>
</section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
