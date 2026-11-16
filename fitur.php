<?php
$page_title = 'Fitur | AgriVoice AI';
$page_desc  = 'Fitur AgriVoice AI: form kunjungan 9 tahap, voice-to-report, foto GPS, diagnosis AI, offline-first, dashboard, dan laporan PDF.';
$nav_active = 'fitur';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero">
 <div class="container">
  <?= breadcrumb('Fitur') ?>

  <h1>Yang bisa dilakukan AgriVoice AI.</h1>
  <p class="lead">Dari kunjungan di lapangan sampai pemantauan pimpinan di kantor.</p>
 </div>
</section>

<section class="section">
 <div class="container">
  <div class="cards">
   <article class="card"><div class="icon-box"><svg class="i"><use href="#i-form"/></svg></div><h3>Form Kunjungan 9 Tahap</h3><p>Penyuluh dipandu langkah demi langkah, dari memilih petani dan lahan sampai laporan akhir, dengan validasi dan simpan draf.</p></article>
   <article class="card is-key"><div class="icon-box"><svg class="i"><use href="#i-mic"/></svg></div><h3>Voice-to-Report</h3><p>Dialog dengan petani direkam dan otomatis menjadi transkrip yang bisa disunting serta data laporan terstruktur.</p></article>
   <article class="card"><div class="icon-box"><svg class="i"><use href="#i-camera"/></svg></div><h3>Foto, GPS &amp; Waktu</h3><p>Foto lahan diberi stempel tanggal, jam, dan koordinat otomatis sebagai bukti kunjungan.</p></article>
   <article class="card"><div class="icon-box"><svg class="i"><use href="#i-diagnose"/></svg></div><h3>Diagnosis AI &amp; Saran PHT</h3><p>Dugaan masalah tanaman, tingkat keparahan, dan saran penanganan dengan rujukan SOP. Keputusan tetap di tangan penyuluh.</p></article>
   <article class="card"><div class="icon-box"><svg class="i"><use href="#i-sync"/></svg></div><h3>Offline-first &amp; Auto-sync</h3><p>Tetap bisa merekam dan mencatat di lokasi tanpa sinyal. Data tersimpan di HP dan terkirim otomatis saat ada koneksi.</p></article>
   <article class="card"><div class="icon-box"><svg class="i"><use href="#i-chart"/></svg></div><h3>Dashboard &amp; Peta GIS</h3><p>Pimpinan memantau indikator kinerja, tren kunjungan, dan sebaran kegiatan per wilayah di peta.</p></article>
   <article class="card"><div class="icon-box"><svg class="i"><use href="#i-db"/></svg></div><h3>Database Petani &amp; Lahan</h3><p>Data petani, kelompok tani, petak lahan, dan riwayat musim tanam tertata rapi.</p></article>
   <article class="card"><div class="icon-box"><svg class="i"><use href="#i-report"/></svg></div><h3>Laporan PDF &amp; Verifikasi</h3><p>Penyuluh menyusun, Koordinator BPP memeriksa, pejabat dinas mengesahkan. Laporan siap cetak dan bisa diekspor ke Excel.</p></article>
  </div>

  <div class="support">
   <h3 class="support-title">Fitur pendukung</h3>
   <div class="support-item"><strong>Bank Data &amp; Audit Log</strong><p>Rekaman audio dan berkas tersimpan terarsip. Setiap perubahan data dan login tercatat.</p></div>
   <div class="support-item"><strong>Tindak Lanjut Terjadwal</strong><p>Tenggat kunjungan ulang dan penanda tindakan yang terlambat, supaya rekomendasi tidak terbengkalai.</p></div>
   <div class="support-item"><strong>5 Peran Hak Akses</strong><p>Kepala Dinas, Kabid, Koordinator BPP, PPL, dan Administrator, masing-masing dengan akses sesuai tugasnya.</p></div>
  </div>
 </div>
</section>

<section class="section dark">
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
   <div><h2>Tertarik mencoba AgriVoice AI?</h2><p>Hubungi kami untuk informasi lebih lanjut tentang aplikasi dan pengembangannya.</p></div>
   <div class="cta-actions"><a class="btn btn-lime" href="kontak.php">Hubungi Kami</a><a class="btn btn-ghost-light" href="cara-kerja.php">Lihat Cara Kerja</a></div>
  </div>
 </div>
</section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
