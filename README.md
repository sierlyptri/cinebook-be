# CineBook Backend API

Sistem backend untuk pemesanan tiket bioskop yang robust dibangun dengan Laravel, menyediakan API lengkap untuk manajemen teater, pemesanan tiket, dan manajemen pengguna.

## 🎬 Fitur

### Manajemen Pengguna 
- Registrasi dan autentikasi pengguna
- Manajemen profil pengguna
- Update profil dan ubah password
- Autentikasi dengan Laravel Sanctum

### Manajemen Film 
- Katalog film dengan informasi lengkap
- CRUD operasi untuk film (Create, Read, Update, Delete)
- Upload dan display gambar film
- Manajemen media file

### Manajemen Teater 
- Konfigurasi ruang bioskop
- Manajemen layout kursi
- Informasi layar dan teater
- Manajemen tingkat harga

### Sistem Penjadwalan 
- Penjadwalan film dan jam tayang
- Manajemen showtime
- Koordinasi film dengan teater

### Sistem Pemesanan 
- Ketersediaan kursi real-time
- Pemesanan dan reservasi tiket
- Manajemen booking
- Sistem pembayaran terintegrasi
- Riwayat pemesanan pengguna

## 🛠️ Teknologi yang Digunakan

- **Framework**: Laravel 10.x
- **Database**: MySQL/PostgreSQL
- **Autentikasi**: Laravel Sanctum
- **File Storage**: Laravel Storage
- **Queue System**: Laravel Queues
- **Cache**: Redis (opsional)
- **Email**: Laravel Mail

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL/PostgreSQL
- Node.js & NPM (untuk kompilasi asset)
- Redis (opsional, untuk caching dan queues)

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/sierlyptri/cinebook-be.git
cd cinebook-be
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Environment Variables
Edit file `.env` dengan pengaturan database dan aplikasi Anda:
```env
APP_NAME=CineBook
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cinebook
DB_USERNAME=username_anda
DB_PASSWORD=password_anda

MAIL_MAILER=smtp
MAIL_HOST=smtp_host_anda
MAIL_PORT=587
MAIL_USERNAME=email_anda
MAIL_PASSWORD=password_email_anda
```

### 5. Setup Database
```bash
php artisan migrate
php artisan db:seed
```

### 6. Setup Storage
```bash
php artisan storage:link
```

### 7. Jalankan Development Server
```bash
php artisan serve
```

API akan tersedia di `http://localhost:8000`

## 📚 Dokumentasi API

### Endpoint Autentikasi
```
POST /api/register                    - Registrasi pengguna baru
POST /api/login                       - Login pengguna
POST /api/logout                      - Logout pengguna (Auth required)
```

### Endpoint Profil Pengguna
```
GET  /api/profile                     - Ambil profil pengguna (Auth required)
POST /api/profile/update              - Update profil pengguna (Auth required)
POST /api/profile/change-password     - Ubah password pengguna (Auth required)
```

### Endpoint Film
```
GET    /api/movies                    - Ambil semua film
GET    /api/movies/{id}               - Ambil detail film berdasarkan ID
POST   /api/movies                    - Tambah film baru
PATCH  /api/movies/{id}               - Update film berdasarkan ID
DELETE /api/movies/{id}               - Hapus film berdasarkan ID
```

### Endpoint Teater
```
GET    /api/theaters                  - Ambil semua teater
GET    /api/theaters/{id}             - Ambil detail teater berdasarkan ID
POST   /api/theaters                  - Tambah teater baru
PATCH  /api/theaters/{id}             - Update teater berdasarkan ID
DELETE /api/theaters/{id}             - Hapus teater berdasarkan ID
```

### Endpoint Jadwal Tayang
```
GET    /api/showtimes                 - Ambil semua jadwal tayang
GET    /api/showtimes/{id}            - Ambil detail jadwal tayang berdasarkan ID
POST   /api/showtimes                 - Tambah jadwal tayang baru
PATCH  /api/showtimes/{id}            - Update jadwal tayang berdasarkan ID
DELETE /api/showtimes/{id}            - Hapus jadwal tayang berdasarkan ID
```

