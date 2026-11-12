# Verifikasi jurnal_adjustment

## Perubahan

- Controller memeriksa permission View/Manage di server, metode HTTP, dan token preview acak yang terikat session dan ID adjustment. Respons mempertahankan `code`/`msg`, dengan tambahan `nomor` saat sukses.
- Model memakai perhitungan yang sama untuk preview/posting. Nominal tetap `round(qty * costbook)` dalam satuan penuh; PLUS mendebit persediaan, MINUS mengkredit persediaan.
- Costbook hari ini diambil dari `ms_costbook`; transaksi lampau mengambil snapshot terakhir pada tanggal yang sama dari `ms_costbook_backup`. Costbook kosong, tidak positif, atau ambigu ditolak. Tidak ada fallback tanggal lain.
- COA `1105-01-01` dan `6201-01-51` wajib masing-masing satu pada `101-<subcab>`, dengan konfigurasi cabang 101 yang tunggal. Nilai preview yang berubah wajib diperiksa ulang.
- Penguncian adjustment dan counter, header/detail, snapshot costbook/total, serta status CLS berada pada satu transaksi/koneksi lintas database. Header disimpan sebelum detail. Error query, jumlah baris, status transaksi, dan commit diperiksa; error teknis tidak dikirim ke pengguna.
- MUTASI tidak masuk daftar pending, tidak dibuatkan jurnal, dan tidak diubah menjadi CLS. Referensi jurnal lama, termasuk header/detail parsial, memblokir posting ulang.
- View meng-escape data tersimpan dan menolak submit berulang. Layout modal dikembalikan ke tampilan awal: enam field readonly, tabel jurnal dengan header biru/footer abu-abu, serta tombol Close/Save. Field Tanggal memuat tanggal adjustment; tanggal detail jurnal tetap tanggal posting. Kesalahan AJAX tidak ditampilkan sebagai sukses.

Tanggal posting tetap hari proses dalam Asia/Jakarta. Snapshot disimpan hanya untuk preview terakhir per session. Semua kode/error/perhitungan dapat diuji tanpa browser.

## Pengujian

Gunakan PHP 8.5 dengan mysqli; tes stock juga memerlukan mbstring. Contoh PowerShell untuk runtime lokal yang tersedia:

```powershell
$php = Join-Path $env:TEMP 'waterco-adjustment-php85\php.exe'
$ext = 'extension_dir=' + (Join-Path $env:TEMP 'waterco-adjustment-php85\ext')
$env:JURNAL_ADJUSTMENT_TEST_DB = '1'
& $php -n -d $ext -d extension=mysqli tests/jurnal_adjustment_test.php
& $php -n -d $ext -d extension=mysqli tests/jurnal_adjustment_concurrency_test.php
node tests/jurnal_adjustment_form_test.js

$env:ADJUSTMENT_TEST_DB = '1'
& $php -n -d $ext -d extension=mysqli -d extension=mbstring tests/adjustmentstock_integration_test.php
& $php -n -d $ext -d extension=mysqli -d extension=mbstring tests/adjustmentstock_integration_test.php --multi
& $php -n tests/adjustmentstock_view_test.php
node tests/adjustmentstock_form_test.js $php
```

`jurnal_adjustment_test.php` memakai tabel TEMPORARY yang membayangi tabel asli hanya pada koneksi tes. Driver database CodeIgniter, BF_Model, Base_Controller, dan Admin_Controller asli dimuat; service session/auth/input/output diganti fixture. Konstruktor framework dilewati agar tidak menjalankan login/render aplikasi.

`jurnal_adjustment_concurrency_test.php` memerlukan hak CREATE/DROP DATABASE dan `proc_open`. Tes membuat dua database bernama acak `jurnal_adj_test_<12 hex>_erp/acc`, menyalin struktur tanpa data operasional, dan menghapus hanya database yang berhasil dibuatnya. Backup tes berada di direktori temporary OS dan dibersihkan setelah tes. Jika proses dihentikan paksa, database/direktori tes dapat tersisa; periksa nama sebelum membersihkannya.

Skenario meliputi PLUS/MINUS seimbang, NULL/OPN/CLS, token dan permission, ID/qty/tanggal/costbook/COA/cabang invalid, snapshot berubah, jurnal lama, pembulatan, escaping, pagination, rollback setelah setiap tahap, begin/commit gagal, serta guard MyISAM pada empat tabel penulisan. Dua proses posting benar-benar menunggu lock database sebelum dilepas untuk menguji sumber sama, sumber berbeda, dan benturan header dari penulis lama.

