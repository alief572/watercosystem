<?php
    $ENABLE_ADD     = has_permission('Spk_produksi.Add');
    $ENABLE_MANAGE  = has_permission('Spk_produksi.Manage');
    $ENABLE_VIEW    = has_permission('Spk_produksi.View');
    $ENABLE_DELETE  = has_permission('Spk_produksi.Delete');
	
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
	<li class="active"><a href="#proces" data-toggle="tab" aria-expanded="true">List Produksi</a></li>
    <li ><a href="#history" data-toggle="tab" aria-expanded="true">History Produksi</a></li>
  </ul>
 </div> 

<div class="tab-content">  
<div class="tab-pane active" id="proces">
<div class="box">
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>#</th>
			<th>No SPK Produksi</th>
			<th>Customer</th>
			<th>Nama Material</th>
			<th>Tanggal Produksi</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th>Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results)){
		}else{
			
			$numb=0; 
			foreach($results['produksi'] AS $record){ 
			
			$numb++; 
			$id_spkproduksi = $record->id_spkproduksi;
			$customer	= $this->db->query("SELECT a.*, b.name_customer as name_customer FROM dt_spk_produksi as a INNER JOIN master_customers as b ON a.idcustomer = b.id_customer WHERE a.id_spkproduksi='$id_spkproduksi' GROUP BY a.idcustomer ")->result();
			
			
			
			$produksi_date = (!empty($record->tgl_spk_produksi))?date('d-m-Y', strtotime($record->tgl_spk_produksi)):'-';
			?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->no_surat ?></td>
			<td>
			<table><?php foreach($customer AS $customer){
				echo"<tr>
					<td>-</td>
					<td>$customer->name_customer</td>
				</tr>";}
				?>
			</table>
			</td>
			<td><?= $record->nama ?></td>
			<td><?= $produksi_date ?></td>
			<?php if($record->status_approve == '1'){ ?>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-success btn-sm view" href="<?= base_url('/spk_aktual/addHeader/'.$record->id_tr_spk_produksi.'/view') ?>" title="View"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>
			</td>
			<?php }else{ ?>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-warning btn-sm view" href="<?= base_url('/spk_aktual/addHeader/'.$record->id_tr_spk_produksi.'/view') ?>" title="View"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<!-- <a class="btn btn-info btn-sm" href="<?= base_url('/spk_aktual/printSPKProduksi/'.$record->id_spkproduksi) ?>" target="_blank"  title="Print"><i class="fa fa-print"></i>
				</a> -->

			<?php if($ENABLE_MANAGE) : ?>
			<a class="btn btn-success btn-sm" href="<?= base_url('/spk_aktual/EditHeader/'.$record->id_spkproduksi) ?>"  title="Input LHP Material Gabungan"><i class="fa fa-plus"></i></i></a>
			
			<a class="btn btn-danger btn-sm" href="<?= base_url('/spk_aktual/EditHeadernew/View/'.$record->id_tr_spk_produksi) ?>"  title="View LHP Material"><i class="fa fa-eye"></i></i></a>
				</a>
			<a class="btn btn-success btn-sm" href="<?= base_url('/spk_aktual/EditHeadernew/Edit/'.$record->id_tr_spk_produksi) ?>"  title="Edit LHP Material"><i class="fa fa-pencil"></i></i></a>
				</a>
			
			<?php endif; ?>
			<?php if($ENABLE_MANAGE) : ?>
			<a class="btn btn-success btn-sm" href="<?= base_url('/spk_aktual/TambahLHP/'.$record->id_spkproduksi) ?>"  title="Input LHP"><i class="fa fa-edit"></i></i></a>
				</a>
			<?php endif; ?>
			
			<?php if($ENABLE_MANAGE) : ?>
			<button type='button' class="btn btn-danger btn-sm reject" data-id_spkproduksi='<?=$record->id_spkproduksi;?>' title="Back To Produksi"><i class="fa fa-reply"></i></i></button>

			<?php endif; ?>
			<?php if($ENABLE_MANAGE) : 
				if($record->input1 == '1' AND $record->input2 == '1' ){
				?>
					<button type='button' class="btn btn-success btn-sm approve" data-id_spkproduksi='<?=$record->id_tr_spk_produksi;?>' title="Approve"><i class="fa fa-check"></i></i></button>
			<?php } 
			
			endif; ?>
			</td>
			<?php } ?>
		</tr>
		<?php } }  ?>
		</tbody>
		</table>
	</div>
</div>
</div>
<div class="tab-pane" id="history">
<div class="box">
	<div class="box-body">
		<table id="exampleoo" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>#</th>
			<th>No SPK Produksi</th>
			<th>Customer</th>
			<th>Product</th>
			<th>Tanggal Produksi</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th>Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results)){
		}else{
			
			$numb=0; foreach($results['aktual'] AS $aktual){ $numb++; 
			
			
			
			$id_spkproduksi = $aktual->id_spk_aktual;
			// print_r($id_spkproduksi);
			// exit;
			
			$customer	= $this->db->query("SELECT a.*, b.name_customer as name_customer FROM dt_spk_produksi as a INNER JOIN master_customers as b ON a.idcustomer = b.id_customer WHERE a.id_tr_spk_produksi='$id_spkproduksi' GROUP BY a.idcustomer ")->result();
			
			$produksi_date = (!empty($aktual->date_production))?date('d-m-Y', strtotime($aktual->date_production)):'-';
			?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $aktual->no_surat_produksi ?></td>
			<td>
			<table><?php foreach($customer AS $customer){
				echo"<tr>
					<td>-</td>
					<td>$customer->name_customer</td>
				</tr>";}
				?>
			</table>
			</td>
			<td><?= $aktual->nama_material ?></td>
			<td><?= $produksi_date ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-warning btn-sm view" href="<?= base_url('/spk_aktual/addHeader/'.$aktual->id_spk_aktual.'/view') ?>" title="View"><i class="fa fa-eye"></i>
				</a>
				
				<a class="btn btn-success btn-sm" href="<?= base_url('/spk_aktual/EditHeader/Edit/'.$aktual->id_spk_aktual.'/history') ?>"  title="Edit LHP Material"><i class="fa fa-pencil"></i></i></a>
				
				<a class="btn btn-danger btn-sm" href="<?= base_url('/spk_aktual/EditHeader/View/'.$aktual->id_spk_aktual) ?>"  title="View LHP Material"><i class="fa fa-eye"></i></i></a>
				</a>				
				
			<?php endif; ?>
			</td>
		</tr>
		<?php } }  ?>
		</tbody>
		</table>
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;SPK AKTUAL</h4>
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

<form action="#" method="POST" id="form_proses">  
<div class="modal fade" id="ModalView2">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id='head_title'>Default Modal</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body" id="view">
		<div class='form-group row'>
			<div class='col-sm-12'>
				<label for="tahunx">Alasan Reject <span class='text-red'>*</span></label>
				<input type="hidden" id='id_spkproduksi' name='id_spkproduksi'  class='form-control input-sm'>
				<textarea name="reason_reject" id="reason_reject" class='form-control input-sm' rows="3"></textarea>
			</div>
		</div>
	</div>
	<div class="modal-footer text-right">
		<button type="button" class="btn btn-success" id='proccess_reject' ><i class="fa fa-save"></i> Process</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
	</div>
	</div>
	<!-- /.modal-content -->
</div>
</form>
<!-- /.modal-dialog -->




<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>

<!-- page script -->
<script type="text/javascript">

		$(document).on('click','.reject', function(e){	
			e.preventDefault();
			let id_spkproduksi = $(this).data('id_spkproduksi');
			$('#id_spkproduksi').val(id_spkproduksi)
			$("#head_title").html("Reject LHP");
			$("#ModalView2").modal();
		});

	$(document).on('click', '.edit', function(e){
		var id = $(this).data('no_penawaran');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'spk_marketing/EditHeader/'+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
		$(document).on('click', '.cetak', function(e){
		var id = $(this).data('no_penawaran');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'xtes/cetak'+id,
			success:function(data){
				
				
			}
		})
	});
	
	// $(document).on('click', '.view', function(){
	// 	var id = $(this).data('id_spkproduksi');
	// 	// alert(id);
	// 	$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Inventory</b>");
	// 	$.ajax({
	// 		type:'POST',
	// 		url:siteurl+'spk_aktual/ViewHeader/'+id,
	// 		data:{'id':id},
	// 		success:function(data){
	// 			$("#dialog-popup").modal();
	// 			$("#ModalView").html(data);
				
	// 		}
	// 	})
	// });

	// $(document).on('click', '.view', function(){
	// 	var id = $(this).data('id_spkproduksi');
	// 	// alert(id);
	// 	$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Inventory</b>");
	// 	$.ajax({
	// 		type:'POST',
	// 		url:siteurl+'spk_aktual/ViewHeader/'+id,
	// 		data:{'id':id},
	// 		success:function(data){
	// 			$("#dialog-popup").modal();
	// 			$("#ModalView").html(data);
				
	// 		}
	// 	})
	// });	

	
	
	// DELETE DATA
	$(document).on('click', '#proccess_reject', function(e){
		e.preventDefault()
		var id = $('#id_spkproduksi').val();
		var reason_reject = $('#reason_reject').val();
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Kembalikan ke SPK Produksi",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Approve!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type :'POST',
			  url :siteurl+'spk_aktual/RejectToProduksi',
			  dataType : "json",
			  data : {
					'id':id, 
					'reason_reject' : reason_reject
				  },
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : result.pesan,
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  :result.pesan,
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
		
	})

	//APPROVE
	$(document).on('click', '.approve', function(e){
		e.preventDefault()
		//var id = $('#id_spkproduksi').val();
		// alert(id);
		var id = $(this).data('id_spkproduksi');
		swal({
		  title: "Anda Yakin?",
		  text: "Approve LHP Produksi",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Approve!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type :'POST',
			  url :siteurl+'spk_aktual/ApproveLHPProduksi',
			  dataType : "json",
			  data : {
					'id':id,
				  },
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : result.pesan,
						  type : "success"
						},
						function (){
							window.location.reload(true);
						})
				  } else {
					swal({
					  title : "Error",
					  text  :result.pesan,
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
		
	})

  	$(function() {
	    var table = $('#example1').DataTable( {
	        orderCellsTop: true,
	        fixedHeader: true
	    } );
    	$("#form-area").hide();
  	});$(function() {
	    var table = $('#exampleoo').DataTable( {
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
