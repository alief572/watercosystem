<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">
<div class="box"><div class="box-body">
    <div id="jurnal-error" class="alert alert-danger" role="alert" hidden></div>
    <div class="table-responsive">
        <table id="exampleaa" class="table table-bordered table-striped">
            <thead><tr><th>#</th><th>No. Transaksi</th><th>Tanggal</th><th>Material</th><th>Adjust</th><th>Gudang</th><th>Keterangan</th><th>Jumlah Stock</th><th>Action</th></tr></thead>
            <tbody></tbody>
        </table>
    </div>
</div></div>
<div class="modal modal-default fade" id="dialog-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"><div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-file"></i> Jurnal Adjustment</h4>
        </div>
        <form id="frm-jurnal" method="post">
            <div class="modal-body" id="ModalView"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                <?php if (has_permission('Jurnal_Adjustment.Manage')): ?>
                <button type="submit" class="btn btn-sm btn-success" title="Save Jurnal" disabled><i class="fa fa-save"></i> Save</button>
                <?php endif; ?>
            </div>
        </form>
    </div></div>
</div>
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let journalBusy = false;
    let journalPreviewReady = false;
    let journalPreviewRequest = 0;
    let adjustmentTable;

    function journalError(xhr) {
        return xhr && xhr.responseJSON && xhr.responseJSON.msg ? xhr.responseJSON.msg : 'Request gagal. Periksa status adjustment sebelum mencoba kembali.';
    }

    $(document).ready(function() {
        adjustmentTable = $('#exampleaa').DataTable({
            serverSide: true, processing: true, stateSave: true, autoWidth: false,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
            ajax: {
                url: siteurl + active_controller + 'get_dataa_adjustment', type: 'GET', dataType: 'json',
                error: function(xhr) { $('#jurnal-error').text(journalError(xhr)).prop('hidden', false); }
            },
            columns: [
                {data: 'no', orderable: false}, {data: 'no_transaksi'}, {data: 'tanggal'},
                {data: 'material'}, {data: 'tipe_adjust'}, {data: 'gudang'}, {data: 'keterangan'},
                {data: 'jumlah_stock', className: 'text-right'}, {data: 'action', orderable: false, searchable: false}
            ],
            language: {processing: 'Loading...', searchPlaceholder: 'Cari transaksi...'}
        });
    });

    $(document).on('click', '.process_jurnal', function() {
        if (journalBusy) return;
        const request = ++journalPreviewRequest;
        journalPreviewReady = false;
        $('#frm-jurnal :submit').prop('disabled', true);
        $('#ModalView').empty();
        $('#jurnal-error').prop('hidden', true);
        $.ajax({
            type: 'GET', url: siteurl + active_controller + 'process_jurnal',
            data: {id_transaksi: $(this).attr('data-id_transaksi')}, cache: false, dataType: 'html'
        }).done(function(html) {
            if (request !== journalPreviewRequest) return;
            $('#ModalView').html(html);
            journalPreviewReady = $('#frm-jurnal input[name="preview_token"]').length === 1;
            $('#frm-jurnal :submit').prop('disabled', !journalPreviewReady);
            $('#dialog-popup').modal('show');
        }).fail(function(xhr) {
            if (request !== journalPreviewRequest) return;
            let message = journalError(xhr);
            if (xhr.responseText) {
                try { message = JSON.parse(xhr.responseText).msg || message; } catch (_) {}
            }
            $('#jurnal-error').text(message).prop('hidden', false);
        });
    });

    $(document).on('submit', '#frm-jurnal', async function(event) {
        event.preventDefault();
        if (journalBusy || !journalPreviewReady) return;
        journalBusy = true;
        $('#frm-jurnal :submit').prop('disabled', true);
        const decision = await Swal.fire({
            icon: 'warning', title: 'Posting jurnal adjustment?',
            text: 'Jurnal masuk ke TRAS dan tidak bisa direvisi melalui modul ini.',
            showCancelButton: true, allowEscapeKey: false, allowOutsideClick: false
        });
        if (!decision.isConfirmed) {
            journalBusy = false;
            $('#frm-jurnal :submit').prop('disabled', !journalPreviewReady);
            return;
        }
        $.ajax({
            type: 'POST', url: siteurl + active_controller + 'save_post_jurnal_adjustment',
            data: $('#frm-jurnal').serialize(), cache: false, dataType: 'json'
        }).done(function(result) {
            if (!result || result.code !== 200) {
                journalPreviewReady = false;
                Swal.fire({icon: 'error', title: 'Posting ditolak', text: result && result.msg ? result.msg : 'Respons posting tidak valid. Buka preview ulang.'});
                return;
            }
            journalPreviewReady = false;
            $('#dialog-popup').modal('hide');
            adjustmentTable.ajax.reload(null, false);
            Swal.fire({icon: 'success', title: 'Posting berhasil', text: result.msg + ' Nomor: ' + result.nomor});
        }).fail(function(xhr) {
            journalPreviewReady = false;
            Swal.fire({icon: 'error', title: 'Posting belum berhasil', text: journalError(xhr) + ' Buka preview ulang sebelum mencoba kembali.'});
        }).always(function() {
            journalBusy = false;
            $('#frm-jurnal :submit').prop('disabled', !journalPreviewReady);
        });
    });
</script>
