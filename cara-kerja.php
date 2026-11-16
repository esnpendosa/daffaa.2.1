<?php
$page_title = 'Cara Kerja | AgriVoice AI';
$page_desc  = 'Cara kerja AgriVoice AI: lima langkah dari merekam dialog dengan petani sampai laporan PDF disahkan.';
$nav_active = 'cara-kerja';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero">
 <div class="container">
  <?= breadcrumb('Cara Kerja') ?>

  <h1>Dari obrolan di lahan sampai laporan resmi.</h1>
  <p class="lead">Lima langkah yang dijalani penyuluh bersama AgriVoice AI.</p>
 </div>
</section>

<section class="section">
 <div class="container steps-layout">
  <div>
   <ol class="steps">
    <li class="step"><div class="step-number">1</div><div><h3>Rekam dialog</h3><p>Penyuluh mengisi data kunjungan dan merekam dialog dengan petani setelah mendapat persetujuan lisan.</p></div></li>
    <li class="step"><div class="step-number">2</div><div><h3>Suara jadi data</h3><p>Aplikasi mengubah suara menjadi teks dan mengisi data seperti komoditas, umur tanaman, gejala, dan luas lahan.</p></div></li>
    <li class="step"><div class="step-number">3</div><div><h3>AI memberi saran</h3><p>AI menduga kemungkinan hama atau penyakit beserta tingkat keparahannya dan memberi saran sesuai pedoman PHT. Penyuluh memeriksa dan bisa mengoreksinya.</p></div></li>
    <li class="step"><div class="step-number">4</div><div><h3>Bukti tersimpan</h3><p>Foto lahan berstempel waktu dan titik GPS tersimpan sebagai bukti. Tanpa sinyal pun tetap bisa, data terkirim otomatis saat koneksi tersedia.</p></div></li>
    <li class="step"><div class="step-number">5</div><div><h3>Laporan disahkan</h3><p>Laporan PDF diperiksa Koordinator BPP, lalu disahkan pejabat dinas dan siap dicetak.</p></div></li>
   </ol>
  </div>
  <figure class="steps-phone">
   <div class="phone"><img src="assets/app-2.webp" alt="Layar detail kegiatan dengan ringkasan AI dan rekomendasi agronomi" width="540" height="1015" loading="lazy"></div>
   <figcaption>Detail kegiatan dengan ringkasan AI</figcaption>
  </figure>
 </div>
</section>

<section class="section" style="padding-top:0">
 <div class="container">
  <div class="cta">
   <div><h2>Lihat apa saja yang bisa dilakukan.</h2><p>Jelajahi fitur AgriVoice AI untuk penyuluh dan pimpinan.</p></div>
   <div class="cta-actions"><a class="btn btn-lime" href="fitur.php">Lihat Fitur</a><a class="btn btn-ghost-light" href="kontak.php">Hubungi Kami</a></div>
  </div>
 </div>
</section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
