<?php
/**
 * Script untuk membuat versi statis HTML dari halaman-halaman PHP
 * untuk kebutuhan deployment ke GitHub Pages.
 */

$pages = [
    'index.php'           => 'index.html',
    'tentang.php'         => 'tentang.html',
    'cara-kerja.php'      => 'cara-kerja.html',
    'fitur.php'           => 'fitur.html',
    'berita.php'          => 'berita.html',
    'materi.php'          => 'materi.html',
    'poster.php'          => 'poster.html',
    'brosur.php'          => 'brosur.html',
    'tangkapan-layar.php' => 'tangkapan-layar.html',
    'video.php'           => 'video.html',
    'kontak.php'          => 'kontak.html',
];

$phpBinary = PHP_BINARY ?: 'php';

echo "Memulai ekspor HTML statis untuk GitHub Pages...\n";

foreach ($pages as $phpFile => $htmlFile) {
    echo "Memproses {$phpFile} -> {$htmlFile}...\n";
    $cmd = escapeshellcmd($phpBinary) . ' ' . escapeshellarg(__DIR__ . '/' . $phpFile);
    $html = shell_exec($cmd);

    if (!$html) {
        echo "Gagal menghasilkan {$phpFile}!\n";
        exit(1);
    }

    // Ubah tautan .php ke .html
    $html = preg_replace(
        '/href="(index|tentang|cara-kerja|fitur|berita|materi|poster|brosur|tangkapan-layar|video|kontak)\.php(#[^"]*)?"/',
        'href="$1.html$2"',
        $html
    );

    file_put_contents(__DIR__ . '/' . $htmlFile, $html);
    echo "✓ Berhasil disimpan: {$htmlFile}\n";
}

// Buat berkas .nojekyll agar GitHub Pages tidak memproses Jekyll
file_put_contents(__DIR__ . '/.nojekyll', '');
echo "✓ Berkas .nojekyll dibuat.\n";
echo "Selesai! Seluruh halaman statis siap untuk GitHub Pages.\n";

