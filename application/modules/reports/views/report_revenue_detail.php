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

	.modal-dialog {
		/* new custom width */
		width: 85%;
	}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">

<div class="box">
	<div class="row">
		<div class="col-sm-10">
			<div class="col-sm-2">
				<div class="form-group">
					<br>
					<label>Dari</label>
					<input type="date" name="tanggal" id="tanggal" class="form-control input-sm">
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<br>
					<label>Sampai</label>
					<input type="date" name="tanggal_to" id="tanggal_to" class="form-control input-sm">
				</div>
			</div>
			<div class="col-sm-5">
				<div class="form-group">
					<br>
					<label> &nbsp;</label><br>
					<button type="button" onclick="tampilkan()" class="btn btn-sm btn-primary">Tampilkan</button> &nbsp;
					<button type="button" class="btn btn-sm btn-danger clearing">Clear</button> &nbsp;
					<button type="button" class="btn btn-sm btn-success export_excel">Export</button>
				</div>
			</div>
		</div>
	</div>

	<div class="box-body">
		<table id="example2" class="table table-bordered table-striped">
			<thead>
				<tr class='bg-blue'>
					<th class="text-center">No</th>
					<th>Tgl</th>
					<th>No SO</th>
					<th>No Invoice</th>
					<th>Persentase</th>
					<th>Price List</th>
					<th>Disc (Rp.)</th>
					<th>Revenue</th>
					<th>HPP</th>
					<th>Jurnal</th>
				</tr>
			</thead>
			<tbody>

			</tbody>

			<tfoot>
				<tr>
					<td></td>
					<td colspan="6" align="right">Total</td>
					<td align="right" class="totalinvoiceformat"></td>
					<td align="right" class="totalhppformat"></td>
					<td></td>
				</tr>
			</tfoot>

		</table>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->
<!-- modal -->

<!-- modal -->


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

	$(document).on('click', '.clearing', function() {
		$('#tanggal').val('');
		$('#tanggal_to').val('');

		DataTables();
	});

	$(document).on('click', '.export_excel', function() {
		var tanggal = $('#tanggal').val();
		var tanggal_to = $('#tanggal_to').val();

		window.open(siteurl + active_controller + 'export_excel_report_revenue_detail?tanggal=' + tanggal + '&tanggal_to=' + tanggal_to);
	});

	function tampilkan() {
		DataTables();
	}

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

		var Datatables = $('#example2').DataTable({
			ajax: {
				url: siteurl + active_controller + 'get_data_report_revenue_detail',
				type: "POST",
				dataType: "JSON",
				data: function(d) {
					d.tanggal = tanggal;
					d.tanggal_to = tanggal_to;
				},
				dataSrc: function(result) {
					$(".totalinvoiceformat").text(number_format(result.totalinvoiceformat, 2));
					$(".totalhppformat").text(number_format(result.totalhppformat, 2));

					return result.data;
				}
			},
			columns: [{
				data: 'no'
			}, {
				data: 'tgl'
			}, {
				data: 'no_so'
			}, {
				data: 'no_invoice'
			}, {
				data: 'persentase'
			}, {
				data: 'price_list'
			}, {
				data: 'disc'
			}, {
				data: 'revenue'
			}, {
				data: 'hpp'
			}, {
				data: 'jurnal'
			}],
			responsive: true,
			processing: true,
			serverSide: true,
			stateSave: true,
			destroy: true,
			paging: true,
			lengthMenu: [10, 50, 100, 200, 500, 1000]
		});
	}


	$(document).on('click', '.buktip', function(e) {
		e.preventDefault();
		$("#head_title").html("<b>Penerimaan Bukti Potong</b>");
		$.ajax({
			type: 'POST',
			url: base_url + active_controller + 'penerimaan_buktipotong/' + $(this).data('kd_pembayaran'),
			success: function(data) {
				$("#ModalView").modal();
				$("#view").html(data);
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
	$(document).on('click', '.detail', function(e) {
		e.preventDefault();
		$("#head_title").html("<b>VIEW PAYMENT [" + $(this).data('id_bq') + "]</b>");
		$.ajax({
			type: 'POST',
			url: base_url + active_controller + 'view_penerimaan/' + $(this).data('id_bq'),
			success: function(data) {
				$("#ModalView").modal();
				$("#view").html(data);
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

	function add_inv() {
		window.location.href = base_url + active_controller + 'modal_detail_invoice';
	}

	function add_unlocated() {
		window.location.href = base_url + active_controller + 'unlocated';
	}

	$(document).on('click', '.print', function(e) {
		e.preventDefault();
		var invoice = $(this).data('inv');
		// alert(invoice); return false;
		swal({
				title: "Yakin Akan Diproses?",
				text: "Data tidak bisa dirubah lagi !!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Ya, Proses!",
				cancelButtonText: "Tidak, Batalkan!",
				closeOnConfirm: true,
				closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
					$('#spinnerx').show();
					window.open(base_url + active_controller + 'print_invoice_fix/' + invoice);

				} else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				}
			});
	});
	$(document).on('click', '.print1', function(e) {
		e.preventDefault();
		var invoice = $(this).data('inv');
		// alert(invoice); return false;
		swal({
				title: "Yakin Akan Diproses?",
				text: "Data tidak bisa dirubah lagi !!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Ya, Proses!",
				cancelButtonText: "Tidak, Batalkan!",
				closeOnConfirm: true,
				closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
					$('#spinnerx').show();
					window.open(base_url + active_controller + 'print_invoice_np_fix/' + invoice);
				} else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				}
			});
	});
	$(document).on('click', '.print2', function(e) {
		e.preventDefault();
		var invoice = $(this).data('inv');
		// alert(invoice); return false;
		swal({
				title: "Yakin Akan Diproses?",
				text: "Data tidak bisa dirubah lagi !!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Ya, Proses!",
				cancelButtonText: "Tidak, Batalkan!",
				closeOnConfirm: true,
				closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
					$('#spinnerx').show();
					window.open(base_url + active_controller + 'print_invoice_np_fix/' + invoice);
				} else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				}
			});
	});
	$(document).on('click', '.jurnal', function(e) {
		e.preventDefault();
		var invoice = $(this).data('inv');
		// alert(invoice); return false;
		swal({
				title: "Yakin Akan Diproses?",
				text: "Data tidak bisa dirubah lagi !!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Ya, Proses!",
				cancelButtonText: "Tidak, Batalkan!",
				closeOnConfirm: true,
				closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
					$('#spinnerx').show();
					window.open(base_url + active_controller + 'appr_jurnal/' + invoice);
					location.reload();
				} else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				}
			});
	});
	$(document).on('click', '.edit', function(e) {
		e.preventDefault();
		$("#head_title").html("<b>EDIT INVOICE [" + $(this).data('inv') + "]</b>");
		$.ajax({
			type: 'POST',
			url: base_url + 'invoicing/edit_invoice/' + $(this).data('inv'),
			success: function(data) {
				$("#ModalView").modal();
				$("#view").html(data);
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

	$(document).on('click', '.terima', function(e) {
		e.preventDefault();
		window.location.href = base_url + 'penerimaan/modal_detail_invoice/' + $(this).data('inv');
	});

	$("#incomplete").click(function() {
		$('#dialog-data-incomplete').modal('show');
		//        $("#list_item_stok").DataTable({lengthMenu:[10,15,25,30]}).draw();		
	});
</script>