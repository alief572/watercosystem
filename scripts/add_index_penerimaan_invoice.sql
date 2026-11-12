-- Index untuk penerimaan/get_data_invoice_modal (modal List Invoice): filter per customer dan sisa invoice.
-- tr_invoice = InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo. Jalankan di DB lain (dev/produksi) di luar jam kerja.
ALTER TABLE tr_invoice ADD INDEX idx_customer_sisa (id_customer, sisa_invoice_idr), ALGORITHM=INPLACE, LOCK=NONE;
