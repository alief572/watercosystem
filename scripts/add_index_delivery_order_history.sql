-- Index untuk wt_delivery_order/delivery_order_history (get_data_history_delivery_order).
-- Join tr_delivery_order -> master_customers dan tr_spk_delivery tanpa index = block nested loop (~1,2 dtk; search ~2 dtk).
-- Diuji di salinan tabel: join 1,23 dtk -> 0,002 dtk, search 1,99 dtk -> 0,015 dtk.
-- Sudah dijalankan di waterco_demo. Jalankan di luar jam kerja untuk produksi.
-- no_spk varchar(255): prefix 100 karakter cukup (nomor SPK jauh lebih pendek) dan menjaga ukuran index.
ALTER TABLE tr_delivery_order ADD INDEX idx_tgl_do (tgl_do), ADD INDEX idx_no_spk (no_spk(100)), ADD INDEX idx_id_customer (id_customer), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE tr_spk_delivery ADD INDEX idx_no_spk (no_spk(100)), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE master_customers ADD INDEX idx_id_customer (id_customer), ALGORITHM=INPLACE, LOCK=NONE;
