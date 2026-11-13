# API Katalog Buku

REST API katalog buku dengan Laravel. Menyimpan kategori dan buku ke database,
memvalidasi input, dan mengembalikan status code yang sesuai.

## Instalasi

```bash
git clone https://github.com/dilanadhila555-arch/toko-buku.git
cd toko-buku
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

Di Windows, ganti `touch database/database.sqlite` dengan `type nul > database\database.sqlite`.

Base URL: `http://127.0.0.1:8000/api`

Semua request wajib mengirim header `Accept: application/json`.

## Endpoint

| Method | URL | Keterangan | Status |
|---|---|---|---|
| GET | /categories | Daftar kategori + jumlah buku | 200 |
| POST | /categories | Buat kategori | 201, 422 |
| GET | /categories/{id} | Detail kategori + bukunya | 200, 404 |
| PUT | /categories/{id} | Ubah kategori | 200, 422 |
| DELETE | /categories/{id} | Hapus kategori | 204, 409 |
| GET | /books | Daftar buku | 200 |
| POST | /books | Tambah buku | 201, 422 |
| GET | /books/{id} | Detail buku | 200, 404 |
| PUT | /books/{id} | Ubah buku (sebagian boleh) | 200, 422 |
| DELETE | /books/{id} | Hapus buku | 204 |

## Field buku

| Field | Aturan |
|---|---|
| category_id | wajib, harus ada di tabel categories |
| title | wajib, maks 200 karakter |
| author | wajib, maks 100 karakter |
| isbn | opsional, unik, maks 20 karakter |
| price | wajib, integer >= 0 (rupiah) |
| stock | wajib, integer >= 0 |
| description | opsional |

## Contoh respons

```json
{
  "data": {
    "id": 1,
    "title": "Laskar Pelangi",
    "author": "Andrea Hirata",
    "isbn": "9789793062792",
    "price": 89000,
    "stock": 12,
    "description": null,
    "category": { "id": 1, "name": "Novel" },
    "created_at": "2026-11-13T05:00:00.000000Z"
  }
}
```

## Catatan desain

- Kategori tidak bisa dihapus selama masih punya buku (409).
- Kolom isbn boleh kosong, tetapi bila diisi harus unik.
- Koleksi Postman ada di folder `postman/`.