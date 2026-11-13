<?php
if($hakakses=='expense'){
	$ENABLE_ADD     = has_permission('Expense.Add');
	$ENABLE_MANAGE  = has_permission('Expense.Manage');
	$ENABLE_VIEW    = has_permission('Expense.View');
	$ENABLE_DELETE  = has_permission('Expense.Delete');
}else{
	$ENABLE_ADD     = has_permission('Expense_List.Add');
	$ENABLE_MANAGE  = has_permission('Expense_List.Manage');
	$ENABLE_VIEW    = has_permission('Expense_List.View');
	$ENABLE_DELETE  = has_permission('Expense_List.Delete');
}
?>
<div id="alert_edit" class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<div class="box">
	<div class="box-header">
		<?php if ($ENABLE_ADD) : ?>
			<div class="dropdown">
			  <button class="btn btn-success btn-sm" type="button" onclick="data_add()">
				<i class="fa fa-plus">&nbsp;</i> Tambah
			  </button>
			</div>
		<?php endif; ?>
	</div>
	<!-- /.box-header -->
	<div class="box-body"><div class="table-responsive col-md-12">
		<table id="tbl_expense" class="table table-bordered table-striped" width="100%">
		<thead>
		<tr>
			<th width="5">#</th>
			<th>No Dokumen</th>
			<th>Tanggal</th>
			<th>Nama</th>
			<th>Approval</th>
			<th>Keterangan</th>
			<th>Jumlah</th>
			<th>Status</th>
			<th width="120">Action</th>
		</tr>
		</thead>
		<tbody></tbody>
		</table>
		</div>
	</div>
	<!-- /.box-body -->
</div>
<div id="form-data"></div>
<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
<!-- page script -->
<script type="text/javascript">
	var url_add = siteurl+'expense/create/';
	var url_edit = siteurl+'expense/edit/';
	var url_delete = siteurl+'expense/delete/';
	var url_view = siteurl+'expense/view/';
	// Header selalu 9 kolom (Action kosong bila tanpa izin), jadi columns juga 9.
	$(function() {
		$('#tbl_expense').DataTable({
			processing: true,
			serverSide: true,
			autoWidth: false,
			searchDelay: 350,
			order: [],
			ajax: { url: siteurl + 'expense/<?= $hakakses == 'expense' ? 'data_expense' : 'data_expense_list' ?>', type: 'POST' },
			columns: [
				{ data: 'no', orderable: false, searchable: false }, { data: 'no_doc' }, { data: 'tgl_doc' }, { data: 'nama' },
				{ data: 'approval' }, { data: 'informasi' }, { data: 'jumlah', className: 'text-right' }, { data: 'status' },
				{ data: 'action', orderable: false, searchable: false }
			]
		});
	});
</script>
<script src="<?= base_url('assets/js/basic.js')?>"></script>

