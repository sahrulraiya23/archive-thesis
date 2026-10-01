# 📚 Thesis Archive & Sistem Pengajuan Judul Tugas Akhir

Aplikasi web modern berbasis **Laravel 12** untuk mengelola, mengarsipkan, serta memverifikasi judul tugas akhir / skripsi mahasiswa secara digital. Sistem ini dilengkapi dengan pencarian cerdas berbasis kata kunci, ekstraksi algoritma otomatis, filter dosen pembimbing, pengecekan plagiarisme / kemiripan judul, serta panel manajemen admin.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC?style=flat&logo=tailwind-css&logoColor=white)
![Database](https://img.shields.io/badge/Database-SQLite%20%7C%20MySQL-003B57?style=flat&logo=sqlite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

---

## ✨ Fitur Utama

### 👥 Untuk Pengguna / Mahasiswa
- 🔍 **Pencarian Cerdas & Filter Lengkap**: Cari skripsi berdasarkan Judul, Kata Kunci (Keywords), Penulis, NIM, Angkatan, serta Dosen Pembimbing (Pembimbing 1 & 2).
- 🏷️ **Ekstraksi Kata Kunci Otomatis**: Mendeteksi dan memprioritaskan metode, algoritma, dan teknologi modern (misal: *YOLO, CNN, LSTM, XGBoost, Random Forest, GIS, IoT, Microservices, Laravel, Next.js*, dll.).
- 🔒 **Pengecekan Plagiarisme / Kemiripan**: Hitung skor kemiripan judul baru terhadap 280+ arsip tugas akhir yang telah ada untuk mencegah duplikasi topik.
- 📖 **Halaman Detail Interaktif**: Tampilan modal dan halaman detail yang rapi menyajikan abstrak, metadata, dan informasi pembimbing.
- 📱 **Desain Responsif & Modern**: Menggunakan Tailwind CSS dengan antarmuka yang bersih, cepat, dan nyaman diakses dari ponsel maupun desktop.

### 🛠️ Untuk Administrator
- ➕ **Manajemen CRUD Tugas Akhir**: Tambah, ubah, dan hapus data tugas akhir lengkap dengan validasi NIM, angkatan, dan pembimbing.
- 📊 **Statistik & Dashboard Admin**: Ringkasan data tugas akhir dan navigasi cepat.
- 🔐 **Autentikasi & Otorisasi**: Proteksi rute berbasis role (`admin` dan `user`) dengan middleware Laravel yang aman.

---

## 💾 Dataset & Seeder Otomatis

Seluruh data tugas akhir (**280 data lengkap**) tersimpan di dalam repository dan siap diisi ke database kapan saja tanpa perlu konfigurasi manual:

| File | Lokasi | Keterangan |
|------|--------|------------|
| `theses_consolidated.json` | `database/data/` | Dataset utama 280 tugas akhir lengkap (ID, NIM, Angkatan, Penulis, Judul, Keywords, Pembimbing 1 & 2, Abstrak). Digunakan otomatis oleh `ThesisSeeder`. |
| `theses_dump.sql` | `database/data/` | Script SQL siap pakai (CREATE TABLE & INSERT 280 data + users) untuk impor langsung via phpMyAdmin / MySQL CLI / DBeaver. |
| `theses-2026.csv` & `user_input_raw.csv` | `database/data/` | Sumber data mentah arsip tugas akhir. |

---

## 📋 Prasyarat Sistem

- **PHP** >= 8.2 (dengan ekstensi `pdo`, `pdo_sqlite` atau `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`)
- **Composer** (Package Manager PHP)
- **Node.js** >= 18.x & **NPM**
- **Git**
- *(Opsional)* MySQL / MariaDB (jika memilih menggunakan MySQL daripada SQLite)

---

## 🔧 Panduan Instalasi Cepat

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

### 1. Clone Repositori
```bash
git clone https://github.com/sahrulraiya23/archive-thesis.git
cd archive-thesis
```

### 2. Install Dependensi PHP & Frontend
```bash
# Install library Laravel
composer install

# Install asset frontend & build
npm install
npm run build
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi contoh `.env.example` menjadi `.env`:

```bash
# Di Windows PowerShell / CMD:
copy .env.example .env

# Di Linux / macOS / Git Bash:
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

---

### 4. Setup Database & Isi Data (Seeder)

Anda dapat memilih salah satu dari dua metode di bawah ini:

#### ⚡ Opsi A: Menggunakan SQLite (Rekomendasi - Paling Mudah & Cepat)
Secara default di `.env`, sistem telah dikonfigurasi menggunakan **SQLite** sehingga Anda tidak perlu menginstal atau membuat database di MySQL/XAMPP.

Jalankan perintah berikut:
```bash
php artisan migrate --seed
```
> **Catatan**: Jika muncul pertanyaan `Database file at ... does not exist. Would you like to create it?`, pilih **`yes`**.
> Perintah ini akan membuat semua tabel dan langsung mengimpor seluruh **280 data tugas akhir** dan akun default dalam waktu kurang dari 1 detik.

---

#### 🐬 Opsi B: Menggunakan MySQL / MariaDB (Alternatif)
Jika Anda lebih memilih menggunakan MySQL (misalnya lewat XAMPP atau Laragon):

1. Buat database baru di MySQL, contoh: `thesis_archive`
2. Buka file `.env`, sesuaikan bagian database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=thesis_archive
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Jalankan migrasi dan seeder:
   ```bash
   php artisan migrate --seed
   ```
   *(Atau alternatif: Anda juga dapat langsung mengimpor file `database/data/theses_dump.sql` ke database Anda melalui phpMyAdmin / MySQL CLI).*

---

### 5. Jalankan Server Aplikasi

Jalankan server pengembangan Laravel:
```bash
php artisan serve
```

Jika Anda ingin mengaktifkan *hot-reload* untuk pengubahan aset frontend (opsional):
```bash
npm run dev
```

Buka browser Anda dan akses:
👉 **`http://localhost:8000`**

---

## 👤 Akun Default untuk Login

Setelah menjalankan `php artisan db:seed`, akun berikut siap digunakan:

| Peran (Role) | Email | Password | Akses |
|--------------|-------|----------|-------|
| **Admin** | `admin@gmail.com` | `admin123` | Akses penuh Panel Admin (`/admin/thesis`), tambah/edit/hapus data. |
| **User** | `user@gmail.com` | `user123` | Akses pengguna umum & dashboard pengguna. |

> 💡 *Halaman publik pencarian (`/`) dan cek plagiarisme (`/plagiarism-check`) dapat diakses langsung oleh siapa saja tanpa login.*

---

## 🗄️ Struktur Tabel Database

### Tabel `thesis` (Data Tugas Akhir)
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | BIGINT (PK) | Auto-increment primary key |
| `title` | TEXT | Judul lengkap tugas akhir |
| `keywords` | TEXT | Kata kunci / algoritma yang diekstrak |
| `abstract` | TEXT | Abstrak tugas akhir |
| `author` | VARCHAR(255) | Nama lengkap mahasiswa |
| `nim` | VARCHAR(50) | NIM mahasiswa (Nullable) |
| `program_study` | VARCHAR(255) | Program Studi (default: 'S1 Teknik Informatika') |
| `angkatan` | INT | Tahun angkatan mahasiswa (contoh: 2018, 2019, 2022) |
| `pembimbing_1` | VARCHAR(255) | Dosen Pembimbing 1 (Nullable) |
| `pembimbing_2` | VARCHAR(255) | Dosen Pembimbing 2 (Nullable) |
| `created_at` | TIMESTAMP | Tanggal dibuat |
| `updated_at` | TIMESTAMP | Tanggal terakhir diubah |

### Tabel `users` (Pengguna & Hak Akses)
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | BIGINT (PK) | Auto-increment primary key |
| `name` | VARCHAR(255) | Nama lengkap |
| `email` | VARCHAR(255) | Email unik |
| `password` | VARCHAR(255) | Password terenkripsi (Hash) |
| `role` | VARCHAR(50) | Hak akses: `'admin'` atau `'user'` |
| `created_at` | TIMESTAMP | Tanggal dibuat |
| `updated_at` | TIMESTAMP | Tanggal terakhir diubah |

---

## 🗺️ Struktur Rute Utama

### Rute Publik
- `GET /` — Halaman beranda & daftar pencarian tugas akhir dengan filter.
- `GET /thesis` — Daftar lengkap arsip tugas akhir.
- `GET /thesis/{id}` — Halaman detail tugas akhir.
- `GET /plagiarism-check` — Halaman antarmuka cek kemiripan judul.
- `POST /plagiarism-check` — Eksekusi algoritma pemindaian kemiripan judul.

### Rute Admin (Middleware: `auth`, `admin`)
- `GET /admin/thesis` — Manajemen daftar arsip tugas akhir.
- `GET /admin/thesis/create` — Form tambah tugas akhir baru.
- `POST /admin/thesis` — Simpan tugas akhir baru.
- `GET /admin/thesis/{id}` — Detail tugas akhir untuk admin.
- `GET /admin/thesis/{id}/edit` — Form perbarui data tugas akhir.
- `PUT/PATCH /admin/thesis/{id}` — Simpan perubahan data tugas akhir.
- `DELETE /admin/thesis/{id}` — Hapus data tugas akhir.

---

## 👨‍💻 Kontributor

- **Sahrul Raiya** ([@sahrulraiya23](https://github.com/sahrulraiya23))

---

## 📝 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).