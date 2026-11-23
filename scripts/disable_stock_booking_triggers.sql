-- Matikan sementara 6 trigger guard stock booking (karantina, maintenance, validasi saldo).
-- Jalankan di DB aplikasi SETELAH backup. Tidak ada data stok yang diubah.
--
-- LANGKAH 1 (wajib, simpan hasilnya untuk restore): ekspor definisi trigger.
--   SELECT TRIGGER_NAME, ACTION_TIMING, EVENT_MANIPULATION, EVENT_OBJECT_TABLE, ACTION_STATEMENT
--   FROM information_schema.TRIGGERS
--   WHERE TRIGGER_SCHEMA = DATABASE() AND TRIGGER_NAME LIKE 'booking_guard_v2_%';
--   (atau jalankan SHOW CREATE TRIGGER <nama>; untuk tiap trigger di bawah dan simpan teksnya)
--
-- LANGKAH 2: jalankan DROP di bawah.

DROP TRIGGER IF EXISTS booking_guard_v2_stock_material_insert;
DROP TRIGGER IF EXISTS booking_guard_v2_stock_material_update;
DROP TRIGGER IF EXISTS booking_guard_v2_stock_material_delete;
DROP TRIGGER IF EXISTS booking_guard_v2_stock_material_multigudang_insert;
DROP TRIGGER IF EXISTS booking_guard_v2_stock_material_multigudang_update;
DROP TRIGGER IF EXISTS booking_guard_v2_stock_material_multigudang_delete;

-- LANGKAH 3: cek, harus 0 baris.
-- SELECT TRIGGER_NAME FROM information_schema.TRIGGERS
-- WHERE TRIGGER_SCHEMA = DATABASE() AND TRIGGER_NAME LIKE 'booking_guard_v2_%';
--
-- RESTORE: jalankan ulang CREATE TRIGGER dari hasil langkah 1, atau dari
-- Stock_booking_schema::guards() (application/libraries/Stock_booking_schema.php).
-- Set Stock_booking_store::ENFORCE=true bersamaan dengan restore.
