# Incoming dan pemulihan costbook Aquamatic

## Perilaku baru

- `incoming/SaveNew` memakai satu transaksi `Stock_booking::document()`. Kegagalan stok, costbook, detail Incoming, PO, atau commit membatalkan seluruh penulisan.
- Barang sama pada beberapa baris/PO digabung untuk mutasi stok dan HPP; detail penerimaan serta hutang tetap mengikuti PO masing-masing.
- Costbook kosong dibuat dari penerimaan hanya jika stok awal nol. Stok lama tanpa HPP, nilai tidak valid, dan costbook ganda menghentikan simpan dengan pesan spesifik.
- HPP rata-rata dibulatkan dua desimal. PPN masuk hutang, tidak masuk HPP; kurs diterapkan sekali. Hutang header dan PO mencakup PPN dalam mata uang transaksi dan IDR.
- Tambah/edit/check Costbook dan penyimpanan master barang aktif memakai lock yang sama. Edit barang tidak membuat atau mengosongkan costbook.
- Format respons `status`/`pesan` tetap; hasil Check juga menyediakan `msg`. Tidak ada perubahan skema atau dependensi.

Modul salinan `incoming2/3/4`, endpoint inventory lama, pembersihan duplikat historis, dan koreksi DO/jurnal lama di luar perubahan ini. Satu referensi mutasi yang sama dilindungi penanda operasi; pengiriman ulang HTTP yang menghasilkan nomor Incoming baru tetap dianggap transaksi baru.

## Pemulihan dua barang

Skrip hanya menerima `LVL41431` dan `LVL41432`. Preview membaca data dalam transaksi read-only dan tidak membuat master. Rekonstruksi memeriksa hubungan PO, harga, kurs, nilai Incoming, urutan kartu stok, dan saldo akhir. Stok gudang lain yang belum direkonsiliasi memblokir pemulihan.

```powershell
$taskPhp = Join-Path $env:TEMP 'waterco-adjustment-php85\php.exe'
$taskExt = 'extension_dir=' + (Join-Path $env:TEMP 'waterco-adjustment-php85\ext')
& $taskPhp -n -d $taskExt -d extension=mysqli scripts/repair_aquamatic_costbook.php --preview
```

Hasil pemeriksaan database konfigurasi development pada 17 November 2026:

| Barang | Saldo kartu pertama | Tanggal | Referensi pertama | Detail DO dengan HPP kosong |
|---|---:|---|---|---:|
| `LVL41431` Autovalve | 5 | 19 September 2024 | `P2401805` | 20 |
| `LVL41432` Fitting Kits | 5 | 19 September 2024 | `P2401805` | 20 |

Pada audit awal, keduanya tanpa master costbook dan memiliki stok aktual 6, booking 2, free 4. Preview rekonstruksi **diblokir** karena nilai persediaan awal belum tersedia. Nilai kartu incoming terakhir bukan pengganti bukti HPP awal.

Pengguna kemudian memilih harga Incoming terakhir sebagai HPP pengganti. Mode ini tidak merekonstruksi rata-rata historis dan tidak membutuhkan bukti HPP awal. Harga dihitung dari nilai barang IDR dibagi qty pada dokumen terakhir, tanpa PPN; urutan memakai tanggal dokumen lalu waktu pembuatannya. Dokumen dengan urutan sama yang ambigu ditolak. Beberapa baris barang pada dokumen yang sama digabung. Validasi PO, kurs, nilai, master tunggal, sumber tidak berubah, dan transaksi tetap berlaku. Preview lama harus dibuat ulang setelah perubahan format sumber.

```powershell
& $taskPhp -n -d $taskExt -d extension=mysqli scripts/repair_aquamatic_costbook.php --preview --basis=latest-incoming
```

Preview 17 November 2026 memilih `IC-001/MP-09/2026`, tanggal dokumen 11 September 2026:

| Barang | Qty penerimaan | Nilai barang IDR | HPP pengganti per unit |
|---|---:|---:|---:|
| `LVL41431` Autovalve | 11 | 31.917.085,20 | 2.901.553,20 |
| `LVL41432` Fitting Kits | 11 | 4.559.583,60 | 414.507,60 |

