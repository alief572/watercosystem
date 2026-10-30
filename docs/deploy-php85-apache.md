# Panduan Deployment Produksi Apache 2.4 + PHP 8.5 (Watercosystem)

Dokumen ini merupakan panduan deployment standar operasional untuk aplikasi **Watercosystem ERP** (berbasis **CodeIgniter 3.1.13 HMVC**) pada lingkungan web server **Apache 2.4** dan runtime **PHP 8.5** (PHP 8.5.12).

---

## 1. Arsitektur Sistem & Spesifikasi Lingkungan

| Komponen | Spesifikasi / Rekomendasi Produksi |
|---|---|
| **Sistem Operasi** | Linux Debian 12 (Bookworm) / Ubuntu 24.04 LTS / Docker Container Linux x86_64 |
| **Web Server** | Apache HTTP Server 2.4 (`apache2`) dengan modul `mod_rewrite` & `mod_headers` aktif |
| **PHP Runtime** | PHP 8.5 (kompatibel penuh dengan PHP 8.5.12) |
| **Framework** | CodeIgniter 3.1.13 HMVC (Wiredesignz MX) + Bonfire Base Models (BF_Model) |
| **Database Server** | MySQL 5.7 / MySQL 8.0 / MariaDB 10.4+ (`waterco_demo`, charset `utf8mb4`, collation `utf8mb4_unicode_ci`) |
| **PDF Engines** | Spipu HTML2PDF (%PDF-1.7 via TCPDF) & mPDF ^8.3 (%PDF-1.4) |
| **Spreadsheet Engine** | PhpOffice PhpSpreadsheet ^3.10 dengan shim kompatibilitas PHPExcel (`Phpexcel_compat.php`) |

---

## 2. Library Sistem Operasi & Ekstensi PHP Wajib

### Paket Sistem Operasi (Debian/Ubuntu)
Instal dependensi sistem menggunakan package manager `apt`:

```bash
apt-get update && apt-get install -y --no-install-recommends \
    apache2 \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    zip \
    unzip \
    git \
    curl \
    ca-certificates
```

### Ekstensi PHP Wajib
Berikut daftar ekstensi PHP yang wajib terpasang dan aktif:
- **`gd`**: Diperlukan untuk manipulasi citra, barcode, kop surat laporan, dan dokumen cetak PDF (dikompilasi dengan `--with-freetype --with-jpeg`).
- **`mysqli`**: Driver koneksi database utama CodeIgniter 3.
- **`pdo_mysql`**: Driver PDO untuk utilitas database sekunder dan query berkinerja tinggi.
- **`zip`**: Diperlukan oleh engine PhpSpreadsheet untuk membaca dan menulis format OpenXML (.xlsx).
- **`intl`**: Format lokalisasi mata uang (IDR), tanggal, dan angka.
- **`mbstring`**: Dukungan multibyte string untuk parsing UTF-8 pada laporan dan invoice.
- **`git`**: Dibutuhkan oleh Composer saat mengunduh dependensi source/dist tertentu.

Jika menggunakan `docker-php-ext-install` (pada Dockerfile):
```dockerfile
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd mysqli pdo_mysql zip intl mbstring
```

---

## 3. Konfigurasi Apache VirtualHost Produksi

Simpan konfigurasi VirtualHost pada `/etc/apache2/sites-available/watercosystem.conf`:

```apache
<VirtualHost *:80>
    ServerName erp.watercosystem.local
    ServerAlias watercosystem.com
    ServerAdmin webmaster@watercosystem.local
    DocumentRoot /var/www/html

    # Direktori Root Aplikasi
    <Directory /var/www/html>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        DirectoryIndex index.php index.html
        Require all granted
    </Directory>

    # Proteksi Direktori Sensitif
    <Directory /var/www/html/application>
        Require all denied
    </Directory>

    <Directory /var/www/html/system>
        Require all denied
    </Directory>

    # Logging
    LogLevel warn
    ErrorLog ${APACHE_LOG_DIR}/waterco_error.log
    CustomLog ${APACHE_LOG_DIR}/waterco_access.log combined

    # Security Headers
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-XSS-Protection "1; mode=block"
</VirtualHost>
```

Aktifkan modul Apache dan VirtualHost:
```bash
a2enmod rewrite headers
a2ensite watercosystem.conf
a2dissite 000-default.conf
apache2ctl configtest
systemctl restart apache2
```

Catatan: Pastikan file `/var/www/html/.htaccess` mengarahkan semua rute dinamis ke `index.php`:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L,QSA]
```

---

## 4. Konfigurasi `php.ini` Produksi

Konfigurasikan direktif PHP pada `/etc/php/8.5/apache2/php.ini` (atau `/usr/local/etc/php/conf.d/production.ini` untuk container):

```ini
[PHP]
; Batas Memori & Waktu Eksekusi
memory_limit = 512M
max_execution_time = 300
max_input_time = 300
max_input_vars = 5000

; Batas Upload Berkas Dokumen & Invoice
upload_max_filesize = 64M
post_max_size = 64M

; Penanganan Kesalahan (Produksi)
display_errors = Off
display_startup_errors = Off
log_errors = On
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE
error_log = /var/log/apache2/php_errors.log

