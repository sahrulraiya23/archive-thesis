# 📚 Thesis Archive

Aplikasi web berbasis Laravel untuk mengelola dan mengarsipkan skripsi, tesis, dan disertasi secara digital. Sistem ini dilengkapi dengan fitur pencarian, manajemen konten, dan pengecekan plagiarisme.

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

---

## ✨ Fitur Utama

### 👥 Untuk Pengguna
- 🔍 **Pencarian Karya Ilmiah** - Cari skripsi, tesis, atau disertasi dengan mudah
- 📖 **Detail Lengkap** - Lihat informasi lengkap termasuk abstrak dan metadata
- 🔒 **Pengecekan Plagiarisme** - Verifikasi keaslian karya ilmiah
- 📱 **Responsif** - Akses dari berbagai perangkat

### 🛠️ Untuk Administrator
- ➕ **Manajemen CRUD** - Kelola data karya ilmiah secara lengkap
- 👨‍💼 **Manajemen Pengguna** - Kontrol akses dan peran pengguna
- 📊 **Dashboard Admin** - Pantau statistik dan aktivitas sistem
- 🔐 **Keamanan Tingkat Lanjut** - Sistem autentikasi dan otorisasi yang aman

---

## 🚀 Teknologi

- **Framework**: Laravel 12.x
- **PHP**: 8.2 atau lebih tinggi
- **Database**: MySQL/PostgreSQL
- **Frontend**: Blade Templates + Vite
- **Package Manager**: Composer & NPM

---

## 📋 Prasyarat

Pastikan sistem Anda telah menginstal:

- PHP >= 8.2
- Composer
- Node.js >= 18.x dan NPM
- MySQL >= 5.7 atau PostgreSQL >= 12
- Git

---

## 🔧 Instalasi

### 1. Clone Repositori

```bash
git clone https://github.com/sahrulraiya23/thesis-archive.git
cd thesis-archive
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Konfigurasi Environment

```bash
# Salin file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=thesis_archive
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Database

```bash
# Jalankan migrasi
php artisan migrate

# Jalankan seeder (opsional - untuk data awal)
php artisan db:seed
```

### 5. Jalankan Aplikasi

```bash
# Terminal 1: Laravel Development Server
php artisan serve

# Terminal 2: Vite Development Server
npm run dev
```

Aplikasi akan berjalan di `http://localhost:8000`

---

## 🗺️ Struktur Rute

### Rute Publik

| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/` | Halaman utama |
| GET | `/thesis` | Daftar karya ilmiah |
| GET | `/thesis/{id}` | Detail karya ilmiah |
| GET | `/plagiarism-check` | Halaman cek plagiarisme |
| POST | `/plagiarism-check` | Proses cek plagiarisme |

### Rute Autentikasi

| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/dashboard` | Dashboard pengguna |
| GET | `/profile` | Halaman profil |
| PATCH | `/profile` | Update profil |
| DELETE | `/profile` | Hapus akun |

### Rute Admin (Middleware: auth, admin)

| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/admin/thesis` | Daftar karya ilmiah (admin) |
| GET | `/admin/thesis/create` | Form tambah karya ilmiah |
| POST | `/admin/thesis` | Simpan karya ilmiah baru |
| GET | `/admin/thesis/{id}` | Detail karya ilmiah (admin) |
| GET | `/admin/thesis/{id}/edit` | Form edit karya ilmiah |
| PUT/PATCH | `/admin/thesis/{id}` | Update karya ilmiah |
| DELETE | `/admin/thesis/{id}` | Hapus karya ilmiah |

---

## 🗄️ Struktur Database

### Tabel `users`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT | Primary Key |
| name | VARCHAR(255) | Nama lengkap |
| email | VARCHAR(255) | Email (unique) |
| password | VARCHAR(255) | Password (hashed) |
| role | ENUM | 'admin' atau 'user' (default: 'user') |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

### Tabel `thesis`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT | Primary Key |
| title | VARCHAR(255) | Judul karya ilmiah |
| abstract | TEXT | Abstrak |
| type | ENUM | 'skripsi', 'tesis', 'disertasi' |
| author | VARCHAR(255) | Nama penulis |
| program_study | VARCHAR(255) | Program studi |
| year | YEAR | Tahun publikasi |
| created_at | TIMESTAMP | - |
| updated_at | TIMESTAMP | - |

---

## 👤 Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk login:

**Admin**
- Email: `admin@example.com`
- Password: `password`

**User**
- Email: `user@example.com`
- Password: `password`

> ⚠️ **Penting**: Ubah password default setelah login pertama kali!

---

## 📦 Build untuk Production

```bash
# Build assets
npm run build

# Optimize aplikasi
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set environment ke production di .env
APP_ENV=production
APP_DEBUG=false
```

---

## 🧪 Testing

```bash
# Jalankan semua test
php artisan test

# Test dengan coverage
php artisan test --coverage
```

---

## 🤝 Kontribusi

Kontribusi selalu diterima dengan baik! Berikut langkah-langkahnya:

1. Fork repositori ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📝 License

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

## 👨‍💻 Author

**Sahrul Raiya**
- GitHub: [@sahrulraiya23](https://github.com/sahrulraiya23)

---

## 📞 Support

Jika Anda menemukan bug atau memiliki saran, silakan buat [issue](https://github.com/sahrulraiya23/thesis-archive/issues) di repositori ini.

---

<div align="center">
Dibuat dengan ❤️ menggunakan Laravel
</div>