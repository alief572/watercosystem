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

</script>
