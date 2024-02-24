<?php
    $ENABLE_ADD     = has_permission('Master_lme.Add');
    $ENABLE_MANAGE  = has_permission('Master_lme.Manage');
    $ENABLE_VIEW    = has_permission('Master_lme.View');
    $ENABLE_DELETE  = has_permission('Master_lme.Delete');
	
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">


<div class="nav-tabs-supplier">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#history" data-toggle="tab" aria-expanded="true">History LME</a></li>
    <li class=""><a href="#rate" data-toggle="tab" aria-expanded="false">Rate LME</a></li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="history">
      <div class="box box-primary">
        	<div class="box-header">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-success btn-sm update" href="javascript:void(0)" title="Add"><i class="fa fa-plus">&nbsp;</i>Input Harga LME</a>
			<?php endif; ?>
		<span class="pull-right"></span>
	</div>
        	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%">Update Date</th>
			<th>Update By</th>
			<th class='text-center'>cu</th>
			<th class='text-center'>zn</th>
			<th class='text-center'>sn</th>
			<th class='text-center'>ni</th>
			<th class='text-center'>ag</th>
			<th class='text-center'>al</th>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['history'])){
		}else{
			
			$numb=0; foreach($results['history'] AS $history){ $numb++;
			$cu = $this->db->query("SELECT * FROM child_history_lme WHERE id_history_lme ='$history->id_history_lme' AND id_compotition = '13' ")->result();
			$zn = $this->db->query("SELECT * FROM child_history_lme WHERE id_history_lme ='$history->id_history_lme' AND id_compotition = '14' ")->result();
			$sn = $this->db->query("SELECT * FROM child_history_lme WHERE id_history_lme ='$history->id_history_lme' AND id_compotition = '15' ")->result();
			$ni = $this->db->query("SELECT * FROM child_history_lme WHERE id_history_lme ='$history->id_history_lme' AND id_compotition = '16' ")->result();
			$ag = $this->db->query("SELECT * FROM child_history_lme WHERE id_history_lme ='$history->id_history_lme' AND id_compotition = '17' ")->result();
			$al = $this->db->query("SELECT * FROM child_history_lme WHERE id_history_lme ='$history->id_history_lme' AND id_compotition = '18' ")->result();
			
			?>
			
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $history->tanggal_update?></td>
			<td><?= $history->nm_lengkap ?></td>
			<td class='text-right'>$ <?= number_format($cu[0]->nominal,2) ?>/ton</td>
			<td class='text-right'>$ <?= number_format($zn[0]->nominal,2) ?>/ton</td>
			<td class='text-right'>$ <?= number_format($sn[0]->nominal,2) ?>/ton</td>
			<td class='text-right'>$ <?= number_format($ni[0]->nominal,2) ?>/ton</td>
			<td class='text-right'>$ <?= number_format($ag[0]->nominal,2) ?>/ton</td>
			<td class='text-right'>$ <?= number_format($al[0]->nominal,2) ?>/ton</td>
		</tr>
		<?php } }  ?>
		</tbody>
		</table>
	</div>
      </div>
    </div>

    <div class="tab-pane" id="rate">
        	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%">Kompisisi</th>
			<th>Rate H-30</th>
			<th>Rate H-10</th>
			<th>Rate Saat Ini</th>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['comp'])){
		}else{
		$hariini 		= date('Y-m-d');
		$satu_hari 		= mktime(0,0,0,date('n'),date('j')-1,date('Y'));
		$kemarin 		= date("Y-m-d", $satu_hari);
		$sepuluh_hari 	= mktime(0,0,0,date('n'),date('j')-14,date('Y'));
		$tendays 		= date("Y-m-d", $sepuluh_hari);
		$tglnow 		= date('d');
		$blnnow 		= date('m');
		if ($blnnow 	!= '1'){ 
		$blnkmrn	 	= $blnnow-1;
		$yearkemaren 	= date('Y');
		}else{
		$blnkmrn 		= "12";
		$yearnow 		= date('Y');
		$yearkemaren 	= $yearnow-1;
		}
			$numb3=0; foreach($results['comp'] as $comp){ $numb3++;
			$id_comp = $comp->id_compotition;
			$lme_10hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$kemarin' AND id_compotition='$id_comp' ")->result();
			$lme_30hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren' AND id_compotition='$id_comp' ")->result();
			?>
		<tr>
		    <td><?= $numbc; ?></td>
			<td><?= $comp->name_compotition ?></td>
			<td>$ <?= number_format( $lme_30hari[0]->nominal,2);?></td>
			<td>$ <?= number_format( $lme_10hari[0]->nominal,2);?></td>
			<td>$ <?= number_format( $comp->nominal_harga,2); ?></td>
		</tr>
		
		<?php } }  ?>
		</tbody>
		</table>
	</div>
      </div>
    </div>
  </div>
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Data LME</h4>
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
<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
<!-- End Modal Bidus-->
<style>
  .box-primary {

    border: 1px solid #ddd;
  }
