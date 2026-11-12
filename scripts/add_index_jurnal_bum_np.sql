-- Index untuk penerimaan/jurnal_bum_np (get_data_pn_jurnal_np_serverside) dan save_jurnal_bum_np:
-- NOT EXISTS pada gl_waterco.jarh mencari per kd_pembayaran. jarh = tabel DB akuntansi (gl_waterco), 4231 baris di demo.
-- jarh = MyISAM: tidak mendukung INPLACE/LOCK=NONE, tabel terkunci (baca/tulis) selama index dibangun, hitungan detik untuk ~4 ribu baris.
-- Sudah dijalankan di waterco_demo. Jalankan di DB akuntansi dev/produksi di luar jam kerja.
ALTER TABLE gl_waterco.jarh ADD INDEX idx_kd_pembayaran (kd_pembayaran);
