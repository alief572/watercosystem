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
		<table id="mytabledata" class="table table-bordered table-striped">
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
		<tbody>
		<?php
		if(!empty($data)){
			$numb=0; foreach($data AS $record){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->no_doc ?></td>
			<td><?= $record->tgl_doc ?></td>
			<td><?= $record->nmuser ?></td>
			<td><?= $record->informasi ?></td>
			<td><?= $status[$record->status] ?></td>
			<td>
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-warning btn-sm view" href="javascript:void(0)" title="View" onclick="data_view('<?=$record->id?>')"><i class="fa fa-eye"></i></a>
			    <a class="btn btn-primary btn-sm edit" href="javascript:void(0)" title="Edit" onclick="data_edit('<?=$record->id?>')"><i class="fa fa-edit"></i></a>
				
			<?php endif;
			if($ENABLE_MANAGE) :
				if ($record->status==0) {?>
				<a class="btn btn-success btn-sm approve" href="javascript:void(0)" title="Approve" onclick="data_approve('<?=$record->id?>')"><i class="fa fa-check-square-o"></i></a>
				<?php }
			endif;
				?>
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
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript">
	var url_edit = siteurl+'expense/edit2/';
	var url_view = siteurl+'expense/view/';
	var url_approval = siteurl+'expense/approval/';
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