<?php
$ENABLE_ADD     = has_permission('Expense_Petty_Cash.Add');
$ENABLE_MANAGE  = has_permission('Expense_Petty_Cash.Manage');
$ENABLE_VIEW    = has_permission('Expense_Petty_Cash.View');
$ENABLE_DELETE  = has_permission('Expense_Petty_Cash.Delete');
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
		<table id="mytabledata" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th>No Dokumen</th>
			<th>Tanggal</th>
			<th>Nama</th>
			<th>Approval</th>
			<th>Keterangan</th>
			<th>Status</th>
			<th width="120">Action</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if(!empty($results)){
			$numb=0; foreach($results AS $record){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->no_doc ?></td>
			<td><?= $record->tgl_doc ?></td>
			<td><?= $record->nmuser ?></td>
			<td><?= $record->nmapproval?></td>
			<td><?= $record->informasi ?></td>
			<td><?= $status[$record->status] ?></td>
			<td>
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-default btn-sm print" href="<?=base_url('expense/expense_print/'.$record->id)?>" target="expense_print" title="Print"><i class="fa fa-print"></i> </a>
				<a class="btn btn-warning btn-sm view" href="javascript:void(0)" title="View" onclick="data_view('<?=$record->id?>')"><i class="fa fa-eye"></i></a>
			<?php endif;
			if($ENABLE_MANAGE) :
				if ($record->status==0 || $record->status==9) {?>
				<a class="btn btn-success btn-sm edit" href="javascript:void(0)" title="Edit" onclick="data_edit('<?=$record->id?>')"><i class="fa fa-edit"></i></a>
				<?php }
				endif;
			if($ENABLE_DELETE) :
				if ($record->status==0 || $record->status==9) {?>
				<a class="btn btn-danger btn-sm delete" href="javascript:void(0)" title="Hapus" onclick="data_delete('<?=$record->id?>')"><i class="fa fa-trash"></i></a>
				<?php }
				endif; ?>
			</td>
		</tr>
		<?php
			}
		}  ?>
		</tbody>
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
	var url_add = siteurl+'expense/create_pc/';
	var url_edit = siteurl+'expense/edit_pc/';
	var url_delete = siteurl+'expense/delete/';
	var url_view = siteurl+'expense/view_pc/';
</script>
<script src="<?= base_url('assets/js/basic.js')?>"></script>
