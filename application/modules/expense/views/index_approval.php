<?php
$ENABLE_ADD     = has_permission('Expense_Approval.Add');
$ENABLE_MANAGE  = has_permission('Expense_Approval.Manage');
$ENABLE_VIEW    = has_permission('Expense_Approval.View');
$ENABLE_DELETE  = has_permission('Expense_Approval.Delete');
?>
<div id="alert_edit" class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<div class="box">
	<!-- /.box-header -->
	<div class="box-body"><div class="table-responsive col-md-12">
		<table id="tbl_expense_approval" class="table table-bordered table-striped" width="100%">
		<thead>
		<tr>
			<th width="5">#</th>
			<th>No Dokumen</th>
			<th>Tanggal</th>
			<th>Nama</th>
			<th>Keterangan</th>
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
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript">
	var url_edit = siteurl+'expense/edit2/';
	var url_view = siteurl+'expense/view/';
	var url_approval = siteurl+'expense/approval/';
	$(function() {
		$('#tbl_expense_approval').DataTable({
			processing: true,
			serverSide: true,
			autoWidth: false,
			searchDelay: 350,
			order: [],
			ajax: { url: siteurl + 'expense/data_expense_approval', type: 'POST' },
			columns: [
				{ data: 'no', orderable: false, searchable: false }, { data: 'no_doc' }, { data: 'tgl_doc' }, { data: 'nama' },
				{ data: 'informasi' }, { data: 'status' }, { data: 'action', orderable: false, searchable: false }
			]
		});
	});
	//Edit
  	function data_approve(id){
		if(id!=""){
			$(".box").hide();
			$("#form-data").show();
			$("#form-data").load(url_approval+id);
		}
	}
</script>
<script src="<?= base_url('assets/js/basic.js')?>"></script>