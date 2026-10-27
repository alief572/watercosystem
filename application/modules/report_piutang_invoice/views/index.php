<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?= html_escape(base_url('assets/plugins/datatables/dataTables.bootstrap.css')) ?>">
<link rel="stylesheet" href="<?= html_escape(base_url('assets/plugins/select2/select2.min.css')) ?>">
<link rel="stylesheet" href="<?= html_escape(base_url('assets/css/report_piutang_invoice.css')) ?>">

<div class="piutang-report" id="piutang-report" data-url="<?= html_escape(site_url('report_piutang_invoice')) ?>" data-invoice="<?= html_escape($filters['no_invoice']) ?>" data-default-date="<?= html_escape($default_date) ?>">
    <!-- Header -->
    <header class="piutang-header">
        <div class="piutang-header-main">
            <h1 class="piutang-title">Laporan Piutang per Invoice</h1>
            <p class="piutang-subtitle">Monitoring posisi saldo piutang outstanding dan riwayat realisasi pembayaran per invoice.</p>
        </div>
        <div class="piutang-header-actions">
            <a class="btn-piutang btn-piutang-export" id="piutang-export" href="<?= html_escape(site_url('report_piutang_invoice/export_excel') . '?' . http_build_query($filters)) ?>" aria-disabled="true">
                <i class="fa fa-file-excel-o"></i> Export Excel
            </a>
        </div>
    </header>

    <!-- KPI Summary Cards -->
    <div class="piutang-kpi-grid">
        <div class="piutang-kpi-card piutang-kpi-primary">
            <div class="piutang-kpi-icon">
                <i class="fa fa-money"></i>
            </div>
            <div class="piutang-kpi-details">
                <span class="piutang-kpi-label">TOTAL PIUTANG OUTSTANDING</span>
                <div class="piutang-kpi-value">
                    <span class="currency">Rp</span>
                    <strong id="piutang-total">—</strong>
                </div>
                <span class="piutang-kpi-desc">Total sisa saldo belum tertagih sesuai filter</span>
            </div>
        </div>

        <div class="piutang-kpi-card">
            <div class="piutang-kpi-icon">
                <i class="fa fa-file-text-o"></i>
            </div>
            <div class="piutang-kpi-details">
                <span class="piutang-kpi-label">INVOICE OUTSTANDING</span>
                <div class="piutang-kpi-value">
                    <strong id="piutang-count">—</strong>
                    <span class="unit">invoice</span>
                </div>
                <span class="piutang-kpi-desc">Jumlah transaksi yang belum lunas</span>
            </div>
        </div>

        <div class="piutang-kpi-card">
            <div class="piutang-kpi-icon">
                <i class="fa fa-calendar-check-o"></i>
            </div>
            <div class="piutang-kpi-details">
                <span class="piutang-kpi-label">POSISI CUT-OFF PER TANGGAL</span>
                <div class="piutang-kpi-value">
                    <strong id="piutang-date">—</strong>
                </div>
                <span class="piutang-kpi-desc">Batas cut-off perhitungan transaksi</span>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="piutang-card piutang-filter-card">
        <div class="piutang-card-header">
            <div class="piutang-card-title">
                <i class="fa fa-sliders"></i> Filter Laporan
            </div>
            <div class="piutang-filter-status" id="piutang-filter-state" aria-live="polite">
                Pilih parameter posisi piutang yang ingin dilihat
            </div>
        </div>
        <div class="piutang-card-body">
            <form id="piutang-filters" autocomplete="off">
                <div class="piutang-filter-grid">
                    <div class="piutang-field">
                        <label for="piutang-tanggal">Per Tanggal <span class="text-danger">*</span></label>
                        <div class="piutang-input-control">
                            <input type="date" name="tanggal" id="piutang-tanggal" class="form-control" value="<?= html_escape($filters['tanggal']) ?>" required>
                        </div>
                    </div>
                    <div class="piutang-field">
                        <label for="piutang-customer">Customer</label>
                        <div class="piutang-input-control">
                            <select name="customer_id" id="piutang-customer" class="form-control">
                                <option value="">Semua Customer</option>
                                <?php foreach ($customers as $customer): ?>
                                <?php if (trim((string) $customer['name_customer']) === '') { continue; } ?>
                                <option value="<?= html_escape($customer['id_customer']) ?>" <?= $filters['customer_id'] === (string) $customer['id_customer'] ? 'selected' : '' ?>><?= html_escape($customer['name_customer']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="piutang-field">
                        <label for="piutang-nomor">Nomor Invoice</label>
                        <div class="piutang-input-control">
                            <select name="no_invoice" id="piutang-nomor" class="form-control" disabled>
                                <option value="">Memuat invoice…</option>
                            </select>
                        </div>
                    </div>
                    <div class="piutang-filter-actions">
                        <button type="submit" class="btn-piutang btn-piutang-primary" id="piutang-apply">
                            <i class="fa fa-search"></i> Tampilkan
                        </button>
                        <button type="button" class="btn-piutang btn-piutang-secondary" id="piutang-reset">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Error Alert Box -->
    <div class="piutang-alert piutang-alert-danger" id="piutang-error" role="alert" hidden></div>

    <!-- Data Table Card -->
    <div class="piutang-card piutang-table-card">
        <div class="piutang-card-header">
            <div>
                <h2 class="piutang-card-title"><i class="fa fa-table"></i> Rincian Piutang per Invoice</h2>
                <p class="piutang-card-subtitle">Setiap invoice menampilkan rincian pembayaran penerimaan secara berurutan.</p>
            </div>
        </div>
        <div class="piutang-card-body piutang-table-responsive">
            <table id="piutang-table" class="table table-hover piutang-invoice-table" width="100%">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Tgl Invoice</th>
                        <th>No Invoice</th>
                        <th class="text-right">Nilai Invoice</th>
                        <th>Kode Penerimaan</th>
                        <th>Tgl Bayar</th>
                        <th class="text-right">Nilai Bayar</th>
                        <th class="text-right">Total Bayar</th>
                        <th class="text-right">Sisa Piutang</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td colspan="8">Total Piutang Outstanding <span>(Seluruh Hasil Filter)</span></td>
                        <td id="piutang-footer-total" class="text-right">—</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Verification Audit Notice -->
    <details class="piutang-card piutang-verification-card" id="piutang-verification">
        <summary class="piutang-verification-summary">
            <div class="piutang-verification-title">
                <i class="fa fa-exclamation-triangle"></i>
                <span>Perlu Verifikasi Transaksi</span>
                <span class="badge-count" id="piutang-issue-count">0</span>
            </div>
            <span class="piutang-verification-meta" id="piutang-verification-note">Memeriksa kelengkapan data…</span>
            <i class="fa fa-chevron-down piutang-toggle-icon"></i>
        </summary>
        <div class="piutang-verification-content">
            <p class="piutang-verification-desc">Data berikut tidak diikutsertakan dalam akumulasi total piutang dan memerlukan pengecekan sebelum dihitung:</p>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>No Invoice</th>
                            <th>Kode Internal</th>
                            <th>Kode Penerimaan</th>
                            <th>Alasan</th>
                        </tr>
                    </thead>
                    <tbody id="piutang-verification-rows"></tbody>
                </table>
            </div>
        </div>
    </details>

    <footer class="piutang-footnote">
        <i class="fa fa-info-circle"></i> Posisi saldo dihitung per cut-off tanggal yang dipilih berdasarkan pencatatan transaksi saat ini. Perubahan transaksi dapat mengubah posisi tanggal lampau.
    </footer>
</div>

<script src="<?= html_escape(base_url('assets/plugins/datatables/jquery.dataTables.min.js')) ?>"></script>
<script src="<?= html_escape(base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')) ?>"></script>
<script src="<?= html_escape(base_url('assets/plugins/select2/select2.full.min.js')) ?>"></script>
<script src="<?= html_escape(base_url('assets/js/report_piutang_invoice.js')) ?>"></script>
