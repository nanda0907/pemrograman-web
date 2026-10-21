<?php
$page_title = "Daftar Rutinitas";
$active_menu = "daftar";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 5;
$keyword = trim($_GET['q'] ?? '');

// Pencarian server-side: cocokkan kata kunci ke produk, kategori, waktu, dan catatan.
// Karakter % dan _ di-escape supaya dianggap teks biasa, bukan wildcard LIKE.
$where = "";
$params = [];
if ($keyword !== '') {
    $where = " WHERE (produk || ' ' || kategori || ' ' || waktu || ' ' || COALESCE(catatan, '')) ILIKE :kw";
    $params['kw'] = '%' . addcslashes($keyword, '%_\\') . '%';
}

$hitung = $pdo->prepare("SELECT COUNT(*) FROM rutinitas" . $where);
$hitung->execute($params);
$totalRows = (int) $hitung->fetchColumn();

$totalPages = max(1, (int) ceil($totalRows / $perPage));
// Halaman dibatasi 1..$totalPages (mis. setelah menghapus data terakhir di halaman terakhir)
$page = min($totalPages, max(1, (int) ($_GET['page'] ?? 1)));
$offset = ($page - 1) * $perPage;

$stmt = $pdo->prepare("SELECT * FROM rutinitas" . $where . " ORDER BY waktu, urutan, id LIMIT :limit OFFSET :offset");
foreach ($params as $nama => $nilai) {
    $stmt->bindValue($nama, $nilai);
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftar = $stmt->fetchAll(PDO::FETCH_ASSOC);

$qs = $keyword !== '' ? '&q=' . urlencode($keyword) : '';
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
                    <div class="col-12 col-md-8 col-lg-6">
                        <form method="get" action="daftar.php" class="d-flex gap-2">
                            <input type="text" id="searchInput" name="q" value="<?php echo e($keyword); ?>" class="form-control" placeholder="Cari produk, kategori, waktu, atau catatan..." autocomplete="off">
                            <button type="submit" class="btn btn-primary px-4">Cari</button>
                        </form>
                    </div>
                    <div class="col text-md-end text-muted small">
                        Menampilkan <strong id="jumlahData"><?php echo count($daftar); ?></strong> dari <span id="totalData"><?php echo $totalRows; ?></span> produk
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
                                <td colspan="7" class="text-center text-muted py-4"><?php echo $keyword !== '' ? 'Tidak ada produk yang cocok dengan pencarianmu.' : 'Belum ada produk. Silakan tambah lewat tombol "Tambah Produk".'; ?></td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($daftar as $i => $item): ?>
                                <tr>
                                    <td><?php echo $offset + $i + 1; ?></td>
                                    <td class="fw-semibold"><?php echo e($item['produk']); ?></td>
                                    <td><?php echo e($item['kategori']); ?></td>
                                    <td><?php echo e($item['waktu']); ?></td>
                                    <td class="text-center"><?php echo e($item['urutan']); ?></td>
                                    <td class="text-muted"><?php echo e($item['catatan']); ?></td>
                                    <td class="text-end text-nowrap">
                                        <a href="edit.php?id=<?php echo (int) $item['id']; ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <form class="d-inline form-hapus" method="post" action="hapus.php">
                                            <input type="hidden" name="id" value="<?php echo (int) $item['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-hapus">Hapus</button>
                                        </form>
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

                <?php if ($totalPages > 1): ?>
                <nav class="mt-3" aria-label="Halaman daftar rutinitas">
                    <ul class="pagination mb-0 justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item<?php echo $i === $page ? ' active' : ''; ?>"><a class="page-link" href="daftar.php?page=<?php echo $i . $qs; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