### Endpoint Kursi
```
GET    /api/seats                     - Ambil semua kursi
GET    /api/seats/{id}                - Ambil detail kursi berdasarkan ID
POST   /api/seats                     - Tambah kursi baru
PATCH  /api/seats/{id}                - Update kursi berdasarkan ID
DELETE /api/seats/{id}                - Hapus kursi berdasarkan ID
GET    /api/theaters/{id}/seats       - Ambil kursi berdasarkan teater
```

### Endpoint Pemesanan
```
GET    /api/bookings                  - Ambil semua pemesanan
GET    /api/bookings/{id}             - Ambil detail pemesanan berdasarkan ID
POST   /api/bookings                  - Buat pemesanan baru
PATCH  /api/bookings/{id}             - Update pemesanan berdasarkan ID
DELETE /api/bookings/{id}             - Batalkan pemesanan berdasarkan ID
```

### Endpoint Media
```
GET    /api/showImage/{filename}      - Tampilkan gambar berdasarkan filename
```

## 🗄️ Skema Database

### Tabel Utama
- `users` - Akun pengguna dan autentikasi
- `movies` - Informasi dan metadata film
- `theaters` - Informasi ruang bioskop
- `seats` - Konfigurasi kursi
- `showtimes` - Jadwal pemutaran film
- `bookings` - Pemesanan dan reservasi tiket
- `personal_access_tokens` - Token autentikasi Laravel Sanctum

### Tabel Pendukung
- `migrations` - Riwayat migrasi database
- `failed_jobs` - Log pekerjaan yang gagal
- `password_reset_tokens` - Token reset password

## 🔧 Konfigurasi

### Konfigurasi Queue
Konfigurasi queue untuk menangani background tasks:
```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```

### Konfigurasi Cache
Setup Redis untuk meningkatkan performa:
```env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## 🧪 Testing

Jalankan test suite:
```bash
php artisan test
```

Untuk kategori test tertentu:
```bash
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

## 📦 Deployment

### Setup Production
1. Set environment ke production:
```env
APP_ENV=production
APP_DEBUG=false
```

2. Optimasi untuk production:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

3. Set permission file yang tepat:
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

## 🔐 Keamanan

- Endpoint API dilindungi dengan authentication middleware
- Validasi dan sanitasi input telah diimplementasikan
- Pencegahan SQL injection melalui Eloquent ORM
- Perlindungan CSRF diaktifkan
- Rate limiting dikonfigurasi untuk endpoint API

## 🤝 Kontribusi

1. Fork repository
2. Buat feature branch (`git checkout -b feature/fitur-keren`)
3. Commit perubahan Anda (`git commit -m 'Tambah fitur keren'`)
4. Push ke branch (`git push origin feature/fitur-keren`)
5. Buat Pull Request

## 👩‍💻 Developer

- **Nama**: Sierly Putri Anjani  
- **Email**: sierlypanjani89@gmail.com
- **LinkedIn**: [linkedin.com/in/sierlyptri](https://linkedin.com/in/sierlyptri)
- **GitHub**: [github.com/sierlyptri](https://github.com/sierlyptri)
- **Proyek**: Sistem Backend Pemesanan Bioskop
- **Repository**: https://github.com/sierlyptri/cinebook-be


## 🚧 Status Pengembangan

### Fitur yang Sudah Selesai ✅
- **Autentikasi Pengguna**: Registrasi, login, logout menggunakan Laravel Sanctum
- **Manajemen Profil**: Update profil dan ubah password  
- **Manajemen Film**: CRUD lengkap untuk film
- **Upload Media**: Sistem upload dan display gambar film
- **Manajemen Teater**: CRUD lengkap untuk teater dan ruang bioskop
- **Sistem Jadwal**: Manajemen showtime dan penjadwalan film
- **Manajemen Kursi**: Konfigurasi dan layout kursi teater
- **Sistem Booking**: Pemesanan tiket dan manajemen reservasi

### Fitur yang Bisa Dikembangkan Lebih Lanjut 🔄
- Dashboard admin dengan analytics
- Sistem notifikasi real-time
- Integrasi payment gateway (Midtrans, Xendit, dll)
- Sistem review dan rating film
- Program loyalitas pelanggan
- API untuk mobile application
- Multi-language support

---
