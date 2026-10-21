<?php
$page_title = "Daftar Rutinitas";
$active_menu = "daftar";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$daftar = $_SESSION['rutinitas'] ?? [];
$total = count($daftar);
?>
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <h2 class="h3 fw-bold text-glow-dark mb-0">Daftar Rutinitas</h2>
                <p class="text-muted mb-0">Kelola semua produk skincare kamu di sini.</p>
            </div>
        </div>

        <?php if ($flash): ?>
        <div class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : 'danger'; ?>" role="alert"><?php echo e($flash['pesan']); ?></div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 p-md-4">
                <div class="row g-2 align-items-center mb-3">
                    <div class="col-12 col-md-6 col-lg-5">
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari produk, kategori, waktu, atau catatan..." autocomplete="off">
                    </div>
                    <div class="col text-md-end text-muted small">
                        Menampilkan <strong id="jumlahData"><?php echo $total; ?></strong> dari <span id="totalData"><?php echo $total; ?></span> produk
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="rutinitasTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Waktu</th>
                                <th class="text-center">Urutan</th>
                                <th>Catatan</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftar)): ?>
                            <tr class="baris-kosong">
                                <td colspan="7" class="text-center text-muted py-4">Belum ada produk. Silakan tambah lewat tombol "Tambah Produk".</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($daftar as $i => $item): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td class="fw-semibold"><?php echo e($item['produk']); ?></td>
                                    <td><?php echo e($item['kategori']); ?></td>
                                    <td><?php echo e($item['waktu']); ?></td>
                                    <td class="text-center"><?php echo e($item['urutan']); ?></td>
                                    <td class="text-muted"><?php echo e($item['catatan']); ?></td>
                                    <td class="text-end text-nowrap">
                                        <a href="edit.php" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-hapus">Hapus</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div id="noResult" class="text-center text-muted py-4" hidden>
                    Tidak ada produk yang cocok dengan pencarianmu.
                </div>
            </div>
        </div>
<?php include __DIR__ . '/../includes/footer.php'; ?>