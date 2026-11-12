-- Index untuk wt_invoicing/jurnal_invoicing (get_data_jurnal_invoicing): filter status_jurnal='OPN', urut no_invoice.
-- tr_invoice = InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo. Jalankan di DB lain (dev/produksi) di luar jam kerja.
ALTER TABLE tr_invoice ADD INDEX idx_status_jurnal (status_jurnal, no_invoice), ALGORITHM=INPLACE, LOCK=NONE;
