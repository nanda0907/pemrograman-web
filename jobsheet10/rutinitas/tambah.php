<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Rutinitas";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold text-glow-dark mb-4">Tambah Rutinitas Skincare</h2>

                        <?php if ($flash): ?>
                        <div class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : 'danger'; ?>" role="alert"><?php echo e($flash['pesan']); ?></div>
                        <?php endif; ?>

                        <form action="proses_tambah.php" method="post" id="form-rutinitas" novalidate>
                            <div class="mb-3">
                                <label for="produk" class="form-label fw-semibold">Nama Produk</label>
                                <input type="text" class="form-control" id="produk" name="produk" placeholder="Contoh: Facial Wash Gentle" required>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="kategori" class="form-label fw-semibold">Kategori</label>
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Cleanser">Cleanser</option>
                                        <option value="Toner">Toner</option>
                                        <option value="Serum">Serum</option>
                                        <option value="Moisturizer">Moisturizer</option>
                                        <option value="Sunscreen">Sunscreen</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="waktu" class="form-label fw-semibold">Waktu Pemakaian</label>
                                    <select class="form-select" id="waktu" name="waktu" required>
                                        <option value="">Pilih Waktu</option>
                                        <option value="Pagi">Pagi</option>
                                        <option value="Malam">Malam</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="urutan" class="form-label fw-semibold">Urutan Pemakaian</label>
                                    <input type="number" class="form-control" id="urutan" name="urutan" min="1" placeholder="1" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="catatan" class="form-label fw-semibold">Catatan</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Opsional, misalnya: tunggu 1 menit sebelum lanjut"></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="daftar.php" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
