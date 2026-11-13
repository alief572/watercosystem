(function ($, window) {
    'use strict';
    function escape(value) {
        return String(value == null ? '' : value).replace(/[&<>"']/g, function (c) { return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[c]; });
    }
    function cents(value) {
        var plain = String(value == null ? '0' : value).replace(/,/g, '');
        if (!/^-?\d+(?:\.\d{1,2})?$/.test(plain)) throw new Error('Nominal tidak valid.');
        var result = Math.round(Number(plain) * 100);
        if (!Number.isSafeInteger(result)) throw new Error('Nominal melewati batas aman.');
        return result;
    }
    function requestItems(drafts) {
        var items = [];
        drafts.forEach(function (d) { if (d.selected) items.push({tipe: d.tipe, ids: d.ids, tanggal: d.tanggal, version: d.version}); });
        if (!items.length) throw new Error('Pilih minimal satu data.');
        if (items.some(function (d) { return !/^\d{4}-\d{2}-\d{2}$/.test(d.tanggal); })) throw new Error('Tanggal pembayaran wajib diisi untuk semua pilihan.');
        return items;
    }
    function appendItems(data, items, prefix) {
        items.forEach(function (item, i) { Object.keys(item).forEach(function (key) { data.append(prefix + '[' + i + '][' + key + ']', item[key]); }); });
    }
    if (typeof module === 'object' && module.exports) { module.exports = {escape: escape, cents: cents, requestItems: requestItems, appendItems: appendItems}; return; }
    function format(value) { return (value / 100).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}); }
    function showError(message) { swal('Proses gagal', message, 'error'); }
    function submit(form, data, action, detail) {
        if (form.data('payment-busy')) return;
        var enabled = form.find(':input').not(':disabled');
        form.data('payment-busy', true); enabled.prop('disabled', true);
        function release() { form.data('payment-busy', false); enabled.prop('disabled', false); }
        swal({title: 'Konfirmasi', text: detail, type: 'warning', showCancelButton: true, confirmButtonText: 'Ya, proses', cancelButtonText: 'Batal', closeOnConfirm: true}, function (yes) {
            if (!yes) { release(); return; }
            $.ajax({url: form.attr('data-base') + action, type: 'POST', data: data, dataType: 'json', processData: false, contentType: false,
                success: function (result) {
                    if (result && result.save === true) {
                        if (form.attr('data-back')) window.location.href = form.attr('data-base') + form.attr('data-back');
                        else window.location.reload();
                    } else { release(); showError(result && result.pesan || 'Data tidak dapat diproses.'); }
                },
                error: function () { release(); showError('Koneksi gagal. Isian tetap tersimpan; coba lagi.'); }
            });
        });
    }
    $(function () {
        var form = $('#payment-form');
        if (form.length && !form.data('payment-init')) {
            form.data('payment-init', true);
            form.on('click.requestPayment', 'a', function (event) { if (form.data('payment-busy')) event.preventDefault(); });
            var kind = form.attr('data-kind'), base = form.attr('data-base'), manage = form.attr('data-manage') === '1';
            var drafts = new Map(), table;
            function draft(row) {
                if (!drafts.has(row.key)) drafts.set(row.key, {tipe: row.tipe, ids: row.ids, version: row.version, tanggal: '', selected: false,
                    amount: cents(row.jumlah), keterangan: row.keterangan || '', bank_admin: row.bank_admin == null ? '0' : String(row.bank_admin), originalAdmin: cents(row.bank_admin), file: null, changed: false});
                return drafts.get(row.key);
            }
            function summary() {
                var count = kind === 'payment' ? Number(form.attr('data-count')) : 0;
                var total = kind === 'payment' ? cents(form.attr('data-total')) : 0, admin = kind === 'payment' ? cents(form.attr('data-admin')) : 0;
                drafts.forEach(function (d) {
                    if (kind === 'request' && d.selected) { count++; total += d.amount; }
                    if (kind === 'payment') admin += cents(d.bank_admin) - d.originalAdmin;
                });
                $('#payment-summary').text(count + ' data; total ' + format(total) + (kind === 'payment' ? '; administrasi terisi ' + format(admin) : ''));
                return count + ' data; total ' + format(total) + (kind === 'payment' ? '; administrasi terisi ' + format(admin) : '');
            }
            function cell(field, type, row) {
                if (type !== 'display') return row[field] == null ? '' : row[field];
                return escape(row[field]);
            }
            function textColumn(field) { return {data: field, render: function (value, type, row) { return cell(field, type, row); }}; }
            function amountColumn(field) { return {data: field, render: function (value, type) { return type === 'display' ? escape(format(cents(value))) : value; }}; }
            function input(row, field, type, value) {
                return '<input class="form-control input-sm" data-field="' + field + '" type="' + type + '" value="' + escape(value) + '" aria-label="' + escape(field + ' ' + row.no_doc) + '">';
            }
            var columns = [{data: 'no', orderable: false, searchable: false}];
            if (kind === 'jurnal') {
                ['no_reff', 'nomor', 'tanggal', 'keterangan'].forEach(function (field) { columns.push(textColumn(field)); });
                columns.push(amountColumn('total'), textColumn('stspos'), {data: null, orderable: false, searchable: false, render: function (r) {
                    return '<a class="btn btn-default btn-sm" href="' + escape(r.url) + '">View</a> ' + (manage && String(r.stspos) === '0' ? '<a class="btn btn-warning btn-sm" href="' + escape(r.edit_url) + '">Edit</a>' : '');
                }});
            } else {
                ['no_doc', 'nama', 'tgl_doc', 'keperluan', 'tipe'].forEach(function (field) { columns.push(textColumn(field)); });
                columns.push(amountColumn(kind === 'approval' ? 'nilai_request' : 'jumlah'));
                if (kind === 'approval') columns.push(amountColumn('jumlah'));
                if (kind === 'request') {
                    columns.push({data: null, orderable: false, searchable: false, render: function (r) { return manage ? input(r, 'tanggal', 'date', draft(r).tanggal) : ''; }},
                        {data: null, orderable: false, searchable: false, render: function (r) { return manage ? '<input type="checkbox" data-field="selected" aria-label="Pilih ' + escape(r.no_doc) + '" ' + (draft(r).selected ? 'checked' : '') + '>' : ''; }});
                } else if (kind === 'approval') {
                    columns.push(textColumn('tanggal'), {data: 'status', render: function (v) { return {'0': 'Open', '1': 'Partial Payment', '2': 'Full Payment'}[String(v)] || 'Undefined'; }},
                        {data: null, orderable: false, searchable: false, render: function (r) { return manage ? '<a class="btn btn-primary btn-sm" href="' + escape(r.url) + '">Process</a>' : ''; }});
                } else {
                    columns.push(textColumn('tanggal'));
                    ['keterangan', 'jumlah', 'bank_admin', 'file'].forEach(function (field) {
                        columns.push({data: null, orderable: false, searchable: false, render: function (r) {
                            if (field === 'jumlah') return escape(format(cents(r.jumlah)));
                            if (!manage) return field === 'file' ? '' : escape(r[field] || '');
                            var d = draft(r);
                            if (field === 'file') return input(r, 'file', 'file', '') + '<span class="payment-file-name">' + escape(d.file ? d.file.name : '') + '</span>';
                            return input(r, field, 'text', d[field]);
                        }});
                    });
                }
            }
            table = $('#payment-table').DataTable({processing: true, serverSide: true, scrollX: true, autoWidth: false, searchDelay: 350,
                pageLength: 10, lengthMenu: [10, 25, 50, 100], order: [], columns: columns,
                ajax: {url: base + 'data_' + kind, type: 'POST', data: function (data) {
                    data.batch_token = form.attr('data-token');
                    form.find('input[type="hidden"]').each(function () { if (this.name) data[this.name] = this.value; });
                }},
                drawCallback: function () {
                    if (kind !== 'approval') return;
                    var api = this.api(), last;
                    api.rows({page: 'current'}).every(function () {
                        var row = this.data();
                        if (row.tanggal !== last) { $('<tr class="payment-date-group"><td colspan="11"></td></tr>').find('td').text('Rencana Pembayaran Tanggal ' + (row.tanggal || '-')).end().insertBefore(this.node()); last = row.tanggal; }
                    });
                }});
            form.on('input.requestPayment change.requestPayment', '[data-field]', function () {
                var row = table.row($(this).closest('tr')).data(); if (!row) return;
                var d = draft(row), field = $(this).attr('data-field');
                d[field] = field === 'selected' ? this.checked : field === 'file' ? this.files[0] || null : this.value; d.changed = true;
                if (field === 'file') $(this).siblings('.payment-file-name').text(d.file ? d.file.name : '');
                try { summary(); } catch (error) { $('#payment-summary').text(error.message); }
            });
            form.on('submit.requestPayment', function (event) {
                event.preventDefault(); if (!manage || form.data('payment-busy')) return;
                try {
                    var data = new FormData(form[0]);
                    if (kind === 'request') data.append('items', JSON.stringify(requestItems(drafts)));
                    else {
                        data.append('batch_token', form.attr('data-token'));
                        var edits = {}, files = [];
                        drafts.forEach(function (d, id) {
                            if (d.changed) edits[id] = {keterangan: d.keterangan, bank_admin: d.bank_admin};
                            if (d.file) { data.append('doc_file_' + id, d.file); files.push(id); }
                        });
                        if (files.length > Number(form.attr('data-files-max'))) throw new Error('Maksimal ' + form.attr('data-files-max') + ' lampiran sesuai batas server.');
                        data.append('edits', JSON.stringify(edits)); data.append('files', JSON.stringify(files));
                    }
                    submit(form, data, kind === 'request' ? 'save_request' : 'save_payment', 'Proses ' + summary() + '?');
                } catch (error) { showError(error.message); }
            });
            $('#payment-export').on('click.requestPayment', function () {
                var params = table.ajax.params(), exportForm = $('<form method="post"></form>').attr('action', base + 'export_payment');
                function hidden(name, value) { $('<input type="hidden">').attr('name', name).val(value).appendTo(exportForm); }
                hidden('search[value]', params.search.value);
                params.order.forEach(function (order, i) { hidden('order[' + i + '][column]', order.column); hidden('order[' + i + '][dir]', order.dir); });
                form.find('input[type="hidden"]').each(function () { if (this.name) hidden(this.name, this.value); });
                exportForm.appendTo(document.body); exportForm[0].submit(); exportForm.remove();
            });
            if ($.fn.select2) form.find('.select2').select2();
            summary();
        }
        var detail = $('#payment-detail');
        if (detail.length && !detail.data('payment-init')) {
            detail.data('payment-init', true);
            detail.on('click.requestPayment', 'a', function (event) { if (detail.data('payment-busy')) event.preventDefault(); });
            detail.on('input.requestPayment', '[data-journal-debet],[data-journal-kredit]', function () {
                try {
                    ['debet', 'kredit'].forEach(function (field) { var total = 0; detail.find('[data-journal-' + field + ']').each(function () { total += cents(this.value); }); $('#journal-' + field).text(format(total)); });
                } catch (error) { showError(error.message); }
            });
            detail.on('submit.requestPayment', function (event) {
                event.preventDefault(); if (detail.data('payment-busy')) return;
                var data = new FormData(detail[0]);
                if (detail.attr('data-action') === 'save_approval') {
                    Array.from(data.keys()).forEach(function (key) { if (/^items\[/.test(key)) data.delete(key); });
                    var items = []; detail.find('input[type="checkbox"]:checked').each(function () { items.push({id: this.value}); });
                    if (!items.length) { showError('Pilih minimal satu detail.'); return; }
                    appendItems(data, items, 'items');
                }
                submit(detail, data, detail.attr('data-action'), 'Proses data ini?');
            });
        }
    });
}(typeof jQuery === 'undefined' ? null : jQuery, typeof window === 'undefined' ? null : window));
