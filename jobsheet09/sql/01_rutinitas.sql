-- Jobsheet 8: skema awal database glowtrack (PostgreSQL)
-- Jalankan setelah membuat database, misal:
--   createdb glowtrack
--   psql -d glowtrack -f sql/01_rutinitas.sql

CREATE TABLE IF NOT EXISTS rutinitas (
    id SERIAL PRIMARY KEY,
    produk VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    waktu VARCHAR(10) NOT NULL CHECK (waktu IN ('Pagi', 'Malam')),
    urutan INTEGER NOT NULL CHECK (urutan >= 1),
    catatan TEXT
);

-- Data awal (6 produk, sama seperti Jobsheet 6 & 7).
-- Hanya diisi kalau tabel masih kosong, jadi aman dijalankan berulang kali.
INSERT INTO rutinitas (produk, kategori, waktu, urutan, catatan)
SELECT * FROM (VALUES
    ('Cleansing Oil',    'Cleanser',    'Malam', 1, 'Pijat 1 menit untuk mengangkat makeup'),
    ('Retinol Serum',    'Serum',       'Malam', 3, 'Pakai 2-3 kali seminggu'),
    ('Night Cream',      'Moisturizer', 'Malam', 4, 'Oleskan tipis-tipis'),
    ('Hydrating Toner',  'Toner',       'Pagi',  2, 'Tepuk-tepuk lembut ke wajah'),
    ('Vitamin C Serum',  'Serum',       'Pagi',  3, 'Tunggu 1 menit sebelum lanjut'),
    ('Sunscreen SPF 50', 'Sunscreen',   'Pagi',  5, 'Ulangi setiap 3 jam')
) AS data_awal(produk, kategori, waktu, urutan, catatan)
WHERE NOT EXISTS (SELECT 1 FROM rutinitas);
