# 🌾 Sitani - Sistem Informasi Pertanian Kabupaten Nganjuk

<div align="center">

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![Firebase](https://img.shields.io/badge/Firebase-FFCA28?style=flat-square&logo=firebase&logoColor=black)](https://firebase.google.com)
[![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat-square&logo=docker&logoColor=white)](https://docker.com)
[![Nginx](https://img.shields.io/badge/Nginx-009639?style=flat-square&logo=nginx&logoColor=white)](https://nginx.org)

<div style="margin: 20px 0;">
  <img src="https://raw.githubusercontent.com/IlmanNafi11/web_sitani_project/main/public/Logo.png" width="400" alt="Sitani Logo">
</div>

<div style="font-size: 1.2em; color: #666; margin: 10px 0;">
  <em>Sistem Informasi Terpadu untuk Pengelolaan Data Pertanian Kabupaten Nganjuk</em>
</div>

<div style="margin: 20px 0;">
  <img src="https://img.shields.io/badge/Status-Aktif-brightgreen?style=flat-square" alt="Status">
  <img src="https://img.shields.io/badge/Versi-1.0.0-blue?style=flat-square" alt="Versi">
  <img src="https://img.shields.io/badge/Lisensi-MIT-yellow?style=flat-square" alt="Lisensi">
  <img src="https://img.shields.io/badge/Docker-Ready-2496ED?style=flat-square" alt="Docker Ready">
</div>

</div>

## 📋 Deskripsi

Sitani adalah platform digital yang dikembangkan untuk Dinas Pertanian Kabupaten Nganjuk dalam rangka modernisasi sistem pengelolaan data pertanian. Aplikasi ini menyediakan solusi terpadu untuk mengelola seluruh aspek data pertanian, mulai dari tingkat desa hingga kabupaten, dengan fokus pada efisiensi dan akurasi data.

### 🎯 Tujuan Utama
- Digitalisasi data pertanian Kabupaten Nganjuk
- Integrasi sistem pelaporan penggunaan bibit
- Manajemen permintaan bantuan alat pertanian
- Peningkatan efisiensi pengelolaan data penyuluh dan kelompok tani

## ✨ Fitur Utama

### 📊 Manajemen Data Master
- 📍 Pengelolaan data desa dan kecamatan
- 🌱 Manajemen komoditas pertanian
- 📄 Katalog bibit berkualitas
- 👨‍🌾 Data penyuluh pertanian
- 👥 Data kelompok tani

### 📈 Laporan dan Monitoring
- 📊 Laporan penggunaan bibit per kecamatan
- 🔍 Tracking permintaan bantuan alat pertanian
- 📱 Dashboard analitik real-time

### 🔄 Integrasi Mobile
- 📱 API terintegrasi dengan aplikasi mobile Sitani
- 🔔 Notifikasi real-time (Firebase Cloud Messaging)
- 🔐 Autentikasi berbasis JWT

### 📥 Manajemen Data
- 📤 Import/Export data melalui Excel
- ✅ Validasi data otomatis
- 💾 Backup data berkala

### 🔐 Keamanan dan Akses
- 👮 Role-based access control (Spatie Permission)
- 🛡️ Manajemen hak akses yang fleksibel
- 🔐 Autentikasi multi-level

## 🛠️ Teknologi yang Digunakan

### Backend
- 🚀 Laravel Framework
- 🔐 JWT Authentication
- 👮 Spatie Permission
- 📦 Repository Pattern
- 🎯 Service Layer Pattern
- ✅ Unit Testing

### Frontend
- 🎯 Blade Components
- 📱 Responsive Design
- 💫 Modern UI/UX

### Integrasi
- 🔥 Firebase Cloud Messaging
- 🔌 RESTful API
- 📊 Excel Import/Export

## ⚙️ Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js & NPM
- Web Server (Apache/Nginx)

## 🐳 Konfigurasi Docker

Proyek ini menggunakan konfigurasi Docker dengan:
- PHP-FPM 8.1
- Nginx
- MySQL 8.0

## 🚀 Instalasi

### Opsi 1: Menggunakan Docker (Direkomendasikan)

1. **Pastikan Docker dan Docker Compose terinstal**
```bash
docker --version
```

2. **Clone repository**
```bash
git clone https://github.com/IlmanNafi11/web_sitani_project.git
cd sitani
```

3. **Konfigurasi environment dan build assets**
```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
npm run build
```

4. **Build dan jalankan container**
```bash
docker build -t nama-image:tag .
docker run --name nama-kontainer -p 80:80 nama-image
```

5. **Jalankan migrasi**
```bash
# Masuk ke container PHP
docker exec nama-container bash

# Di dalam container
php artisan migrate --seed
```

6. **Akses aplikasi**
- Web: http://localhost
- API: http://localhost/api

### Opsi 2: Instalasi Manual

1. **Clone repository**
```bash
git clone https://github.com/IlmanNafi11/web_sitani_project.git
cd sitani
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Konfigurasi environment**
```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

4. **Konfigurasi database**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sitani
DB_USERNAME=root
DB_PASSWORD=
```

5. **Jalankan migrasi dan seeder**
```bash
php artisan migrate --seed
```

6. **Compile assets**
```bash
npm run dev
```

7. **Jalankan server**
```bash
php artisan serve
```

## Pengujian

```bash
# Menjalankan semua test
php artisan test

# Menjalankan test spesifik
php artisan test --filter=TestName
```

## 🤝 Kontribusi

1. Fork repository
2. Clone repository fork Anda
```bash
git clone url-hasil-fork sitani
cd sitani
```

3. Buat branch baru dari branch dev
```bash
# Pastikan branch dev Anda up-to-date
git checkout dev
git pull upstream dev

# Buat branch fitur baru
git checkout -b feature
```

4. Lakukan perubahan dan commit
```bash
git add .
git commit -m "feat: Add some AmazingFeature"
```

5. Push ke repository fork Anda
```bash
git push origin feature
```

6. Buat Pull Request
   - Buka repository fork Anda di GitHub
   - Klik "Compare & pull request"
   - Pastikan base branch adalah `dev` dari repository asli
   - Isi deskripsi perubahan
   - Klik "Create pull request"

### Panduan Commit Message
Gunakan format berikut untuk commit message:
- `feat:` untuk fitur baru
- `fix:` untuk perbaikan bug
- `docs:` untuk perubahan dokumentasi
- `style:` untuk perubahan format/kode
- `refactor:` untuk refactoring kode
- `test:` untuk menambah/memperbaiki test
- `chore:` untuk perubahan build process/auxiliary tools

Contoh: `feat: Add user authentication system`

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE.md).

## 📞 Kontak

**Dinas Pertanian Kabupaten Nganjuk**
- 📧 Email: [pertanian@nganjukkab.go.id](mailto:pertanian@nganjukkab.go.id)
- 🌐 Website: [Sitani - Sistem Informasi Pertanian](https://sitani.pbltifnganjuk.com/)
- 📍 Alamat: [Lokasi Dinas Pertanian Kabupaten Nganjuk](https://maps.app.goo.gl/WiQ8FBYymmTaHK3W8?g_st=aw)

## 👥 Tim Pengembang

- [Ilman Nafian](https://github.com/IlmanNafi11) - FullStack Developer
- [Mohamad Aditya Pradana Putra](https://github.com/aditcoding) - FullStack Developer
- [Muhammad Azka Imanika](https://github.com/imkazka) - Frontend Developer Landing Page

---

<div align="center">
Made with ❤️ by Tim Pengembang Efisiensi Group
</div>