Latihan migrasi memeriksa backup, konversi engine dan indeks, migrasi ulang, deteksi perubahan isi, restore SQL ke tabel tes kosong, lalu migrasi kembali. JavaScript diuji melalui Node VM untuk race preview, cancel, submit ganda, respons gagal, dan sukses.

Hasil verifikasi lokal pada PHP 8.5.12:

- 200 pemeriksaan backend jurnal adjustment lulus.
- 32 pemeriksaan preflight, backup/restore, migrasi, dan concurrency lulus.
- Tes JavaScript jurnal adjustment lulus.
- Regresi stock: 72 pemeriksaan single dan 102 multi lulus; render form dan tes JavaScript stock juga lulus.
- Lint tujuh file PHP terkait dan `git diff --check` lulus. Tidak ada jurnal operasional dibuat selama tes.

## Maintenance database

Implementasi kode tidak menjalankan migrasi otomatis. Migrasi lokal yang diminta terpisah sudah dijalankan; hasilnya dicatat di bawah. Posting mengembalikan HTTP 503 selama salah satu dari `adjustment_stock`, `javh`, `jurnal`, atau `pastibisa_tb_cabang` belum InnoDB. `coa_master` tetap MyISAM karena hanya dibaca.

1. Jalankan preflight dengan environment yang benar. Pilihan default `development`; `production` membaca konfigurasi production atau konfigurasi dasar aplikasi. Database default wajib cocok dengan konstanta DBERP. Simpan laporan di lokasi privat.
2. Periksa temuan adjustment ganda, ID melebihi kapasitas referensi, COA/cabang, jurnal tidak seimbang, header/detail parsial, dan adjustment terbuka yang sudah punya referensi jurnal. Daftar temuan dibatasi 100 baris per kategori; kosongnya laporan bukan sertifikasi seluruh accounting. Pemeriksaan header/detail memakai keterangan `Adjustment %`, sebab modul lain dapat memiliki tabel header berbeda.
3. Hentikan seluruh penulis accounting dan adjustment, termasuk job/worker, dan pertahankan maintenance sampai verifikasi selesai. Flag `--maintenance` adalah pernyataan operator; skrip tidak menghentikan aplikasi atau worker otomatis.
4. Jalankan backup ke direktori baru di luar workspace/web root. Skrip mengambil READ lock pada empat tabel penulisan saat mengekspor SQL dan manifest. File tidak ditimpa. Jika ditemukan trigger, skrip menolak backup; DBA harus menyiapkan prosedur lengkap yang mencakup trigger.
5. Jalankan migrasi dengan backup tersebut. Setiap ALTER TABLE melakukan implicit commit; kegagalan dapat meninggalkan sebagian tabel sudah InnoDB. Jangan membuka maintenance pada kondisi ini.
6. Jalankan verifikasi sebelum membuka akses. Verifikasi mencocokkan server/database, checksum dump, jumlah baris, sidik isi semua kolom, struktur kolom, indeks lama, engine, dan indeks pencarian ID adjustment. Isi debit/kredit/header ikut diperiksa melalui sidik data lengkap, bukan hanya jumlah baris.

```powershell
& $php -n -d $ext -d extension=mysqli scripts/migrate_jurnal_adjustment.php --preflight --environment=development
& $php -n -d $ext -d extension=mysqli scripts/migrate_jurnal_adjustment.php --backup --maintenance --environment=development --backup-dir=C:\backups\waterco-jurnal-adjustment-YYYYMMDD
& $php -n -d $ext -d extension=mysqli scripts/migrate_jurnal_adjustment.php --migrate --maintenance --environment=development --backup-dir=C:\backups\waterco-jurnal-adjustment-YYYYMMDD
& $php -n -d $ext -d extension=mysqli scripts/migrate_jurnal_adjustment.php --verify --maintenance --environment=development --backup-dir=C:\backups\waterco-jurnal-adjustment-YYYYMMDD
```

Jika ALTER gagal tetapi isi tetap sama, perbaiki penyebab saat maintenance lalu ulangi `--migrate` memakai backup yang sama. Jika verifikasi mendeteksi perubahan isi/struktur yang tidak diharapkan, jangan lanjutkan atau membalik engine otomatis. Simpan tabel gagal untuk investigasi, verifikasi checksum dump, lalu DBA memulihkan empat tabel dari SQL backup ke tabel target yang sudah dikosongkan/disiapkan. Dump memakai CREATE TABLE tanpa DROP untuk mencegah penimpaan tidak sengaja. Periksa ulang seluruh isi, engine, indeks, dan aplikasi sebelum membuka penulisan. Backup harus tersimpan privat dan latihan restore harus selesai sebelum migrasi operasional.

