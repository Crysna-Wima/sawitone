# Sawitone

Sawitone adalah aplikasi **ERP untuk pengelolaan kelapa sawit** yang dibangun menggunakan **Laravel Framework** dan **MySQL** sebagai basis data utama. Aplikasi ini dikembangkan untuk membantu perusahaan kelapa sawit dalam mengelola data operasional, keuangan, dan distribusi secara terintegrasi.

---

## 🚀 Teknologi yang Digunakan

* **Bahasa Pemrograman**: PHP `^7.3|^8.0`
* **Framework**: Laravel `^8.75`
* **Database**: MySQL
* **Web Server**: Apache / Nginx
* **Dependency Management**: Composer & NPM

---

## 📂 Struktur Proyek

```
sawitone/
├── app/              # Business logic aplikasi
├── bootstrap/        # File bootstrap Laravel
├── config/           # Konfigurasi aplikasi
├── database/         # Migrasi dan seeder database
├── public/           # Entry point aplikasi (index.php)
├── resources/        # Blade templates, CSS, JS
├── routes/           # Definisi routes (web/api)
├── storage/          # Cache, logs, uploads
├── tests/            # Unit & feature tests
└── vendor/           # Dependency composer
```

---

## ⚙️ Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/sawitone.git
cd sawitone
```

### 2. Install Dependencies

```bash
composer install
npm install && npm run dev
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env` lalu sesuaikan konfigurasi database dan lainnya:

```bash
cp .env.example .env
```

Edit file `.env`:

```env
APP_NAME=Sawitone
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sawitone_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Migrasi Database

```bash
php artisan migrate --seed
```

### 6. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi dapat diakses di: [http://localhost:8000](http://localhost:8000)

---

## 🛠️ Fitur Utama

* 📊 **Manajemen Data Operasional** (perkebunan, panen, distribusi)
* 💰 **Modul Keuangan & Akuntansi**
* 👥 **Manajemen Karyawan & Absensi**
* 🏭 **Integrasi Produksi & Gudang**
* 📈 **Dashboard & Laporan Analitik**

---

## 👨‍💻 Kontribusi

Jika ingin berkontribusi, silakan fork repository ini dan ajukan pull request dengan penjelasan yang jelas mengenai perubahan yang diajukan.

---

## 📜 Lisensi

Proyek ini dirilis di bawah lisensi [MIT License](LICENSE).
