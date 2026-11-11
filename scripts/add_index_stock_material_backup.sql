-- Index untuk stock_material/GudangRawMaterialBackdate (filter aktif + id_gudang + range tgl).
-- Sudah dijalankan di waterco_demo (3.9s, 1.78 juta baris). Jalankan di luar jam kerja untuk produksi.
ALTER TABLE stock_material_backup
  ADD INDEX idx_aktif_gudang_tgl (aktif, id_gudang, tgl),
  ALGORITHM=INPLACE, LOCK=NONE;
