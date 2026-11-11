-- Index untuk stock_material/view_kartu_stok (join kartu_stok <-> ms_inventory_category3 tanpa index = block nested loop).
-- Sudah dijalankan di waterco_demo. Jalankan di luar jam kerja untuk produksi.
ALTER TABLE ms_inventory_category3 ADD INDEX idx_id_category3 (id_category3), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE kartu_stok ADD INDEX idx_id_category3 (id_category3), ALGORITHM=INPLACE, LOCK=NONE;
