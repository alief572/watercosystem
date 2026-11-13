-- Index untuk budget_periodik (daftar departemen dan proses_budget_periodik / updatebudget).
-- ms_budget_rutin dan ms_budget = InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo.
-- Jalankan di DB lain (dev/produksi) di luar jam kerja.
ALTER TABLE ms_budget_rutin ADD INDEX idx_departement (departement), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE ms_budget ADD INDEX idx_tahun_kategori_coa (tahun, kategori, coa), ALGORITHM=INPLACE, LOCK=NONE;
