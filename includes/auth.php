<?php
/** Sesi, CSRF, flash message, dan autentikasi admin. */
require_once __DIR__ . '/db.php';

const LOGIN_MAX_FAILS   = 5;     // gagal berapa kali sebelum diblokir
const LOGIN_WINDOW_MIN  = 15;    // ...dalam berapa menit
const SESSION_IDLE_SECS = 7200;  // otomatis keluar setelah 2 jam tidak aktif

function is_https()
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443);
}

function start_session()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    session_name('agrivoice_admin');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => is_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

/* ---------- CSRF ---------- */
function csrf_token()
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function csrf_verify()
{
    $sent = isset($_POST['csrf']) ? $_POST['csrf'] : '';
    if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) {
        http_response_code(419);
        exit('Sesi formulir kedaluwarsa. Muat ulang halaman lalu coba lagi.');
    }
}

/* ---------- Flash message ---------- */
function flash_set($type, $message)
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function flash_pull()
{
    $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
    unset($_SESSION['flash']);
    return $flash;
}

/* ---------- Login ---------- */
function current_admin()
{
    return isset($_SESSION['admin_id'])
        ? ['id' => (int) $_SESSION['admin_id'], 'username' => (string) $_SESSION['admin_name']]
        : null;
}

function require_admin()
{
    if (!current_admin()) {
        redirect('login.php');
    }
    if (isset($_SESSION['last_seen']) && time() - $_SESSION['last_seen'] > SESSION_IDLE_SECS) {
        logout_admin();
        session_start();
        flash_set('err', 'Sesi berakhir karena tidak aktif. Silakan masuk lagi.');
        redirect('login.php');
    }
    $_SESSION['last_seen'] = time();
}

function logout_admin()
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

function client_ip()
{
    return isset($_SERVER['REMOTE_ADDR']) ? substr((string) $_SERVER['REMOTE_ADDR'], 0, 45) : '0.0.0.0';
}

function login_blocked()
{
    $st = db()->prepare('SELECT COUNT(*) FROM login_attempts WHERE ip = ? AND attempted_at > (NOW() - INTERVAL ' . (int) LOGIN_WINDOW_MIN . ' MINUTE)');
    $st->execute([client_ip()]);
    return (int) $st->fetchColumn() >= LOGIN_MAX_FAILS;
}

/** Mengembalikan true bila username + password benar (sesi langsung dibuat). */
function attempt_login($username, $password)
{
    $st = db()->prepare('SELECT id, username, password_hash FROM admins WHERE username = ? LIMIT 1');
    $st->execute([$username]);
    $row = $st->fetch();

    // Tetap memverifikasi hash walau user tidak ada, agar waktu respons tidak membocorkan keberadaan akun.
    $hash = $row ? $row['password_hash'] : password_hash('tidak-ada-user', PASSWORD_DEFAULT);
    $ok   = password_verify($password, $hash) && $row;

    if (!$ok) {
        db()->prepare('INSERT INTO login_attempts (ip) VALUES (?)')->execute([client_ip()]);
        return false;
    }

    db()->prepare('DELETE FROM login_attempts WHERE ip = ?')->execute([client_ip()]);
    if (password_needs_rehash($row['password_hash'], PASSWORD_DEFAULT)) {
        db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')
            ->execute([password_hash($password, PASSWORD_DEFAULT), $row['id']]);
    }
    session_regenerate_id(true);
    $_SESSION['admin_id']  = (int) $row['id'];
    $_SESSION['admin_name'] = $row['username'];
    $_SESSION['last_seen'] = time();
    return true;
}
