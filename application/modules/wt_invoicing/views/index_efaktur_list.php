<?php
$ENABLE_ADD     = has_permission('Invoicing.Add');
$ENABLE_MANAGE  = has_permission('Invoicing.Manage');
$ENABLE_VIEW    = has_permission('Invoicing.View');
$ENABLE_DELETE  = has_permission('Invoicing.Delete');
?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert/sweetalert.css') ?>">

<style type="text/css">
	.table-efaktur-list th {
		text-align: center;
		vertical-align: middle !important;
	}
</style>

<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-history"></i> Riwayat Batch Ekspor E-Faktur DJP CoreTax</h3>
		<div class="box-tools pull-right">
			<a href="<?= base_url('wt_invoicing/e_faktur') ?>" class="btn btn-sm btn-primary">
				<i class="fa fa-file-excel-o"></i> E-Faktur Siap Ekspor
			</a>
			<a href="<?= base_url('wt_invoicing') ?>" class="btn btn-sm btn-default">
				<i class="fa fa-arrow-left"></i> Kembali ke Invoice
			</a>
		</div>
	</div>

	<div class="box-body">
		<div class="table-responsive">
			<table id="table_efaktur_list" class="table table-bordered table-striped table-hover table-efaktur-list" width="100%">
				<thead>
					<tr class="bg-blue">
						<th width="5%">No</th>
						<th width="20%">ID Batch Ekspor</th>
						<th width="20%">Tanggal Ekspor</th>
						<th width="15%">Jam Ekspor</th>
						<th width="20%">Jumlah Faktur</th>
						<th width="20%">Aksi</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- DataTables & SweetAlert -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/sweetalert.min.js') ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#table_efaktur_list').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: siteurl + 'wt_invoicing/list_efaktur',
				type: 'POST'
			},
			columns: [
				{ data: 'no', orderable: false, className: 'text-center' },
				{ data: 'id_export', className: 'text-center' },
				{ data: 'date_export', className: 'text-center' },
				{ data: 'time_export', className: 'text-center' },
				{ data: 'total_inv', className: 'text-center' },
				{ data: 'action', orderable: false, className: 'text-center' }
			],
			order: [[1, 'desc']]
		});
	});
</script>
