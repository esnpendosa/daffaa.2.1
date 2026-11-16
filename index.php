<?php
$page_title = 'AgriVoice AI | Laporan penyuluhan pertanian lewat suara';
$page_desc  = 'AgriVoice AI adalah aplikasi laporan berbasis suara untuk penyuluh pertanian lapangan. Rekam dialog dengan petani, jadi laporan kunjungan lengkap dengan foto, GPS, dan waktu.';
$nav_active = 'index';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="hero" id="beranda">
 <div class="container hero-center">
  <span class="eyebrow">Aplikasi laporan untuk penyuluh pertanian</span>
  <h1>Laporan penyuluhan pertanian, cukup dengan berbicara.</h1>
  <p class="lead">AgriVoice AI membantu penyuluh pertanian lapangan mengubah obrolan dengan petani menjadi laporan kunjungan yang rapi, lengkap dengan bukti foto, lokasi, dan rekaman.</p>
  <div class="hero-actions"><a class="btn btn-pill btn-lime" href="tentang.php">Kenali AgriVoice AI</a><a class="btn btn-pill btn-dark" href="fitur.php">Lihat Fitur</a></div>
 </div>
 <div class="hero-pill left"><span class="wave" aria-hidden="true"><i style="--h:8px;--n:0"></i><i style="--h:14px;--n:1"></i><i style="--h:22px;--n:2"></i><i style="--h:12px;--n:3"></i><i style="--h:18px;--n:4"></i><i style="--h:24px;--n:5"></i><i style="--h:13px;--n:6"></i><i style="--h:20px;--n:7"></i><i style="--h:10px;--n:8"></i><i style="--h:16px;--n:9"></i></span>Dari suara ke laporan</div>
 <a class="hero-pill right" href="#mulai">Gulir ke bawah<svg class="i" viewBox="0 0 24 24"><path d="M12 5v14M6 13l6 6 6-6"/></svg></a>
</section>

<section class="section" id="mulai">
 <div class="container demo">
  <div class="demo-copy">
   <h2>Cukup bicara, data kunjungan terisi.</h2>
   <p>Saat penyuluh berbincang dengan petani, AgriVoice AI mengenali isi percakapan dan mengisi data kunjungan. Penyuluh tinggal memeriksa dan mengoreksi.</p>
   <a class="btn" href="cara-kerja.php">Lihat cara kerja</a>
  </div>
  <div class="demo-card">
   <div class="say">
    <span class="mic"><svg class="i"><use href="#i-mic"/></svg></span>
    <div><small>Percakapan di lahan</small><p>&ldquo;Cabai saya umur 35 hari, daunnya keriting, kira-kira setengah hektar.&rdquo;</p></div>
    <div class="wave" aria-hidden="true"><i style="--h:10px;--n:0"></i><i style="--h:18px;--n:1"></i><i style="--h:26px;--n:2"></i><i style="--h:14px;--n:3"></i><i style="--h:22px;--n:4"></i><i style="--h:30px;--n:5"></i><i style="--h:16px;--n:6"></i><i style="--h:24px;--n:7"></i><i style="--h:12px;--n:8"></i><i style="--h:20px;--n:9"></i><i style="--h:28px;--n:10"></i><i style="--h:14px;--n:11"></i><i style="--h:22px;--n:12"></i><i style="--h:10px;--n:13"></i><i style="--h:18px;--n:14"></i></div>
   </div>
   <ul class="fields">
    <li><span>Komoditas</span><strong>Cabai</strong></li>
    <li><span>Umur tanaman</span><strong>35 hari</strong></li>
    <li><span>Gejala</span><strong>Daun keriting</strong></li>
    <li><span>Luas lahan</span><strong>0,5 ha</strong></li>
   </ul>
   <p class="demo-note">Contoh ilustrasi. Data tersimpan setelah diperiksa penyuluh.</p>
  </div>
 </div>
</section>

