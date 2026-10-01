<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?= html_escape(base_url('assets/plugins/datatables/dataTables.bootstrap.css')) ?>">
<link rel="stylesheet" href="<?= html_escape(base_url('assets/plugins/select2/select2.min.css')) ?>">
<link rel="stylesheet" href="<?= html_escape(base_url('assets/css/report_piutang_invoice.css')) ?>">
<div class="piutang-report" id="piutang-report" data-url="<?= html_escape(site_url('report_piutang_invoice')) ?>" data-invoice="<?= html_escape($filters['no_invoice']) ?>" data-default-date="<?= html_escape($default_date) ?>">
    <header class="piutang-heading piutang-reveal">
        <div><span class="piutang-eyebrow">REPORTS / PIUTANG CUSTOMER</span><h1>Piutang per invoice<span>.</span></h1><p>Posisi outstanding dan riwayat penerimaan, dalam satu laporan.</p></div>
        <a class="piutang-button piutang-button-export" id="piutang-export" href="<?= html_escape(site_url('report_piutang_invoice/export_excel') . '?' . http_build_query($filters)) ?>" aria-disabled="true">Export Excel<span class="piutang-button-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v12m-4-4 4 4 4-4M5 16v5h14v-5"/></svg></span></a>
    </header>
    <div class="piutang-summary piutang-reveal">
        <div class="piutang-summary-total"><span class="piutang-label">TOTAL PIUTANG</span><div class="piutang-total"><span>Rp</span><strong id="piutang-total">—</strong></div><p>Seluruh invoice yang sesuai filter</p></div>
        <div class="piutang-summary-aside"><div><span class="piutang-label">INVOICE OUTSTANDING</span><strong id="piutang-count">—</strong></div><div><span class="piutang-label">POSISI PER TANGGAL</span><strong id="piutang-date">—</strong></div></div>
    </div>
    <div class="piutang-shell piutang-reveal">
        <form class="piutang-filter-core" id="piutang-filters" autocomplete="off">
            <div class="piutang-filter-heading"><span class="piutang-label">FILTER LAPORAN</span><span id="piutang-filter-state" aria-live="polite">Pilih posisi piutang yang ingin dilihat</span></div>
            <div class="piutang-filter-grid">
                <div class="piutang-field"><label for="piutang-tanggal">Per tanggal</label><div class="piutang-input-shell"><input type="date" name="tanggal" id="piutang-tanggal" value="<?= html_escape($filters['tanggal']) ?>" required></div></div>
                <div class="piutang-field"><label for="piutang-customer">Customer</label><div class="piutang-input-shell"><select name="customer_id" id="piutang-customer"><option value="">Semua customer</option>
                    <?php foreach ($customers as $customer): ?>
                    <?php if (trim((string) $customer['name_customer']) === '') { continue; } ?>
                    <option value="<?= html_escape($customer['id_customer']) ?>" <?= $filters['customer_id'] === (string) $customer['id_customer'] ? 'selected' : '' ?>><?= html_escape($customer['name_customer']) ?></option>
                    <?php endforeach; ?>
                </select></div></div>
                <div class="piutang-field"><label for="piutang-nomor">Nomor invoice</label><div class="piutang-input-shell"><select name="no_invoice" id="piutang-nomor" disabled><option value="">Memuat invoice…</option></select></div></div>
                <div class="piutang-filter-actions"><button type="submit" class="piutang-button piutang-button-primary" id="piutang-apply">Tampilkan<span class="piutang-button-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14m-5-5 5 5-5 5"/></svg></span></button><button type="button" class="piutang-reset" id="piutang-reset">Reset filter</button></div>
            </div>
        </form>
    </div>
    <div class="piutang-error" id="piutang-error" role="alert" hidden></div>
    <section class="piutang-shell piutang-table-shell piutang-reveal"><div class="piutang-table-core">
        <div class="piutang-section-heading"><div><h2>Daftar piutang</h2><p>Setiap invoice menampilkan penerimaannya secara berurutan.</p></div><span class="piutang-status"><span></span>Outstanding</span></div>
        <table id="piutang-table" class="table piutang-invoice-table" width="100%"><thead><tr><th>Customer</th><th>Tgl Invoice</th><th>No Invoice</th><th>Nilai Invoice</th><th>Kode Penerimaan</th><th>Tgl Bayar</th><th>Nilai Bayar</th><th>Total Bayar</th><th>Sisa Piutang</th></tr></thead><tbody></tbody><tfoot><tr><td colspan="8">Total piutang <span>seluruh hasil filter</span></td><td id="piutang-footer-total">—</td></tr></tfoot></table>
    </div></section>
    <details class="piutang-verification piutang-reveal" id="piutang-verification"><summary><span class="piutang-verification-heading">Perlu verifikasi <span id="piutang-issue-count">0</span></span><span class="piutang-verification-note" id="piutang-verification-note">Memeriksa kelengkapan data…</span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></summary><div class="piutang-verification-body"><p>Data berikut tidak termasuk total piutang dan perlu diperiksa sebelum dihitung.</p><div class="piutang-verification-scroll"><table class="table"><thead><tr><th>Customer</th><th>No Invoice</th><th>Kode Internal</th><th>Kode Penerimaan</th><th>Alasan</th></tr></thead><tbody id="piutang-verification-rows"></tbody></table></div></div></details>
    <p class="piutang-footnote">Posisi dihitung dari transaksi yang tersedia sekarang. Perubahan transaksi dapat mengubah hasil tanggal lampau.</p>
</div>
<script src="<?= html_escape(base_url('assets/plugins/datatables/jquery.dataTables.min.js')) ?>"></script>
<script src="<?= html_escape(base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')) ?>"></script>
<script src="<?= html_escape(base_url('assets/plugins/select2/select2.full.min.js')) ?>"></script>
<script src="<?= html_escape(base_url('assets/js/report_piutang_invoice.js')) ?>"></script>
