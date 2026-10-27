# Report Progress PO

Modul `report_progress_po` menyediakan laporan baca saja dari PO dan Incoming yang sudah ada. Referensi konsep: `Laporan_Pembelian_PO.xlsx`, sheet Ringkasan dan Data PO. Tidak ada impor Excel atau perubahan transaksi, stok, jurnal, pembayaran, maupun saldo hutang.

## Cakupan dan filter

- PO Approved (`status=2`) dan Closed (`status=3`), mata uang USD/IDR. PO Waiting serta mata uang lain tidak masuk.
- Default tanggal PO: 1 Januari tahun berjalan sampai hari ini, zona Asia/Jakarta. Tanggal valid tahun 2000–2099.
- Filter supplier, jenis Import/Lokal, mata uang, status dan pencarian berlaku sama untuk tabel, ringkasan dan ekspor. Pencarian mencakup nomor PO, supplier, keterangan, nama barang, nomor Incoming dan PIB.
- Penerimaan dihitung sampai kondisi terbaru, termasuk Incoming setelah akhir periode PO. Laporan bukan snapshot posisi akhir periode.
- Supplier nonaktif tetap disertakan untuk transaksi historis.
- Status `Periksa Data` pada filter mencakup semua PO dengan masalah nilai/kuantitas/relasi, termasuk PO yang status fisiknya tetap parsial/lengkap.

## Sumber dan perhitungan

Header `tr_purchase_order` → item `dt_trans_po` melalui `no_po`. Penerimaan berasal dari `dt_incoming.id_dt_po` → `dt_trans_po.id_dt_po`; metadata tanggal/kurs/mata uang/PIB berasal dari `tr_incoming` melalui `id_data`. Header Incoming bukan sumber pengelompokan PO karena satu dokumen dapat mencakup beberapa PO. Header yang hilang atau duplikat ditandai bermasalah.

Nilai bersih per item = `jumlahharga × (1 − diskon / 100)`. Diskon kosong berarti tanpa diskon, sesuai data lama. `jumlahharga` sudah merupakan nilai baris PO dalam mata uang asal; tidak dihitung ulang dari berat. Kuantitas memakai `dt_trans_po.qty` dan `dt_incoming.qty_recive`, sesuai alur PO/Incoming saat ini.

Harga PO menjadi dasar valuasi: nilai bersih dialokasikan proporsional terhadap kuantitas diterima. Harga aktual Incoming tidak dipakai, sehingga perbedaan harga tidak mengubah progress PO. PPN, ongkir dan biaya tambahan dikecualikan.

- USD diterima: jumlah alokasi nilai USD × kurs masing-masing header Incoming.
- USD belum diterima: sisa nilai USD × `nominal_kurs` PO, diberi label estimasi.
- IDR: nilai langsung, kurs 1.
- Total laporan IDR = diterima IDR + sisa estimasi IDR. Kurs efektif USD = total laporan IDR / nilai bersih USD.
- Kurs tertimbang hanya memakai PO USD yang mempunyai total IDR valid dan nilai USD positif; PO IDR tidak ikut pembilang atau penyebut.
- Progress berbobot nilai bersih item, maksimum 100%. Status lengkap tetap mensyaratkan semua item berkuantitas positif terpenuhi. PO bernilai nol yang parsial tidak mempunyai persentase nilai; ditampilkan kosong.
- Kelebihan penerimaan tetap terlihat di rincian, tetapi alokasi dibatasi kuantitas PO. Urutan alokasi berdasarkan tanggal Incoming kemudian ID detail. Penutupan PO/item ditandai terpisah dan tidak membuat penerimaan parsial menjadi lengkap.

Jika kurs/nilai/relasi tidak valid, angka terkait bernilai `null` dan tampil kosong atau tanda pisah, bukan nol. Ringkasan menjumlahkan angka yang diketahui pada setiap kolom; total dapat belum lengkap dan belum saling cocok. Banner peringatan PO bermasalah dan kolom Periksa data pada rekap bulanan/supplier disembunyikan sesuai kebutuhan tampilan. Deteksi masalah, filter, rincian dan ekspor tetap mempertahankan informasi tersebut. Kontribusi supplier menggunakan total IDR yang diketahui. Masalah ini tidak diperbaiki otomatis.

