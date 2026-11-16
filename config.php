<?php
/**
 * Konfigurasi AgriVoice AI.
 * Sesuaikan data database di bawah ini (atau pakai environment variable DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS).
 */
return [
    'db' => [
        'host'    => getenv('DB_HOST') ?: 'localhost',
        'port'    => (int) (getenv('DB_PORT') ?: 3306),
        'name'    => getenv('DB_NAME') ?: 'agro',
        'user'    => getenv('DB_USER') ?: 'root',
        'pass'    => getenv('DB_PASS') !== false ? getenv('DB_PASS') : '',
        'charset' => 'utf8mb4',
    ],
    'timezone'         => 'Asia/Jakarta',
    'upload_max_bytes' => 5 * 1024 * 1024, // 5 MB
];
