-- Index untuk Penerimaan Debit Note (penerimaandn/index: urut tgl_pembayaran, subquery detail per kd_pembayaran).
-- InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo. Jalankan di DB lain di luar jam kerja.
ALTER TABLE tr_debit_note_payment ADD INDEX idx_tgl_pembayaran (tgl_pembayaran), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE tr_debit_note_payment_detail ADD INDEX idx_kd_pembayaran (kd_pembayaran), ALGORITHM=INPLACE, LOCK=NONE;
