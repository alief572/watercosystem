<?php
$ENABLE_ADD     = has_permission('SO_Invoice_Indent.Add');
$ENABLE_MANAGE  = has_permission('SO_Invoice_Indent.Manage');
$ENABLE_VIEW    = has_permission('SO_Invoice_Indent.View');
$ENABLE_DELETE  = has_permission('SO_Invoice_Indent.Delete');

?>
<style type="text/css">
    thead input {
        width: 100%;
    }
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">

<div class="box">
    <div class="box-header">


        <span class="pull-right">
        </span>
    </div>
    <!-- /.box-header -->
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example5" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th width="10%">No.SO</th>
                    <th>Nama Customer</th>
                    <th>Marketing</th>
                    <th>Nilai<br>Penawaran</th>
                    <th>Nilai<br>SO</th>
                    <th width="5%">Persentase</th>
                    <th width="5%">View PO</th>
                    <th width="5%">View Penawaran Deal</th>
                    <th width="5%">Created By</th>
                    <th width="5%">Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>

<!-- awal untuk modal dialog -->
<!-- Modal -->
<div class="modal modal-primary" id="dialog-rekap" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><span class="fa fa-file-pdf-o"></span>&nbsp;Rekap Data Customer</h4>
            </div>
            <div class="modal-body" id="MyModalBody">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-default fade" id="dialog-popup" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Data Penawaran</h4>
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

<!-- modal -->
<div class="modal modal-default fade" id="ModalViewX" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id='head_title'>Closing Penawaran</h4>
            </div>
            <div class="modal-body" id="viewX">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id='close_penawaran'>Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

<!-- page script -->
<script type="text/javascript">
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

    $(document).on('click', '.reddeliv', function() {
        var no_so = $(this).data('no_so')

        swal({
            type: 'warning',
            title: 'Are you sure ?',
            text: 'This data status will be updated !',
            showCancelButton: true
        }, function(next) {
            if (next) {
                $.ajax({
                    type: 'post',
                    url: siteurl + active_controller + 'reddeliv',
                    data: {
                        'no_so': no_so
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(result) {
                        if (result.status == '1') {
                            swal({
                                type: 'success',
                                title: 'Success !',
                                text: result.msg
                            }, function(lanjut) {
                                DataTables()
                            });
                        } else {
                            swal({
                                type: 'warning',
                                title: 'Failed !',
                                text: result.msg
                            });
                        }
                    },
                    error: function(result) {
                        swal({
                            type: 'error',
                            title: 'Error !',
                            text: 'Please try again later !'
                        });
                    }
                });
            }
        });
    });

    $(function() {
        DataTables();
        $("#form-area").hide();
    });

    function DataTables() {
        var DataTables = $('#example5').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: 'post',
                url: siteurl + active_controller + 'get_so_indent',
                data: function(d) {

                }
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'no_so'
                },
                {
                    data: 'nm_customer'
                },
                {
                    data: 'marketing'
                },
                {
                    data: 'nilai_penawaran'
                },
                {
                    data: 'nilai_so'
                },
                {
                    data: 'persentase'
                },
                {
                    data: 'view_po'
                },
                {
                    data: 'view_penawaran_deal'
                },
                {
                    data: 'created_by'
                },
                {
                    data: 'status'
                },
                {
                    data: 'option'
                }
            ]
        });
    }
</script>