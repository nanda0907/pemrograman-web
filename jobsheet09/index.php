<?php
$page_title = "Beranda";
$active_menu = "home";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

$total = $pdo->query("SELECT COUNT(*) FROM rutinitas")->fetchColumn();
$pagi = $pdo->query("SELECT COUNT(*) FROM rutinitas WHERE waktu = 'Pagi'")->fetchColumn();
$malam = $pdo->query("SELECT COUNT(*) FROM rutinitas WHERE waktu = 'Malam'")->fetchColumn();
?>
        <section class="hero rounded-4 p-4 p-md-5 mb-4 text-white">
            <h1 class="display-6 fw-bold">Selamat Datang di GlowTrack</h1>
            <p class="lead mb-4">Catat dan atur rutinitas skincare kamu setiap hari, pagi maupun malam.</p>
            <a href="rutinitas/daftar.php" class="btn btn-hero rounded-pill px-4 me-2 mb-2">Lihat Rutinitas</a>
            <a href="rutinitas/tambah.php" class="btn btn-hero rounded-pill px-4 mb-2">Tambah Produk</a>
        </section>

        <h2 class="h4 fw-bold text-glow-dark mb-3">Ringkasan Rutinitas</h2>

        <div class="row g-3">
            <div class="col-12 col-md-4">
                <div class="card stat-card stat-total border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="text-muted small">Total Rutinitas</div>
                        <div class="stat-number"><?php echo $total; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card stat-card stat-pagi border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="text-muted small">Rutinitas Pagi</div>
                        <div class="stat-number"><?php echo $pagi; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card stat-card stat-malam border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="text-muted small">Rutinitas Malam</div>
                        <div class="stat-number"><?php echo $malam; ?></div>
                    </div>
                </div>
            </div>
        </div>
<?php include __DIR__ . '/includes/footer.php'; ?>
