<?php
    $ENABLE_ADD     = has_permission('Material_Planing.Add');
    $ENABLE_MANAGE  = has_permission('Material_Planing.Manage');
    $ENABLE_VIEW    = has_permission('Material_Planing.View');
    $ENABLE_DELETE  = has_permission('Material_Planing.Delete');
	
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">

<div class="box">
	<div class="box-body">
		<div>
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#mat1" class='mat1' aria-controls="mat1" role="tab" data-toggle="tab">Material Planning</a></li>
				<li role="presentation" class=""><a href="#mat2" class='mat2' aria-controls="mat2" role="tab" data-toggle="tab">Closing SPK Produksi</a></li>
			</ul>

			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="mat1">
					<br>
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>No. SPK</th>
								<th>Custommer</th>
								<th>No. Aloy</th>
								<th>Thickness</th>
								<th>Width</th>
								<th>Delivery Date</th>
								<th>Total Weight</th>
								<th>Total SPK</th>
								<th>FG</th>
								<?php if($ENABLE_MANAGE) : ?>
								<th>Action</th>
								<?php endif; ?>
							</tr>
						</thead>

						<tbody>
							<?php if(empty($results)){
							}else{
								
								$numb=0; foreach($results AS $record){ 
									if ($record->status_lanjutan==1){	
								$numb++; 
								$id_spkmarketing = $record->id_spkmarketing;
								$totalharga	= $this->db->query("SELECT SUM(total_harga) as total FROM dt_spkmarketing WHERE id_spkmarketing='$id_spkmarketing' ")->result();
								$booking	= $this->db->query("SELECT 
																	SUM(a.berat) as total,
																	b.id_category3
																FROM 
																	stock_material_customer a 
																	LEFT JOIN stock_material b ON a.id_stock=b.id_stock
																WHERE 
																	a.id_customer = '$record->id_customer' 
																	AND b.id_category3 = '$record->id_material'
																	AND b.width = '$record->width'
																")->result();
								?>
							<tr>
								<td><?= $numb; ?></td>
								<td><?= $record->no_surat ?></td>
								<td><?= strtoupper($record->name_customer) ?></td>
								
								<td><?= $record->no_alloy ?></td>
								<td align='right'><?= number_format($record->thickness,2); ?></td>
								<td align='right'><?= number_format($record->width,2); ?></td>
								<td align='right'><?= date('d-M-Y', strtotime($record->delivery)); ?></td> 
								<td align='right'><?= number_format($record->qty_produk) ?></td>
								<td align='right'>-</td>
								<td align='right'><?= number_format($booking[0]->total,2);?></td>
								<td>
								<?php if($ENABLE_VIEW) : ?> 
									<a class="btn btn-warning btn-sm edit" href="javascript:void(0)" title="Lihat Stock" data-id_dt_spkmarketing="<?=$record->id_dt_spkmarketing?>" data-id_material="<?=$record->id_material?>" data-width="<?=$record->width?>" data-view='edit'><i class="fa fa-bars"></i>
									</a>
								<?php endif; ?>
								<?php if($ENABLE_VIEW) : ?>
									<a class="btn btn-primary btn-sm" href="<?= base_url('/purchase_request/add_pr/'.$record->id_dt_spkmarketing) ?>" title="Create PR" data-no_inquiry="<?=$record->no_inquiry?>"><i class="fa fa-table"></i>
									</a>
								<?php endif; ?>
								
								<?php if($ENABLE_VIEW) : ?>
								<?php if ($record->status_lanjutan==1){ ?>
									<a class="btn btn-success btn-sm delete" href="javascript:void(0)" title="Approve" data-id_dt_spkmarketing="<?=$record->id_dt_spkmarketing?>" data-id_material="<?=$record->id_material?>"><i class="fa fa-check"></i>
									</a>
								<?php } ?>
								
								<?php endif; ?>
								</td>

							</tr>
							<?php } } }  ?>
						</tbody>
					</table>
				</div>
				
				<div role="tabpanel" class="tab-pane " id="mat2">
					<br>
					<table id="example2" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>No. SPK</th>
								<th>Custommer</th>
								<th>No. Aloy</th>
								<th>Thickness</th>
								<th>Width</th>
								<th>Delivery Date</th>
								<th>Total Weight</th>
								<th>Total SPK</th>
								<th>FG</th>
								<?php if($ENABLE_MANAGE) : ?>
								<th>Action</th>
								<?php endif; ?>
							</tr>
						</thead>

						<tbody>
							<?php if(empty($results)){
							}else{
								
								$numb=0; foreach($results AS $record){ 
									if ($record->status_lanjutan==2){
									$numb++; 
								$id_spkmarketing = $record->id_spkmarketing;
								$totalharga	= $this->db->query("SELECT SUM(total_harga) as total FROM dt_spkmarketing WHERE id_spkmarketing='$id_spkmarketing' ")->result();
								$booking	= $this->db->query("SELECT 
																	SUM(a.berat) as total,
																	b.id_category3
																FROM 
																	stock_material_customer a 
																	LEFT JOIN stock_material b ON a.id_stock=b.id_stock
																WHERE 
																	a.id_customer = '$record->id_customer' 
																	AND b.id_category3 = '$record->id_material'
																	AND b.width = '$record->width'
																")->result();
								?>
							<tr>
								<td><?= $numb; ?></td>
								<td><?= $record->no_surat ?></td>
								<td><?= strtoupper($record->name_customer) ?></td>
								
								<td><?= $record->no_alloy ?></td>
								<td align='right'><?= number_format($record->thickness,2); ?></td>
								<td align='right'><?= number_format($record->width,2); ?></td>
								<td align='right'><?= date('d-M-Y', strtotime($record->delivery)); ?></td> 
								<td align='right'><?= number_format($record->qty_produk) ?></td>
								<td align='right'>-</td>
								<td align='right'><?= number_format($booking[0]->total,2);?></td>
								<td>
								<?php if($ENABLE_VIEW) : ?> 
									<a class="btn btn-warning btn-sm edit" href="javascript:void(0)" title="Lihat Stock" data-id_dt_spkmarketing="<?=$record->id_dt_spkmarketing?>" data-id_material="<?=$record->id_material?>"  data-width="<?=$record->width?>" data-view='onlyview'><i class="fa fa-bars"></i>
									</a>
								<?php endif; ?>
								
								<?php if($ENABLE_VIEW) : ?>
								<?php if ($record->status_lanjutan==2){ ?>
									<a class="btn btn-danger btn-sm hapus" href="javascript:void(0)" title="Close" data-id_dt_spkmarketing="<?=$record->id_dt_spkmarketing?>" data-id_material="<?=$record->id_material?>"><i class="fa fa-trash"></i> 
									</a>
								<?php } ?>
								
								<?php endif; ?> 
								
								</td>

							</tr>
							<?php } } }  ?>
						</tbody>
					</table>
				</div>

			</div>
		</div>
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
  <div class="modal-dialog" style='width:70%;'>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
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

	$(document).on('click', '.edit', function(e){
		var id = $(this).data('id_dt_spkmarketing');
		var id_material = $(this).data('id_material');
		var width = $(this).data('width');
		var view = $(this).data('view');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'material_planing/EditHeader',
			data:{
				'id' : id,
				'id_material' : id_material,
				'width' : width,
				'view' : view
			},
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
	
	$(document).on('click', '.view', function(){
		var id = $(this).data('id_material');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'material_planing/ViewStock/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});

	
	
	// DELETE DATA
	$(document).on('click', '.delete', function(e){
		e.preventDefault()
		var id = $(this).data('id_dt_spkmarketing');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data Material Planing akan di approve.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Approve!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'material_planing/Approve',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data Inventory berhasil dihapus.",
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
		
	})
	
	
	// DELETE DATA
	$(document).on('click', '.hapus', function(e){
		e.preventDefault()
		var id = $(this).data('id_dt_spkmarketing');
		// alert(id); 
		swal({ 
		  title: "Anda Yakin?",
		  text: "Data Material Planing akan di Close.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-info",
		  confirmButtonText: "Ya, Close!",
		  cancelButtonText: "Batal",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
			  type:'POST',
			  url:siteurl+'material_planing/Close',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data Material Planing berhasil di close.",
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
		
	})

  	$(function() {
    	// $('#example1 thead tr').clone(true).appendTo( '#example1 thead' );
	    // $('#example1 thead tr:eq(1) th').each( function (i) {
	        // var title = $(this).text();
	        //alert(title);
	        // if (title == "#" || title =="Action" ) {
	        	// $(this).html( '' );
	        // }else{
	        	// $(this).html( '<input type="text" />' );
	        // }

	        // $( 'input', this ).on( 'keyup change', function () {
	            // if ( table.column(i).search() !== this.value ) {
	                // table
	                    // .column(i)
	                    // .search( this.value )
	                    // .draw();
	            // }else{
	            	// table
	                    // .column(i)
	                    // .search( this.value )
	                    // .draw();
	            // }
	        // } );
	    // } );

	    var table = $('#example1').DataTable( {
	        orderCellsTop: true,
	        fixedHeader: true
	    } );

		var table = $('#example2').DataTable( {
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