## Antarmuka internal

Semua endpoint memerlukan `Report_Progress_Po.View`:

| Endpoint GET | Hasil |
| --- | --- |
| `index` | Halaman laporan dengan tab Ringkasan dan Data PO |
| `data_po` | JSON `data`, `recordsTotal`, `recordsFiltered`, `draw`, total, rekap dan waktu data |
| `summary` | Total dan rekap tanpa dataset item |
| `detail?id=...` | Satu PO sesuai filter dengan item dan riwayat Incoming |
| `export_excel` | XLSX Ringkasan dan Data PO, seluruh hasil filter |

Filter bersama: `start_date`, `end_date`, `supplier_id`, `type`, `currency`, `status`, `search`. Pagination: `start`, `length` (maksimal 100), `draw`; pengurutan `sort` dan `direction` menggunakan allowlist. Input tidak valid menghasilkan HTTP 422, PO tidak ditemukan 404, kegagalan internal 500 dengan pesan umum.

Daftar memakai pagination di server. Dataset periode terpilih dihitung di PHP agar filter status berbasis penerimaan dan ringkasan memakai aturan yang sama; pengambilan detail dibagi batch 400 PO, bukan query per PO. Belum ada cache/materialisasi. Untuk volume jauh lebih besar, ukur waktu/memori sebelum memperluas pendekatan ini.

Ekspor menyimpan tanggal/angka dengan tipe Excel yang sesuai, memaksa teks sebagai string untuk mencegah formula injection, dan menyelesaikan serialisasi sebelum mengirim header unduhan. Tidak ada batas 500 baris.

## Registrasi dan rollback

Branch dev dan main tetap menggunakan PHP 5.6. Modul memakai PHPExcel bawaan repository, tanpa PhpSpreadsheet atau autoloader Composer. Ekstensi mysqli/mysqlnd, mbstring, XML dan ZIP mengikuti kebutuhan aplikasi/PHPExcel yang sudah ada; harness tes dapat memakai PCLZip bawaan PHPExcel jika ZipArchive tidak tersedia. Tidak perlu upgrade PHP atau Composer untuk modul ini. Contoh perintah dari root proyek, dengan konfigurasi environment yang dituju:

```text
php scripts/deploy_report_progress_po.php --environment=development
php scripts/deploy_report_progress_po.php --environment=development --apply
```

Tanpa `--apply`, skrip hanya memeriksa struktur, metadata dan ketersediaan indeks. Dengan `--apply`, skrip mendaftarkan permission dan menu di bawah Reports; dapat dijalankan ulang tanpa menggandakan metadata. Tidak memberikan akses ke role secara otomatis. Administrator memilih role melalui pengaturan hak akses yang sudah ada.

Indeks diperiksa pada tanggal PO, nomor PO detail, ID item PO, relasi Incoming dan ID header Incoming. Skrip tidak menambahkan indeks otomatis; ukur `EXPLAIN` dan ukuran tabel target sebelum perubahan schema. Pada database lokal awal, kolom tersebut belum memiliki indeks pendukung.

Rollback: nonaktifkan menu `report_progress_po` melalui pengaturan menu, lalu lepaskan file modul/aset jika diperlukan. Tidak ada migrasi atau perubahan transaksi untuk dibalik.

## Pengujian tanpa browser

```text
php tests/report_progress_po_rules_test.php
php tests/report_progress_po_controller_test.php
php tests/report_progress_po_workbook_test.php
php tests/report_progress_po_integration_test.php
php tests/report_progress_so_delivery_test.php
node --check assets/js/report_progress_po.js
node tests/report_progress_po_ui_test.js
```

Tes aturan dan controller menggunakan fixture. Tes integrasi membaca database yang dikonfigurasi tanpa menulis transaksi; juga membuat file XLSX sementara, membukanya kembali, lalu menghapusnya. Jangan menjalankan suite lain tanpa memeriksa apakah suite tersebut memutasi database.

## Batas validasi awal

