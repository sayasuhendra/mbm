# Baitul Muttaqin Youth Management System

Sistem Informasi Manajemen Pemuda Masjid Baitul Muttaqin (MBM Youth). Aplikasi ini dibangun dengan standar *Clean Architecture* dan *Production-Ready*, dirancang untuk mengelola berbagai kegiatan kepemudaan masjid dengan fokus awal pada **Klub Panahan Remaja**.

---

## 🚀 Fitur Utama

### 1. Sistem Kepesertaan Panahan
- **Form Pendaftaran Publik**: Calon anggota dapat mendaftar langsung dari halaman depan (Landing Page).
- **Manajemen Peserta**: Pencatatan data peserta lengkap dari sisi admin (Filament), termasuk status aktif/non-aktif, data orang tua, dan perlengkapan.
- **Jadwal Latihan**: Pengelolaan jadwal latihan panahan yang dapat di-*publish* kepada peserta.
- **Materi Panahan**: Repositori ilmu dan kurikulum panahan menggunakan format tulisan *Markdown*, disertai cover.

### 2. Transparansi Keuangan (Kas Pemuda)
- **Manajemen Pemasukan & Pengeluaran**: Pencatatan kas yang rapi menggunakan sistem kategori pemasukan/pengeluaran.
- **Infak/Donasi Mingguan**: Pengelolaan tagihan partisipasi/infak mingguan untuk anggota secara otomatis.
- **Pengaturan Rekening & QRIS**: Admin dapat memasukkan nomor rekening dan *barcode* QRIS melalui halaman pengaturan khusus yang mudah digunakan.

### 3. Sistem Notifikasi & WhatsApp Broadcast
- **Broadcast WhatsApp**: Admin dapat mengirimkan pesan massal (Teks maupun Media) ke anggota secara langsung atau terjadwal.
- **Reminder Infak Otomatis**: Sistem akan membuat tagihan infak mingguan dan *secara otomatis* mengirimkan notifikasi WhatsApp ke peserta.
- **Multi Gateway Dukungan**: Sistem dirancang fleksibel dengan *Gateway Pattern*, mendukung pengiriman melalui Fonnte, Wablas, Official Meta (WhatsApp Business API), atau metode *Mock* untuk tes.

### 4. Role & Permissions (Keamanan)
- Sistem otorisasi menggunakan **Filament Shield / Spatie Permissions**.
- Mendukung berbagai Role (Super Admin, Admin, Member, dll).

### 5. Galeri & Media
- **Spatie Media Library**: Pengelolaan unggahan gambar dan dokumen secara *scalable* dan rapi.
- **Galeri Dokumentasi**: Menu untuk memamerkan foto-foto kegiatan ke Landing Page.

---

## 🛠 Tech Stack

- **Framework**: Laravel 13
- **PHP**: ^8.4
- **Admin Panel**: FilamentPHP v5 (TALL Stack)
- **CSS Framework**: TailwindCSS v4
- **Database**: SQLite 3
- **Media Management**: Spatie Media Library
- **Authorization**: Spatie Laravel Permission & Filament Shield

---

## 💻 Panduan Instalasi Lokal (Local Development)

### Persyaratan Sistem
- PHP 8.4+
- Composer
- Node.js & NPM
- PHP SQLite extension (`pdo_sqlite`)
- Redis (Opsional, direkomendasikan untuk Queue & Cache)

### Langkah Instalasi

1. **Kloning Repositori & Masuk Direktori**
   ```bash
   git clone <url-repo> mbmyouth
   cd mbmyouth
   ```

2. **Install Dependensi Backend & Frontend**
   ```bash
   composer install
   npm install
   ```

3. **Pengaturan Environment**
   Salin file `.env.example` menjadi `.env`.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Gunakan SQLite dan buat file database:
   ```env
   DB_CONNECTION=sqlite
   ```
   ```bash
   touch database/database.sqlite
   ```

4. **Jalankan Migrasi Database & Storage Link**
   ```bash
   php artisan migrate
   php artisan storage:link
   ```

5. **Buat User Super Admin**
   Untuk akses awal Filament, buat akun Super Admin (Aplikasi ini secara otomatis membypass izin via `Gate::before` untuk role `super_admin`):
   ```bash
   php artisan shield:super-admin
   # Ikuti instruksi di terminal, contoh masukkan email: sayasuhendra@gmail.com
   ```

6. **Jalankan Server Lokal**
   Buka dua tab terminal.
   ```bash
   # Terminal 1 (Laravel)
   php artisan serve
   
   # Terminal 2 (Vite/Tailwind)
   npm run dev
   ```
   Aplikasi publik: `http://localhost:8000`
   Admin Panel: `http://localhost:8000/admin`

