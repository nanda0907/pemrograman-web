// ===== Pencarian + hitung jumlah baris (Daftar Rutinitas) =====
function perbaruiTabel() {
    const searchInput = document.getElementById("searchInput");
    const rows = document.querySelectorAll("#rutinitasTable tbody tr");
    const jumlahData = document.getElementById("jumlahData");
    const totalData = document.getElementById("totalData");
    const noResult = document.getElementById("noResult");
    if (!searchInput || rows.length === undefined) return;

    const keyword = searchInput.value.trim().toLowerCase();
    let tampil = 0;

    rows.forEach(function (row) {
        const cocok = row.textContent.toLowerCase().includes(keyword);
        row.style.display = cocok ? "" : "none";
        if (cocok) tampil++;
    });

    if (jumlahData) jumlahData.textContent = tampil;
    if (totalData) totalData.textContent = rows.length;
    if (noResult) noResult.hidden = tampil > 0;
}

function initTableFilter() {
    const searchInput = document.getElementById("searchInput");
    if (!searchInput) return;
    searchInput.addEventListener("input", perbaruiTabel);
}

// ===== Konfirmasi hapus (front-end only, belum ke server) =====
function initHapusConfirm() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");
            const nama = row ? row.cells[1].textContent : "data ini";
            const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");

            if (yakin && row) {
                row.remove();

                // Nomor urut dihitung ulang setelah baris dihapus
                document.querySelectorAll("#rutinitasTable tbody tr").forEach(function (r, i) {
                    r.cells[0].textContent = i + 1;
                });

                perbaruiTabel();
            }
        });
    });
}

// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    input.classList.add("is-invalid");

    const div = document.createElement("div");
    div.className = "invalid-feedback";
    div.textContent = pesan;
    input.insertAdjacentElement("afterend", div);
}

function hapusError(input) {
    input.classList.remove("is-invalid");

    const next = input.nextElementSibling;
    if (next && next.classList.contains("invalid-feedback")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-rutinitas");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        const produk = form.querySelector("[name='produk']");
        if (produk.value.trim() === "") {
            tampilkanError(produk, "Nama produk harus diisi.");
            valid = false;
        } else if (produk.value.trim().length > 100) {
            tampilkanError(produk, "Nama produk maksimal 100 karakter.");
            valid = false;
        } else {
            hapusError(produk);
        }

        const kategori = form.querySelector("[name='kategori']");
        if (kategori.value === "") {
            tampilkanError(kategori, "Kategori harus dipilih.");
            valid = false;
        } else {
            hapusError(kategori);
        }

        const waktu = form.querySelector("[name='waktu']");
        if (waktu.value === "") {
            tampilkanError(waktu, "Waktu pemakaian harus dipilih.");
            valid = false;
        } else {
            hapusError(waktu);
        }

        const urutan = form.querySelector("[name='urutan']");
        const nilai = parseInt(urutan.value, 10);
        if (isNaN(nilai) || nilai < 1) {
            tampilkanError(urutan, "Urutan harus lebih dari 0.");
            valid = false;
        } else {
            hapusError(urutan);
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initTableFilter();
    initHapusConfirm();
    initValidasiForm();
});