</style>
<!-- page script -->
<script type="text/javascript">

	$(document).on('click', '.edit_category', function(e){
		var id = $(this).data('id_category_customer');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_customers/EditCategory/'+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	$(document).on('click', '.view_category', function(){
		var id = $(this).data('id_category_supplier');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_suplier/viewCategory/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
		$(document).on('click', '.edit_international', function(e){
		var id = $(this).data('id_suplier');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_suplier/EditInternasional/'+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	$(document).on('click', '.view_international', function(){
		var id = $(this).data('id_suplier');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_suplier/viewInternasional/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.edit_local', function(e){
		var id = $(this).data('id_customer');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_customers/editCustomer/'+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	$(document).on('click', '.view_local', function(){
		var id = $(this).data('id_history_lme');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_lme/viewHistory/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.update', function(){
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_lme/UpdateLme',
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.add_category', function(){
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_customers/addCategory',
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	
	// DELETE DATA
	$(document).on('click', '.delete_category', function(e){
		e.preventDefault()
		var id = $(this).data('id_category_customer');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data akan di hapus.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Hapus!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'master_customers/deleteCategory',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data berhasil dihapus.",
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Gagal hapus data",
					  type  : "error"
					})
					
				  }
			  },
			  error : function(){
				swal({
					  title : "Error",
					  text  : "Data error. Gagal request Ajax",
					  type  : "error"
					})
			  }
		  })
		});
		
	});
	// DELETE DATA
	$(document).on('click', '.delete_local', function(e){
		e.preventDefault()
		var id = $(this).data('id_suplier');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data akan di hapus.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Hapus!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'master_suplier/deletelokal',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data berhasil dihapus.",
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Gagal hapus data",
					  type  : "error"
					})
					
				  }
			  },
			  error : function(){
				swal({
					  title : "Error",
					  text  : "Data error. Gagal request Ajax",
					  type  : "error"
					})
			  }
		  })
		});
		
	});
	// DELETE DATA
	$(document).on('click', '.delete_international', function(e){
		e.preventDefault()
		var id = $(this).data('id_suplier');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data akan di hapus.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Hapus!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'master_suplier/deleteinternational',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data berhasil dihapus.",
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Gagal hapus data",
					  type  : "error"
					})
					
				  }
			  },
			  error : function(){
				swal({
					  title : "Error",
					  text  : "Data error. Gagal request Ajax",
					  type  : "error"
					})
			  }
		  })
		});
		
	});

  	$(function() {

	    var table = $('#example1').DataTable( {
	        orderCellsTop: true,
	        fixedHeader: true
	    } );
    	$("#form-area").hide();
  	});
	
	
	//Delete

	function PreviewPdf(id)
	{
		param=id;
		tujuan = 'customer/print_request/'+param;

	   	$(".modal-body").html('<iframe src="'+tujuan+'" frameborder="no" width="570" height="400"></iframe>');
	}

	function PreviewRekap()
	{
		tujuan = 'customer/rekap_pdf';
	   	$(".modal-body").html('<iframe src="'+tujuan+'" frameborder="no" width="100%" height="400"></iframe>');
	}
</script>
