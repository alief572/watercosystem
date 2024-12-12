<?php
$this->load->view('include/side_menu');
?>
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?php echo $title;?></h3>
		<div class="box-tool">
		<?php
			if($akses_menu['create']=='1'){
		?><div class="row">
			<div class="col-md-12">
				<div class="dropdown">
					<a class="btn btn-success" href="<?=base_url("invoice_np/data_form")?>">
						<i class="fa fa-plus">&nbsp;</i> New Invoice Non Product
					</a>
				</div>
			</div>
		  <?php
			}
		  ?>			
		</div>		
	</div>
	<!-- /.box-header -->
		<div class="box-body">
			<table class="table table-bordered table-striped" id="my-grid" width='100%'>
				<thead>
					<tr class='bg-blue'>
						<th class="text-center" width='4%'>#</th>
						<th class="text-center" width='8%'>No Invoice</th>
						<th class="text-center" width='8%'>Tgl Invoice</th>
						<th class="text-center" width='8%'>No Faktur</th>
						<th class="text-center">Keterangan</th>
						<th class="text-center">Customer</th>
						<th class="text-center" width='12%'>Total Invoice</th>
						<th class="text-center no-sort" width='16%'>Option</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	<!-- /.box-body -->
 </div>
  <!-- /.box -->
  <!-- modal -->
	<div class="modal fade" id="ModalView">
		<div class="modal-dialog"  style='width:80%; '>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="head_title"></h4>
					</div>
					<div class="modal-body" id="view">
					</div>
					<div class="modal-footer">
					<!--<button type="button" class="btn btn-primary">Save</button>-->
					<button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->
<?php $this->load->view('include/footer'); ?>
<script>
$(document).ready(function() {
    DataTables();
});

$(document).on('click', '.viewed', function(e) {
    window.location.href = base_url + active_controller + '/data_form/' + $(this).data('iddata') + '/view';
});

$(document).on('click', '.edited', function(e) {
    window.location.href = base_url + active_controller + '/data_form/' + $(this).data('iddata') + '/edit';
});

function DataTables() {
    var dataTable = $('#my-grid').DataTable({
        "serverSide": true,
        "stateSave": true,
        "autoWidth": false,
        "processing": true,
        "destroy": true,
        "responsive": true,
        "aaSorting": [
            [1, "desc"]
        ],
        "columnDefs": [{
            "targets": 'no-sort',
            "orderable": false,
        }],
        "sPaginationType": "simple_numbers",
        "iDisplayLength": 10,
        "aLengthMenu": [
            [10, 20, 50, 100, 150],
            [10, 20, 50, 100, 150]
        ],
        "ajax": {
            url: base_url + active_controller + '/server_side_data',
            type: "post",
            cache: false,
            error: function() {
                $(".my-grid-error").html("");
                $("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="7">No data found in the server</th></tr></tbody>');
                $("#my-grid_processing").css("display", "none");
            }
        }
    });
}

$(document).on('click', '.deleted', function() {
    var iddata = $(this).data('iddata');

    swal({
            title: "Are you sure?",
            text: "Delete this data ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Process it!",
            cancelButtonText: "No, cancel process!",
            closeOnConfirm: true,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                loading_spinner();
                $.ajax({
                    url: base_url + active_controller + '/delete_data/' + iddata,
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 1) {
                            swal({
                                title: "Delete Success!",
                                text: data.pesan,
                                type: "success",
                                timer: 5000
                            });
                            window.location.href = base_url + active_controller;
                        } else if (data.status == 0) {
                            swal({
                                title: "Delete Failed!",
                                text: data.pesan,
                                type: "warning",
                                timer: 5000
                            });
                        }
                    },
                    error: function() {
                        swal({
                            title: "Error Message !",
                            text: 'An Error Occured During Process. Please try again..',
                            type: "warning",
                            timer: 5000
                        });
                    }
                });
            } else {
                swal("Cancelled", "Data can be process again :)", "error");
                return false;
            }
        });
});

$(document).on('click', '.updated', function() {
    var iddata = $(this).data('iddata');

    swal({
            title: "Are you sure?",
            text: "Update this data ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Process it!",
            cancelButtonText: "No, cancel process!",
            closeOnConfirm: true,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                loading_spinner();
                $.ajax({
                    url: base_url + active_controller + '/update_data/' + iddata,
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 1) {
                            swal({
                                title: "Update Success!",
                                text: data.pesan,
                                type: "success",
                                timer: 5000
                            });
                            window.location.href = base_url + active_controller;
                        } else if (data.status == 0) {
                            swal({
                                title: "Update Failed!",
                                text: data.pesan,
                                type: "warning",
                                timer: 5000
                            });
                        }
                    },
                    error: function() {
                        swal({
                            title: "Error Message !",
                            text: 'An Error Occured During Process. Please try again..',
                            type: "warning",
                            timer: 5000
                        });
                    }
                });
            } else {
                swal("Cancelled", "Data can be process again :)", "error");
                return false;
            }
        });
});
</script>