Perbaikan kompatibilitas diverifikasi pada PHP 5.6.40 dengan snapshot file committed dan PHPExcel bawaan repository, tanpa perubahan lokal upgrade PHP/Composer. Tes aturan, controller, dan ekspor XLSX menggunakan fixture; tes integrasi database membutuhkan environment mysqli yang sesuai. Validasi integrasi awal menggunakan PHP 8.3 dan database Docker lokal `waterco_demo`. Tidak ada pengujian browser. Data lokal awal memuat 311 PO Approved/Closed dan 1.536 detail Incoming terkait; 11 PO ditandai perlu diperiksa. Database dev/produksi terpisah belum didaftarkan atau divalidasi oleh pekerjaan ini. Beberapa harness/framework lama masih mengeluarkan deprecation dynamic property pada PHP 8.3.

## Arah UI dan pemeriksaan antislop

Mode antislop `during` dipilih pengguna. Layar dibaca sebagai laporan operasional pembelian untuk tim purchasing/finance, mengikuti bahasa visual Waterco yang sudah ada. Dials: ENERGY 2 / RHYTHM 2 / MOTION 1.

- Warna utama `#1f536d` mengikuti Report Progress SO; latar terang mengikuti admin aplikasi dan mendukung pembacaan tabel panjang. Hijau, amber, merah hanya menandai penerimaan atau masalah data.
- Font diwarisi dari aplikasi agar modul menyatu dengan shell. Angka memakai tabular numerals dan rata kanan supaya besaran nilai mudah dibandingkan.
- Total pembelian menjadi titik fokus, diikuti nilai diterima/sisa. Jumlah PO, USD dan kurs menjadi informasi pendukung; tidak lagi enam kotak dengan bobot yang sama.
- Tabel diringkas dari 16 menjadi 9 kolom. Identitas dan tanggal, supplier dan jenis/mata uang, serta status dan progress digabungkan. Keterangan, kurs dan seluruh detail tetap tersedia pada dialog; ekspor tetap lengkap.
- Kolom identitas PO melekat saat tabel digeser. Scroll dibatasi pada tabel, termasuk riwayat Incoming; pagination tetap berada di luar area scroll.
- Radius 3/4/6 px membedakan status, kontrol dan panel. Tidak ada gambar, font eksternal, gradient, glow, atau bayangan tambahan. Ikon Excel memakai pustaka aplikasi untuk mengenali unduhan.
- Layout satu kolom pada layar sempit, dua kolom mulai 640 px, dan grid filter penuh mulai 1100 px. Angka panjang dapat membungkus. Form mobile memakai font 16 px dan tombol minimal 44 px.
- Filter yang diubah harus diterapkan sebelum ekspor; UI memberi pesan perubahan dan menonaktifkan ekspor. Loading, hasil kosong dan kegagalan memakai pesan spesifik; kegagalan dapat dicoba ulang. Banner dan tombol menuju PO bermasalah disembunyikan, sementara filter status Periksa Data tetap tersedia.
- Tab mendukung tombol panah/Home/End. Fokus kembali ke tombol rincian setelah modal ditutup. Tidak ada animasi berulang; prefers-reduced-motion menonaktifkan transisi modal.

Delivery Gate, bukti pemeriksaan kode dan CLI:

| Kelompok | Hasil dan bukti |
| --- | --- |
| Hard Gate | PASS pada kode: data berasal dari endpoint, teks dinamis di-escape, kontrol memiliki handler, tidak ada aset/fakta rekaan atau tautan kosong. Struktur view diperiksa melalui render PHP. |
| Purpose Gate | PASS: alasan palette, font, hierarki, spacing, status dan pengurangan kolom tercatat di atas; setiap bar progress berasal dari nilai backend dan dibatasi 0–100. |
| Liveliness | PASS pada implementasi: dials 2/2/1, total pembelian menjadi fokus, komposisi ringkasan berbeda dari rekap, aksen mengikuti identitas Waterco. |
| Quality Locks | PASS pada pemeriksaan CLI: render controller/ekspor dan tes renderer JS lulus; pemetaan sort/filter tetap sesuai endpoint. Pemeriksaan kontras pasangan teks/status lulus AA; batas input `#7e909c` terhadap putih 3,30:1 memenuhi ambang kontrol 3:1. |

Pemeriksaan ini tidak mengklaim validasi visual atau interaksi browser. Rendering lintas ukuran, perilaku keyboard nyata dan integrasi modal/DataTables di browser belum diuji, sesuai arahan pengguna bahwa pengujian web tidak diperlukan.
