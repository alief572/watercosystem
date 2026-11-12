-- Index untuk penerimaan/index_np (get_data_pn_np_serverside) dan modal List Invoice NP (get_data_invoice_np_modal).
-- InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo. Jalankan di DB lain (dev/produksi) di luar jam kerja.
ALTER TABLE tr_invoice_np_payment ADD INDEX idx_tgl_pembayaran (tgl_pembayaran), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE tr_invoice_np_header ADD INDEX idx_customer_sisa (id_customer, sisa_invoice_idr), ALGORITHM=INPLACE, LOCK=NONE;
