-- Index untuk wt_delivery_order/history_pengiriman (get_data_history_delivery_order_detail).
-- Join tr_delivery_order_detail -> tr_delivery_order dan tr_invoice, plus lookup costbook per baris ke
-- ms_costbook_backup (1,6 juta baris), semuanya tanpa index = full scan / block nested loop.
-- Diuji di salinan tabel: query utama 4,3 dtk -> 0,007 dtk, lookup costbook 0,16 dtk -> 0,0004 dtk.
-- Sudah dijalankan di waterco_demo. Jalankan di luar jam kerja untuk produksi (ms_costbook_backup besar).
-- Catatan: idx_no_do di tr_delivery_order dan idx_id_customer di master_customers dibuat script lain
-- (add_index_delivery_order_history.sql); jalankan script itu lebih dulu.
ALTER TABLE tr_delivery_order ADD INDEX idx_no_do (no_do(100)), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE tr_delivery_order_detail ADD INDEX idx_no_do (no_do(100)), ADD INDEX idx_no_so (no_so), ADD INDEX idx_created_on (created_on), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE tr_invoice ADD INDEX idx_no_so (no_so), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE ms_costbook_backup ADD INDEX idx_cat_tgl (id_category3, tgl), ALGORITHM=INPLACE, LOCK=NONE;
