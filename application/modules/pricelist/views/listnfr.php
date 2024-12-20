<?php
    $ENABLE_ADD     = has_permission('Pricelist.Add');
    $ENABLE_MANAGE  = has_permission('Pricelist.Manage');
    $ENABLE_VIEW    = has_permission('Pricelist.View');
    $ENABLE_DELETE  = has_permission('Pricelist.Delete');
	$id_category1 = $this->uri->segment(3);
	
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
		<?php if($ENABLE_ADD) : ?>
				<a class="btn btn-success btn-sm add" href="javascript:void(0)" title="add" data-id_category1="<?=$id_category1?>"><i class="fa fa-plus">&nbsp;</i>Add</i>
				</a>
				<a class="btn btn-success btn-sm refresh" href="javascript:void(0)" title="refresh" data-id_category1="<?=$id_category1?>"><i class="fa fa-refresh">&nbsp;</i>Refresh</i>
				</a>
				<a class="btn btn-primary btn-sm" href="<?= base_url('/pricelist') ?>" title="Detail" >Back</a>
			<?php endif; ?>
		<span class="pull-right">
		</span>
		
	</div>
	<!-- /.box-header -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th>Detail Nama Material</th>
				<th>Update Terahir</th>
			<th>Bottom Price by Book Of Price</th>
			<th>Bottom Price by LME 10 Hari</th>
			<th>Bottom Price By LME 1 Bulan</th>
			<th>Bottom Price By LME Spot</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results)){
		}else{
			$numb=0; foreach($results AS $record){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->nama2.'-'.$record->nama3.'-'.$record->hardness.'-'.$record->nilai_dimensi  ?></td>
			<td>
			<?php
			if (empty($record->modified_on)){
				echo "$record->created_on";
			}else{
				echo "$record->modified_on";
			}
			?>
			</td>
			<td>$.
			<?= number_format($record->bottom_price,2) ?>
			</td>
			<td>$. 
			<?= number_format($record->bottom_price10,2) ?>
			</td>
			<td>$. 
			<?= number_format($record->bottom_price30,2) ?>
			</td>
			<td>$. 
			<?= number_format($record->bottom_pricespot,2) ?>
			</td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view" href="javascript:void(0)" title="View" data-id_pricelistnfr="<?=$record->id_pricelistnfr?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>
			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit" href="javascript:void(0)" title="Edit" data-id_pricelistnfr="<?=$record->id_pricelistnfr?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Data Inventory</h4>
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
		var id = $(this).data('id_pricelistnfr');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Pricelist</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'pricelist/editPricelistnfr/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	$(document).on('click', '.view', function(){
		var id = $(this).data('id_pricelistnfr');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Pricelist</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'pricelist/viewPricelistnfr/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
		$(document).on('click', '.add', function(){
		var id_category1 = $(this).data('id_category1');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Add Pricelist</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'pricelist/addPricelistnfr/'+id_category1,
			data:{'id_category1':id_category1},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.refresh', function(){
		var id_category1 = $(this).data('id_category1');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Add Pricelist</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'pricelist/refPricelistnfr/'+id_category1,
			data:{'id_category1':id_category1},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	
	// DELETE DATA
	$(document).on('click', '.delete', function(e){
		e.preventDefault()
		var id = $(this).data('id_bentuk');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data Inventory akan di hapus.",
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
			  url:siteurl+'master_bentuk/deleteBentuk',
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
