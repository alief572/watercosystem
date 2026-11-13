(function ($) {
    'use strict';

    function amount(value) {
        if (!/^(?:[0-9]+|[0-9]{1,3}(?:,[0-9]{3})+)(?:\.[0-9]{1,2})?$/.test(String(value))) return NaN;
        var number = Number(String(value).replace(/,/g, ''));
        return Number.isFinite(number) ? number : NaN;
    }

    $(function () {
        $('[data-payment-list]').each(function () {
            $(this).DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                fixedHeader: true,
                scrollX: true,
                searchDelay: 350,
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [],
                ajax: {url: $(this).attr('data-url'), type: 'GET'},
                columns: [
                    {data: 'number', orderable: false, searchable: false},
                    {data: 'id_incoming'},
                    {data: 'tanggal'},
                    {data: 'supplier'},
                    {data: 'hutang_usd', className: 'text-right'},
                    {data: 'kurs', className: 'text-right'},
                    {data: 'hutang_idr', className: 'text-right'},
                    {data: 'action', orderable: false, searchable: false}
                ],
                language: {processing: 'Memuat data pembayaran PO...'}
            });
        });

        var form = $('#data-form[data-payment-action]');
        if (!form.length) return;
        var busy = false;
        form.on('blur', '#total_bayar, #nominal_kurs', function () {
            var value = amount(this.value);
            if (Number.isFinite(value)) this.value = value.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        });
        form.on('submit', function (event) {
            event.preventDefault();
            if (busy) return;
            var submitter = event.originalEvent && event.originalEvent.submitter;
            var action = $(submitter).attr('data-payment-action') || form.attr('data-payment-action');
            var request = action === 'SaveRequest';
            var payment = action === 'SavePembayaran';
            var date = form.find(request ? '#tanggal_request' : '#tanggal_bayar').val();
            if ((request || payment) && !/^\d{4}-\d{2}-\d{2}$/.test(date || '')) {
                swal('Validasi', 'Tanggal wajib diisi.', 'error'); return;
            }
            if ((request || payment) && (!(amount(form.find('#total_bayar').val()) > 0)
                || (String(form.find('#matauang').val()).toLowerCase() === 'usd' && !(amount(form.find('#nominal_kurs').val()) > 0)))) {
                swal('Validasi', 'Nominal dan kurs harus positif, maksimal dua desimal.', 'error'); return;
            }
            if (payment && !form.find('#bank').val()) {
                swal('Validasi', 'Bank wajib dipilih.', 'error'); return;
            }
            busy = true;
            var buttons = form.find(':submit');
            buttons.prop('disabled', true);
            function release() { busy = false; buttons.prop('disabled', false); }
            swal({
                title: 'Konfirmasi',
                text: action === 'SaveReject' ? 'Tolak request pembayaran ini?' : 'Proses data pembayaran ini?',
                type: 'warning', showCancelButton: true,
                confirmButtonText: 'Ya, proses', cancelButtonText: 'Batal', closeOnConfirm: true
            }, function (confirmed) {
                if (!confirmed) { release(); return; }
                $.ajax({
                    url: form.attr('data-payment-base') + action,
                    type: 'POST', data: new FormData(form[0]),
                    dataType: 'json', processData: false, contentType: false,
                    success: function (data) {
                        if (data.status === 1) {
                            window.location.href = form.attr('data-payment-base');
                        } else {
                            release();
                            swal('Proses gagal', data.pesan || 'Data tidak dapat diproses.', 'error');
                        }
                    },
                    error: function () {
                        release();
                        swal('Proses gagal', 'Koneksi gagal. Silakan coba lagi.', 'error');
                    }
                });
            });
        });
    });
}(jQuery));
