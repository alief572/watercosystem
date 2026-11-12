-- Index untuk wt_delivery_order/delivery_order_jurnal (get_data_do_jurnal) dan jurnal_nomor/jurnal_fn
-- (jurnal_delivery / jurnal_confirmdelivery hapus + isi ulang baris sementara di tabel jurnal per no_reff).
-- Jalankan SETELAH add_index_delivery_order_history.sql (yang membuat index no_spk/id_customer/tgl_do).
-- Sudah dijalankan di waterco_demo. Jalankan di luar jam kerja untuk produksi.
-- tr_delivery_order = InnoDB: online (INPLACE, tanpa lock). jurnal = MyISAM: tidak mendukung INPLACE/LOCK=NONE,
-- tabel terkunci sebentar saat index dibangun (~38 ribu baris, hitungan detik).
ALTER TABLE tr_delivery_order ADD INDEX idx_created_on (created_on), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE jurnal ADD INDEX idx_no_reff_jenis (no_reff, jenis_jurnal(50));
