# 🚗 API Sistem Rental Mobil (Rent Car)

RESTful API untuk pengelolaan sistem rental mobil mencakup manajemen mobil, kategori mobil, pelanggan, dan transaksi penyewaan mobil.

## 📖 Deskripsi Singkat

API Sistem Rental Mobil adalah layanan Web Service berbasis RESTful API yang dibangun menggunakan Laravel dan JWT Authentication. Sistem ini dirancang untuk memudahkan pengelolaan data rental mobil secara digital, aman, dan terintegrasi.

### Fitur Utama yang Tersedia

🔐 Autentikasi pengguna menggunakan JWT (register, login, logout)

🚗 Manajemen data mobil dan kategori mobil

👥 Manajemen data pelanggan

📋 Transaksi penyewaan dan pengembalian mobil

📊 Monitoring status mobil (tersedia, disewa, maintenance)

📝 Log aktivitas otomatis setiap request tercatat ke database

---

# ⚙️ Cara Menjalankan Sistem

## Persyaratan

* PHP >= 8.2
* Composer
* MySQL
* Laravel Herd / XAMPP / Laragon

## Langkah-langkah

### 1. Clone repositori

```bash
git clone https://github.com/username/api_rent_car.git
cd api_rent_car
```

### 2. Install dependency

```bash
composer install
```

### 3. Salin file konfigurasi

```bash
cp .env.example .env
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Konfigurasi file .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rent_car
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Generate JWT Secret

```bash
php artisan jwt:secret
```

### 7. Jalankan migrasi dan seeder

```bash
php artisan migrate --seed
```

### 8. Jalankan server

```bash
php artisan serve
```

---

# 👤 Informasi Akun Uji Coba

Setelah menjalankan seeder, akun berikut sudah tersedia dan siap digunakan:

| Role    | Email                                             | Password    |
| ------- | ------------------------------------------------- | ----------- |
| Admin   | [admin@rentcar.com](mailto:admin@rentcar.com)     | password123 |
| Petugas | [petugas@rentcar.com](mailto:petugas@rentcar.com) | password123 |

Cara login:

Kirim request **POST /api/login** dengan email dan password di atas, lalu gunakan token yang didapat sebagai **Bearer Token** pada header Authorization untuk mengakses endpoint lainnya.

---

# 📡 Daftar Endpoint

## 🔐 Auth

| Method | Endpoint      | Keterangan                      |
| ------ | ------------- | ------------------------------- |
| POST   | /api/register | Registrasi user baru            |
| POST   | /api/login    | Login dan mendapatkan token JWT |
| POST   | /api/logout   | Logout dan invalidasi token     |
| GET    | /api/me       | Data user yang sedang login     |

---

## 👤 Users

| Method | Endpoint       | Keterangan        |
| ------ | -------------- | ----------------- |
| GET    | /api/user      | Daftar semua user |
| GET    | /api/user/{id} | Detail user       |
| PUT    | /api/user/{id} | Update data user  |
| DELETE | /api/user/{id} | Hapus user        |

---

## 🚘 Categories

| Method | Endpoint                  | Keterangan                        |
| ------ | ------------------------- | --------------------------------- |
| GET    | /api/categories           | Daftar kategori mobil             |
| POST   | /api/categories           | Tambah kategori baru              |
| GET    | /api/categories/{id}      | Detail kategori                   |
| PUT    | /api/categories/{id}      | Update kategori                   |
| DELETE | /api/categories/{id}      | Hapus kategori                    |
| GET    | /api/categories/{id}/cars | Daftar mobil berdasarkan kategori |

---

## 🚗 Cars

| Method | Endpoint            | Keterangan                      |
| ------ | ------------------- | ------------------------------- |
| GET    | /api/cars           | Daftar semua mobil              |
| POST   | /api/cars           | Tambah mobil baru               |
| GET    | /api/cars/{id}      | Detail mobil                    |
| PUT    | /api/cars/{id}      | Update data mobil               |
| DELETE | /api/cars/{id}      | Hapus mobil                     |
| GET    | /api/cars/available | Daftar mobil yang tersedia      |
| GET    | /api/cars/rented    | Daftar mobil yang sedang disewa |

---

## 👥 Customers

| Method | Endpoint                    | Keterangan               |
| ------ | --------------------------- | ------------------------ |
| GET    | /api/customers              | Daftar pelanggan         |
| POST   | /api/customers              | Tambah pelanggan baru    |
| GET    | /api/customers/{id}         | Detail pelanggan         |
| PUT    | /api/customers/{id}         | Update data pelanggan    |
| DELETE | /api/customers/{id}         | Hapus pelanggan          |
| GET    | /api/customers/{id}/rentals | Riwayat rental pelanggan |

---

## 📋 Rentals

| Method | Endpoint            | Keterangan                         |
| ------ | ------------------- | ---------------------------------- |
| GET    | /api/rentals        | Daftar semua transaksi rental      |
| POST   | /api/rentals        | Buat transaksi rental baru         |
| GET    | /api/rentals/{id}   | Detail transaksi                   |
| PUT    | /api/rentals/{id}   | Pengembalian mobil                 |
| DELETE | /api/rentals/{id}   | Hapus transaksi                    |
| GET    | /api/rentals/active | Rental yang masih aktif            |
| GET    | /api/rentals/late   | Rental yang terlambat dikembalikan |

---

# 📄 Dokumentasi API

Dokumentasi lengkap endpoint tersedia melalui Postman Collection atau Swagger Documentation yang mencakup:

* Detail endpoint
* Method
* Parameter request
* Contoh request
* Contoh response
* Kode status HTTP

---

# 🛠️ Teknologi yang Digunakan

| Teknologi  | Keterangan                                |
| ---------- | ----------------------------------------- |
| Laravel 13 | Framework PHP untuk membangun RESTful API |
| MySQL      | Database penyimpanan data                 |
| JWT Auth   | Autentikasi berbasis JSON Web Token       |
| Postman    | Testing dan dokumentasi API               |
| GitHub     | Version Control dan Repository Proyek     |

---

# 👨‍💻 Tim Pengembang

| Nama            | NIM        | Tugas                                                                 |
| --------------- | ---------- | --------------------------------------------------------------------- |
| Bunga Azizah    | 2301040039 | Arsitektur Sistem, Endpoint Auth, JWT Authentication, Dokumentasi API |
| Fitri Ramadhani | 2301040028 | Endpoint Mobil, Kategori Mobil, Pelanggan, dan Transaksi Rental       |

---

**Proyek UAS Mata Kuliah Pemrograman Web Service Genap 2025/2026**

**Program Studi Rekayasa Perangkat Lunak**

**Universitas Bumigora**
