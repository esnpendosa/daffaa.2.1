<?php
/**
 * Data dinamis untuk halaman publik (pengaturan, berita).
 * Bila database tidak bisa dihubungi, situs tetap tampil memakai nilai bawaan di bawah ini.
 */
require_once __DIR__ . '/db.php';

/** Nilai bawaan pengaturan (juga dipakai installer untuk mengisi tabel settings). */
function setting_defaults()
{
    return [
        'wa_number'        => '6281554190997',
        'wa_display'       => '+62 815-5419-0997',
        'email'            => 'daffaakhoirin12@gmail.com',
        'location'         => 'Leran,Manyar,Gresik',
        'news_note'        => 'Contoh tampilan. Judul, tanggal, dan isi diganti dengan berita sebenarnya.',
        'link_poster'      => '',
        'link_brosur'      => '',
        'link_screenshots' => '',
        'link_video'       => '',
    ];
}

/** Semua pengaturan (bawaan + isi tabel settings), di-cache selama satu request. */
function setting_all($refresh = false)
{
    static $cache = null;
    if ($cache === null || $refresh) {
        $cache = setting_defaults();
        try {
            $rows = db()->query('SELECT setting_key, setting_value FROM settings')->fetchAll(PDO::FETCH_KEY_PAIR);
            foreach ($rows as $key => $value) {
                $cache[$key] = (string) $value;
            }
        } catch (Throwable $ex) {
            error_log('[agrivoice] setting_all: ' . $ex->getMessage());
        }
    }
    return $cache;
}

function setting($key, $default = '')
{
    $all = setting_all();
    return array_key_exists($key, $all) ? $all[$key] : $default;
}

/** Tautan unduhan materi; kosong => '#'. */
function material_link($key)
{
    $value = trim(setting($key));
    return $value === '' ? '#' : $value;
}

/** Berita terbaru lebih dulu. $onlyPublished = false untuk panel admin. */
function get_news($onlyPublished = true)
{
    try {
        $sql = 'SELECT id, title, summary, image_url, image_alt, link_url, published_at, is_published FROM news'
             . ($onlyPublished ? ' WHERE is_published = 1' : '')
             . ' ORDER BY published_at DESC, id DESC';
        $rows = db()->query($sql)->fetchAll();
        if (!empty($rows)) {
            return $rows;
        }
    } catch (Throwable $ex) {
        error_log('[agrivoice] get_news: ' . $ex->getMessage());
    }

    $sample = __DIR__ . '/../database/sample_news.json';
    if (file_exists($sample)) {
        $data = json_decode(file_get_contents($sample), true);
        if (is_array($data)) {
            return $data;
        }
    }
    return [];
}

/** '2026-11-16' => '16 November 2026' */
function tgl_indo($date)
{
    $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $parts = explode('-', substr((string) $date, 0, 10));
    if (count($parts) !== 3 || !checkdate((int) $parts[1], (int) $parts[2], (int) $parts[0])) {
        return '';
    }
    return (int) $parts[2] . ' ' . $bulan[(int) $parts[1]] . ' ' . (int) $parts[0];
}
