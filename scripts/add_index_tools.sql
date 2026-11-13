-- Index untuk menu Tools (Batal Planning / Batal SO) dan Stock_booking::cancelPlanning.
-- Tanpa index ini "SELECT ... WHERE no_planning = ? FOR UPDATE" memindai dan mengunci seluruh tabel.
-- Semua tabel InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo. Jalankan di DB lain di luar jam kerja.
ALTER TABLE tr_planning_delivery ADD INDEX idx_no_planning (no_planning), ADD INDEX idx_no_so (no_so), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE tr_planning_delivery_detail ADD INDEX idx_no_planning (no_planning), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE tr_spk_delivery ADD INDEX idx_no_planning (no_planning), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE wt_plan_tagih ADD INDEX idx_no_planning (no_planning), ALGORITHM=INPLACE, LOCK=NONE;
