<?php
$ENABLE_ADD     = has_permission('Jurnal_Adjustment.Add');
$ENABLE_MANAGE  = has_permission('Jurnal_Adjustment.Manage');
$ENABLE_VIEW    = has_permission('Jurnal_Adjustment.View');
$ENABLE_DELETE  = has_permission('Jurnal_Adjustment.Delete');
$id_bentuk = $this->uri->segment(3);
?>
<style type="text/css">
    thead input {
        width: 100%;
    }
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">

<div class="nav-tabs-supplier">

</div>

<div class="tab-content">
    <div class="tab-pane active" id="history">
        <div class="box">

            <div class="box-body">
                <table id="exampleaa" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">No. Transaksi</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Material</th>
                            <th class="text-center">Adjust</th>
                            <th class="text-center">Gudang</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Jumlah Stock</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

</div>
<!-- awal untuk modal dialog -->
<!-- Modal -->

<div class="modal modal-default fade" id="dialog-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-file"></i> Jurnal Adjustment</h4>
            </div>
            <form action="" id="frm-jurnal">
                <div class="modal-body" id="ModalView">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> Close
                    </button>
                    <button type="submit" class="btn btn-sm btn-success" title="Save Jurnal"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- page script -->
<script type="text/javascript">
    $(document).ready(function() {
        initAdjustmentDataTable();
    });

    $(document).on('click', '.process_jurnal', function() {
        var id_transaksi = $(this).data('id_transaksi');

        $.ajax({
            type: 'get',
            url: siteurl + active_controller + 'process_jurnal',
            data: {
                'id_transaksi': id_transaksi
            },
            cache: false,
            success: function(result) {
                $('#ModalView').html(result);

                $('#dialog-popup').modal('show');
            },
            error: function(xhr, status, error) {

            }
        });
    });

    $(document).on('submit', '#frm-jurnal', function(e) {
        e.preventDefault();

        Swal.fire({
            icon: 'warning',
            title: 'Anda yakin ?',
            text: 'Data jurnal adjustment akan masuk ke Tras dan tidak bisa di revisi !',
            showConfirmButton: true,
            showCancelButton: true,
            allowEscapeKey: false,
            allowOutsideClick: false
        }).then((next) => {
            if (next.isConfirmed) {
                var formdata = $('#frm-jurnal').serialize();

                $.ajax({
                    type: 'post',
                    url: siteurl + active_controller + 'save_post_jurnal_adjustment',
                    data: formdata,
                    cache: false,
                    dataType: 'json',
                    success: function(result) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success !',
                            text: 'Selamat! Jurnal adjustment sudah berhasil masuk ke TRAS !',
                            showConfirmButton: false,
                            showCancelButton: false,
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 3000
                        }).then(() => {
                            Swal.close();
                            $('#dialog-popup').modal('hide');
                            initAdjustmentDataTable();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !',
                            text: 'Maaf, Silahkan dicoba kembali proses posting jurnal Adjustment nya !',
                            showConfirmButton: false,
                            showCancelButton: false,
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 3000
                        });
                    }
                });
            }
        });
    })

    function initAdjustmentDataTable() {
        const $table = $('#exampleaa');

        // Hancurkan instance lama jika ada (mencegah memory leak/duplicate re-init)
        if ($.fn.DataTable.isDataTable($table)) {
            $table.DataTable().destroy();
        }

        return $table.DataTable({
            // 1. Core Settings
            serverSide: true,
            processing: false,
            paging: true,
            stateSave: true,
            autoWidth: false, // Disarankan false agar CSS lebih terkontrol
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],

            // 2. Data Fetching
            ajax: {
                url: `${siteurl}${active_controller}get_dataa_adjustment`,
                type: 'GET',
                dataType: 'json',
                // Tambahkan error handling dasar agar tidak "silent error"
                error: (xhr, error, code) => {
                    console.error("DataTables Ajax Error:", error, code);
                }
            },

            // 3. Column Definitions
            // Menggunakan columnDefs seringkali lebih rapi jika ada format khusus
            columns: [{
                    data: 'no',
                    orderable: false,
                    searchPrompt: false
                },
                {
                    data: 'no_transaksi'
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'material'
                },
                {
                    data: 'tipe_adjust'
                },
                {
                    data: 'gudang'
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'jumlah_stock',
                    className: 'text-right', // Biasanya angka diratakan kanan
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ],

            // 4. Language/UI Customization (Opsional agar lebih user-friendly)
            language: {
                processing: 'Loading...',
                searchPlaceholder: "Cari transaksi..."
            }
        });
    }
</script>