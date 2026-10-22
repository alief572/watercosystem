<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/report_progress_so.css') ?>">

<div class="progress-so-container">
    <!-- Header -->
    <div class="progress-so-header">
        <div class="title-area">
            <h2><i class="fa fa-line-chart"></i> Report Progress Sales Order</h2>
            <p>Melihat progress penagihan, pembayaran, dan realisasi status pengiriman Sales Order secara terpadu.</p>
        </div>
        <div>
            <a href="#" id="btn-export-excel" class="btn-export-excel">
                <i class="fa fa-file-excel-o"></i> Export Excel (2 Sheet)
            </a>
        </div>
    </div>

    <!-- KPI Summary Cards -->
    <div class="progress-kpi-grid">
        <div class="progress-kpi-card kpi-blue">
            <div class="progress-kpi-icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="progress-kpi-info">
                <span class="progress-kpi-label">Total Value SO</span>
                <div class="progress-kpi-value" id="kpi-value-so">Rp 0</div>
                <div class="progress-kpi-sub"><span id="kpi-count-so">0</span> Transaksi SO</div>
            </div>
        </div>

        <div class="progress-kpi-card kpi-teal">
            <div class="progress-kpi-icon">
                <i class="fa fa-file-text-o"></i>
            </div>
            <div class="progress-kpi-info">
                <span class="progress-kpi-label">Total Invoice</span>
                <div class="progress-kpi-value" id="kpi-invoice">Rp 0</div>
                <div class="progress-kpi-sub">Tertagih: <strong id="kpi-pct-tertagih">0%</strong></div>
            </div>
        </div>

        <div class="progress-kpi-card kpi-emerald">
            <div class="progress-kpi-icon">
                <i class="fa fa-check-circle-o"></i>
            </div>
            <div class="progress-kpi-info">
                <span class="progress-kpi-label">Total Terbayar</span>
                <div class="progress-kpi-value" id="kpi-payment">Rp 0</div>
                <div class="progress-kpi-sub">Realisasi: <strong id="kpi-pct-terbayar">0%</strong></div>
            </div>
        </div>

        <div class="progress-kpi-card kpi-amber">
            <div class="progress-kpi-icon">
                <i class="fa fa-clock-o"></i>
            </div>
            <div class="progress-kpi-info">
                <span class="progress-kpi-label">Outstanding Piutang</span>
                <div class="progress-kpi-value" id="kpi-outstanding-piutang">Rp 0</div>
                <div class="progress-kpi-sub">Sisa Invoice Belum Lunas</div>
            </div>
        </div>
    </div>

    <!-- Shared Filter Box -->
    <div class="progress-filter-box">
        <div class="filter-title">
            <i class="fa fa-filter text-primary"></i> Filter Parameter Laporan
        </div>
        <form id="form-filter" autocomplete="off">
            <div class="row">
                <div class="col-md-2 col-sm-6">
                    <div class="form-group">
                        <label for="filter_start_date">Tgl SO Dari</label>
                        <input type="date" class="form-control input-sm" id="filter_start_date" name="start_date" value="<?= html_escape($filters['start_date']) ?>">
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="form-group">
                        <label for="filter_end_date">Tgl SO Sampai</label>
                        <input type="date" class="form-control input-sm" id="filter_end_date" name="end_date" value="<?= html_escape($filters['end_date']) ?>">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label for="filter_customer">Customer</label>
                        <select class="form-control input-sm select2" id="filter_customer" name="customer_id" style="width: 100%;">
                            <option value="">-- Semua Customer --</option>
                            <?php foreach ($customers as $c): ?>
                                <option value="<?= html_escape($c['id_customer']) ?>">
                                    <?= html_escape($c['name_customer']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label for="filter_sales">Sales / Account Handler</label>
                        <select class="form-control input-sm select2" id="filter_sales" name="sales_name" style="width: 100%;">
                            <option value="">-- Semua Sales --</option>
                            <?php foreach ($sales as $s): ?>
                                <option value="<?= html_escape($s['nama_sales']) ?>">
                                    <?= html_escape($s['nama_sales']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12">
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-filter-apply">
                            <i class="fa fa-search"></i> Tampilkan
                        </button>
                        <button type="button" id="btn-reset-filter" class="btn btn-filter-reset">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- 2-Tab Navigation -->
    <div class="nav-tabs-custom-progress">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#tab-progress-so" aria-controls="tab-progress-so" role="tab" data-toggle="tab">
                    <i class="fa fa-file-text-o"></i> Progress Sales Order (SO)
                </a>
            </li>
            <li role="presentation">
                <a href="#tab-delivery" aria-controls="tab-delivery" role="tab" data-toggle="tab">
                    <i class="fa fa-truck"></i> Status Pengiriman (DO)
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- TAB 1: PROGRESS SALES ORDER -->
            <div role="tabpanel" class="tab-pane active" id="tab-progress-so">
                <div class="table-responsive">
                    <table id="table-progress-so" class="table table-bordered table-striped table-hover table-progress-so" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="4%">No</th>
                                <th width="11%">No SO</th>
                                <th width="8%">Tgl SO</th>
                                <th width="14%">Customer</th>
                                <th width="10%">Sales</th>
                                <th width="14%">Deskripsi</th>
                                <th width="9%">Value SO</th>
                                <th width="9%">Invoice</th>
                                <th width="9%">Outstanding SO</th>
                                <th width="9%">Payment</th>
                                <th width="9%">Outstanding Piutang</th>
                                <th width="6%">% Tertagih</th>
                                <th width="6%">% Terbayar</th>
                                <th width="9%">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" style="text-align: right;">TOTAL:</th>
                                <th id="ft-value-so" style="text-align: right;">0</th>
                                <th id="ft-invoice" style="text-align: right;">0</th>
                                <th id="ft-outstanding-so" style="text-align: right;">0</th>
                                <th id="ft-payment" style="text-align: right;">0</th>
                                <th id="ft-outstanding-piutang" style="text-align: right;">0</th>
                                <th id="ft-pct-tertagih" style="text-align: center;">0%</th>
                                <th id="ft-pct-terbayar" style="text-align: center;">0%</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- TAB 2: STATUS PENGIRIMAN -->
            <div role="tabpanel" class="tab-pane" id="tab-delivery">
                <div class="table-responsive">
                    <table id="table-status-delivery" class="table table-bordered table-striped table-hover table-progress-so" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="4%">No</th>
                                <th width="10%">No SO</th>
                                <th width="15%">Barang</th>
                                <th width="6%">Qty</th>
                                <th width="8%">Tgl SO</th>
                                <th width="7%">Qty Kirim</th>
                                <th width="7%">Outstanding</th>
                                <th width="7%">% Terkirim</th>
                                <th width="9%">Status Kirim</th>
                                <th width="8%">Tgl DO</th>
                                <th width="10%">No DO</th>
                                <th width="14%">Nama Customer</th>
                                <th width="10%">Account Handler</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" style="text-align: right;">TOTAL:</th>
                                <th id="ft-qty-so" style="text-align: right;">0</th>
                                <th></th>
                                <th id="ft-qty-kirim" style="text-align: right;">0</th>
                                <th id="ft-qty-outstanding" style="text-align: right;">0</th>
                                <th colspan="6"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/select2/select2.full.min.js') ?>"></script>

<script type="text/javascript">
$(document).ready(function() {
    var defaultStartDate = '<?= $filters['start_date'] ?>';
    var defaultEndDate = '<?= $filters['end_date'] ?>';
    var baseUrl = '<?= site_url('report_progress_so') ?>';

    // Initialize Select2
    $('.select2').select2({
        allowClear: true
    });

    // Function to construct query string from current form inputs
    function getFilterParams() {
        return {
            start_date: $('#filter_start_date').val(),
            end_date: $('#filter_end_date').val(),
            customer_id: $('#filter_customer').val(),
            sales_name: $('#filter_sales').val()
        };
    }

    // Update Export Excel Link
    function updateExportLink() {
        var params = getFilterParams();
        var url = baseUrl + '/export_excel?' + $.param(params);
        $('#btn-export-excel').attr('href', url);
    }
    updateExportLink();

    // Initialize DataTable for Tab 1: Progress SO
    var tableSO = $('#table-progress-so').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ordering: true,
        order: [[2, 'desc']],
        ajax: {
            url: baseUrl + '/data_so',
            type: 'POST',
            data: function(d) {
                var p = getFilterParams();
                d.start_date = p.start_date;
                d.end_date = p.end_date;
                d.customer_id = p.customer_id;
                d.sales_name = p.sales_name;
            },
            dataSrc: function(json) {
                // Update KPI Cards
                if (json.totals) {
                    $('#kpi-value-so').text('Rp ' + json.totals.total_value_so);
                    $('#kpi-count-so').text(json.totals.count_so);
                    $('#kpi-invoice').text('Rp ' + json.totals.total_invoice);
                    $('#kpi-pct-tertagih').text(json.totals.avg_persen_tertagih);
                    $('#kpi-payment').text('Rp ' + json.totals.total_payment);
                    $('#kpi-pct-terbayar').text(json.totals.avg_persen_terbayar);
                    $('#kpi-outstanding-piutang').text('Rp ' + json.totals.total_outstanding_piutang);

                    // Update Footer Totals
                    $('#ft-value-so').text(json.totals.total_value_so);
                    $('#ft-invoice').text(json.totals.total_invoice);
                    $('#ft-outstanding-so').text(json.totals.total_outstanding_so);
                    $('#ft-payment').text(json.totals.total_payment);
                    $('#ft-outstanding-piutang').text(json.totals.total_outstanding_piutang);
                    $('#ft-pct-tertagih').text(json.totals.avg_persen_tertagih);
                    $('#ft-pct-terbayar').text(json.totals.avg_persen_terbayar);
                }
                return json.data;
            }
        },
        columns: [
            { data: 'no', className: 'text-center', orderable: false },
            { data: 'no_so' },
            { data: 'tanggal_so', className: 'text-center' },
            { data: 'customer' },
            { data: 'sales' },
            { data: 'deskripsi' },
            { data: 'value_so', className: 'text-right' },
            { data: 'invoice', className: 'text-right' },
            { data: 'outstanding_so', className: 'text-right' },
            { data: 'payment', className: 'text-right' },
            { data: 'outstanding_piutang', className: 'text-right' },
            { data: 'persen_tertagih', className: 'text-center' },
            { data: 'persen_terbayar', className: 'text-center' },
            { data: 'status', className: 'text-center' }
        ],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw text-primary"></i> Memuat data...',
            search: 'Cari dalam tabel:',
            searchPlaceholder: 'Ketik No SO, Customer, Sales...',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_ s/d _END_ dari _TOTAL_ data',
            infoEmpty: 'Menampilkan 0 s/d 0 dari 0 data',
            infoFiltered: '(disaring dari _MAX_ total data)',
            zeroRecords: 'Tidak ada data yang cocok dengan pencarian',
            emptyTable: 'Tidak ada data untuk periode ini'
        }
    });

    // Initialize DataTable for Tab 2: Status Pengiriman
    var tableDelivery = $('#table-status-delivery').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ordering: true,
        order: [[4, 'desc']],
        ajax: {
            url: baseUrl + '/data_delivery',
            type: 'POST',
            data: function(d) {
                var p = getFilterParams();
                d.start_date = p.start_date;
                d.end_date = p.end_date;
                d.customer_id = p.customer_id;
                d.sales_name = p.sales_name;
            },
            dataSrc: function(json) {
                // Update Footer Totals
                if (json.totals) {
                    $('#ft-qty-so').text(json.totals.total_qty_so);
                    $('#ft-qty-kirim').text(json.totals.total_qty_kirim);
                    $('#ft-qty-outstanding').text(json.totals.total_outstanding);
                }
                return json.data;
            }
        },
        columns: [
            { data: 'no', className: 'text-center', orderable: false },
            { data: 'no_so' },
            { data: 'barang' },
            { data: 'qty', className: 'text-right' },
            { data: 'tanggal_so', className: 'text-center' },
            { data: 'qty_kirim', className: 'text-right' },
            { data: 'outstanding', className: 'text-right' },
            { data: 'persen_terkirim', className: 'text-center' },
            { data: 'status_kirim', className: 'text-center' },
            { data: 'tanggal_do', className: 'text-center' },
            { data: 'no_do', className: 'text-center' },
            { data: 'nama_customer' },
            { data: 'account_handler' }
        ],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw text-primary"></i> Memuat data...',
            search: 'Cari dalam tabel:',
            searchPlaceholder: 'Ketik No SO, Barang, No DO...',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_ s/d _END_ dari _TOTAL_ data',
            infoEmpty: 'Menampilkan 0 s/d 0 dari 0 data',
            infoFiltered: '(disaring dari _MAX_ total data)',
            zeroRecords: 'Tidak ada data yang cocok dengan pencarian',
            emptyTable: 'Tidak ada data untuk periode ini'
        }
    });

    // On Form Filter Submit
    $('#form-filter').on('submit', function(e) {
        e.preventDefault();
        updateExportLink();
        tableSO.ajax.reload();
        tableDelivery.ajax.reload();
    });

    // On Filter Reset
    $('#btn-reset-filter').on('click', function() {
        $('#filter_start_date').val(defaultStartDate);
        $('#filter_end_date').val(defaultEndDate);
        $('#filter_customer').val('').trigger('change');
        $('#filter_sales').val('').trigger('change');
        updateExportLink();
        tableSO.ajax.reload();
        tableDelivery.ajax.reload();
    });

    // Adjust DataTable column widths when switching tabs
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    });
});
</script>
