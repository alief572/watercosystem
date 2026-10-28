<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/report_progress_po.css') ?>">
<div id="progress-po" data-url="<?= html_escape(site_url('report_progress_po')) ?>">
    <header class="po-page-header">
        <div><h2>Report Progress PO</h2><p>Pantau nilai pembelian, barang diterima, dan sisa pesanan.</p></div>
        <button class="btn po-export" id="po-export" type="button" disabled><i class="fa fa-file-excel-o" aria-hidden="true"></i> Ekspor Excel <span>2 sheet</span></button>
    </header>
    <section class="po-panel po-filter-panel" aria-labelledby="po-filter-title">
        <div class="po-section-heading"><h3 id="po-filter-title">Filter laporan</h3><span class="po-muted">Berdasarkan tanggal PO</span></div>
        <form id="po-filters">
            <div class="po-filter-grid">
                <div class="po-field po-field-date"><label for="po-start">Tanggal mulai</label><input class="form-control" type="date" id="po-start" name="start_date" min="2000-01-01" max="2099-12-31" value="<?= html_escape($filters['start_date']) ?>" required></div>
                <div class="po-field po-field-date"><label for="po-end">Tanggal akhir</label><input class="form-control" type="date" id="po-end" name="end_date" min="2000-01-01" max="2099-12-31" value="<?= html_escape($filters['end_date']) ?>" required></div>
                <div class="po-field po-field-wide"><label for="po-supplier">Supplier</label><select class="form-control" id="po-supplier" name="supplier_id"><option value="">Semua supplier</option>
                    <?php foreach ($suppliers as $supplier): ?><option value="<?= html_escape($supplier['id_suplier']) ?>"><?= html_escape($supplier['name_suplier'] ?: $supplier['id_suplier']) ?></option><?php endforeach; ?>
                </select></div>
                <div class="po-field po-field-wide"><label for="po-search">Pencarian</label><input class="form-control" id="po-search" name="search" maxlength="200" type="search" placeholder="Nomor PO, supplier, barang, Incoming, atau PIB"></div>
                <div class="po-field po-field-date"><label for="po-type">Jenis pembelian</label><select class="form-control" id="po-type" name="type"><option value="">Semua jenis</option><option>Import</option><option>Lokal</option></select></div>
                <div class="po-field po-field-date"><label for="po-currency">Mata uang</label><select class="form-control" id="po-currency" name="currency"><option value="">USD dan IDR</option><option>USD</option><option>IDR</option></select></div>
                <div class="po-field po-field-status"><label for="po-status">Status penerimaan</label><select class="form-control" id="po-status" name="status"><option value="">Semua status</option>
                    <?php foreach (Progress_po_rules::LABELS as $code => $label): ?><option value="<?= html_escape($code) ?>"><?= html_escape($label) ?></option><?php endforeach; ?>
                </select></div>
                <div class="po-actions"><button class="btn po-apply" type="submit">Tampilkan laporan</button><button class="btn po-reset" type="reset">Reset filter</button></div>
            </div>
            <p id="po-filter-pending" class="po-note" role="status" hidden>Filter telah diubah. Klik Tampilkan laporan untuk menerapkannya.</p>
        </form>
    </section>
    <div id="po-error" class="po-notice po-notice-error" role="alert" hidden></div>
    <div id="po-warning" class="po-notice po-notice-warning" role="status" hidden></div>
    <section class="po-panel po-report" aria-label="Hasil laporan PO" aria-busy="true">
        <div class="po-report-toolbar">
            <ul class="nav nav-tabs po-tabs" role="tablist" aria-label="Tampilan laporan">
                <li class="active" role="presentation"><a href="#po-summary-tab" id="po-summary-label" aria-controls="po-summary-tab" role="tab" data-toggle="tab" aria-selected="true">Ringkasan</a></li>
                <li role="presentation"><a href="#po-data-tab" id="po-data-label" aria-controls="po-data-tab" role="tab" data-toggle="tab" aria-selected="false" tabindex="-1">Data PO <span id="po-count" class="po-tab-count" hidden></span></a></li>
            </ul>
            <span id="po-load-state" class="po-muted" role="status">Memuat laporan PO...</span>
        </div>
        <div class="po-report-context"><p id="po-period">Periode PO terpilih</p><p id="po-generated" class="po-muted" aria-live="polite"></p></div>
        <div class="tab-content">
            <div class="tab-pane active" id="po-summary-tab" role="tabpanel" aria-labelledby="po-summary-label">
                <div id="po-metrics">
                    <dl class="po-value-ledger">
                        <div class="po-value-primary"><dt>Total nilai pembelian</dt><dd data-metric="total_idr">Belum dimuat</dd><dd class="po-value-note">Termasuk estimasi barang yang belum diterima.</dd></div>
                        <div class="po-value-received"><dt>Sudah diterima</dt><dd data-metric="received_idr">Belum dimuat</dd><dd class="po-value-note">Dinilai dengan kurs masing-masing Incoming.</dd></div>
                        <div><dt>Sisa pesanan</dt><dd data-metric="remaining_idr">Belum dimuat</dd><dd class="po-value-note">Estimasi dengan kurs PO.</dd></div>
                    </dl>
                    <dl class="po-secondary-metrics">
                        <div><dt>Jumlah PO</dt><dd data-metric="count_po">Belum dimuat</dd></div>
                        <div><dt>Nilai PO dalam USD</dt><dd data-metric="usd">Belum dimuat</dd></div>
                        <div><dt>Kurs tertimbang USD</dt><dd data-metric="weighted_rate">Belum dimuat</dd><span>Aktual + estimasi; PO IDR dikecualikan</span></div>
                    </dl>
                </div>
                <section class="po-recap" aria-labelledby="po-monthly-title">
                    <div class="po-section-heading"><div><h3 id="po-monthly-title">Pembelian per bulan</h3><p>Bandingkan nilai pesanan dan penerimaan berdasarkan bulan PO.</p></div></div>
                    <div class="po-table-scroll" tabindex="0" role="region" aria-label="Rekap bulanan, dapat digeser horizontal"><table class="table po-recap-table" id="po-monthly"><caption class="sr-only">Rekap bulanan sesuai tanggal PO</caption><thead><tr><th scope="col">Bulan</th><th scope="col">Jumlah PO</th><th scope="col">Nilai USD</th><th scope="col">Total IDR</th><th scope="col">Diterima IDR</th><th scope="col">Sisa estimasi IDR</th><th scope="col" hidden>Periksa data</th></tr></thead><tbody></tbody></table></div>
                </section>
                <section class="po-recap" aria-labelledby="po-suppliers-title">
                    <div class="po-section-heading"><div><h3 id="po-suppliers-title">Pembelian per supplier</h3><p>Kontribusi terhadap total nilai pembelian yang dapat dihitung.</p></div></div>
                    <div class="po-table-scroll" tabindex="0" role="region" aria-label="Rekap supplier, dapat digeser horizontal"><table class="table po-recap-table" id="po-suppliers"><caption class="sr-only">Rekap supplier</caption><thead><tr><th scope="col">Supplier</th><th scope="col">Jumlah PO</th><th scope="col">Nilai USD</th><th scope="col">Total IDR</th><th scope="col">Diterima IDR</th><th scope="col">Sisa estimasi IDR</th><th scope="col">Kontribusi</th><th scope="col" hidden>Periksa data</th></tr></thead><tbody></tbody></table></div>
                </section>
            </div>
            <div class="tab-pane" id="po-data-tab" role="tabpanel" aria-labelledby="po-data-label">
                <div class="po-section-heading"><div><h3>Progress setiap PO</h3><p>Buka rincian untuk melihat barang, kurs, dan riwayat penerimaan.</p></div><span class="po-muted">Nilai diterima dan sisa dalam IDR</span></div>
                <div class="po-list-table"><table class="table" id="po-table"><caption class="sr-only">Progress setiap purchase order; kolom PO diurutkan berdasarkan tanggal</caption><thead><tr><th scope="col">PO / tanggal</th><th scope="col">Supplier</th><th scope="col">Penerimaan</th><th scope="col">Nilai PO</th><th scope="col">Total IDR</th><th scope="col">Diterima IDR</th><th scope="col">Sisa estimasi IDR</th><th scope="col">Incoming</th><th scope="col"><span class="sr-only">Rincian</span></th></tr></thead><tbody></tbody></table></div>
            </div>
        </div>
        <details class="po-method"><summary>Cara membaca laporan ini</summary><div>
            <p>Nilai barang setelah diskon, sebelum PPN dan ongkir. Laporan mencakup PO Approved/Closed dalam USD dan IDR.</p>
            <p>Periode mengikuti tanggal PO. Penerimaan mencakup kondisi terbaru, termasuk Incoming setelah tanggal akhir periode. Sisa pesanan memakai estimasi kurs PO.</p>
            <p>Progress berbobot nilai barang. Nilai yang belum dapat dihitung ditampilkan dengan tanda "-" dan ditandai untuk diperiksa. Ekspor memuat seluruh hasil filter dalam dua sheet.</p>
        </div></details>
    </section>
    <div class="modal fade" id="po-detail" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="po-detail-title">
        <div class="modal-dialog modal-lg" role="document"><div class="modal-content">
            <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Tutup rincian">&times;</button><p class="po-detail-caption">Rincian purchase order</p><h3 class="modal-title" id="po-detail-title">Rincian PO</h3></div>
            <div class="modal-body" id="po-detail-body" aria-live="polite"></div>
            <div class="modal-footer"><button class="btn po-reset" type="button" data-dismiss="modal">Tutup rincian</button></div>
        </div></div>
    </div>
</div>
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/report_progress_po.js') ?>"></script>
