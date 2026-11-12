# Adjustment stock

Alur aktif yang diperiksa: PLUS/MINUS gudang utama, display, exdisplay, retur dan konsinyasi; mutasi antar-gudang; pemilihan gudang; form; daftar stok; dan riwayat.

## Perubahan

- Kedua `SavePlus` memakai `Stock_booking::document()` dan jalur adjustment bersama. Saldo, kartu stok, riwayat, serta penanda permintaan disimpan dalam transaksi yang sama.
- Referensi perubahan stok memakai nomor adjustment. Dua adjustment berbeda untuk barang/arah yang sama tidak lagi berbenturan dengan label tetap `ADJUSMENT PLUS` atau `ADJUSMENT MINUS`.
- Token acak per form terikat sesi dan dicatat di `stock_booking_operations`. Pengiriman ulang ditolak tanpa perubahan tambahan. Sesi menyimpan maksimal 50 token form; form lebih lama perlu dibuka ulang.
- Endpoint simpan tetap `POST .../SavePlus`, dengan JSON `status`, `pesan`, dan `code`. `code` sukses berisi nomor adjustment. Izin `Adjustmentstock.Add` dan `Adjustmentstock.Manage` tetap diperlukan; endpoint baca memerlukan `Adjustmentstock.View`.
- Material, gudang, stok asal, dan metadata dibaca dari database. Jumlah harus bulat positif dan muat dalam kolom riwayat `INT`; alasan wajib maksimal 255 karakter. Saldo asal juga diperiksa agar snapshot riwayat tidak terpotong.
- MINUS/mutasi hanya mengurangi stok bebas. Booking tetap di asal. Tujuan baru dibuat dengan saldo dan booking nol sebelum menerima stok; tujuan ambigu, tidak aktif, dikarantina, atau ledger tidak konsisten ditolak.
- Form bersama menggantikan AJAX lot/berat lama yang tidak sesuai skema stok saat ini. Endpoint helper lama tetap tersedia dengan pemeriksaan izin, parameter terikat, dan keluaran HTML yang di-escape.
- Riwayat mengikuti gudang asal/tujuan. Riwayat utama membedakan total dan hasil pencarian serta membatasi satu halaman hingga 100 baris. Tabel tetap mempunyai jumlah kolom konsisten untuk pengguna View saja.

Tidak ada migrasi, cleansing, perubahan konfigurasi database, atau perubahan alur SO/DO dalam pekerjaan ini. CRUD master inventory dan cetak PDF legacy berada di luar cakupan perbaikan alur aktif.

## Berkas berubah

- `application/libraries/Stock_booking.php` dan `Stock_booking_store.php`: token sesi dan transaksi adjustment bersama.
- `application/modules/adjustmentstock/`: controller, model `Inventory_4_model`, serta view `Adjust` dan `index`.
- `application/modules/adjustmentstockmulti/`: controller, model `Inventory_4_model`, serta view `Adjust`, `CreateMutasi`, `index_display`, `index_exdisplay`, `index_retur`, `index_konsinyasi`, `index_mutasi`, `konsinyasi`, dan `mutasi`.
- `tests/adjustmentstock_view_test.php`, `adjustmentstock_integration_test.php`, dan `adjustmentstock_form_test.js`: regresi render, database/controller, dan submit form.
- Dokumen ini: perilaku, perintah tes, hasil, dan batasan verifikasi.

## Menjalankan pemeriksaan

Gunakan PHP 8.5 dengan ekstensi `mysqli`, `mbstring`, dan DOM. Tes integrasi membaca koneksi dari `application/config/development/database.php`. Koneksi harus mengizinkan `CREATE TEMPORARY TABLE`; seluruh tabel fixture menutupi tabel asli hanya pada koneksi tes dan hilang saat koneksi ditutup. Tes tidak membuat trigger atau mengubah data operasional.

PowerShell:

```powershell
php tests/adjustmentstock_view_test.php
node tests/adjustmentstock_form_test.js
php tests/stock_booking_rules_test.php
php tests/stock_booking_cleansing_test.php
$env:ADJUSTMENT_TEST_DB = '1'
php tests/adjustmentstock_integration_test.php
php tests/adjustmentstock_integration_test.php --multi
```

Jalankan kedua tes integrasi berurutan karena pemeriksaan controller memakai coordinator lock stok yang sama dengan aplikasi. Tes memakai driver database CodeIgniter, model dan controller sebenarnya; autentikasi, sesi, serta rendering template disediakan fixture CLI. Tes form JavaScript memakai Node VM tanpa browser atau dependensi tambahan.

Skenario meliputi adjustment berulang, replay token, token sesi lain, input tidak valid, akses tanpa izin, stok bebas, metadata palsu, tujuan baru, perpindahan dua arah, kegagalan kartu/riwayat, rollback controller, karantina, maintenance, saldo tidak konsisten, counter nomor penuh, pencarian, pagination, HTML berbahaya, dan kolom tabel berdasarkan izin.

## Hasil dan batasan

Verifikasi dijalankan pada PHP 8.5.12. Skema lokal memakai InnoDB untuk stok, kartu stok, dan riwayat; baseline booking berstatus `applied`, maintenance `0`, dan enam trigger `booking_guard_v2` terpasang. Pemeriksaan kondisi operasional tersebut hanya membaca data.

Hasil: 72 pemeriksaan integrasi modul tunggal, 102 pemeriksaan integrasi modul multi, tiga form render, pemeriksaan perilaku JavaScript, 11 aturan booking, dan 14 kasus cleansing lolos. Uji mutasi kondisi gudang tujuan juga dipastikan membuat tes regresi gagal; kode asli kemudian dipulihkan.

Tabel sementara tidak mewarisi trigger asli: tes integrasi membuktikan validasi dan transaksi layanan, bukan eksekusi trigger produksi. Browser dan cetak PDF tidak diuji. PDF legacy masih memakai kolom `weight` yang tidak ada pada skema lokal; perbaikannya merupakan TODO terpisah dari alur aktif di atas.

Deployment harus menyertakan seluruh library `Stock_booking*` yang sudah menjadi dependensi proyek. Tes menolak stok yang ledger/baseline-nya belum siap; pekerjaan ini tidak memperbaiki atau membersihkan saldo historis.
