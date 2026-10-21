# Jobsheet 8 — Koneksi PostgreSQL (GlowTrack)

Sub-CPMK: Menghubungkan aplikasi dengan basis data PostgreSQL.

## Perubahan dari Jobsheet 7
- Tambah `sql/01_rutinitas.sql` — DDL tabel `rutinitas` beserta 6 data awal (hanya diisi jika tabel masih kosong).
- Tambah `includes/koneksi.php` — koneksi `PDO` driver `pgsql`.
- `includes/header.php`: data awal di `$_SESSION` (Jobsheet 7) dihapus, karena data kini berasal dari database. `$_SESSION` hanya dipakai untuk flash message.
- `rutinitas/proses_tambah.php`: `$_SESSION['rutinitas'][] = ...` diganti `INSERT ... RETURNING id` via prepared statement, dibungkus `try/catch` agar kegagalan database tidak menampilkan error mentah.
- `rutinitas/daftar.php`: sumber data diganti dari `$_SESSION` menjadi `SELECT * FROM rutinitas ORDER BY waktu, urutan, id`.
- `index.php`: kartu ringkasan (Total/Pagi/Malam) kini `SELECT COUNT(*)` dari database.

## Persiapan database
1. Pastikan PostgreSQL berjalan dan ekstensi PHP `pdo_pgsql` aktif (`php -m` harus memuat `pdo_pgsql`; bila belum, aktifkan `extension=pdo_pgsql` di `php.ini` lalu restart server).
2. Buat database:
   ```bash
   createdb glowtrack
   ```
   (atau lewat pgAdmin: klik kanan Databases → Create → Database → nama `glowtrack`)
3. Jalankan skema:
   ```bash
   psql -d glowtrack -f sql/01_rutinitas.sql
   ```
   (atau di pgAdmin: Query Tool pada database `glowtrack`, buka dan jalankan isi file `.sql`)
4. Sesuaikan kredensial di `includes/koneksi.php` (`$user`, `$pass`) dengan environment lokal.

## Cara menjalankan
- PHP built-in server, dari dalam folder `jobsheet08/`: `php -S localhost:8000`, lalu buka `http://localhost:8000/index.php`.
- Laragon: buka `http://localhost/pemrograman-web/jobsheet08/index.php`.

## Catatan
- Data kini **persisten** — tutup-buka browser, data tetap ada (beda dengan Jobsheet 7 yang hilang saat sesi berakhir).
- Query memakai prepared statement (`:nama_parameter`), bukan penyambungan string, sebagai fondasi keamanan dari SQL injection.
- Urutan tampilan memakai `ORDER BY waktu, urutan, id` (kelompok Malam lalu Pagi, sama dengan tampilan Jobsheet 6-7), bukan `ORDER BY id DESC`.
- Kolom `id` sudah ikut ter-fetch dari `SELECT *` meski belum dipakai di tampilan — akan digunakan untuk Edit/Hapus sungguhan pada jobsheet berikutnya.
- Tombol Hapus masih hanya menghapus baris di tampilan, dan halaman Edit masih form statis.
