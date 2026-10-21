# Wireframe & User Flow — GlowTrack

Sub-CPMK: Merancang UI/UX aplikasi (proyek).

Halaman yang sudah ada (Beranda, Daftar Rutinitas, Tambah Rutinitas, Edit Rutinitas — Jobsheet 1-3) masih berupa HTML statis. Dokumen ini merancang alur dan wireframe untuk fitur yang **belum dibangun**: Login, pengelolaan data (Tambah, Edit, Hapus) yang benar-benar tersimpan, serta pencarian produk. Rancangan ini menjadi acuan implementasi di jobsheet berikutnya (JavaScript, lalu PHP/PostgreSQL).

## Aktor
- **Tamu**: hanya bisa melihat Beranda dan Daftar Rutinitas tanpa login.
- **Pengguna (login)**: bisa menambah, mengedit, dan menghapus produk rutinitas skincare miliknya.

## User Flow — Tambah Produk

```
[Login] -> [Beranda] -> [Klik "Tambah Produk"]
        -> [Isi nama, kategori, waktu, urutan, catatan]
        -> [Simpan] -> [Data tersimpan] -> [Kembali ke Daftar Rutinitas]
```

## User Flow — Edit Produk

```
[Daftar Rutinitas] -> [Klik "Edit" pada produk] -> [Form terisi data lama]
        -> [Ubah data] -> [Update] -> [Kembali ke Daftar Rutinitas]
```

## User Flow — Hapus Produk

```
[Daftar Rutinitas] -> [Klik "Hapus"] -> [Konfirmasi "Yakin ingin menghapus?"]
        -> OK: [Data terhapus] -> [Daftar diperbarui]
        -> Cancel: [Tidak ada perubahan]
```

## User Flow — Cari Produk

```
[Daftar Rutinitas] -> [Ketik kata kunci di kotak cari]
        -> [Tabel tersaring otomatis] -> [Jumlah "Menampilkan X dari Y" ikut berubah]
```

## Wireframe: Halaman Login

```
+----------------------------------------------------+
| GlowTrack      Beranda | Daftar Rutinitas | Login  |
|----------------------------------------------------|
|                                                    |
|        +--------------------------------+          |
|        |  Login                         |          |
|        |                                |          |
|        |  Username                      |          |
|        |  [__________________________]  |          |
|        |  Password                      |          |
|        |  [__________________________]  |          |
|        |                                |          |
|        |  [          Masuk           ]  |          |
|        +--------------------------------+          |
|                                                    |
+----------------------------------------------------+
```

## Wireframe: Beranda (setelah login)

```
+----------------------------------------------------+
| GlowTrack      Beranda | Daftar Rutinitas | Logout |
|----------------------------------------------------|
| +----------------------------------------------+   |
| |  Selamat Datang di GlowTrack    (hero pink)  |   |
| |  Catat dan atur rutinitas skincare kamu...   |   |
| |  (Lihat Rutinitas)   (Tambah Produk)         |   |
| +----------------------------------------------+   |
|                                                    |
| Ringkasan Rutinitas                                |
| +--------------+ +--------------+ +--------------+ |
| |    Total     | |     Pagi     | |    Malam     | |
| |      9       | |      5       | |      4       | |
| +--------------+ +--------------+ +--------------+ |
|                                                    |
+----------------------------------------------------+
```

## Wireframe: Daftar Rutinitas

```
+----------------------------------------------------+
| GlowTrack      Beranda | Daftar Rutinitas | Logout |
|----------------------------------------------------|
| Daftar Rutinitas                                   |
| Kelola semua produk skincare kamu di sini.         |
|                                                    |
| [ Cari produk, kategori, waktu, catatan... ]       |
|                  Menampilkan 9 dari 9 produk       |
| No | Produk      | Waktu | Urutan | Aksi           |
| ---+-------------+-------+--------+--------------  |
| 1  | Cleansing   | Malam |   1    | [Edit][Hapus]  |
| 2  | Retinol     | Malam |   3    | [Edit][Hapus]  |
| 5  | Facial Wash | Pagi  |   1    | [Edit][Hapus]  |
|                                                    |
| (Jika kosong: "Belum ada produk. Yuk tambah yang   |
|  pertama!"  [ + Tambah Produk ])                   |
|                                                    |
+----------------------------------------------------+
```

## Wireframe: Form Tambah Rutinitas

```
+----------------------------------------------------+
| GlowTrack      Beranda | Daftar Rutinitas | Logout |
|----------------------------------------------------|
| Tambah Rutinitas Skincare                          |
|                                                    |
| Nama Produk                                        |
| [ Contoh: Facial Wash Gentle ___________________ ] |
|                                                    |
| Kategori        Waktu Pemakaian   Urutan Pemakaian |
| [Pilih Kategori v] [Pilih Waktu v]  [ 1 ]          |
|                                                    |
| Catatan                                            |
| [ Opsional, misalnya: tunggu 1 menit ... ]         |
| [                                          ]       |
|                                                    |
|                         ( Batal )  [ Simpan ]      |
|                                                    |
+----------------------------------------------------+
```

## Wireframe: Form Edit Rutinitas

```
+----------------------------------------------------+
| GlowTrack      Beranda | Daftar Rutinitas | Logout |
|----------------------------------------------------|
| Edit Rutinitas                                     |
|                                                    |
| Nama Produk                                        |
| [ Vitamin C Serum  (sudah terisi) ______________ ] |
|                                                    |
| Kategori        Waktu             Urutan Pemakaian |
| [Serum v]       [Pagi v]          [ 3 ]            |
|                                                    |
| Catatan                                            |
| [ Tunggu 1 menit sebelum lanjut            ]       |
|                                                    |
|                         ( Batal )  [ Update ]      |
|                                                    |
+----------------------------------------------------+
```

## Wireframe: Konfirmasi Hapus

```
+----------------------------------------------------+
|  (Peringatan bawaan browser, window.confirm)       |
|                                                    |
|        +--------------------------------+          |
|        |  Yakin ingin menghapus data    |          |
|        |  ini?                          |          |
|        |                                |          |
|        |      [   OK   ] [ Cancel ]     |          |
|        +--------------------------------+          |
|                                                    |
+----------------------------------------------------+
```

## Konsistensi dengan Desain yang Sudah Berjalan
- Warna aksen pink, tipografi navbar, dan gaya tabel/kartu mengikuti `assets/css/style.css` yang sudah dibangun sejak Jobsheet 3.
- Navbar akan menampilkan tombol **Login** untuk tamu dan **Logout** setelah pengguna masuk.
- Edge case yang perlu ditangani saat implementasi: nama produk wajib diisi (maksimal 100 karakter), urutan minimal 1, kategori dan waktu hanya boleh dari pilihan yang tersedia, dan tampilan khusus saat daftar masih kosong.