<?php
/** Dimuat di awal setiap halaman admin. */
require_once __DIR__ . '/functions.php';   // e(), data publik
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/upload.php';
require_once __DIR__ . '/admin_ui.php';

date_default_timezone_set(app_config()['timezone']);
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');
header('Cache-Control: no-store');
start_session();

/**
 * Validasi tautan: '#', alamat http/https/mailto/tel, atau path relatif.
 * Skema lain (javascript:, data:, dll.) ditolak.
 */
function valid_link($value)
{
    if ($value === '#' || $value === '') {
        return true;
    }
    if (preg_match('#^[a-z][a-z0-9+.\-]*:#i', $value)) {
        return (bool) preg_match('#^(https?://|mailto:|tel:)#i', $value) && strlen($value) <= 500;
    }
    return strlen($value) <= 500 && !preg_match('/[\s"<>]/', $value);
}

function valid_http_url($value)
{
    return (bool) preg_match('#^https?://[^\s"<>]+$#i', $value) && strlen($value) <= 500;
}

/** Path untuk dipakai dari folder /admin (URL luar dibiarkan, path relatif diberi ../). */
function admin_asset_url($path)
{
    return preg_match('#^https?://#i', $path) ? $path : '../' . ltrim($path, '/');
}

// Cadangan bila ekstensi mbstring tidak aktif di hosting.
if (!function_exists('mb_strlen')) {
    function mb_strlen($value)
    {
        return strlen($value);
    }
}
