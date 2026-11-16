<?php
$page_title = 'Kontak | AgriVoice AI';
$page_desc  = 'Hubungi tim AgriVoice AI lewat WhatsApp atau email.';
$nav_active = 'kontak';
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero">
 <div class="container">
  <?= breadcrumb('Kontak') ?>

  <h1>Ada yang ingin ditanyakan?</h1>
  <p class="lead">Kami senang membantu menjawab pertanyaan seputar AgriVoice AI.</p>
 </div>
</section>

<section class="section">
 <div class="container contact-grid">
  <div class="contact-copy"><h2>Hubungi tim AgriVoice AI.</h2><p>Untuk informasi lebih lanjut tentang aplikasi dan pengembangannya, pilih salah satu jalur di samping.</p></div>
  <div class="contact-list">
   <a class="contact-item" href="https://wa.me/<?= e(preg_replace('/\D+/', '', setting('wa_number'))) ?>"> 
    <span class="icon-box"><svg class="i"><use href="#i-chat"/></svg></span>
    <div><strong>WhatsApp</strong><span><?= e(setting('wa_display')) ?>

    </span></div>
    <span class="btn btn-sm">Kirim pesan</span>
   </a>
   <a class="contact-item" href="mailto:<?= e(setting('email')) ?>"> 
    <span class="icon-box"><svg class="i"><use href="#i-mail"/></svg></span>
    <div><strong>Email</strong><span><?= e(setting('email')) ?></span></div>
    <span class="btn btn-sm btn-outline">Kirim email</span>
   </a>
   <div class="contact-item">
    <span class="icon-box"><svg class="i"><use href="#i-pin"/></svg></span>
    <div><strong>Lokasi</strong><span><?= e(setting('location')) ?></span></div>
   </div>
  </div>
 </div>
</section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
