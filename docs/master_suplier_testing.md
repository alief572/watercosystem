# Pengujian Master Supplier

Modul aplikasi bernama `master_suplier`; tabel utamanya `master_supplier`.

## Menjalankan tes

```powershell
docker exec waterco_web85 php tests/master_suplier_test.php
```

Argumen opsional menyaring nama kasus, misalnya:

```powershell
docker exec waterco_web85 php tests/master_suplier_test.php "rollback"
```

Tes memerlukan PHP CLI dengan mysqli, mbstring, dan DOM, serta MySQL lokal pada
`DB_HOST=db`, database sumber `waterco_demo`. Kredensial dibaca dari konfigurasi
development; tidak disimpan di skrip tes.

Tes membuat `waterco_demo_test_master_suplier`, menyalin struktur sepuluh tabel,
dan memakai data buatan. Database tes dihapus di blok `finally`. Jika database
tersebut sudah ada, tes menolak melanjutkan agar tidak menimpa database lain.
Sesi database sumber diatur `TRANSACTION READ ONLY` untuk pemeriksaan data yang
sudah ada. Tidak ada migrasi atau perubahan data pada `waterco_demo`.

## Hasil verifikasi, 11 November 2026

- PHP 8.5: **94 kasus lulus, 0 gagal**.
- Pemeriksaan sintaks controller, model, seluruh view, dan skrip tes: **17 file lulus**.
- `git diff --check` untuk perubahan modul lulus.
- Guard generator ID dilepas sementara: kasus tabel kosong gagal sesuai harapan.
  Guard dipulihkan sebelum menjalankan keseluruhan tes akhir.

Cakupan: daftar dan modal lokal/internasional/kategori; tambah, lihat, edit,
soft delete; PIC kosong/satu/banyak dan penggantian PIC; generator ID; lookup kota;
filter lokasi, deleted, dan relasi kosong; input tidak valid; escaping HTML;
izin endpoint dan tombol; rollback kegagalan PIC serta penolakan penulisan jika
transaksi gagal dimulai. Fungsi inventory lama dan helper model mendapat smoke test
dengan data buatan.

## Perbaikan

- Menghapus pembacaan variabel JavaScript `data_pay` yang tidak dipakai dan
  mengakses `$results['supplier']` yang tidak dikirim controller.
- Menyatukan empat alur simpan supplier agar validasi dan transaksi supplier/PIC
  konsisten. PIC tanpa baris diterima; PIC yang dikirim diperiksa bentuk dan isinya.
- Memakai izin Add untuk tambah, Manage untuk edit, Delete untuk hapus, dan View
  untuk baca. Kolom aksi tetap sejajar pada akun dengan izin lihat saja.
- Mengembalikan 404 untuk record detail yang tidak ditemukan; request simpan/hapus
  tidak valid mengembalikan `status=0` dan `pesan`, tanpa warning PHP.
- Memakai `id_kota` untuk pilihan kota, dengan respons option yang sesuai dengan
  callback frontend yang mengisi select yang sudah ada.
- Mempertahankan audit pembuatan saat edit, lalu mengisi audit perubahan.
- Mengamankan nilai HTML yang memuat kutip/markup, generator ID saat tabel kosong,
  serta query dimensi. LEFT JOIN mempertahankan supplier yang relasinya kosong.

URL, nama field, format ID, serta key JSON `status` dan `pesan` dipertahankan.

## Batas dan TODO

- Browser, interaksi JavaScript, login, dan session middleware tidak diuji.
  Izin controller diperiksa memakai fixture Auth; SQL memakai driver CI/MySQL asli.
- Generator ID masih memakai pola `MAX` lama. Penyimpanan bersamaan belum diuji;
  pencegahan tabrakan ID memerlukan pekerjaan terpisah pada alokasi ID dan constraint.
- Endpoint inventory lama hanya mendapat smoke test; bukan perubahan desain atau
  audit menyeluruh terhadap kontrak input inventory.
- Tes hanya dijalankan di PHP 8.5. Jalankan kembali sebelum memakai runtime lain.