Gunakan perintah apply berikut dengan file preview mode ini. Basis diambil dari file preview dan diverifikasi ulang. Jangan memakai `cost_book` kartu stok terakhir: nilai tersebut berasal dari perhitungan lama yang kehilangan nilai stok awal.

Pemulihan diterapkan pada 17 November 2026 oleh `aquamatic-repair-cli`: master costbook ID 1695 (`LVL41431`) dan 1696 (`LVL41432`) dibuat dengan nilai tabel di atas. Pembacaan ulang melalui koneksi baru setelah commit memverifikasi nilai tersimpan dan hash sumber stok/histori tidak berubah. Preview, hasil penerapan, dan pembacaan ulang disimpan lokal di `output/aquamatic_latest_incoming_{preview,applied,verified}_2026-11-17.json` (diabaikan git). Histori DO/jurnal tidak diperbaiki oleh pemulihan ini.

Jika finance menyediakan HPP awal terverifikasi, buat JSON dengan key ID barang. Setiap barang memuat `qty` (5), `costbook` (HPP per unit terverifikasi), `as_of` (`2024-09-19`), `source` (nomor dokumen/sumber), dan `verified_by` (ID pemeriksa). Field `verified_by` dan pelaksana CLI memakai 1–50 karakter huruf, angka, `_`, `.`, `@`, atau `-`. Skrip memvalidasi bentuk bukti dan rekonsiliasi berikutnya; kebenaran dokumen saldo awal tetap tanggung jawab pemeriksa.

```powershell
& $taskPhp -n -d $taskExt -d extension=mysqli scripts/repair_aquamatic_costbook.php --preview --opening-file=verified-opening.json
```

Simpan keluaran JSON sebagai UTF-8 tanpa BOM di lokasi privat. Periksa `ready`, nilai usulan, sumber saldo awal, dan daftar detail DO kosong untuk kedua barang. Penerapan memerlukan preview dari database yang sama dan ID pelaksana:

```powershell
& $taskPhp -n -d $taskExt -d extension=mysqli scripts/repair_aquamatic_costbook.php --apply --preview-file=preview.json --actor=USER_ID
```

Penerapan mengunci dan memeriksa ulang sumber sebelum menulis. Satu barang belum siap, data berubah, master berbeda, atau tabel non-InnoDB membatalkan kedua pemulihan. Bukti saldo awal diambil dari preview; `--opening-file` hanya dipakai untuk membuat preview baru. Master yang sudah sesuai tidak ditulis ulang. Simpan keluaran sebelum/sesudah sebagai catatan pemulihan. Stok, booking, hutang, histori DO, dan jurnal tidak diubah oleh skrip.

## Pemeriksaan lokal

Tes membuat database acak `incoming_cost_test_<12 hex>` pada `127.0.0.1:3306`, menyalin struktur dari `waterco_demo`, lalu menghapus hanya database tes tersebut. Konfigurasi dasar aplikasi dipakai untuk kredensial lokal; host remote development tidak dipakai oleh tes. Tes memerlukan hak CREATE/DROP DATABASE dan `proc_open` untuk dua proses bersamaan.

```powershell
$env:INCOMING_COSTBOOK_TEST_DB = '1'
& $taskPhp -n -d $taskExt -d extension=mysqli tests/incoming_costbook_test.php
& $taskPhp -n tests/delivery_order_save_test.php
& $taskPhp -n tests/spk_delivery_validation_test.php
& $taskPhp -n tests/stock_booking_rules_test.php
```

Skenario mencakup HPP normal/kosong/ganda/tidak valid, stok nol/positif, barang berulang, beberapa PO, PPN/kurs, supplier/qty tidak cocok, rollback query/commit, konkurensi, edit master, preview, bukti saldo awal, perubahan sumber, serta pemulihan ulang. Pengujian tidak memakai browser atau menulis transaksi operasional.

Saat penerapan kode, pastikan tabel penulisan memakai InnoDB. Pada database development yang diperiksa, tabel Incoming, PO, stok, kartu stok, dan costbook sudah InnoDB. Rekonstruksi historis tetap memerlukan bukti HPP awal; metode harga terakhir merupakan keputusan pemulihan terpisah dari pengguna.
