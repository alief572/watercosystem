<?php
    $ENABLE_ADD     = has_permission('Warehouse_material.Add');
    $ENABLE_MANAGE  = has_permission('Warehouse_material.Manage');
    $ENABLE_VIEW    = has_permission('Warehouse_material.View');
    $ENABLE_DELETE  = has_permission('Warehouse_material.Delete');
	$id_category3 = $this->uri->segment(3);
	$jumlah	= $this->db->query("SELECT SUM(qty) as jumlahqty, SUM(totalweight) as jumlahtotalweight, SUM(weight) as jumlahweight FROM stock_material WHERE id_category3 = '$id_category3 '  ")->result();
	$bentuk	= $this->db->query("SELECT b.nm_bentuk as namabentuk FROM ms_inventory_category3 as a INNER JOIN ms_bentuk as b on a.id_bentuk=b.id_bentuk WHERE a.id_category3 = '$id_category3 '  ")->result();
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
				<a class="btn btn-success btn-sm add" href="javascript:void(0)" data-id_category3="<?=$id_category3?>" title="Add"><i class="fa fa-plus">&nbsp;</i>Add</a>
			<?php endif; ?>
			<a class="btn btn-primary btn-sm" href="<?= base_url('/stock_material') ?>" title="Detail" >Back</a>
		
	</div>
	<!-- /.box-header -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>#</th>
			<th>Lot Number</th>
			<th>Nama Material</th>
			<th>width</th>
			<th>length</th>
			<th>Berat Satuan</th>
			<th>Jumlah Item</th>
			<th>Total Berat</th>
			<th>Gudang</th>

			<?php if($ENABLE_MANAGE) : ?>
			<th>Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results)){
		}else{
			
			$numb=0; foreach($results AS $record){ $numb++; 
			$lot = $record->lotno;
			?>
		<tr>
		    <td><?= $numb; ?></td>
			<td ><?= $lot?></td>
			<td ><?= $record->nama_category3?></td>
			<td class='text-right'><?= $record->width ?></td>
			<td><?= $record->length ?></td>
			<td class='text-right'><?= $record->sisa_spk ?> Kg</td>
			<td class='text-right'><?= $record->qty ?> <?= $bentuk[0]->namabentuk ?></td>
			<td class='text-right'><?= $record->sisa_spk * $record->qty ?> Kg</td>
			<td><?= $record->nama_gudang ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view" href="javascript:void(0)" title="View" data-id_inventory3="<?=$record->id_category3?>"><i class="fa fa-eye"></i></a>
			<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="5">Jumlah</th>
				<th class='text-right'><?= $jumlah[0]->jumlahweight ?> Kg</th>
				<th class='text-right'><?= $jumlah[0]->jumlahqty ?> <?= $bentuk[0]->namabentuk ?></th>
				<th class='text-right'><?= $jumlah[0]->jumlahtotalweight ?> Kg</th>
				<th colspan="2"></th>
			</tr>
		</tfoot>
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Data Stok Material</h4>
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
		var id = $(this).data('id_bentuk');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_bentuk/editBentuk/'+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	$(document).on('click', '.view', function(){
		var id = $(this).data('id_bentuk');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_bentuk/viewBentuk/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
		$(document).on('click', '.add', function(){
		var id = $(this).data('id_category3');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'stock_material/AddStock/'+id,
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
