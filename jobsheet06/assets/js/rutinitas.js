// Mengambil & menampilkan Daftar Rutinitas secara asinkron dari data/rutinitas.json

// Mencegah karakter khusus HTML (<, >, &) dari data dianggap sebagai tag
function escapeHtml(teks) {
    return String(teks)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
}

async function muatDaftarRutinitas() {
    const tbody = document.querySelector("#rutinitasTable tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // simulasi delay jaringan agar loading indicator terlihat
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/rutinitas.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftar = await res.json();

        daftar.forEach(function (item, i) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + (i + 1) + "</td>" +
                "<td class=\"fw-semibold\">" + escapeHtml(item.produk) + "</td>" +
                "<td>" + escapeHtml(item.kategori) + "</td>" +
                "<td>" + escapeHtml(item.waktu) + "</td>" +
                "<td class=\"text-center\">" + escapeHtml(item.urutan) + "</td>" +
                "<td class=\"text-muted\">" + escapeHtml(item.catatan) + "</td>" +
                "<td class=\"text-end text-nowrap\">" +
                "<a href=\"edit.html\" class=\"btn btn-sm btn-outline-warning\">Edit</a> " +
                "<button type=\"button\" class=\"btn btn-sm btn-outline-danger btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });

        // Hitung ulang "Menampilkan X dari Y produk" (fungsi ada di app.js)
        perbaruiTabel();
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"7\" class=\"text-center text-danger py-4\">Gagal memuat data: " +
            escapeHtml(err.message) + "</td></tr>";
        document.getElementById("jumlahData").textContent = 0;
        document.getElementById("totalData").textContent = 0;
    } finally {
        loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarRutinitas);