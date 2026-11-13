-- Index untuk Nilai Inventory (stock_material/GudangRawMaterialHarga): filter tgl berupa range.
-- stock_material_backup = InnoDB (~1,8 juta baris): online (INPLACE, tanpa lock), ~7 detik. Model memakai STRAIGHT_JOIN agar index ini terpakai (query turun ~60 detik -> ~0,7 detik).
ALTER TABLE stock_material_backup ADD INDEX idx_tgl_aktif (tgl, aktif), ALGORITHM=INPLACE, LOCK=NONE;
