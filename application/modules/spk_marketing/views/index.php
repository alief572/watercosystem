<?php
    $ENABLE_ADD     = has_permission('SPK_marketing.Add');
    $ENABLE_MANAGE  = has_permission('SPK_marketing.Manage');
    $ENABLE_VIEW    = has_permission('SPK_marketing.View');
    $ENABLE_DELETE  = has_permission('SPK_marketing.Delete');
	
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
			<?php if($ENABLE_VIEW) : ?>
			<a class="btn btn-success btn-sm" href="<?= base_url('/spk_marketing/addHeader/') ?>"  title="Tambah"><i class="fa fa-plus">&nbsp;</i>Add</i></a>
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
			<th >Tanggal SPK Terbit</th>
			<th>No. SPK</th>
			<th>Custommer</th>
			<th>Nilai SPK</th>
			<th>Status</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results)){
		}else{
			
			$numb=0; foreach($results AS $record){ $numb++; 
			$id_spkmarketing = $record->id_spkmarketing;
			$totalharga	= $this->db->query("SELECT SUM(total_harga) as total FROM dt_spkmarketing WHERE id_spkmarketing='$id_spkmarketing' ")->result();
			?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->tgl_spk_marketing ?></td>
			<td><?= $record->no_surat ?></td>
			<td><?= $record->name_customer ?></td>
			
			<td align='right'> Rp <?= number_format($totalharga[0]->total); ?></td>
			<td>
				<?php if($record->status_approve == '1'){ ?>
					<label class="label label-success">Approved</label>
				<?php }else{ ?>
					<label class="label label-danger">Belum di Approve</label>
				<?php } ?>
			</td>
			<?php if($record->status_approve == '1'){ ?>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view" href="javascript:void(0)" title="View" data-id_spkmarketing="<?=$record->id_spkmarketing?>"><i class="fa fa-eye"></i>
				</a>
			    <a class="btn btn-success btn-sm" href="<?= base_url('/spk_marketing/PrintH2/'.$record->id_spkmarketing) ?>" target="_blank"title="Print" ><i class="fa fa-print"></i></a>
			<?php endif; ?>
				<!--
				<a class="btn btn-primary btn-sm delete" href="javascript:void(0)" title="Approve" data-id_spkmarketing="<?=$record->id_spkmarketing?>"><i class="fa fa-check"></i>
				</a>
				-->
			</td>
			<?php }else{ ?>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view" href="javascript:void(0)" title="View" data-id_spkmarketing="<?=$record->id_spkmarketing?>"><i class="fa fa-eye"></i>
				</a>
				<a class="btn btn-success btn-sm" href="<?= base_url('/spk_marketing/PrintH2/'.$record->id_spkmarketing) ?>" target="_blank"title="Print" ><i class="fa fa-print"></i></a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
			<a class="btn btn-info btn-sm" href="<?= base_url('/spk_marketing/editHeader/'.$record->id_spkmarketing) ?>"  title="Edit"><i class="fa fa-edit">&nbsp;</i></i></a>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_VIEW) : 
				if(!empty(checkApprove($record->id_spkmarketing))){
				?>
				<a class="btn btn-success btn-sm delete" href="javascript:void(0)" title="Approve" data-id_spkmarketing="<?=$record->id_spkmarketing?>"><i class="fa fa-check"></i>
				</a>
			<?php }
			endif; ?>

			</td>
			<?php } ?>
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;SPK MARKETING</h4>
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
	
	$(document).on('click', '.view', function(){
		var id = $(this).data('id_spkmarketing');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'spk_marketing/ViewHeader/'+id,
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
		var id = $(this).data('id_spkmarketing');
		// alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data Inventory akan di Approve.",
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
			  url:siteurl+'spk_marketing/Approve',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data Inventory berhasil diApprove.",
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
