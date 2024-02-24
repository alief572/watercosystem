<?php
    $ENABLE_ADD     = has_permission('Adjustmentstock.Add');
    $ENABLE_MANAGE  = has_permission('Adjustmentstock.Manage');
    $ENABLE_VIEW    = has_permission('Adjustmentstock.View');
    $ENABLE_DELETE  = has_permission('Adjustmentstock.Delete');
	$id_bentuk = $this->uri->segment(3);
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
	<li class="active"><a href="#history" data-toggle="tab" aria-expanded="true">History Adjustment Stock</a></li>
    <li ><a href="#adjust" data-toggle="tab" aria-expanded="true">Add Adjust</a></li>
  </ul>
 </div> 

<div class="tab-content">  
<div class="tab-pane active" id="history">
<div class="box">

	<div class="box-body">
		<table id="exampleaa" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>#</th>
			<th>No Transaksi</th>
			<th>Tanggal</th>
			<th>Material</th>
			<th>Adjust</th>
			<th>Gudang</th>
			<th>Keterangan</th>
			<th>Jumlah Stock</th>
		</tr>
		</thead>
		<tbody>
		<?php if(empty($results)){
		}else{
			$numb=0; foreach($results['history'] AS $historia){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td ><?= $historia->id_transaksi ?></td>
			<td ><?= $historia->tanggal_transaksi ?></td>
			<td><?= $historia->nama_material ?></td>
			<td><?= $historia->adjustment ?></td>
			<td><?php 
			if($historia->adjustment == "PLUS"){
			echo"".$historia->nama_gudang."";
			}elseif($historia->adjustment == "MINUS"){
			echo"".$historia->nama_gudang."";
			}elseif($historia->adjustment == "MUTASI"){
			echo"".$historia->nama_gudang."->".$historia->nama_gudang_baru."";
			} ?></td>
			<td><?= $historia->note ?></td>
			<td><?= $historia->total_qty ?></td>


		</tr>
		<?php } }  ?>
		</tbody>
	</table>
	</div>
	<!-- /.box-body -->
</div>
</div>
<div class="tab-pane" id="adjust">
<div class="box">

	<div class="box-body">
		<table id="examplebb" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th  width="5">Id Produk</th>
			<th width="5">Kode Barang</th>
			<th>Nama Produk</th>
			<th>Supplier</th>
			<th>Qty Aktual</th>
			<th>Qty Free</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>
		<tbody>
		<?php if(empty($results)){
		}else{
			$numb=0; foreach($results['stok'] AS $record){ $numb++; ?>
		<tr>
		    <td width="5"><?= $numb; ?></td>
			<td width="5"><?= $record->id_category3 ?></td>
			<td width="5"><?= $record->kode_barang ?></td>
			<td><?= $record->nama?></td>
			<td ></td>
			<td><?= number_format($record->qty,2)?></td>
			<td><?= number_format($record->qty_free,2)?></td>
			<td style="padding-left:20px"> 
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm edit" href="javascript:void(0)" title="Add Adjustment" data-id_inventory3="<?=$record->id_category3?>" data-id_stock="<?=$record->id_stock?>" data-id_gudang="<?=$record->id_gudang?>"><i class="fa fa-edit"></i></a>
	     	<?php endif; ?>
			</td>

		</tr>
		<?php } }  ?>
		</tbody>
	</table>
	</div>
	<!-- /.box-body -->
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Adjustment Stock</h4>
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
		var id = $(this).data('id_inventory3');
		var idstock = $(this).data('id_stock');
		var idgudang = $(this).data('id_gudang');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Adjust Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'adjustmentstockmulti/AdjustNow/'+id+'/'+idstock+'/'+idgudang,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	$(document).on('click', '.copy', function(e){
		var id = $(this).data('id_inventory3');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Copy Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'inventory_4/copyInventory/'+id,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	$(document).on('click', '.view', function(){
		var id = $(this).data('id_inventory3');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'inventory_4/viewInventory/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
		$(document).on('click', '.add', function(){
			var id = $(this).data('id_bentuk');
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
		var id = $(this).data('id_inventory3');
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
			  url:siteurl+'inventory_4/deleteInventory',
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

	    var table = $('#exampleaa').DataTable( {
	        orderCellsTop: true,
	        fixedHeader: true
	    } );
    	$("#form-area").hide();
  	});
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

	    var table = $('#examplebb').DataTable( {
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
