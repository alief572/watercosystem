(function ($) {
    'use strict';
    $(function () {
        var root = $('#progress-po');
        if (!root.length) { return; }
        var url = root.attr('data-url'), form = $('#po-filters'), filters = {}, pending, detailRequest, dirty = false, detailTrigger;
        var exportButton = $('#po-export'), table;
        var numeric = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 });
        var dates = new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        var months = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' });
        function number(value) { return value === null || value === undefined || !isFinite(Number(value)) ? '-' : numeric.format(value); }
        function money(value, currency) { return value === null || value === undefined ? '-' : (currency === 'USD' ? 'US$ ' : 'Rp ') + number(value); }
        function escape(value) { return $('<span>').text(value === null || value === undefined || value === '' ? '-' : String(value)).html(); }
        function date(value) {
            if (!value || !/^\d{4}-\d{2}-\d{2}$/.test(value)) { return '-'; }
            var parts = value.split('-');
            return dates.format(new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2])));
        }
        function status(po) {
            var code = ['belum', 'parsial', 'lengkap', 'bermasalah'].indexOf(po.status_code) >= 0 ? po.status_code : 'bermasalah';
            return '<span class="po-status po-status-' + code + '">' + escape(po.status) + '</span>';
        }
        function progress(po) {
            var html = status(po);
            if (po.progress !== null && po.progress !== undefined && isFinite(Number(po.progress))) {
                var value = Math.max(0, Math.min(100, Number(po.progress)));
                html += '<div class="po-progress-label"><span>Progress nilai</span><strong>' + number(value) + '%</strong></div>'
                    + '<div class="po-progress-track" aria-hidden="true"><span class="po-progress-fill" style="width:' + value + '%"></span></div>';
            }
            if (po.closed) { html += '<span class="po-cell-sub">PO / item ditutup</span>'; }
            if (po.issues && po.issues.length) { html += '<span class="po-cell-sub po-note">Periksa data nilai</span>'; }
            return html;
        }
        function readFilters() {
            var result = {};
            $.each(form.serializeArray(), function (_, field) { result[field.name] = field.value; });
            return result;
        }
        function errorMessage(xhr) { return xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Laporan belum dapat dimuat. Periksa koneksi lalu coba kembali.'; }
        function setBusy(busy) {
            $('.po-report').attr('aria-busy', String(busy));
            $('#po-load-state').text(busy ? 'Memuat laporan PO...' : '');
        }
        function metricText(data) {
            root.find('[data-metric]').each(function () {
                var field = $(this).attr('data-metric'), value = data ? data[field] : null;
                $(this).text(!data ? 'Belum tersedia' : ['total_idr', 'received_idr', 'remaining_idr'].indexOf(field) >= 0 ? money(value, 'IDR') : field === 'usd' ? money(value, 'USD') : number(value));
            });
        }
        function summary(data) {
            metricText(data.totals);
            var problems = data.totals.problem_count;
            var warning = $('#po-warning').empty().prop('hidden', true);
            if (problems) {
                warning.append($('<strong>').text(number(problems) + ' PO perlu diperiksa. '),
                    $('<span>').text('Ada nilai yang belum dapat dihitung. Total tiap kolom hanya menjumlahkan nilai yang tersedia dan dapat belum saling cocok. '),
                    $('<button type="button" class="btn po-reset" id="po-show-problems">').text('Lihat PO bermasalah'));
            }
            $('#po-period').text('Periode PO: ' + date(filters.start_date) + ' s.d. ' + date(filters.end_date));
            $('#po-generated').text('Diperbarui ' + data.generated_at + ' WIB');
            $('#po-count').prop('hidden', false).text(number(data.recordsFiltered));
            function recap(selector, rows, supplier) {
                var body = $(selector + ' tbody').empty();
                $.each(rows, function (_, row) {
                    var label = row.supplier;
                    if (!supplier) {
                        var parts = row.month.split('-');
                        label = months.format(new Date(Number(parts[0]), Number(parts[1]) - 1, 1));
                    }
                    var tr = $('<tr>').append($('<td>').text(label));
                    if (!row.count_po) { tr.addClass('po-month-empty'); }
                    $.each(['count_po', 'usd', 'total_idr', 'received_idr', 'remaining_idr'], function (_, field) { tr.append($('<td class="po-number">').text(number(row[field]))); });
                    if (supplier) { tr.append($('<td class="po-number">').text(number(row.share) + '%')); }
                    tr.append($('<td class="po-number" hidden>').text(row.problem_count ? number(row.problem_count) + ' PO' : '-')); body.append(tr);
                });
                if (!rows.length) { body.append($('<tr>').append($('<td class="po-empty">').attr('colspan', supplier ? 7 : 6).text('Tidak ada PO yang sesuai. Perluas periode atau reset filter untuk melihat pesanan lain.'))); }
            }
            recap('#po-monthly', data.monthly, false); recap('#po-suppliers', data.suppliers, true);
        }
        filters = readFilters();
        table = $('#po-table').DataTable({
            processing: true, serverSide: true, searching: false, pageLength: 25,
            lengthMenu: [10, 25, 50, 100], order: [[0, 'desc']], autoWidth: false,
            dom: '<"po-table-controls"l><"po-table-scroll"rt><"po-table-footer"ip>',
            initComplete: function () {
                $('#po-table_wrapper .po-table-scroll').attr({ tabindex: '0', role: 'region', 'aria-label': 'Daftar PO, dapat digeser horizontal' });
            },
            ajax: function (request, callback) {
                if (pending) { pending.abort(); }
                exportButton.prop('disabled', true); $('#po-error').prop('hidden', true); setBusy(true);
                var order = request.order[0] || { column: 0, dir: 'desc' };
                var fields = { 0: 'date', 1: 'supplier', 2: 'progress', 3: 'native', 4: 'total_idr', 5: 'received_idr', 6: 'remaining_idr' };
                pending = $.ajax({ url: url + '/data_po', dataType: 'json', data: $.extend({}, filters, {
                    start: request.start, length: request.length, draw: request.draw,
                    sort: fields[order.column] || 'date', direction: order.dir
                }) }).done(function (data) {
                    summary(data); callback(data); exportButton.prop('disabled', dirty || !data.recordsFiltered);
                    setBusy(false); $('#po-load-state').text(number(data.recordsFiltered) + ' PO sesuai filter');
                }).fail(function (xhr, state) {
                    if (state === 'abort') { return; }
                    $('#po-error').prop('hidden', false).empty().append($('<span>').text(errorMessage(xhr) + ' '),
                        $('<button type="button" class="btn po-reset" id="po-retry">').text('Coba kembali'));
                    metricText(null); $('#po-monthly tbody, #po-suppliers tbody, #po-generated').empty();
                    $('#po-warning, #po-count').prop('hidden', true); setBusy(false); $('#po-load-state').text('Laporan gagal dimuat');
                    callback({ draw: request.draw, recordsTotal: 0, recordsFiltered: 0, data: [] });
                });
            },
            columns: [
                { data: 'date', render: function (value, type, po) { return '<strong class="po-cell-title">' + escape(po.number) + '</strong><span class="po-cell-sub">' + date(value) + '</span>'; } },
                { data: 'supplier', render: function (value, type, po) { return '<span class="po-cell-title">' + escape(value) + '</span><span class="po-cell-sub">' + escape(po.type) + ' / ' + escape(po.currency) + '</span>'; } },
                { data: 'progress', render: function (value, type, po) { return progress(po); } },
                { data: 'native', className: 'po-number', render: function (value, type, po) { return escape(money(value, po.currency)); } },
                { data: 'total_idr', className: 'po-number', render: number },
                { data: 'received_idr', className: 'po-number', render: number },
                { data: 'remaining_idr', className: 'po-number', render: number },
                { data: 'first_incoming', orderable: false, render: function (value, type, po) {
                    if (!value) { return '<span class="po-cell-sub">Belum ada Incoming</span>'; }
                    return date(value) + (po.last_incoming && po.last_incoming !== value ? '<span class="po-cell-sub">s.d. ' + date(po.last_incoming) + '</span>' : '');
                } },
                { data: null, orderable: false, render: function (value, type, po) { return '<button type="button" class="btn po-open" aria-label="' + escape('Lihat rincian ' + po.number) + '">Rincian</button>'; } }
            ],
            language: { emptyTable: 'Tidak ada PO yang sesuai. Perluas periode atau reset filter.', zeroRecords: 'Tidak ada PO yang sesuai dengan filter ini.', processing: 'Memuat data PO...',
                lengthMenu: 'Tampilkan _MENU_ PO', info: '_START_ - _END_ dari _TOTAL_ PO', infoEmpty: '0 PO',
                infoFiltered: '(dari _MAX_ PO sebelum filter status/pencarian)', paginate: { previous: 'Sebelumnya', next: 'Berikutnya' } }
        });
        function reload() {
            if (detailRequest) { detailRequest.abort(); }
            $('#po-detail').modal('hide'); filters = readFilters(); dirty = false;
            $('#po-filter-pending').prop('hidden', true); table.ajax.reload();
        }
        form.on('submit', function (event) { event.preventDefault(); reload(); });
        form.on('reset', function () { setTimeout(reload, 0); });
        form.on('input change', function () { dirty = true; exportButton.prop('disabled', true); $('#po-filter-pending').prop('hidden', false); });
        exportButton.on('click', function () { if (!dirty) { window.location.assign(url + '/export_excel?' + $.param(filters)); } });
        root.on('click', '#po-retry', function () { table.ajax.reload(null, false); });
        root.on('click', '#po-show-problems', function () { $('#po-status').val('bermasalah'); reload(); $('#po-data-label').tab('show'); });
        root.find('[role="tab"]').on('shown.bs.tab', function () {
            root.find('[role="tab"]').attr({ 'aria-selected': 'false', tabindex: '-1' });
            $(this).attr({ 'aria-selected': 'true', tabindex: '0' }); table.columns.adjust();
        }).on('keydown', function (event) {
            var keys = ['ArrowLeft', 'ArrowRight', 'Home', 'End'];
            if (keys.indexOf(event.key) < 0) { return; }
            event.preventDefault();
            var tabs = root.find('[role="tab"]'), index = tabs.index(this), next;
            if (event.key === 'Home') { next = 0; }
            else if (event.key === 'End') { next = tabs.length - 1; }
            else { next = (index + (event.key === 'ArrowRight' ? 1 : -1) + tabs.length) % tabs.length; }
            tabs.eq(next).tab('show').trigger('focus');
        });
        function valuesList(items, className) {
            var list = $('<dl>').addClass(className);
            $.each(items, function (_, entry) { list.append($('<div>').append($('<dt>').text(entry[0]), $('<dd>').text(entry[1]))); });
            return list;
        }
        function showDetail(po) {
            var body = $('#po-detail-body').empty();
            body.append($('<div>').html(status(po)), $('<p class="po-cell-sub">').text(po.supplier + ' / ' + po.type + ' / ' + po.currency + (po.closed ? ' / PO atau item ditutup' : '')));
            body.append(valuesList([
                ['Tanggal PO', date(po.date)], ['Nilai bersih PO', money(po.native, po.currency)], ['Total laporan IDR', money(po.total_idr, 'IDR')],
                ['Sudah diterima', money(po.received_idr, 'IDR')], ['Sisa estimasi', money(po.remaining_idr, 'IDR')],
                ['Progress nilai', po.progress === null ? '-' : number(po.progress) + '%'], ['Kurs PO', number(po.po_rate)], ['Kurs efektif', number(po.effective_rate)],
                ['Periode Incoming', date(po.first_incoming) + (po.last_incoming !== po.first_incoming ? ' s.d. ' + date(po.last_incoming) : '')]
            ], 'po-detail-overview'));
            if (po.description) { body.append($('<p class="po-detail-description">').text(po.description)); }
            if (po.issues.length) { body.append($('<div class="po-notice po-notice-warning">').text(po.issues.join('; '))); }
            if (!po.items.length) { body.append($('<p class="po-empty">').text('Detail barang belum tersedia. Periksa dokumen PO sumber.')); }
            $.each(po.items, function (_, item) {
                var section = $('<section class="po-item">').append($('<h4>').text(item.name), $('<p class="po-cell-sub">').text(item.id));
                section.append(valuesList([
                    ['Qty PO', number(item.qty)], ['Diterima', number(item.received_qty)], ['Kelebihan', number(item.excess_qty)], ['Nilai bersih ' + po.currency, number(item.net)]
                ], 'po-item-meta'));
                var history = $('<table class="table po-history">').append($('<caption class="sr-only">').text('Riwayat Incoming untuk ' + item.name));
                history.append($('<thead>').append($('<tr>').append($.map(['Incoming', 'Tanggal', 'PIB', 'Qty aktual', 'Qty alokasi', 'Kurs Incoming', 'Alokasi IDR'], function (text) { return $('<th scope="col">').text(text)[0]; }))));
                var tbody = $('<tbody>');
                $.each(item.receipts, function (_, receipt) {
                    var tr = $('<tr>');
                    $.each([receipt.number || '-', date(receipt.date), receipt.pib || '-', number(receipt.qty), number(receipt.allocated_qty), number(receipt.rate), number(receipt.idr)], function (index, value) { tr.append($('<td>').toggleClass('po-number', index >= 3).text(value)); });
                    tbody.append(tr);
                });
                if (!item.receipts.length) { tbody.append($('<tr>').append($('<td class="po-empty" colspan="7">').text('Belum ada penerimaan untuk barang ini.'))); }
                section.append($('<div class="po-table-scroll" tabindex="0" role="region" aria-label="Riwayat Incoming, dapat digeser horizontal">').append(history.append(tbody))); body.append(section);
            });
        }
        $('#po-table').on('click', '.po-open', function () {
            var row = table.row($(this).closest('tr')).data(); detailTrigger = this;
            if (detailRequest) { detailRequest.abort(); }
            $('#po-detail-title').text(row.number); $('#po-detail-body').text('Memuat barang dan riwayat Incoming...').attr('aria-busy', 'true'); $('#po-detail').modal('show');
            detailRequest = $.getJSON(url + '/detail', $.extend({}, filters, { id: row.id })).done(showDetail)
                .fail(function (xhr, state) { if (state !== 'abort') { $('#po-detail-body').text(errorMessage(xhr) + ' Tutup rincian dan buka kembali untuk mencoba lagi.'); } })
                .always(function () { $('#po-detail-body').attr('aria-busy', 'false'); });
        });
        $('#po-detail').on('hidden.bs.modal', function () {
            if (detailRequest) { detailRequest.abort(); }
            if (detailTrigger && document.documentElement.contains(detailTrigger)) { $(detailTrigger).trigger('focus'); }
        });
    });
}(jQuery));
