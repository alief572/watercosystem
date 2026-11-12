# Stock booking: cleansing dan SOP

## Keputusan dan status penerapan

Target pekerjaan ini adalah `206.84.97.106 / waterco_dev`. Excel **List Barang Statusnya masih So per 20 Oktober 2026.xlsx** menjadi acuan 21 baris, 9 SO, 57 unit pada 20 Oktober 2026 pukul 10.00 WIB. Qty setiap pasangan SO–barang tetap mengikuti Excel, termasuk bila ada pengiriman setelah cutoff. Kolom Qty SO dipakai per baris; Total Booking merupakan pembanding agregat dan tidak dijumlahkan ulang ke setiap baris.

Booking sah setelah cutoff dipertahankan tanpa menghitung ulang pasangan yang sudah dicakup Excel. SO baru memakai sisa Qty SO setelah pengiriman terkonfirmasi. Booking baru pada SO lama harus mempunyai bukti kartu stok yang tidak ambigu. Barang tanpa kode dicocokkan dengan nama unik pada SO; kode gabungan dicocokkan dengan kode master, bukan dipecah otomatis.

Audit awal menemukan 5.571 baris stok di dua tabel. Saldo booking tujuan adalah 68 unit: 57 dari Excel dan 11 dari booking sah setelah cutoff. Ada 11 konflik: sembilan aktual minus dan dua barang dengan booking Excel di atas aktual. Dua barang tersebut adalah `2201480 + 2280600` pada SO `043/WI/SO/IX/2026` (booking 5, aktual 2) serta `244200` pada SO `044/WI/SO/X/2026` (booking 10, aktual 3). Laporan terbaru berada di `output/stock-booking/audit/`.

**Cleansing bertahap sudah diterapkan pada 26 Oktober 2026 pukul 10.56 WIB** di `waterco_dev`, menggunakan kode di `C:/web_dev/watercosystem` dan koneksi `application/config/development/database.php`. Batch: `7fe0560902ba61c4c771bfecba939a75df4ff536604fd5d35219be6f1e0cdcd8`.

Hasil verifikasi: 195 koreksi kartu stok; 5.560 baris operasional memenuhi aturan saldo; 11 baris dikarantina dan dinonaktifkan (`aktif=N`). Seluruh Qty Aktual tetap. Qty Aktual, Qty Booking, dan Qty Free pada baris karantina dipertahankan apa adanya; 15 unit kebutuhan booking Excel tetap tersimpan pada alokasi yang diblokir. Booking operasional adalah 53 unit. Maintenance database sudah OFF. Laporan penerapan dan verifikasi ada di `output/stock-booking/applied-quarantine/`.

Backup sebelum perubahan mencakup 386 tabel, 29 view, dan 5.437.908 baris, tersimpan sebagai `output/stock-booking/backup-before-quarantine.sql.gz` beserta manifest SHA256. Backup gzip dan SHA256 sudah diperiksa.

Mode bawaan tetap menghentikan apply bila ada konflik. Mode `--quarantine-conflicts` hanya mengisolasi konflik kapasitas yang dapat dipetakan ke identitas stok tertentu; pemetaan ambigu tetap menghentikan seluruh apply. Pilihan ini disetujui pengguna agar barang lain tetap dapat dioperasikan. Baris karantina perlu stock opname/adjustment dengan bukti yang sah sebelum rekonsiliasi dan pembukaan blokir; jangan menjalankan ulang baseline atau mengaktifkan baris tersebut secara manual.

## Aturan saldo dan penyimpanan

- Untuk baris di luar karantina: `0 <= qty_book <= qty`; `qty_free = qty - qty_book`. Saldo tidak valid pada karantina dipertahankan untuk rekonsiliasi dan tidak dapat ditransaksikan.
- Tanpa booking sah, free sama dengan aktual. Nilai booking minus dikoreksi sebagai anomali saldo; nilainya tidak dianggap stok yang dilepas.
- `stock_booking_allocations` menyimpan alokasi per detail SO dan identitas baris stok. `stock_booking_operations` menahan pengulangan operasi; `stock_booking_batches` menyimpan snapshot cleansing dan batas ID detail lama.
- Baseline menyimpan booking Excel sebagai saldo yang disetujui, terpisah dari jumlah historis yang sudah dikirim. Perubahan Qty berikutnya menggunakan selisih dari Qty SO saat baseline, sehingga pemanggilan ulang tidak menghidupkan booking yang sudah dilepas.
- SO normal menggunakan baris unik pada Gudang Penjualan (`id_gudang=1`). Baris yang tidak unik ditolak. Saldo gudang lain diperiksa terpisah; mutasi tidak menggunakan filter kode barang saja.
- Kolom qty pada stok dan kartu stok database saat ini mempunyai presisi nol. Qty pecahan, tidak numerik, minus, atau di luar rentang integer yang aman ditolak.
- Mutasi menggunakan transaksi InnoDB, `FOR UPDATE`, dan lock `waterco-stock-booking`. Status dokumen, alokasi, saldo, serta kartu stok menjadi satu transaksi. Respons sukses dikirim setelah commit.
- `stock_booking_quarantine` menyimpan identitas barang/gudang, snapshot saldo asli, target booking, batch, dan alasan blokir. Enam guard INSERT/UPDATE/DELETE mencegah transaksi pada baris karantina, penghapusan, perubahan identitas, dan pembuatan baris pengganti untuk barang/gudang yang sama.
- `stock_booking_control` mengendalikan maintenance stok. Instalasi skema mengaktifkan maintenance; apply yang terverifikasi mematikannya dalam transaksi commit yang sama. Jika apply gagal, maintenance tetap ON sampai penyebabnya diselesaikan.
- Guard database menolak saldo tidak valid dan perubahan booking yang melewati layanan alokasi. Jalur lama yang mengirim saldo tidak konsisten akan gagal, sehingga tidak dapat merusak saldo kembali.