---

## 📲 Pengaturan WhatsApp & Gateway

Aplikasi dapat mem-broadcast pesan via WhatsApp dengan beberapa pilihan Gateway.

1. Buka Admin Panel -> Menu **Settings**.
2. Anda akan menemukan input untuk **WhatsApp Gateway** (Pilihan: `mock`, `fonnte`, `wablas`, `meta`).
3. Anda juga perlu mengisi **WhatsApp API Key** sesuai dengan layanan yang Anda gunakan.
4. Jika Anda hanya ingin menguji *flow* tanpa benar-benar mengirim pesan, pilih **Mock**. Hasil *Mock* bisa dilihat di file log Laravel (`storage/logs/laravel.log`).

---

## ⚙️ Menjalankan WhatsApp Reminder & Scheduler Otomatis

Aplikasi ini menggunakan **Laravel Scheduler** untuk men-generate tagihan infak mingguan dan mengirim **WhatsApp Reminder** pada setiap **hari Senin pukul 07:00**.

Selain itu, tugas pengiriman pesan (`SendWhatsappBroadcastJob`) dan notifikasi berjalan di *background* menggunakan **Laravel Queue** agar website tidak lambat ketika diakses admin.

### 1. Mode Lokal (Testing di Komputer Sendiri)
Buka terminal baru untuk memproses antrean pesan (Queue):
```bash
php artisan queue:work
```
Buka terminal baru untuk menjalankan jadwal (Scheduler):
```bash
php artisan schedule:work
```
*(Catatan: Scheduler akan mengeksekusi `GenerateWeeklyDonationsJob` di hari Senin. Namun, pesan broadcast terjadwal dari admin panel akan dicek setiap menitnya.)*

### 2. Mode Production (Server Linux / Ubuntu)

Saat sistem sudah di-deploy (misal di VPS Nginx), Anda harus mengatur **Cron Job** dan **Supervisor** agar berjalan tanpa intervensi.

#### A. Konfigurasi Cron (Untuk Scheduler / Reminder)
Masuk ke terminal server Anda dan jalankan perintah:
```bash
crontab -e
```
Tambahkan baris berikut di bagian paling bawah (Sesuaikan direktori ke folder project Anda):
```bash
* * * * * cd /var/www/mbmyouth && php artisan schedule:run >> /dev/null 2>&1
```
*Dengan ini, server akan selalu mengecek dan mengirim tagihan mingguan saat jadwalnya tiba secara presisi.*

#### B. Konfigurasi Supervisor (Untuk Proses Queue)
Agar pesan WhatsApp (Queue) berjalan terus-menerus meskipun terminal ditutup, gunakan `Supervisor`.
1. Install Supervisor di server Ubuntu:
   ```bash
   sudo apt-get install supervisor
   ```
2. Buat file konfigurasi worker baru:
   ```bash
   sudo nano /etc/supervisor/conf.d/mbmyouth-worker.conf
   ```
3. Isi dengan script berikut:
   ```ini
   [program:mbmyouth-worker]
   process_name=%(program_name)s_%(process_num)02d
   command=php /var/www/mbmyouth/artisan queue:work --sleep=3 --tries=3 --max-time=3600
   autostart=true
   autorestart=true
   stopasgroup=true
   killasgroup=true
   user=www-data
   numprocs=2
   redirect_stderr=true
   stdout_logfile=/var/www/mbmyouth/storage/logs/worker.log
   stopwaitsecs=3600
   ```
4. Baca ulang dan jalankan ulang Supervisor:
   ```bash
   sudo supervisorctl reread
   sudo supervisorctl update
   sudo supervisorctl start mbmyouth-worker:*
   ```

---

## 📦 Deployment ke Production (Ringkasan)

Saat akan melakukan deploy ke server produksi, ikuti *checklist* berikut:
1. Pastikan `APP_ENV=production` dan `APP_DEBUG=false` di file `.env`.
2. Jalankan `composer install --optimize-autoloader --no-dev`.
3. Lakukan build asset untuk frontend/Filament:
   ```bash
   npm run build
   ```
4. Lakukan optimize aplikasi Laravel:
   ```bash
   php artisan optimize
   php artisan view:cache
   php artisan event:cache
   php artisan filament:cache-components
   ```
5. Pastikan folder `storage` dan `bootstrap/cache` memiliki hak akses *write* (misal: `chmod -R 775` dan chown ke `www-data`).
6. Atur **Cron Job** dan **Supervisor** seperti penjelasan di bagian atas.
7. Aplikasi siap digunakan!
