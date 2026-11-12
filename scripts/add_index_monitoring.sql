-- Index untuk wt_invoicing/index_monitoring (get_data_monitoring): filter status_close, deleted_by, urut no_invoice.
-- tr_invoice = InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo. Jalankan di DB lain (dev/produksi) di luar jam kerja.
ALTER TABLE tr_invoice ADD INDEX idx_close_deleted (status_close, deleted_by, no_invoice), ALGORITHM=INPLACE, LOCK=NONE;