Pemilihan ledger diperlukan karena saldo agregat barang tidak menunjukkan booking milik SO tertentu. Membatasi angka minus saja masih memungkinkan pembatalan SO mengambil booking milik SO lain. Penguncian mengikuti [locking reads MySQL](https://dev.mysql.com/doc/refman/8.0/en/innodb-locking-reads.html), dengan transaksi yang memenuhi persyaratan [MySQLi/InnoDB](https://www.php.net/manual/en/mysqli.begin-transaction.php).

## SOP SO Invoice dan SO Indent

| Tahap | Stok dan booking |
|---|---|
| Draft | Tidak membooking. |
| SO Stock deal | Validasi tipe dari penawaran tersimpan, Qty dan ketersediaan; booking satu kali. Token formulir menolak pengiriman ulang permintaan yang sama. |
| SO Indent dibuat | Tidak membooking stok fisik. |
| Indent Ready to Deliver | Booking satu kali setelah stok mencukupi; permintaan ulang tidak menambah booking. |
| Invoice/proforma | Dokumen penagihan tidak membooking atau mengeluarkan stok lagi. Jalur invoicing yang diperiksa tidak menulis saldo stok. |
| Planning dan SPK | Dibatasi sisa alokasi; belum mengurangi aktual. |
| DO dibuat | Qty dan identitas barang harus cocok dengan SO/SPK serta sisa alokasi. Belum mengurangi aktual. |
| DO dikonfirmasi berhasil | Mengurangi aktual dan booking milik detail SO; konfirmasi ulang tidak memutasi stok. Total pengiriman dihitung dari DO berhasil yang terkonfirmasi. |
| DO gagal kirim | Aktual dan booking SO tetap. Qty planning/SPK yang gagal dibuka kembali untuk penjadwalan ulang. |
| Pembatalan planning | Mengurangi jadwal milik planning tersebut saja. Planning yang sudah mempunyai SPK ditolak sampai dokumen turunannya selesai. |
| Pembatalan SO penuh | Hanya sisa booking yang dilepas. SO disimpan sebagai soft delete, sehingga detail/alokasi/histori tetap ada. Invoice aktif, pengiriman berhasil, atau DO yang belum selesai harus ditangani terlebih dahulu. |
| Pengurangan Qty SO | Layanan mengurangi sisa alokasi sesuai selisih Qty; Qty di bawah jumlah yang sudah dikirim/dilepas ditolak. Perubahan dokumen/keuangan harus mengikuti prosedur revisi yang berlaku. |
| Incoming/adjustment | Memperbarui aktual dan menghitung free dari aktual dikurangi alokasi. Adjustment yang membuat aktual di bawah booking ditolak. |
| Input stok awal | Booking awal harus nol; booking dibuat melalui SO. Free dihitung dari aktual. |

Pengiriman berhasil tidak boleh dibatalkan dengan mengubah status kirim lalu mengirim ulang endpoint konfirmasi. Gunakan pembalikan tercatat setelah barang benar-benar kembali atau terdapat bukti koreksi yang sah. `scripts/reverse_stock_booking_delivery.php` mendukung DO yang diproses oleh layanan baru, menolak jurnal DO yang sudah diposting, mempertahankan booking SO, dan menandai DO sebagai `R`. Pengiriman berikutnya memakai DO baru. DO historis sebelum baseline memerlukan rekonsiliasi tersendiri; tidak dibalik otomatis.

## Menjalankan audit dan penerapan

Perintah berikut adalah prosedur awal untuk database yang **belum** mempunyai baseline. Target saat ini sudah diproses; pengulangan batch ditolak agar transaksi berikutnya tidak ditimpa.

1. Ekspor manifest dari Excel asli, lalu buat backup tabel/view/trigger. Manifest memeriksa 21 baris, 9 SO, total 57, dan merekam SHA256 file Excel tanpa mengubahnya.

   ```powershell
   python scripts/read_stock_booking_excel.py "C:/Users/Febry/Downloads/List Barang Statusnya masih So per 20 Oktober 2026.xlsx" --output output/stock-booking/source.json
   php scripts/backup_stock_booking_database.php --output output/stock-booking/backup-before-quarantine.sql.gz
   php scripts/cleanse_stock_booking.php --source=output/stock-booking/source.json --report=output/stock-booking/audit-quarantine --quarantine-conflicts
   ```

2. Tinjau `summary.md`, `conflicts.csv`, `quarantine.csv`, `allocations.csv`, `changes.csv`, dan snapshot JSON. Pastikan konflik hanya pada baris yang disetujui untuk dikarantina. Script menolak konflik pemetaan dan perubahan jumlah karantina dari angka yang ditinjau.
3. Pasang skema/guard dalam langkah terpisah menggunakan backup terverifikasi dan SHA256 snapshot dry-run terakhir. DDL dipisahkan dari transaksi saldo untuk menghindari implicit commit MySQL. Langkah ini mengaktifkan maintenance stok database; tidak perlu mematikan seluruh web server.

   ```powershell
   php scripts/cleanse_stock_booking.php --source=output/stock-booking/source.json --report=output/stock-booking/install-quarantine --quarantine-conflicts --expected-quarantine-count=11 --install-schema --maintenance --expected-snapshot=SHA256_DARI_AUDIT --backup=output/stock-booking/backup-before-quarantine.sql.gz
   ```

4. Terapkan baseline dengan snapshot yang sama. Script mengunci/membaca ulang data, menyimpan karantina dan alokasi penuh, mengoreksi stok yang valid, memeriksa seluruh saldo, lalu commit dan membuka maintenance. Qty Aktual tidak diubah; Qty karantina tidak dikoreksi otomatis.

   ```powershell
   php scripts/cleanse_stock_booking.php --source=output/stock-booking/source.json --report=output/stock-booking/applied-quarantine --quarantine-conflicts --expected-quarantine-count=11 --apply --maintenance --expected-snapshot=SHA256_DARI_AUDIT --backup=output/stock-booking/backup-before-quarantine.sql.gz
   ```

5. Segera sesudah apply, jalankan verifikasi hanya-baca berikut. Pemeriksaan ini juga membandingkan aktual dengan snapshot sebelum cleansing; jangan memakainya sebagai monitor rutin sesudah terdapat incoming/DO/adjustment baru yang sah.

   ```powershell
   php scripts/verify_stock_booking_cleansing.php --batch=HASH_BATCH --report=output/stock-booking/applied-quarantine/verification.json
   ```

Jika penerapan gagal sebelum commit, seluruh mutasi saldo, alokasi, karantina, dan kartu stok dibatalkan; skema tetap ada dan maintenance yang dipasang sebelumnya tetap ON. Setelah commit, jangan memulihkan snapshot lama di atas transaksi baru. Gunakan jurnal dan transaksi pembalik yang memeriksa kondisi saat ini. Snapshot yang mengandung saldo minus bukan baseline yang aman untuk diaktifkan kembali.

Pembalikan DO selalu dry-run secara bawaan:

```powershell
php scripts/reverse_stock_booking_delivery.php --no-do=KODE_INTERNAL_DO --reason="Referensi bukti retur/koreksi"
```

Tambahkan `--apply` hanya setelah hasil dry-run dan bukti fisik/keuangan sesuai.

## Pengujian

```powershell
php tests/stock_booking_rules_test.php
php tests/stock_booking_cleansing_test.php
php tests/stock_booking_integration_test.php
php tests/stock_booking_guard_test.php
php tests/stock_booking_partial_apply_test.php
```

Dua pengujian pertama tidak memerlukan database. Pengujian integrasi memakai tabel TEMPORARY pada koneksi tersendiri, termasuk simulasi transaksi CodeIgniter dan dua koneksi untuk memeriksa lock. Pengujian guard membuat tiga tabel fixture bernama acak (stok, kontrol maintenance, dan karantina), lalu menghapus seluruh fixture dan trigger-nya dalam `finally`, karena MySQL tidak mendukung trigger pada tabel TEMPORARY. Tidak ada pengujian yang mengubah baris stok aplikasi. Tidak diperlukan pengujian browser untuk pekerjaan ini.

Pengujian apply parsial menggunakan tabel TEMPORARY dengan struktur stok yang sama seperti database untuk membuktikan rollback, pelestarian jumlah booking, penolakan akses karantina, saldo barang sehat, dan penolakan batch berulang.
