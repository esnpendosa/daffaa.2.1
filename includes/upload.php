<?php
/** Unggah berkas yang aman (jenis dicek dari isi berkas, nama diacak, disimpan di /uploads). */
require_once __DIR__ . '/db.php';

/** Jenis berkas yang diizinkan: mime => ekstensi. SVG sengaja tidak diizinkan (bisa memuat skrip). */
function upload_types($kind)
{
    $image = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    switch ($kind) {
        case 'image':
            return $image;
        case 'pdf':
            return ['application/pdf' => 'pdf'];
        case 'image_zip':
            return $image + ['application/zip' => 'zip'];
    }
    return [];
}

function upload_error_message($code)
{
    switch ($code) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            return 'Berkas terlalu besar (batas server terlampaui).';
        case UPLOAD_ERR_PARTIAL:
            return 'Berkas hanya terunggah sebagian. Coba lagi.';
        default:
            return 'Berkas gagal diunggah (kode ' . (int) $code . ').';
    }
}

/**
 * Memproses <input type="file" name="$field">.
 * Mengembalikan 'uploads/nama-acak.ext', atau null bila tidak ada berkas dipilih.
 * Melempar RuntimeException (pesan siap tampil) bila berkas ditolak.
 */
function handle_upload($field, array $types, $prefix)
{
    if (!isset($_FILES[$field]) || !is_array($_FILES[$field]) || is_array($_FILES[$field]['error'])) {
        return null;
    }
    $file = $_FILES[$field];
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException(upload_error_message($file['error']));
    }
    $max = app_config()['upload_max_bytes'];
    if ($file['size'] > $max) {
        throw new RuntimeException('Ukuran berkas melebihi ' . round($max / 1048576) . ' MB.');
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        throw new RuntimeException('Berkas tidak valid.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    if (!isset($types[$mime])) {
        throw new RuntimeException('Jenis berkas tidak diizinkan. Gunakan: ' . implode(', ', array_unique(array_values($types))) . '.');
    }
    if (strpos($mime, 'image/') === 0 && @getimagesize($file['tmp_name']) === false) {
        throw new RuntimeException('Berkas gambar rusak atau tidak valid.');
    }

    $dir = dirname(__DIR__) . '/uploads';
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        throw new RuntimeException('Folder uploads tidak bisa dibuat.');
    }
    $name = $prefix . '-' . bin2hex(random_bytes(8)) . '.' . $types[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) {
        throw new RuntimeException('Berkas tidak bisa disimpan. Pastikan folder uploads dapat ditulis.');
    }
    return 'uploads/' . $name;
}

/** Menghapus berkas hasil unggahan (hanya path 'uploads/nama.ext' yang valid). */
function delete_upload($path)
{
    if (is_string($path) && preg_match('#^uploads/[A-Za-z0-9_-]+\.[A-Za-z0-9]+$#', $path)) {
        $full = dirname(__DIR__) . '/' . $path;
        if (is_file($full)) {
            @unlink($full);
        }
    }
}

function is_upload_path($path)
{
    return is_string($path) && preg_match('#^uploads/[A-Za-z0-9_-]+\.[A-Za-z0-9]+$#', $path) === 1;
}
