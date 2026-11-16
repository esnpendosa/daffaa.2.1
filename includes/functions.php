<?php
/**
 * Fungsi bantu untuk template AgriVoice AI.
 * Semua keluaran HTML-nya sama persis dengan versi statis sebelumnya.
 */

/** Escape teks untuk dicetak di HTML. */
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Menu utama: kunci => [label, url]. Ubah di sini, semua halaman ikut berubah. */
function nav_items()
{
    return [
        'index'      => ['Beranda',    'index.php'],
        'tentang'    => ['Tentang',    'tentang.php'],
        'cara-kerja' => ['Cara Kerja', 'cara-kerja.php'],
        'fitur'      => ['Fitur',      'fitur.php'],
        'berita'     => ['Berita',     'berita.php'],
        'materi'     => ['Materi',     'materi.php'],
        'kontak'     => ['Kontak',     'kontak.php'],
    ];
}

/** Tautan menu utama; $active = kunci halaman yang sedang dibuka. */
function nav_links($active)
{
    $html = '';
    foreach (nav_items() as $key => $item) {
        $current = ($key === $active) ? ' aria-current="page"' : '';
        $html .= '<a href="' . $item[1] . '"' . $current . '>' . $item[0] . '</a>';
    }
    return $html;
}

/** Sub-menu jenis materi (halaman Poster, Brosur, Tangkapan Layar, Video). */
function subnav_items()
{
    return [
        'materi'          => ['Semua materi',    'materi.php'],
        'poster'          => ['Poster',          'poster.php'],
        'brosur'          => ['Brosur',          'brosur.php'],
        'tangkapan-layar' => ['Tangkapan Layar', 'tangkapan-layar.php'],
        'video'           => ['Video',           'video.php'],
    ];
}

function subnav($active)
{
    $html = '<nav class="subnav" aria-label="Jenis materi">';
    foreach (subnav_items() as $key => $item) {
        $current = ($key === $active) ? ' aria-current="page"' : '';
        $html .= '<a href="' . $item[1] . '"' . $current . '>' . $item[0] . '</a>';
    }
    return $html . '</nav>';
}

/**
 * Jejak halaman. $current = judul halaman ini,
 * $parents = daftar [label, url] induknya (opsional).
 */
function breadcrumb($current, $parents = [])
{
    $sep  = '<span aria-hidden="true">/</span>';
    $html = '<nav class="breadcrumb" aria-label="Jejak halaman"><a href="index.php">Beranda</a>';
    foreach ($parents as $p) {
        $html .= $sep . '<a href="' . $p[1] . '">' . $p[0] . '</a>';
    }
    return $html . $sep . '<span aria-current="page">' . $current . '</span></nav>';
}

require_once __DIR__ . '/data.php';