; Zona Waktu & Tanggal
date.timezone = Asia/Jakarta

; Keamanan Session
session.use_strict_mode = 1
session.cookie_httponly = 1
session.cookie_secure = 0 ; Ganti 1 jika menggunakan HTTPS/SSL
session.gc_maxlifetime = 14400
```

Pastikan berkas log error PHP dapat ditulisi oleh Apache:
```bash
touch /var/log/apache2/php_errors.log
chown www-data:www-data /var/log/apache2/php_errors.log
chmod 660 /var/log/apache2/php_errors.log
```

---

## 5. Hak Akses Direktori (Write Permissions)

Aplikasi Watercosystem ERP membutuhkan hak akses tulis pada beberapa direktori penyimpanan log, temporary files, upload berkas, dan aset dinamis:

```bash
# Buat direktori jika belum ada
mkdir -p /var/www/html/application/logs
mkdir -p /var/www/html/uploads
mkdir -p /var/www/html/assets
mkdir -p /var/www/html/tmp

# Atur kepemilikan ke user web server (www-data)
chown -R www-data:www-data /var/www/html/application/logs
chown -R www-data:www-data /var/www/html/uploads
chown -R www-data:www-data /var/www/html/assets
chown -R www-data:www-data /var/www/html/tmp

# Atur izin akses aman (rwxrwxr-x untuk folder, rw-rw-r-- untuk berkas)
chmod -R 775 /var/www/html/application/logs
chmod -R 775 /var/www/html/uploads
chmod -R 775 /var/www/html/assets
chmod -R 775 /var/www/html/tmp
```

---

## 6. Manajemen Dependensi & Perintah Rilis Composer

Sebelum aplikasi dijalankan, pastikan seluruh dependensi PHP (PhpSpreadsheet ^3.10 dan mPDF ^8.3) diinstal secara optimal untuk produksi:

```bash
cd /var/www/html

# Instalasi dependensi tanpa dev requirements dan buat autoloader teroptimasi
composer install --no-dev --optimize-autoloader --no-interaction

# Verifikasi integritas autoloader
composer dump-autoload --optimize
```

Pastikan file backward-compatibility shim `application/libraries/Phpexcel_compat.php` dan `application/libraries/PHPExcel.php` tersedia untuk melayani modul-modul warisan Excel tanpa modifikasi kode modul.

---

## 7. Prosedur Verifikasi Pasca-Deployment

Setelah deployment selesai atau kontainer dijalankan ulang, jalankan rangkaian pengujian verifikasi otomatis untuk memastikan stabilitas runtime PHP 8.5:

### 1. Verifikasi Checkpoint Fase Upgrade
Jalankan verifikator checkpoint:
```bash
# Melalui host container:
docker exec waterco_web85 php scripts/verify_php85_checkpoint.php --status

# Atau langsung di server Linux:
php scripts/verify_php85_checkpoint.php --status
```
**Kriteria Lolos:**
- Seluruh Fase 0, 1, 2, 3, 4, dan 5 berstatus `[PASS]` / `LULUS`.
- Runtime terdeteksi `PHP 8.5.x`.
- Ekstensi `gd`, `mysqli`, `pdo_mysql`, `zip`, `intl`, `mbstring` aktif.
- Autoload vendor dan class `Spreadsheet`, `Mpdf`, `Html2Pdf`, `PHPExcel` resolve.
- Seluruh 54 modul terverifikasi.

### 2. Eksekusi Pengujian Regresi End-to-End Penuh (16/16 Test Cases)
Jalankan test suite E2E opaque-box:
```bash
# Melalui host container:
docker exec waterco_web85 php tests/e2e_php85_regression_test.php

# Atau langsung di server Linux:
php tests/e2e_php85_regression_test.php
```

**Cakupan Validasi Pengujian:**
- **Tier 1 (Feature Coverage - 7 Test Cases)**: Autentikasi admin (`POST /login` -> HTTP 303 & session cookie), Dashboard Sentral ERP (HTTP 200), Server-side DataTables Piutang Invoice & Progress PO (JSON contract valid), HTML2PDF Delivery Order (`%PDF-1.7`), mPDF Delivery Order (`%PDF-1.4`), dan PhpSpreadsheet Progress PO XLSX (PK ZIP valid).
- **Tier 2 (Boundary & Corner Cases - 5 Test Cases)**: Penolakan kredensial salah, proteksi redirect unauthenticated access (HTTP 307/302 ke `/login`), query DataTables rentang tanggal kosong (recordsTotal: 0), penanganan graceful ID non-existent entitas PDF tanpa fatal error.
- **Tier 3 (Cross-Feature Interactions - 3 Test Cases)**: Persistensi session login lintas 5 modul berurutan, verifikasi offset paginasi DataTables (start=0 vs start=10), dan terminasi session saat `/logout`.
- **Tier 4 (Real-World Scenarios - 1 Test Case)**: Siklus operasional lengkap manajer dari login, review dashboard, query DataTables, cetak PDF, ekspor XLSX, hingga logout.

**Kriteria Sukses Akhir:**
`OVERALL STATUS: ALL TESTS PASSED [PASS]` dengan `16 Passed`, `0 Failed`, exit code `0`.
