<?php
$ENABLE_ADD     = has_permission('Report_Mutasi_Stock.Add');
$ENABLE_MANAGE  = has_permission('Report_Mutasi_Stock.Manage');
$ENABLE_VIEW    = has_permission('Report_Mutasi_Stock.View');
$ENABLE_DELETE  = has_permission('Report_Mutasi_Stock.Delete');

?>
<style type="text/css">
    thead input {
        width: 100%;
    }
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="box">
    <div class="box-header">
        <div class="row">
            <div class="col-sm-10">

                <div class="col-sm-2">
                    <br>
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="date" name="tgl" id="" class="form-control form-control-sm" max="<?= date('Y-m-d') ?>">
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <br>
                        <label> &nbsp;</label><br>
                        <input type="button" name="" value="Tampilkan" class="btn btn-sm btn-primary pull-center tampilkan">
                        <button type="button" class="btn btn-sm btn-danger reset_search" title="Reset Search">Reset</button>
                        <button type="button" class="btn btn-sm btn-success export_excel" title="Export Excel">Export Excel</button>
                        <!-- <input type="button" name="" value="Export Excel" class="btn btn-sm btn-primary pull-center export_excel"> &nbsp;
							<input type="button" name="" value="Bersihkan" class="btn btn-sm btn-danger pull-center bersihkan"> &nbsp; -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.box-header -->
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Tgl</th>
                    <th class="text-center">Nomor</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Costbook</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" class="text-center">Grand Total</th>
                    <th class="text-right ttl_total">0</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.box-body -->
</div>


<div class="modal modal-default fade" id="dialog-popup" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90% !important">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" id="ModalView">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> Close</button>
            </div>
        </div>
    </div>
</div>


<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>


<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- page script -->
<script type="text/javascript">
    $(document).ready(function() {
        DataTables();

        $('#product_name').select2({
            width: '100%'
        });
    });

    $(document).on('click', '.tampilkan', function() {
        DataTables();
    })

    $(document).on('click', '.reset_search', function() {
        $('input[name="tgl"]').val('');

        DataTables();
    })

    $(document).on('click', '.export_excel', function() {
        var tgl = $('input[name="tgl"]').val();

        window.open(siteurl + active_controller + 'export_excel/?tgl=' + tgl);
    });

    $(document).on('click', '.export_excel_detail', function() {
        var tgl = $(this).data('tgl');
        var id_category3 = $(this).data('id_category3');

        window.open(siteurl + active_controller + 'export_excel_detail/?tgl=' + tgl + '&id_category3=' + id_category3);
    });

    $(document).on('click', '.detail', function() {
        var id_category3 = $(this).data('id_category3');
        var tgl = $('input[name="tgl"]').val();

        $.ajax({
            type: 'post',
            url: siteurl + active_controller + 'detail_mutasi',
            data: {
                'id_category3': id_category3,
                'tgl': tgl
            },
            cache: false,
            success: function(result) {
                $('#myModalLabel').html('<i class="fa fa-list"></i> List Mutasi Stock');
                $('#ModalView').html(result);

                $('#dialog-popup').modal('show');
            },
            error: function(result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error !',
                    text: 'Please try again later !',
                    showConfirmButton: false,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    timer: 3000
                });
            }
        });
    })

    function number_format(number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    function DataTables() {
        var tgl = $('input[name="tgl"]').val();

        $('#example2').DataTable({
            ajax: {
                url: siteurl + active_controller + 'get_data_report_mutasi_stock',
                type: "POST",
                dataType: "JSON",
                data: function(d) {
                    d.tgl = tgl;
                },
                dataSrc: function(response) {
                    ttl_total = response.ttl_total;

                    return response.data;
                }
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'tgl'
                },
                {
                    data: 'nomor'
                },
                {
                    data: 'nama_barang'
                },
                {
                    data: 'qty'
                },
                {
                    data: 'costbook'
                },
                {
                    data: 'total'
                },
                {
                    data: 'action'
                }
            ],
            responsive: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            destroy: true,
            paging: true,
            lengthMenu: [10, 50, 100, 200, 500, 1000],
            footerCallback: function(row, data, start, end, display) {
                // Tidak perlu lagi menghitung ttl_total di sini karena sudah ada dari backend
                var api = this.api();


                // Update footer dengan ttl_total dari backend
                $(api.column(6).footer()).html(number_format(ttl_total)); // Tampilkan ttl_total di footer
            }
        });
    }



    $(document).on('click', '.edit', function(e) {
        var id = $(this).data('no_penawaran');
        $("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
        $.ajax({
            type: 'POST',
            url: siteurl + 'wt_penawaran/editPenawaran/' + id,
            success: function(data) {
                $("#dialog-popup").modal();
                $("#ModalView").html(data);

            }
        })
    });

    $(document).on('click', '.cetak', function(e) {
        var id = $(this).data('no_penawaran');
        $("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
        $.ajax({
            type: 'POST',
            url: siteurl + 'xtes/cetak' + id,
            success: function(data) {

            }
        })
    });

    $(document).on('click', '.view', function() {
        var id = $(this).data('no_penawaran');
        // alert(id);
        $("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Inventory</b>");
        $.ajax({
            type: 'POST',
            url: siteurl + 'penawaran/ViewHeader/' + id,
            data: {
                'id': id
            },
            success: function(data) {
                $("#dialog-popup").modal();
                $("#ModalView").html(data);

            }
        })
    });



    // CLOSE PENAWARAN
    $(document).on('click', '.close_penawaran', function(e) {
        e.preventDefault();
        var id = $(this).data('no_penawaran');

        $("#head_title").html("Closing Penawaran");
        $.ajax({
            type: 'POST',
            url: base_url + active_controller + '/modal_closing_penawaran/' + id,
            success: function(data) {
                $("#ModalViewX").modal();
                $("#viewX").html(data);

            },
            error: function() {
                swal({
                    title: "Error Message !",
                    text: 'Connection Timed Out ...',
                    type: "warning",
                    timer: 5000,
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
            }
        });
    });

    $(function() {

        $("#form-area").hide();
    });


    //Delete

    function PreviewPdf(id) {
        param = id;
        tujuan = 'customer/print_request/' + param;

        $(".modal-body").html('<iframe src="' + tujuan + '" frameborder="no" width="570" height="400"></iframe>');
    }

    function PreviewRekap() {
        tujuan = 'customer/rekap_pdf';
        $(".modal-body").html('<iframe src="' + tujuan + '" frameborder="no" width="100%" height="400"></iframe>');
    }
</script>