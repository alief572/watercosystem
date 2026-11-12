<?php
$ENABLE_ADD    = has_permission('Penjualan_Non_Product.Add');
$ENABLE_MANAGE = has_permission('Penjualan_Non_Product.Manage');
?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">

<div class="box">
	<?php if ($ENABLE_ADD) : ?>
		<div class="box-header">
			<a class="btn btn-success" href="<?= site_url('invoice_np/data_form') ?>">
				<i class="fa fa-plus">&nbsp;</i> New Invoice Non Product
			</a>
		</div>
	<?php endif; ?>
	<div class="box-body">
		<table class="table table-bordered table-striped" id="tbl_invoice_np" width="100%">
			<thead>
				<tr class="bg-blue">
					<th class="text-center" width="4%">#</th>
					<th class="text-center" width="12%">No Invoice</th>
					<th class="text-center" width="9%">Tgl Invoice</th>
					<th class="text-center" width="9%">No Faktur</th>
					<th class="text-center">Keterangan</th>
					<th class="text-center">Customer</th>
					<th class="text-center" width="12%">Total Invoice</th>
					<th class="text-center" width="14%">Option</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>

<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

<script type="text/javascript">
	var invoiceUrl = siteurl + 'invoice_np/';

	$(function() {
		$('#tbl_invoice_np').DataTable({
			processing: true,
			serverSide: true,
			autoWidth: false,
			order: [
				[2, 'desc']
			],
			ajax: {
				url: invoiceUrl + 'get_data',
				type: 'POST'
			},
			columns: [{
					data: 'no'
				},
				{
					data: 'no_invoice'
				},
				{
					data: 'tgl_invoice'
				},
				{
					data: 'no_faktur'
				},
				{
					data: 'keterangan'
				},
				{
					data: 'nm_customer'
				},
				{
					data: 'total_invoice'
				},
				{
					data: 'option'
				}
			],
			columnDefs: [{
				orderable: false,
				targets: [0, 7]
			}]
		});
	});

	$(document).on('click', '.viewed', function() {
		window.location.href = invoiceUrl + 'data_form/' + $(this).data('iddata') + '/view';
	});

	$(document).on('click', '.edited', function() {
		window.location.href = invoiceUrl + 'data_form/' + $(this).data('iddata') + '/edit';
	});

	// Delete dan Update (approve) memakai alur yang sama: konfirmasi lalu POST.
	function prosesInvoice(iddata, aksi, teks, judul) {
		swal({
				title: "Are you sure?",
				text: teks,
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, Process it!",
				cancelButtonText: "No, cancel process!",
				closeOnConfirm: true,
				closeOnCancel: false
			},
			function(isConfirm) {
				if (!isConfirm) {
					swal("Cancelled", "Data can be process again :)", "error");
					return;
				}
				$.ajax({
					url: invoiceUrl + aksi + '/' + iddata,
					type: 'POST',
					cache: false,
					dataType: 'json',
					success: function(data) {
						if (data.status == 1) {
							swal({
								title: judul + " Success!",
								text: data.pesan,
								type: "success",
								timer: 3000
							});
							$('#tbl_invoice_np').DataTable().ajax.reload(null, false);
						} else {
							swal({
								title: judul + " Failed!",
								text: data.pesan,
								type: "warning"
							});
						}
					},
					error: function() {
						swal({
							title: "Error Message !",
							text: 'An Error Occured During Process. Please try again..',
							type: "warning"
						});
					}
				});
			});
	}

	$(document).on('click', '.deleted', function() {
		prosesInvoice($(this).data('iddata'), 'delete_data', 'Delete this data ?', 'Delete');
	});

	$(document).on('click', '.updated', function() {
		prosesInvoice($(this).data('iddata'), 'update_data', 'Update this data ?', 'Update');
	});
</script>