## Hasil migrasi gl_waterco lokal — 12 November 2026

Target diperiksa sebagai MySQL 5.7.44 pada `localhost:3306`, terikat Docker hanya ke `127.0.0.1:3306`, container `waterco_db` / hostname `529f01e1febf`. Tidak ada koneksi atau migrasi server remote.

Sesuai permintaan, hanya tiga engine tabel `gl_waterco` yang diubah. Layanan `waterco_web85` dihentikan sementara sebelum backup dan dihidupkan kembali setelah seluruh verifikasi selesai; container database tetap sehat.

| Tabel | Engine sebelum | Engine sesudah | Baris sebelum/sesudah |
| --- | --- | --- | --- |
| `gl_waterco.javh` | MyISAM | InnoDB | 7.140 / 7.140 |
| `gl_waterco.jurnal` | MyISAM | InnoDB | 37.789 / 37.789 |
| `gl_waterco.pastibisa_tb_cabang` | MyISAM | InnoDB | 1 / 1 |

Backup privat: `C:\web_dev\backups\gl_waterco-local-20261112-124344`. Direktori berisi tiga dump SQL, `preflight.json`, `manifest.json`, dan `verification.json`. Backup di-flush ke disk sebelum ALTER; checksum dump dan manifest diverifikasi sebelum konversi.

Hasil pemeriksaan:

- Sidik SHA-256 seluruh isi setiap tabel, jumlah baris, struktur kolom, dan indeks lama sama sebelum/sesudah konversi.
- Total header, debit, dan kredit sama sebelum/sesudah; tidak ada perubahan nilai jurnal atau counter.
- Satu nilai lama `tgl_jvkoreksi = '0000-00-00'` dipertahankan. Hanya flag `NO_ZERO_DATE`/`NO_ZERO_IN_DATE` pada sesi migrasi yang dilepas saat ALTER, kemudian SQL mode sesi dikembalikan. SQL mode global tidak diubah.
- `waterco_demo.adjustment_stock` (676 baris) dan `gl_waterco.coa_master` (263 baris) diperiksa melalui sidik isi, engine, kolom, dan indeks; keduanya tidak berubah.
- `Jurnal_adjustment_model::assert_transactional_tables()` dijalankan melalui driver CodeIgniter pada database lokal asli dan lulus. Tidak dilakukan posting jurnal untuk pengujian.
- Preflight adjustment tidak menemukan ID invalid/ganda, jurnal tidak seimbang, header/detail parsial, atau adjustment terbuka yang sudah memiliki referensi jurnal.

Indeks tambahan pada `waterco_demo.adjustment_stock` tidak dipasang karena permintaan membatasi perubahan ke `gl_waterco`. Verifikasi eksekusi lokal memakai manifest tiga tabel dan pembandingan tabel lain yang tidak berubah; berbeda dari `--verify` generik di atas yang juga mensyaratkan indeks ERP. Guard transaksi aplikasi hanya mensyaratkan engine InnoDB, sehingga sudah lulus pada lokal.

## Batas dan tindak lanjut

- Tiga tabel accounting lokal sudah InnoDB dan web lokal sudah diaktifkan kembali. Migrasi remote tidak dijalankan. Indeks pencarian ID adjustment pada database ERP tetap pekerjaan terpisah jika diperlukan.
- Audit sebelumnya menemukan 443 dari 655 adjustment PLUS/MINUS terbuka belum punya backup costbook tanggal transaksi. Costbook sah perlu dilengkapi; kode tidak mengarang valuasi atau memperbaiki jurnal lama otomatis.
- Counter masih dipakai modul lama yang belum mengunci pembacaan. Modul ini membatalkan benturan secara utuh; penyeragaman generator nomor seluruh accounting tetap pekerjaan terpisah. Counter tertinggal atau nomor berisi detail yatim memerlukan rekonsiliasi, bukan retry tanpa batas.
- Hilangnya koneksi saat commit dapat membuat hasil tidak pasti. Respons meminta pemeriksaan status; jangan retry otomatis. Status/ref jurnal mencegah posting ulang jika commit sebenarnya sudah berhasil.
- Schema uang tetap DOUBLE dan nominal jurnal dibulatkan ke satuan penuh. Migrasi DECIMAL diperlukan bila kebijakan nominal pecahan berubah.
- Backup dan ALTER pada data besar memerlukan disk/memori serta waktu maintenance yang cukup. Backup yang disiapkan hanya empat tabel penulisan; full database backup tetap bagian prosedur DBA bila perubahan maintenance lain dijalankan bersamaan.
- Tidak ada dependency baru, pengujian browser, commit, atau perubahan pada pekerjaan lokal modul lain.
