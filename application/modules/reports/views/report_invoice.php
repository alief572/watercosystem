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

	<form method="post" action="<?= base_url() ?>reports/tampilkan_invoice" autocomplete="off">
		<div class="row">
			<div class="col-sm-10">
				<div class="col-sm-2">
					<div class="form-group">
						<br>
						<label>From</label>
						<input type="date" name="tanggal" id="tanggal" class="form-control input-sm">
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
						<button type="button" class="btn btn-sm btn-success search"><i class="fa fa-search"></i> Search</button>
						<button type="button" class="btn btn-sm btn-danger clearing"><i class="fa fa-refresh"></i> Clear</button>
					</div>
				</div>
			</div>
		</div>


	</form>
	<!-- /.box-header -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example2" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>No.Invoice</th>
					<th>Nama Customer</th>
					<th>Marketing</th>
					<th>Top</th>
					<th>Payment</th>
					<th>Nilai<br>DPP</th>
					<th>Nilai<br>Invoice</th>
					<th>Tanggal<br>Invoice</th>
				</tr>
			</thead>

			<tbody>
				
			</tbody>
			<tfoot>
				<tr>
					<th></th>
					<th colspan="5" class="text-right">Total</th>
					<th class="text-right totaldppformat"></th>
					<th class="text-right totalformat"></th>
					<th></th>
				</tr>
			</tfoot>
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
		// DataTables();
	});


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

	$(document).on('click', '.search', function() {
		DataTables();
	})
	$(document).on('click', '.clearing', function() {
		$('#tanggal').val('');
		$('#tanggal_to').val('');

		DataTables();
	})

	$(function() {
		// $('#example1 thead tr').clone(true).appendTo( '#example1 thead' );
		// $('#example1 thead tr:eq(1) th').each( function (i) {
		// var title = $(this).text();
		//alert(title);
		// if (title == "#" || title =="Action" ) {
		// $(this).html( '' );
		// }else{
		// $(this).html( '<input type="text" />' );
		// }

		// $( 'input', this ).on( 'keyup change', function () {
		// if ( table.column(i).search() !== this.value ) {
		// table
		// .column(i)
		// .search( this.value )
		// .draw();
		// }else{
		// table
		// .column(i)
		// .search( this.value )
		// .draw();
		// }
		// } );
		// } );


		$("#form-area").hide();
	});


	//Delete
	
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
		var tanggal = $('#tanggal').val();
		var tanggal_to = $('#tanggal_to').val();



		var datatables = $('#example2').DataTable().destroy();
		var datatables = $('#example2').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				type: 'post',
				url: siteurl + active_controller + 'get_report_invoice',
				data: function(d) {
					d.tanggal = tanggal;
					d.tanggal_to = tanggal_to;
				},
				dataSrc: function(result) {
					$('.totaldppformat').text(number_format(result.totaldppformat, 2));
					$('.totalformat').text(number_format(result.totalformat, 2));

					return result.data;
				}
			},
			columns: [
				{
					data: 'no'
				},
				{
					data: 'no_invoice'
				},
				{
					data: 'nama_customer'
				},
				{
					data: 'marketing'
				},
				{
					data: 'top'
				},
				{
					data: 'payment'
				},
				{
					data: 'nilai_dpp'
				},
				{
					data: 'nilai_invoice'
				},
				{
					data: 'tanggal_invoice'
				}
			]
		});
	}
</script>