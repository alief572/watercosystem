<?php
    $ENABLE_ADD     = has_permission('Debit_Note.Add');
    $ENABLE_MANAGE  = has_permission('Debit_Note.Manage');
    $ENABLE_VIEW    = has_permission('Debit_Note.View');
    $ENABLE_DELETE  = has_permission('Debit_Note.Delete');
	
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">

<div class="box">
	<div class="box-header">
		<span class="pull-left">
			
		</span>
	</div>
	<!-- /.box-header -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="tbl_debit_note_approval" class="table table-bordered table-striped" width="100%">
		<thead>
		<tr>
			<th width="5">#</th>
			<th >Id.DN</th>
			<th >No.DN</th>
			<th>Tanggal DN</th>
			<th>Customer</th>
			<th>Total</th>
			<th>Status</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody></tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>

<!-- awal untuk modal dialog -->
<!-- Modal -->
<div class="modal modal-primary" id="dialog-rekap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
        <span class="glyphicon glyphicon-remove"></span>  Close</button>
        </div>
    </div>
  </div>
</div>

<div class="modal modal-default fade" id="dialog-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
        <span class="glyphicon glyphicon-remove"></span>  Close</button>
        </div>
    </div>
  </div>
</div>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<!-- page script -->
<script type="text/javascript">
	// Header: #, Id.DN, No.DN, Tanggal DN, Customer, Total, Status[, Action jika izin Manage].
	$(function() {
		var columns = [
			{ data: 'no', orderable: false, searchable: false }, { data: 'no_pr' }, { data: 'no_surat' },
			{ data: 'tanggal' }, { data: 'nm_customer' }, { data: 'total', className: 'text-right' }, { data: 'status' }
		];
		<?php if ($ENABLE_MANAGE) : ?>
		columns.push({ data: 'action', orderable: false, searchable: false });
		<?php endif; ?>
		$('#tbl_debit_note_approval').DataTable({
			processing: true,
			serverSide: true,
			autoWidth: false,
			searchDelay: 350,
			order: [],
			ajax: { url: siteurl + 'debit_note/data_debit_note_approval', type: 'POST' },
			columns: columns
		});
	});
</script>
