-- Index untuk penerimaan/jurnal_bum (get_data_pn_jurnal_serverside): filter status_jurnal='0', urut tgl_pembayaran.
-- tr_invoice_payment = InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo. Jalankan di DB lain (dev/produksi) di luar jam kerja.
ALTER TABLE tr_invoice_payment ADD INDEX idx_status_jurnal (status_jurnal, tgl_pembayaran), ALGORITHM=INPLACE, LOCK=NONE;
-- Subquery invoiced/totalinvoiced mencari detail per kd_pembayaran; index lama dimulai dari no_invoice sehingga scan penuh.
ALTER TABLE tr_invoice_payment_detail ADD INDEX idx_kd_pembayaran (kd_pembayaran), ALGORITHM=INPLACE, LOCK=NONE;
