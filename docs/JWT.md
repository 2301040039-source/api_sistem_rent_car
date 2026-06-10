# Panduan singkat JWT API

Contoh endpoint autentikasi menggunakan JWT pada projek ini.

- Register
  - URL: `POST /api/auth/register`
  - Body (JSON): `name`, `email`, `password`, `password_confirmation`
  - Response: `201` dengan `data.token`

- Login
  - URL: `POST /api/auth/login`
  - Body (JSON): `email`, `password`
  - Response: `200` dengan `data.token`

- Me (protected)
  - URL: `GET /api/auth/me`
  - Header: `Authorization: Bearer <token>`
  - Response: `200` dengan info user

- Refresh (protected)
  - URL: `POST /api/auth/refresh`
  - Header: `Authorization: Bearer <token>`
  - Response: `200` dengan token baru

- Logout (protected)
  - URL: `POST /api/auth/logout`
  - Header: `Authorization: Bearer <token>`
  - Response: `200`

Catatan Middleware
- Saya menambahkan middleware custom di `app/Http/Middleware/JwtMiddleware.php`.
- Route proteksi sekarang menggunakan middleware langsung berupa kelas: `App\Http\Middleware\JwtMiddleware`.
- Paket `tymon/jwt-auth` juga menyediakan alias middleware: `jwt.auth`, `jwt.refresh`, `jwt.check`, `jwt.renew`.
- Alternatif: gunakan `auth:api` jika guard `api` dikonfigurasi ke driver `jwt`.

Langkah persiapan (jika belum):
```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider" --tag=config
php artisan jwt:secret
``` 

Contoh curl (register):

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"User","email":"user@example.com","password":"password","password_confirmation":"password"}'
```

## Import Postman

1. Buka Postman.
2. Klik tombol `Import`.
3. Pilih file `postman/jwt-api-collection.postman_collection.json` dari project.
4. Set variable `baseUrl` ke `http://127.0.0.1:8000` jika belum.
5. Jalankan urutan request:
   - `Register`
   - `Login`
   - masukkan token dari login ke variable `token`
   - `Me`
   - `Refresh`
   - `Logout`

> Token harus dikirim di header `Authorization: Bearer {{token}}` untuk request protected.
