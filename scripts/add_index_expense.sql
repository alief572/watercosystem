-- Index untuk modul Expense (Expense, Expense Petty Cash, Expense List, Approval): GetListDataServerside.
-- tr_expense berada di DBERP (waterco_demo di environment ini); users untuk join nama/approval.
-- InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo. Jalankan di DB lain (dev/produksi) di luar jam kerja.
ALTER TABLE tr_expense ADD INDEX idx_nama_pettycash (nama, pettycash), ADD INDEX idx_status (status), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE users ADD INDEX idx_username (username), ALGORITHM=INPLACE, LOCK=NONE;
