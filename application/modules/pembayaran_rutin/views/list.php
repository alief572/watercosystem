<?php
$ENABLE_ADD     = has_permission('Pembayaran_Periodik.Add');
$ENABLE_MANAGE  = has_permission('Pembayaran_Periodik.Manage');
$ENABLE_VIEW    = has_permission('Pembayaran_Periodik.View');
$ENABLE_DELETE  = has_permission('Pembayaran_Periodik.Delete');
?>
<div id="alert_edit" class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<div class="box">
	<!-- /.box-header -->
	<div class="box-body"><div class="table-responsive col-md-12">
		<table id="mytabledata" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th>Departement</th>
			<th>Nomor</th>
			<th>Tanggal</th>
			<th>Status</th>
			<th width="150">
				Action
			</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if(!empty($results)){
			$numb=0; foreach($results AS $record){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->nm_dept ?></td>
			<td><?= $record->no_doc?></td>
			<td><?= $record->tanggal_doc?></td>
			<td><?= $status[$record->status]?></td>
			<td>
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-warning btn-sm view" href="javascript:void(0)" title="View" onclick="data_view('<?=$record->id?>')"><i class="fa fa-eye"></i></a>
			<?php endif;
			if($record->status==10){
				if($ENABLE_MANAGE) : ?>
					<a class="btn btn-success btn-sm edit" href="javascript:void(0)" title="Edit" onclick="data_edit('<?=$record->id?>')"><i class="fa fa-edit"></i></a>
				<?php endif;
			}?>
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
	var url_add = "";
	var url_add_def = siteurl+'pembayaran_rutin/create/';
	var url_edit = siteurl+'pembayaran_rutin/edit/';
	var url_view = siteurl+'pembayaran_rutin/view/';

	function new_data(key){
		url_add = url_add_def+key;
		data_add();
	}
</script>
<script src="<?= base_url('assets/js/basic.js')?>"></script>

