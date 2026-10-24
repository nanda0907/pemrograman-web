<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Edit Rutinitas";
$active_menu = "daftar";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// id harus bilangan bulat; selain itu kembali ke daftar
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: daftar.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM rutinitas WHERE id = :id");
$stmt->execute(['id' => $id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data tidak ditemukan.'];
    header('Location: daftar.php');
    exit;
}

$daftarKategori = ['Cleanser', 'Toner', 'Serum', 'Moisturizer', 'Sunscreen', 'Lainnya'];
$daftarWaktu = ['Pagi', 'Malam'];
?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold text-glow-dark mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Rutinitas</h2>

                        <?php if ($flash): ?>
                        <div class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : 'danger'; ?>" role="alert"><?php echo e($flash['pesan']); ?></div>
                        <?php endif; ?>

                        <form action="proses_edit.php" method="post" id="form-rutinitas" novalidate>
                            <input type="hidden" name="id" value="<?php echo (int) $item['id']; ?>">

                            <div class="mb-3">
                                <label for="produk" class="form-label fw-semibold">Nama Produk</label>
                                <input type="text" class="form-control" id="produk" name="produk" value="<?php echo e($item['produk']); ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="kategori" class="form-label fw-semibold">Kategori</label>
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <?php foreach ($daftarKategori as $k): ?>
                                        <option value="<?php echo e($k); ?>"<?php echo $item['kategori'] === $k ? ' selected' : ''; ?>><?php echo e($k); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="waktu" class="form-label fw-semibold">Waktu</label>
                                    <select class="form-select" id="waktu" name="waktu" required>
                                        <?php foreach ($daftarWaktu as $w): ?>
                                        <option value="<?php echo e($w); ?>"<?php echo $item['waktu'] === $w ? ' selected' : ''; ?>><?php echo e($w); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="urutan" class="form-label fw-semibold">Urutan Pemakaian</label>
                                    <input type="number" class="form-control" id="urutan" name="urutan" value="<?php echo (int) $item['urutan']; ?>" min="1" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="catatan" class="form-label fw-semibold">Catatan</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="3"><?php echo e($item['catatan']); ?></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="daftar.php" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
