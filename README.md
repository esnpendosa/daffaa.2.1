# AgriVoice AI — PHP native + MySQL + Admin Panel

Kebutuhan: PHP 7.4+ (ekstensi `pdo_mysql`, `fileinfo`, `mbstring`), MySQL 5.7+ / MariaDB 10.3+.

## Pemasangan
1. Salin folder ini ke server (mis. `htdocs/agrivoice`).
2. Buat database kosong (mis. `agrivoice`) atau biarkan installer membuatnya bila user MySQL punya izin.
3. Sesuaikan akses database di `config.php` (host, nama db, user, password).
4. Pastikan folder `uploads/` dapat ditulis oleh web server.
5. Buka `http://localhost/agrivoice/install.php`, isi username + kata sandi admin, klik **Pasang**.
6. **Hapus `install.php`** dari server.
7. Masuk di `http://localhost/agrivoice/admin/login.php`.

Tanpa Apache/XAMPP: jalankan `php -S localhost:8000` di folder ini, lalu buka `http://localhost:8000/install.php`.

## Yang bisa dikelola dari admin
- **Berita**: tambah/ubah/hapus, sembunyikan (draf), gambar via unggah atau URL. Berita terbaru jadi kartu besar.
- **Materi & Kontak**: nomor WhatsApp, email, lokasi, tautan/berkas unduhan Poster, Brosur, Tangkapan Layar, Video, dan catatan di halaman Berita.
- **Akun**: ganti kata sandi.

## Struktur
```
index.php, tentang.php, ... kontak.php   halaman publik
includes/   header/footer, fungsi template, db.php, data.php (pengaturan & berita), auth.php, upload.php, admin_*.php
admin/      login, dashboard, berita, pengaturan, akun
database/   schema.sql, sample_news.json
uploads/    berkas unggahan (tidak bisa dieksekusi)
```

## Keamanan yang sudah diterapkan
Prepared statements (PDO), kata sandi `password_hash`, token CSRF di semua form POST, sesi HttpOnly + SameSite,
pembatasan 5 kali gagal login / 15 menit per IP, validasi jenis berkas dari isinya (SVG ditolak), nama berkas diacak,
output di-escape, tautan `javascript:` ditolak, `.htaccess` memblokir `includes/`, `database/`, dan `config.php`.
Di Nginx, blokir folder-folder itu lewat konfigurasi server, dan gunakan HTTPS untuk admin.

Jika database tidak bisa dihubungi, halaman publik tetap tampil memakai nilai bawaan (berita kosong).