<section class="section section-soft">
 <div class="container about-grid">
  <!-- FOTO 2: petani menanam padi, Yogyakarta (Pexels) -->
  <div class="about-image"><img src="assets/pexels-photo-35544010.avif" alt="Petani menanam padi di sawah" width="1100" height="760" loading="lazy"></div>
  <div class="about-copy">
   <h2>Mencatat kunjungan penyuluh dengan lebih cepat.</h2>
   <p>AgriVoice AI adalah aplikasi Android dan dasbor web yang membantu Penyuluh Pertanian Lapangan (PPL) mencatat kunjungan ke petani. Penyuluh cukup berdialog seperti biasa dengan petani, lalu aplikasi merekamnya dan mengubahnya menjadi teks serta data laporan.</p>
   <ul class="check-list">
    <li><span><svg class="i"><use href="#i-check"/></svg></span>Foto, lokasi GPS, dan waktu tercatat otomatis</li>
    <li><span><svg class="i"><use href="#i-check"/></svg></span>Tetap berjalan tanpa internet, data terkirim saat sinyal kembali</li>
    <li><span><svg class="i"><use href="#i-check"/></svg></span>AI memberi saran sesuai pedoman PHT, penyuluh yang memutuskan</li>
   </ul>
   <a class="btn" href="tentang.php">Selengkapnya tentang kami</a>
  </div>
 </div>
</section>

<section class="section">
 <div class="container">
  <div class="section-head left"><h2>Mulai dari mana?</h2><p>Setiap topik punya halamannya sendiri.</p></div>
  <ul class="index">
   <li><a href="tentang.php"><span class="ix-title">Tentang</span><span class="ix-desc">Latar belakang, tujuan, dan manfaat bagi penyuluh dan pimpinan.</span><span class="ix-go"><svg class="i" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a></li>
   <li><a href="cara-kerja.php"><span class="ix-title">Cara Kerja</span><span class="ix-desc">Lima langkah dari rekam dialog sampai laporan disahkan.</span><span class="ix-go"><svg class="i" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a></li>
   <li><a href="fitur.php"><span class="ix-title">Fitur</span><span class="ix-desc">Voice-to-report, foto GPS, diagnosis AI, offline-first, dashboard.</span><span class="ix-go"><svg class="i" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a></li>
   <li><a href="berita.php"><span class="ix-title">Berita</span><span class="ix-desc">Penjelasan fitur, pembaruan aplikasi, dan kegiatan di lapangan.</span><span class="ix-go"><svg class="i" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a></li>
   <li><a href="materi.php"><span class="ix-title">Materi Promosi</span><span class="ix-desc">Poster, brosur, tangkapan layar, dan video untuk dibagikan.</span><span class="ix-go"><svg class="i" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a></li>
   <li><a href="kontak.php"><span class="ix-title">Kontak</span><span class="ix-desc">Hubungi tim AgriVoice AI lewat WhatsApp atau email.</span><span class="ix-go"><svg class="i" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span></a></li>
  </ul>
 </div>
</section>

<section class="section dark" id="aplikasi">
 <div class="container">
  <div class="section-head"><h2>Seperti inilah aplikasinya.</h2><p>Tiga layar yang paling sering dipakai penyuluh di lapangan.</p></div>
  <div class="shots">
   <figure class="shot"><div class="phone"><img src="assets/app-3.webp" alt="Beranda aplikasi dengan pilihan mode online dan offline" width="540" height="1015" loading="lazy"></div><figcaption>Beranda dengan mode online dan offline</figcaption></figure>
   <figure class="shot"><div class="phone"><img src="assets/app-1.webp" alt="Layar rekam suara kunjungan dengan transkripsi realtime" width="540" height="1015" loading="lazy"></div><figcaption>Rekam suara kunjungan</figcaption></figure>
   <figure class="shot"><div class="phone"><img src="assets/app-2.webp" alt="Layar detail kegiatan dengan ringkasan AI" width="540" height="1015" loading="lazy"></div><figcaption>Detail kegiatan dengan ringkasan AI</figcaption></figure>
  </div>
  <p class="shot-note">Tampilan prototipe dengan data contoh.</p>
 </div>
</section>

<section class="section" style="padding-top:0">
 <div class="container">
  <div class="cta">
   <div><h2>Ikuti kabar terbaru AgriVoice AI.</h2><p>Baca berita, unduh materi promosi, atau hubungi kami untuk informasi lebih lanjut.</p></div>
   <div class="cta-actions"><a class="btn btn-lime" href="berita.php">Baca Berita</a><a class="btn btn-ghost-light" href="kontak.php">Hubungi Kami</a></div>
  </div>
 </div>
</section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>