<?php
$page_title = "Edit Rutinitas";
$active_menu = "daftar";
include __DIR__ . '/../includes/header.php';
?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold text-glow-dark mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Rutinitas</h2>

                        <form action="daftar.php" id="form-rutinitas" novalidate>
                            <div class="mb-3">
                                <label for="produk" class="form-label fw-semibold">Nama Produk</label>
                                <input type="text" class="form-control" id="produk" name="produk" value="Vitamin C Serum" required>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="kategori" class="form-label fw-semibold">Kategori</label>
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <option value="Cleanser">Cleanser</option>
                                        <option value="Toner">Toner</option>
                                        <option value="Serum" selected>Serum</option>
                                        <option value="Moisturizer">Moisturizer</option>
                                        <option value="Sunscreen">Sunscreen</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="waktu" class="form-label fw-semibold">Waktu</label>
                                    <select class="form-select" id="waktu" name="waktu" required>
                                        <option value="Pagi" selected>Pagi</option>
                                        <option value="Malam">Malam</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="urutan" class="form-label fw-semibold">Urutan Pemakaian</label>
                                    <input type="number" class="form-control" id="urutan" name="urutan" value="3" min="1" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="catatan" class="form-label fw-semibold">Catatan</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="3">Tunggu 1 menit sebelum lanjut</textarea>
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
