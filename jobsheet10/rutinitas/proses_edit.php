<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

// Hanya menerima request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: daftar.php');
    exit;
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: daftar.php');
    exit;
}

$produk = trim($_POST['produk'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$waktu = trim($_POST['waktu'] ?? '');
$urutan = trim($_POST['urutan'] ?? '');
$catatan = trim($_POST['catatan'] ?? '');

$kategoriValid = ['Cleanser', 'Toner', 'Serum', 'Moisturizer', 'Sunscreen', 'Lainnya'];
$waktuValid = ['Pagi', 'Malam'];

// Validasi server-side (sama seperti proses_tambah.php)
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
    header('Location: edit.php?id=' . $id);
    exit;
}

try {
    $stmt = $pdo->prepare(
        "UPDATE rutinitas
         SET produk = :produk, kategori = :kategori, waktu = :waktu,
             urutan = :urutan, catatan = :catatan
         WHERE id = :id"
    );
    $stmt->execute([
        'produk' => $produk,
        'kategori' => $kategori,
        'waktu' => $waktu,
        'urutan' => (int) $urutan,
        'catatan' => $catatan,
        'id' => $id,
    ]);
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui data di database.'];
    header('Location: edit.php?id=' . $id);
    exit;
}

if ($stmt->rowCount() === 0) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data tidak ditemukan.'];
} else {
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Produk berhasil diperbarui.'];
}
header('Location: daftar.php');
exit;
