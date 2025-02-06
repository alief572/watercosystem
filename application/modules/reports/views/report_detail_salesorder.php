<?php
$ENABLE_ADD     = has_permission('Management.Add');
$ENABLE_MANAGE  = has_permission('Management.Manage');
$ENABLE_VIEW    = has_permission('Management.View');
$ENABLE_DELETE  = has_permission('Management.Delete');

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
		<form method="post" action="<?= base_url() ?>reports/tampilkan_detail_salesorder" autocomplete="off">
			<div class="row">
				<div class="col-sm-10">

					<div class="col-sm-2">
						<div class="form-group">
							<br>
							<label>From</label>
							<input type="date" name="tanggal" id="tanggal" class="form-control input-sm">
						</div>
					</div>
					<div class="col-sm-1 text-center">
						<div class="form-group">
							<br><br>
							<span>S/D</span>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<br>
							<label>To</label>
							<input type="date" name="tanggal_to" id="tanggal_to" class="form-control input-sm">
						</div>
					</div>
					<div class="col-sm-5">
						<div class="form-group">
							<br>
							<label> &nbsp;</label><br>
							<input type="button" name="" value="Tampilkan" class="btn btn-sm btn-success pull-center tampilkan"> &nbsp;
							<input type="button" name="" value="Bersihkan" class="btn btn-sm btn-danger pull-center bersihkan"> &nbsp;
						</div>
					</div>
				</div>
			</div>


		</form>

		<span class="pull-right">
		</span>
	</div>

	<!-- /.box-header -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example2" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th width="10%">Tgl.SO</th>
					<th width="10%">No.SO</th>
					<th width="10%">No.Invoice</th>
					<th width="10%">Customer</th>
					<th>Nama Produk</th>
					<th width="10%">Qty SO</th>
					<th>Harga<br>Pricelist</th>
					<th>Harga<br>Total</th>
					<th>Diskon</th>
					<th>Harga<br>Nett</th>

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


<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<!-- page script -->
<script type="text/javascript">
	$(document).ready(function() {
		DataTables();
	});

	$(document).on('click', '.tampilkan', function() {
		DataTables();
	})

	$(document).on('click', '.bersihkan', function() {
		$('#tanggal').val('');
		$('#tanggal_to').val('');

		DataTables();
	});

	function DataTables() {
		var tanggal = $('#tanggal').val();
		var tanggal_to = $('#tanggal_to').val();

		$('#example2').DataTable({
			ajax: {
				url: siteurl + active_controller + 'get_data_report_detail_sales_order',
				type: "POST",
				dataType: "JSON",
				data: function(d) {
					d.tanggal = tanggal;
					d.tanggal_to = tanggal_to;
				}
			},
			columns: [{
					data: 'no',
				}, {
					data: 'tgl_so'
				},
				{
					data: 'no_surat'
				},
				{
					data: 'no_invoice'
				},
				{
					data: 'nm_customer'
				},
				{
					data: 'nama_produk'
				},
				{
					data: 'qty_so'
				},
				{
					data: 'harga_pricelist'
				},
				{
					data: 'harga_total'
				},
				{
					data: 'diskon'
				},
				{
					data: 'harga_nett'
				}
			],
			responsive: true,
			processing: true,
			serverSide: true,
			stateSave: true,
			destroy: true,
			paging: true
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