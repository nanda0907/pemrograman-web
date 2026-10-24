# Jobsheet 10 — Autentikasi & Manajemen Sesi (GlowTrack)

Sub-CPMK: Menerapkan autentikasi & manajemen sesi pengguna.

## Perubahan dari Jobsheet 9
- Tambah `sql/02_users.sql` — tabel `users` (nama, username, password, role).
- Tambah `auth/register.php` + `proses_register.php` (password disimpan dengan `password_hash()`, cek username duplikat), `auth/login.php` + `proses_login.php` (`password_verify()` + `session_regenerate_id()`), `auth/logout.php` (`session_destroy()`).
- Tambah `includes/auth.php` — guard clause: redirect ke `auth/login.php` bila `$_SESSION['user_id']` belum ada. **Wajib di-include sebagai baris pertama** (sebelum `header.php`) agar `header('Location: ...')` masih bisa dipanggil sebelum ada output HTML.
- `includes/header.php`: `session_start()` diubah menjadi `if (session_status() === PHP_SESSION_NONE)` agar tidak konflik dengan `auth.php`; navbar menampilkan nama pengguna + Logout jika sudah login, atau link Login jika belum.
- `index.php`: tombol kedua di hero berubah sesuai status login ("Tambah Produk" jika sudah login, "Login untuk Mengelola" jika belum).
- `rutinitas/daftar.php`: kolom Aksi (tombol Edit/Hapus) hanya tampil untuk pengguna yang sudah login.
- Halaman yang **dikunci** (butuh login): `rutinitas/tambah.php`, `edit.php`, `proses_tambah.php`, `proses_edit.php`, `hapus.php`.
- Halaman yang **tetap publik**: `index.php` (Beranda) dan `rutinitas/daftar.php` (daftar bisa dilihat Tamu tanpa login — sesuai wireframe Jobsheet 4).

## Persiapan database
Jalankan skema tambahan pada database `glowtrack`:
```bash
psql -d glowtrack -f sql/02_users.sql
```
(atau di DBeaver/HeidiSQL: buka Query pada database `glowtrack`, paste isi `02_users.sql`, lalu jalankan)

## Cara menjalankan
Buka `http://localhost/pemrograman-web/jobsheet10/index.php` (Laragon) atau `php -S localhost:8000` dari folder `jobsheet10/`.
Uji: akses `rutinitas/tambah.php` langsung tanpa login → harus redirect ke halaman Login. Daftar akun lewat Registrasi, login, lalu coba akses halaman yang sama → berhasil.

## Catatan
- Guard `auth.php` berjalan sebelum kode yang butuh koneksi database, sehingga halaman terkunci mengembalikan redirect 302 ke login.
- Data produk (tabel `rutinitas`) belum dipisah per pengguna — semua pengguna login melihat dan mengelola data yang sama.
- Perbedaan akses berdasarkan `role` belum diterapkan; kolom `role` disiapkan untuk pengembangan berikutnya (tugas mandiri).
- Nama pengguna di navbar dan semua pesan flash dicetak lewat `e()` (`htmlspecialchars`), dan ID sesi diganti setelah login berhasil (`session_regenerate_id`) untuk mencegah session fixation.
