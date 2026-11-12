function poRound(value) {
    var parts = String(value).split('e');
    var shifted = Math.round(Number(parts[0] + 'e' + ((Number(parts[1]) || 0) + 2)));
    parts = String(shifted).split('e');
    return Number(parts[0] + 'e' + ((Number(parts[1]) || 0) - 2));
}

function poNumber(value) {
    return Number(String(value || '0').replace(/,/g, ''));
}

function poLine(row, rate) {
    if (row.taxable && (rate === null || !isFinite(rate) || rate < 0)) throw new Error('Tarif PPN belum tersedia.');
    var goods = poRound(row.qty * poRound(row.price));
    var tax = row.taxable ? poRound(goods * rate / 100) : 0;
    if (row.savedTax !== undefined) tax = row.savedTax;
    return {goods: goods, tax: tax, discount: poRound(goods * poRound(row.discount) / 100), fee: poRound(row.fee)};
}

function poTotals(lines, shipping) {
    var result = {goods: 0, tax: 0, discount: 0, fee: 0};
    lines.forEach(function (line) {
        ['goods', 'tax', 'discount', 'fee'].forEach(function (key) { result[key] += line[key]; });
    });
    result.total = poRound(result.goods - result.discount + result.tax + result.fee + poRound(shipping));
    return result;
}

function poFormat(value) {
    return Number(value).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function poRecalculate() {
    var lines = [], form = $('#data-form');
    var rateValue = form.attr('data-ppn-rate');
    var rate = rateValue === '' || rateValue === undefined ? null : Number(rateValue);
    form.find('[name$="[idpr]"]').each(function () {
        var row = $(this).closest('tr');
        function field(name) { return row.find('[name$="[' + name + ']"]'); }
        function number(name) { return poNumber(field(name).val()); }
        var taxField = field('nilai_ppn'), choice = field('ppn');
        var taxable = choice.length ? choice.val() === 'Y' : poNumber(taxField.val()) > 0;
        var input = {qty: number('qty'), price: number('hargasatuan'), discount: number('diskon'), fee: number('pajak'), taxable: taxable};
        if (taxField.attr('data-original-qty') !== undefined && input.qty === poNumber(taxField.attr('data-original-qty'))
            && poRound(input.price) === poNumber(taxField.attr('data-original-price'))
            && taxable === (poNumber(taxField.attr('data-original-tax')) > 0)) {
            input.savedTax = poNumber(taxField.attr('data-original-tax'));
        }
        var line = poLine(input, input.savedTax !== undefined ? 0 : rate);
        field('jumlahharga').val(poFormat(line.goods));
        taxField.val(poFormat(line.tax));
        field('totalharga').val(poFormat(line.goods + line.tax));
        lines.push(line);
    });
    var shipping = $('#kirim').length ? poNumber($('#kirim').val()) : poNumber($('#taxtotal').val());
    var totals = poTotals(lines, shipping);
    $('#hargatotal').val(poFormat(totals.goods));
    $('#totalppn').val(poFormat(totals.tax));
    $('#diskontotal').val(poFormat(totals.discount));
    $('#taxtotal').val(poFormat(form.attr('data-po-direct') ? totals.fee : shipping));
    $('#subtotal').val(poFormat(totals.total));
    return totals;
}

function HitAmmount() { return poRecalculate(); }
function CariPPN() { return poRecalculate(); }
function SumDel() { return poRecalculate(); }
function TotalSemua() { return poRecalculate(); }
function cariTotal() { return poRecalculate(); }

$(document).ready(function () {
    var form = $('#data-form'), saving = false;
    function recalculate() {
        try { poRecalculate(); return true; }
        catch (error) { swal('Warning', error.message, 'error'); return false; }
    }
    function expectedDate() {
        var ids = form.find('[name$="[idpr]"]').map(function () { return this.value; }).get();
        if (!ids.length) { $('#expect_tanggal').val(''); return; }
        $.ajax({url: siteurl + 'purchase_order/getDateExp', type: 'POST', data: {id_pr: ids}, dataType: 'json',
            success: function (data) {
                var current = form.find('[name$="[idpr]"]').map(function () { return this.value; }).get();
                if (ids.join(';') === current.join(';')) $('#expect_tanggal').val(data.minimal);
            }
        });
    }
    recalculate();
    if (!form.attr('data-po-edit')) expectedDate();
    form.on('input.po change.po', '[name^="dt["], #kirim', recalculate);
    form.on('click.po', '.hapus_baris', function () { $(this).closest('tr').remove(); recalculate(); expectedDate(); });
    $(document).ajaxComplete(function (event, xhr, settings) {
        if (settings.url.indexOf('purchase_order/AddMaterial') !== -1) recalculate();
    });
    $('#simpan-com').off('click').on('click.po', function (event) { event.preventDefault(); form.trigger('submit'); });
    form.off('submit').on('submit.po', function (event) {
        event.preventDefault();
        if (saving || !recalculate()) return;
        if (!form.find('[name$="[idpr]"]').length) { swal('Warning', 'Detail PO tidak boleh kosong.', 'error'); return; }
        saving = true; $('#simpan-com').prop('disabled', true);
        function release() { saving = false; $('#simpan-com').prop('disabled', false); }
        swal({title: 'Are you sure?', text: 'Simpan Purchase Order?', type: 'warning', showCancelButton: true,
            confirmButtonText: 'Yes, Process it!', closeOnConfirm: true}, function (confirmed) {
            if (!confirmed) { release(); return; }
            $.ajax({url: siteurl + 'purchase_order/' + (form.attr('data-po-edit') ? 'SaveEdit' : 'SaveNew'),
                type: 'POST', data: new FormData(form[0]), processData: false, contentType: false, dataType: 'json',
                success: function (data) {
                    if (data.status === 1) { window.location.href = siteurl + 'purchase_order'; return; }
                    release(); swal('Save Failed', data.pesan, 'warning');
                },
                error: function () { release(); swal('Save Failed', 'Koneksi gagal. Silakan coba lagi.', 'warning'); }
            });
        });
    });
});
