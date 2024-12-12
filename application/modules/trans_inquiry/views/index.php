<?php
    $ENABLE_ADD     = has_permission('Trans_inquiry.Add');
    $ENABLE_MANAGE  = has_permission('Trans_inquiry.Manage');
    $ENABLE_VIEW    = has_permission('Trans_inquiry.View');
    $ENABLE_DELETE  = has_permission('Trans_inquiry.Delete');
	
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">


<div class="nav-tabs-supplier">

  <div class="tab-content">
    <div class="tab-pane active" id="customer">
      <div class="box box-primary">
        	<div class="box-header">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-success btn-sm add_inq" href="javascript:void(0)" title="Add"><i class="fa fa-plus">&nbsp;</i>Tambah Data</a>
			<?php endif; ?>
		<span class="pull-right"></span>
	</div>
        	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%">No. CRCL</th>
			<th>Nama Customer</th>
			<th>Tanggal</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th width="13%">Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['inquiry'])){
		}else{
			
			$numb=0; foreach($results['inquiry'] AS $inquiry){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $inquiry->no_inquiry?></td>
			<td><?= $inquiry->name_customer ?></td>
			<td><?= $inquiry->tgl_inquiry ?></td>
			<td style="padding-left:20px">
			<?php if($ENABLE_VIEW) : ?>
				<a class="btn btn-primary btn-sm view_local" href="javascript:void(0)" title="View" data-id_customer="<?=$customer->id_customer?>"><i class="fa fa-eye"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_MANAGE) : ?>
				<a class="btn btn-success btn-sm edit_local" href="javascript:void(0)" title="Edit" data-id_customer="<?=$customer->id_customer?>"><i class="fa fa-edit"></i>
				</a>
			<?php endif; ?>

			<?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete_local" href="javascript:void(0)" title="Delete" data-id_customer="<?=$customer->id_customer?>"><i class="fa fa-trash"></i>
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
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Data Inquiry</h4>
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
		var id = $(this).data('id_suplier');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'master_suplier/viewLokal/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	$(document).on('click', '.add_inq', function(){
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Tambah Data</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'trans_inquiry/addInquiry',
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
	
	$(document).on('change','.get_product',function(){
	    var bentuk = $(this).val();
		var nomor =  $(this).data('no');
	    $.ajax({
	      url: siteurl+'trans_inquiry/get_product/'+bentuk,
	      cache: false,
	      type: "POST",
	      dataType: "json",
	      success: function(data){
	        $("#produk_"+nomor).html(data.option).trigger("chosen:updated");
	        swal.close();
	      },
	      error: function() {
	        swal({
	          title				: "Error Message !",
	          text				: 'Connection Time Out. Please try again..',
	          type				: "warning",
	          timer				: 3000,
	          showCancelButton	: false,
	          showConfirmButton	: false,
	          allowOutsideClick	: false
	        });
	      }
	    });
	  });

</script>
