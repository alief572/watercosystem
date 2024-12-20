<?php
    $ENABLE_ADD 	= has_permission('Asset.Add');
    $ENABLE_MANAGE 	= has_permission('Asset.Manage');
    $ENABLE_VIEW 	= has_permission('Asset.View');
    $ENABLE_DELETE 	= has_permission('Asset.Delete');
?>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">
<div class="box">
	<!-- /.box-header -->
	<div class="box-body">
		<table id="mytabledata" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="35">
			<?php if($ENABLE_MANAGE) : ?>
			Action
			<?php endif; ?>
			</th>
			<th class="text-center" width='4%'>#</th>
			<th class="text-center" width='15%'>Asset Code</th>
			<th class="text-center">Asset Name</th>
			<th class="text-center" width='12%'>Category</th>
			<th class="text-center" width='9%'>Costcenter</th>
			<th class="text-center" width='9%'>Depreciation</th>
			<th class="text-center" width='9%'>Acquisition</th>
			<th class="text-center" width='9%'>Depreciation</th>
			<th class="text-center" width='9%'>Asset&nbsp;Val</th>
			<th class="text-center no-sort" width='10%'>#</th>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results)){
		}else{
			$numb=0; foreach($results AS $record){ $numb++; ?>
			
			<?php
	    
			$no_pr  = $record->no_pr;
			
			$search  = $this->db->query("SELECT * FROM tr_pr_aset WHERE no_pr='$no_pr'")->row();
			$idaset	 = $search->id_aset;
			$msaset  = $this->db->query("SELECT * FROM ms_coa_aset WHERE id='$idaset'")->row();
			
			?>
		<tr>
			<td style="padding-left:20px">
			<?php if($ENABLE_MANAGE) : ?>
				<a class="text-green" href="javascript:void(0)" title="Proses Penyusutan" onclick="edit_data('<?=$record->no_pr?>')"><i class="btn fa fa-plus"></i></a>
			<?php endif;?>
			</td>
			<td><?= $record->no_pr ?></td>
			<td><?= $record->no_po ?></td>
			<td><?= $record->tgl_po?></td>
			<td><?= $msaset->nama_aset?></td>
			<td><?= $record->qty?></td>
			<td><?= number_format($record->harga_satuan)?></td>
			<td><?php
			if($record->penyusutan=='0') {
				echo 'Belum Penyusutan';
			}else{				
				echo 'Sudah Diproses Penyusutan';				
			}
			?></td>
		</tr>
		<?php }
		}  ?>
		</tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>

<div id="form-data">
</div>
<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<!-- page script -->
<script type="text/javascript">

  	$(function() {
    	$("#mytabledata").DataTable();
    	$("#form-data").hide();
  	});

  	function add_data(){
		var url = 'po_aset/create/';
		$(".box").hide();
		$("#form-data").show();
		$("#form-data").load(siteurl+url);
		$("#title").focus();
	}

  	function edit_data(id){
		if(id!=""){
			var url = 'asset/create_aset/'+id;
			$(".box").hide();
			$("#form-data").show();
			$("#form-data").load(siteurl+url);
		    $("#title").focus();
		}
	}

</script>
