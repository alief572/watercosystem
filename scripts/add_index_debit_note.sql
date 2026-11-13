-- Index untuk modul Debit Note (debit_note/index, index_approval, edit per no_pr) dan modal Add Invoice Penerimaan DN.
-- tr_debit_note dan dt_debit_note = InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo.
-- Jalankan di DB lain (dev/produksi) di luar jam kerja.
ALTER TABLE tr_debit_note ADD INDEX idx_status_created (status, created_on), ADD INDEX idx_no_pr (no_pr), ADD INDEX idx_customer_sisa (id_customer, sisa_tagihan), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE dt_debit_note ADD INDEX idx_no_pr (no_pr), ALGORITHM=INPLACE, LOCK=NONE;
