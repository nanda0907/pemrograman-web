<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sudahLogin = isset($_SESSION['user_id']);

// Fungsi bantu: amankan teks sebelum dicetak ke HTML (mencegah XSS)
function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

// Prefix relatif ke root proyek ini (bukan root domain) — supaya
// assets/ dan link menu tetap benar walau proyek diakses lewat subfolder
// (mis. localhost/pemrograman-web/jobsheet08/).
$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);

// Menu yang sedang aktif (diisi oleh tiap halaman sebelum include header)
$active_menu = $active_menu ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Glow<?php echo isset($page_title) ? ' | ' . e($page_title) : ''; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo $base; ?>index.php">GlowTrack</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <nav class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link<?php echo $active_menu === 'home' ? ' active' : ''; ?>" href="<?php echo $base; ?>index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link<?php echo $active_menu === 'daftar' ? ' active' : ''; ?>" href="<?php echo $base; ?>rutinitas/daftar.php">Daftar Rutinitas</a></li>
                    <?php if ($sudahLogin): ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>auth/logout.php">Logout</a></li>
                    <?php else: ?>
                    <li class="nav-item"><a class="nav-link<?php echo $active_menu === 'login' ? ' active' : ''; ?>" href="<?php echo $base; ?>auth/login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container py-4 flex-grow-1">
