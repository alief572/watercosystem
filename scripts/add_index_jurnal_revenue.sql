-- Index untuk wt_revenue/jurnal_revenue (get_data_revenue_jurnal): filter status_jurnal='OPN' dan
-- NOT EXISTS (no_surat sama dengan status_jurnal='CLS').
-- tr_revenue = InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo. Jalankan di DB lain (dev/produksi) di luar jam kerja.
ALTER TABLE tr_revenue ADD INDEX idx_status_surat (status_jurnal, no_surat), ALGORITHM=INPLACE, LOCK=NONE;
