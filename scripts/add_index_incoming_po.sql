-- Index untuk incoming/index_jurnal, purchase_order_payment/jurnal_po dan index pembayaran PO (getIndexData).
-- Semua tabel InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo. Jalankan di DB lain (dev/produksi) di luar jam kerja.
ALTER TABLE tr_incoming ADD INDEX idx_id_data (id_data), ADD INDEX idx_no_po (no_po), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE master_supplier ADD INDEX idx_id_suplier (id_suplier), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE tr_purchase_order ADD INDEX idx_no_po (no_po), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE tr_po_payment ADD INDEX idx_created_on (created_on), ADD INDEX idx_no_po (no_po), ALGORITHM=INPLACE, LOCK=NONE;
