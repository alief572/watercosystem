(function (root, factory) {
    if (typeof module === 'object' && module.exports) {
        module.exports = factory(null);
    } else {
        root.PiutangInvoiceTable = factory(root.jQuery);
    }
}(this, function ($) {
    'use strict';
    function escape(value) {
        return String(value == null ? '' : value).replace(/[&<>"']/g, function (character) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[character];
        });
    }
    function money(value) {
        return Number(value || 0).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    function date(value) {
        if (!value) { return ''; }
        var parts = value.split('-');
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        return parts[2] + ' ' + months[Number(parts[1]) - 1] + ' ' + parts[0];
    }
    function cell(invoice, column) {
        var payments = invoice.payments.length ? invoice.payments : [null];
        var html = '<div class="piutang-stack">';
        payments.forEach(function (payment, index) {
            var value = '';
            if (column === 'customer' || column === 'no_surat') { value = index === 0 ? invoice[column] : ''; }
            else if (column === 'tgl_invoice') { value = index === 0 ? date(invoice.tgl_invoice) : ''; }
            else if (column === 'nilai_invoice') { value = index === 0 ? money(invoice.nilai_invoice) : ''; }
            else if (column === 'tgl_pembayaran') { value = payment ? date(payment.tgl_pembayaran) : ''; }
            else if (column === 'kd_pembayaran') { value = payment ? payment.kd_pembayaran : ''; }
            else if (column === 'sisa_piutang') { value = money(payment ? payment.sisa_piutang : invoice.sisa_piutang); }
            else { value = payment ? money(payment[column]) : ''; }
            html += '<div class="piutang-line" title="' + escape(value) + '">' + escape(value) + '</div>';
        });
        return html + '</div>';
    }
    if ($) { $(function () {
        var root = $('#piutang-report');
        if (!root.length) { return; }
        $('body').addClass('piutang-report-page');
        var url = root.attr('data-url');
        var invoiceSelect = $('#piutang-nomor');
        var customerSelect = $('#piutang-customer');
        var defaultDate = root.attr('data-default-date');
        var selectedInvoice = root.attr('data-invoice') || '';
        var table = null;
        var optionsRequest = null;
        var tableRequest = null;
        var optionsVersion = 0;
        var tableVersion = 0;
        var applied = null;
        var exportButton = $('#piutang-export');
        var errorBox = $('#piutang-error');
        var filterState = $('#piutang-filter-state');
        customerSelect.add(invoiceSelect).select2({ width: '100%', dropdownCssClass: 'piutang-select-dropdown', language: {
            noResults: function () { return 'Tidak ada pilihan yang sesuai'; },
            searching: function () { return 'Mencari…'; }
        }});
        function readFilters() {
            return { tanggal: $('#piutang-tanggal').val(), customer_id: customerSelect.val() || '', no_invoice: invoiceSelect.val() || '' };
        }
        function clearError() { errorBox.prop('hidden', true).text(''); }
        function fail(message) {
            errorBox.text(message).prop('hidden', false);
            exportButton.attr('aria-disabled', 'true');
            filterState.text('Laporan belum berhasil dimuat');
            $('#piutang-total, #piutang-count, #piutang-date').text('—');
            root.find('tfoot td:last-child').text('—');
            $('#piutang-verification-rows').empty();
            $('#piutang-issue-count').text('—');
            $('#piutang-verification-note').text('Data belum berhasil dimuat');
        }
        function verification(report) {
            var body = $('#piutang-verification-rows').empty();
            $('#piutang-issue-count').text(report.verification.length);
            $('#piutang-verification-note').text(report.verification.length
                ? report.verification_invoice_count + ' invoice dipisahkan · ' + report.verification.length + ' detail perlu diperiksa'
                : 'Tidak ada data yang perlu diperiksa');
            report.verification.forEach(function (issue) {
                var row = $('<tr>');
                ['customer', 'no_surat', 'no_invoice', 'kd_pembayaran', 'reason'].forEach(function (field) {
                    $('<td>').text(issue[field] || '—').appendTo(row);
                });
                body.append(row);
            });
            if (!report.verification.length) { body.append($('<tr>').append($('<td colspan="5">').text('Tidak ada data perlu verifikasi.'))); }
        }
        function summary(report) {
            $('#piutang-total').text(money(report.total_piutang));
            $('#piutang-count').text(money(report.invoice_count));
            $('#piutang-date').text(date(report.tanggal));
            root.find('tfoot td:last-child').text(money(report.total_piutang));
            verification(report);
            filterState.text('Laporan sesuai filter yang dipilih');
            exportButton.attr('href', url + '/export_excel?' + $.param(applied)).attr('aria-disabled', 'false');
        }
        function startTable() {
            if (table) { table.ajax.reload(null, true); return; }
            var fields = ['customer', 'tgl_invoice', 'no_surat', 'nilai_invoice', 'kd_pembayaran', 'tgl_pembayaran', 'nilai_bayar', 'total_bayar', 'sisa_piutang'];
            table = $('#piutang-table').DataTable({
                processing: true, serverSide: true, searching: false, scrollX: true, autoWidth: false,
                pageLength: 25, lengthMenu: [10, 25, 50, 100], order: [],
                ajax: function (request, callback) {
                    var version = ++tableVersion;
                    if (tableRequest) { tableRequest.abort(); }
                    exportButton.attr('aria-disabled', 'true');
                    clearError();
                    filterState.text('Memuat laporan…');
                    $.extend(request, applied);
                    tableRequest = $.ajax({ url: url + '/data', type: 'GET', dataType: 'json', data: request })
                        .done(function (report) {
                            if (version !== tableVersion) { return; }
                            callback(report);
                            summary(report);
                        }).fail(function (xhr, status) {
                            if (status === 'abort' || version !== tableVersion) { return; }
                            callback({ draw: request.draw, recordsTotal: 0, recordsFiltered: 0, data: [] });
                            fail('Laporan gagal dimuat. Periksa koneksi dan pastikan sesi login masih aktif, lalu tekan Tampilkan.');
                        });
                },
                columns: fields.map(function (field, index) {
                    return { data: null, orderable: [4, 5, 6].indexOf(index) === -1,
                        className: ([3, 6, 7, 8].indexOf(index) !== -1 ? 'amount ' : '') + (index === 8 ? 'balance' : '') + (index === 2 ? ' invoice-number' : ''),
                        render: function (data, type, row) { return type === 'display' ? cell(row, field) : (row[field] || ''); }
                    };
                }),
                language: {
                    processing: 'Memuat invoice…', lengthMenu: 'Tampilkan _MENU_ invoice',
                    info: '_START_–_END_ dari _TOTAL_ invoice', infoEmpty: 'Belum ada invoice outstanding', infoFiltered: '',
                    emptyTable: 'Tidak ada invoice outstanding untuk filter ini.', zeroRecords: 'Tidak ada invoice yang sesuai.',
                    paginate: { first: 'Pertama', previous: 'Sebelumnya', next: 'Berikutnya', last: 'Terakhir' }
                }
            });
        }
        function refreshOptions(keepInvoice) {
            var form = document.getElementById('piutang-filters');
            if (!form.checkValidity()) { form.reportValidity(); return; }
            var version = ++optionsVersion;
            if (optionsRequest) { optionsRequest.abort(); }
            if (tableRequest) { ++tableVersion; tableRequest.abort(); }
            var filters = readFilters();
            var requested = keepInvoice ? (invoiceSelect.val() || selectedInvoice) : '';
            exportButton.attr('aria-disabled', 'true');
            invoiceSelect.prop('disabled', true).trigger('change.select2');
            clearError();
            filterState.text('Memuat pilihan invoice…');
            optionsRequest = $.ajax({ url: url + '/invoice_options', type: 'GET', dataType: 'json',
                data: { tanggal: filters.tanggal, customer_id: filters.customer_id } })
                .done(function (result) {
                    if (version !== optionsVersion) { return; }
                    invoiceSelect.empty().append(new Option('Semua invoice', ''));
                    var available = false;
                    result.options.forEach(function (option) {
                        invoiceSelect.append(new Option(option.text, option.id));
                        if (option.id === requested) { available = true; }
                    });
                    invoiceSelect.val(available ? requested : '').prop('disabled', false).trigger('change.select2');
                    selectedInvoice = '';
                    applied = readFilters();
                    startTable();
                }).fail(function (xhr, status) {
                    if (status === 'abort' || version !== optionsVersion) { return; }
                    fail('Pilihan invoice gagal dimuat. Periksa tanggal, koneksi, atau sesi login, lalu tekan Tampilkan.');
                });
        }
        $('#piutang-filters').on('submit', function (event) { event.preventDefault(); refreshOptions(true); });
        $('#piutang-tanggal').add(customerSelect).on('change', function () { refreshOptions(false); });
        invoiceSelect.on('change', function () {
            if (invoiceSelect.prop('disabled')) { return; }
            applied = readFilters();
            startTable();
        });
        $('#piutang-reset').on('click', function () {
            $('#piutang-tanggal').val(defaultDate);
            customerSelect.val('').trigger('change.select2');
            refreshOptions(false);
        });
        exportButton.on('click', function (event) { if (exportButton.attr('aria-disabled') === 'true') { event.preventDefault(); } });
        refreshOptions(true);
    }); }
    return { cell: cell, money: money, date: date, escape: escape };
}));
