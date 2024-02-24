<?php
    $ENABLE_ADD     = has_permission('Aset.Add');
    $ENABLE_MANAGE  = has_permission('Aset.Manage');
    $ENABLE_VIEW    = has_permission('Aset.View');
    $ENABLE_DELETE  = has_permission('Aset.Delete');
?>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<style>
.modal-dialog{
width:90%;
}
</style>
<div class="box">
	<div class="box-header">
		<?php if ($ENABLE_ADD) : ?>
			<a class="btn btn-success" href="javascript:add_data()" title="Add"><i class="fa fa-plus">&nbsp;</i>New</a>
		<?php endif; ?>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="50">
			<?php if($ENABLE_MANAGE) : ?>
			Action
			<?php endif; ?>
			</th>
			<th>Aset</th>
			<th>Tanggal</th>
			<th>Status</th>
			<th>Nilai Aset</th>
		</tr>
		</thead>
		<tbody>
		<?php if(empty($results)){
		}else{
			$numb=0; foreach($results AS $record){ $numb++; ?>
		<tr>
		    <td>
			<?php if($ENABLE_MANAGE) : ?>
				<a class="text-green" title="Edit" href="javascript:edit_data('<?=$record->id?>')"><i class="fa fa-pencil"></i></a>
			    <a class="btn btn-success btn-sm view" href="javascript:void(0)" title="View Jurnal Penjualan Aset" data-id_material="<?=$record->kd_asset?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>
			</td>
			<td><?= $record->kd_asset ?></td>
			<td><?= $record->tgl ?></td>
			<td><?= $record->status ?></td>
			<td><?= number_format($record->nilai_aset) ?></td>
		</tr>
		<?php }
		}  ?>
		</tbody>
		</table>
	</div>
	<!-- /.box-body -->
	
	<div class="modal modal-default fade" id="dialog-popup" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow:hidden;">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Detail Jurnal</h4>
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
	
</div>
<div id="form-data">
</div>
<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
<!-- page script -->
<script type="text/javascript">

    $(document).on('click', '.view', function(){
		var id = $(this).data('id_material');
		var pp = 'pjaset';
		var akses = 'list_aset';
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Jurnal</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'jurnal_nomor/view_jurnal_penjualan/'+id+'/'+pp+'/'+akses,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});

  	$(function() {
    	$("#mytabledata").DataTable();
    	$("#form-data").hide();
  	});

  	function add_data(){
		var url = 'asset/create_out/';
		$(".box").hide();
		$("#form-data").show();
		$("#form-data").load(siteurl+url);
		$("#title").focus();
	}

  	function edit_data(id){
		if(id!=""){
			var url = 'asset/edit_out/'+id;
			$(".box").hide();
			$("#form-data").show();
			$("#form-data").load(siteurl+url);
		    $("#title").focus();
		}
	}

</script>
