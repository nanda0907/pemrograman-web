<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Sengaja hanya menerima POST (bukan GET) agar penghapusan tidak bisa
// dipicu tanpa sengaja lewat link/preview crawler.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: daftar.php');
    exit;
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: daftar.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM rutinitas WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() === 0) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data tidak ditemukan.'];
    } else {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Produk berhasil dihapus.'];
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data dari database.'];
}

header('Location: daftar.php');
exit;
