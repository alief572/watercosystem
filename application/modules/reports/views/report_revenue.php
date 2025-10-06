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
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">

<div class="box">
	<form method="post" action="<?= base_url() ?>reports/tampilkan_revenue" autocomplete="off">
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
	</form>

	<div class="box-body">
		<table id="example2" class="table table-bordered table-striped">
			<thead>
				<tr class='bg-blue'>
					<th class="text-center" width='4%'>No</th>
					<th width='7%'>Tgl</th>
					<th width='18%'>No SO</th>
					<th width='18%'>No Invoice</th>
					<th width='7%'>Total SO</th>
					<th width='7%'>Revenue</th>
					<th width='7%'>HPP</th>

				</tr>
			</thead>
			<tbody>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4" class="text-right">Total</td>
					<td align="right" class="totalgrandtotalformat">0</td>
					<td align="right" class="totalinvoiceformat">0</td>
					<td align="right" class="totalhppformat">0</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->
<!-- modal -->
<div class="modal fade" id="ModalView">
	<div class="modal-dialog" style='width:80%; '>
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



<!-- DataTables -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

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

		window.open(siteurl + active_controller + 'export_excel_report_revenue?tanggal=' + tanggal + '&tanggal_to=' + tanggal_to);
	});

	function tampilkan() {
		DataTables();
	}

	function add_inv() {
		window.location.href = base_url + active_controller + 'modal_detail_invoice';
	}

	function add_unlocated() {
		window.location.href = base_url + active_controller + 'unlocated';
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
				url: siteurl + active_controller + 'get_data_report_revenue',
				type: "POST",
				dataType: "JSON",
				data: function(d) {
					d.tanggal = tanggal;
					d.tanggal_to = tanggal_to;
				},
				dataSrc: function(result) {
					$(".totalgrandtotalformat").text(number_format(result.totalgrandtotalformat, 2));
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
				data: 'total_so'
			}, {
				data: 'revenue'
			}, {
				data: 'hpp'
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

	
</script>