-- Index untuk wt_invoicing/plan_tagih (get_data_plan_tagih): join tr_sales_order via no_so dan filter/sort wt_plan_tagih.
-- Keduanya InnoDB: online (INPLACE, tanpa lock). Sudah dijalankan di waterco_demo. Jalankan di DB lain (dev/produksi) di luar jam kerja.
ALTER TABLE tr_sales_order ADD INDEX idx_no_so (no_so), ALGORITHM=INPLACE, LOCK=NONE;
ALTER TABLE wt_plan_tagih ADD INDEX idx_status_tgl (status_invoice, tgl_create_inv), ALGORITHM=INPLACE, LOCK=NONE;
