<?php
session_start();

// Hanya menerima request POST (bukan dibuka langsung lewat alamat browser)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$produk = trim($_POST['produk'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$waktu = trim($_POST['waktu'] ?? '');
$urutan = trim($_POST['urutan'] ?? '');
$catatan = trim($_POST['catatan'] ?? '');

$kategoriValid = ['Cleanser', 'Toner', 'Serum', 'Moisturizer', 'Sunscreen', 'Lainnya'];
$waktuValid = ['Pagi', 'Malam'];

// Validasi server-side — wajib ada meski sudah divalidasi JS di Jobsheet 5,
// karena validasi client bisa dilewati (nonaktifkan JS / kirim request manual).
$errors = [];
if ($produk === '') {
    $errors[] = "Nama produk harus diisi.";
} elseif (strlen($produk) > 100) {
    $errors[] = "Nama produk maksimal 100 karakter.";
}
if (!in_array($kategori, $kategoriValid, true)) {
    $errors[] = "Kategori harus dipilih.";
}
if (!in_array($waktu, $waktuValid, true)) {
    $errors[] = "Waktu pemakaian harus dipilih.";
}
if (filter_var($urutan, FILTER_VALIDATE_INT) === false || (int) $urutan < 1) {
    $errors[] = "Urutan harus lebih dari 0.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

if (!isset($_SESSION['rutinitas'])) {
    $_SESSION['rutinitas'] = [];
}

$_SESSION['rutinitas'][] = [
    'produk' => $produk,
    'kategori' => $kategori,
    'waktu' => $waktu,
    'urutan' => (int) $urutan,
    'catatan' => $catatan,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Produk berhasil ditambahkan.'];
header('Location: daftar.php');
exit;