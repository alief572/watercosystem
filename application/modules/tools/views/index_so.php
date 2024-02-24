<?php
    $ENABLE_ADD     = has_permission('Management.Add');
    $ENABLE_MANAGE  = has_permission('Management.Manage');
    $ENABLE_VIEW    = has_permission('Management.View');
    $ENABLE_DELETE  = has_permission('Management.Delete');
?>
	<style type="text/css">
thead input {
	width: 100%;
}

.modal-dialog {
/* new custom width */
width: 85%;
}

</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">

<div class="box">
		<form method="post" action="<?= base_url() ?>tools/tampilkan_so" autocomplete="off">
				<div class="row">
					<div class="col-sm-10">
						<div class="col-sm-2">
							<div class="form-group">
								<br>
								<label>Nomor SO</label>
								<input type="text" name="nomor" id="nomor" class="form-control input-sm">
							</div>
						</div>
						<div class="col-sm-5">
							<div class="form-group">
								<br>
								<label> &nbsp;</label><br>
								<input type="submit" name="tampilkan" value="Tampilkan" onclick="return check()" class="btn warnaTombol pull-center"> &nbsp;
							</div>
						</div>
					</div>
				</div>
			
			
			</form>		
		
		<div class="box-body">
		<table id="example2" class="table table-bordered table-striped">
		<thead>
				<tr>
					<th>#</th>
					<th width="10%">No.SO</th>
					<th>Nama Customer</th>
					<th>Marketing</th>
					<th>Nilai<br>Penawaran</th>
					<th>Nilai<br>SO</th>
					<?php if($ENABLE_MANAGE) : ?>
					<th>Action</th>
					<?php endif; ?>
				</tr>
		</thead>
		<tbody>
		<?php if(empty($results)){
		}else{
			
			
			foreach($results AS $record){ 
			$numb++; 
							
			?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->no_surat ?></td>
			<td><?= strtoupper($record->name_customer) ?></td>
            <td><?= $record->nama_sales ?></td>
              <td><?= number_format($record->total_penawaran) ?></td>
			<td><?= number_format($record->grand_total) ?></td>
			<td>
            <?php if($ENABLE_DELETE) : ?>
				<a class="btn btn-danger btn-sm delete" href="javascript:void(0)" title="Delete" data-no_planning="<?=$record->no_so?>"><i class="fa fa-trash"></i>
				</a>
			<?php endif; ?>
	       </td>

		</tr>
		<?php }  ?>
		</tbody>
		
		<?php }  ?>
				
			</table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->	
		<!-- modal -->
		<div class="modal fade" id="ModalView">
			<div class="modal-dialog"  style='width:80%; '>
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="head_title"></h4>
						</div>
						<div class="modal-body" id="view">
						</div>
						<div class="modal-footer">
						<!--<button type="button" class="btn btn-primary">Save</button>-->
						<button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- modal -->
		
	<div class="modal modal-primary" id="dialog-data-incomplete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-file-pdf-o"></span>&nbsp;Data Unlocated</h4>
      </div>
      <div class="modal-body" id="MyModalBodyUnlocated" style="background: #FFF !important;color:#000 !important;">
          <table class="table table-bordered" width="100%" id="list_item_unlocated">
              <thead>
                  <tr>
                     <th class="text-center">Tanggal</th>
					 <th class="text-center">Keterangan</th>
					 <th class="text-center">Total Penerimaan</th>
					 <th class="text-center">Bank</th>
                  </tr>
              </thead>
              <tbody>
                  <?php	
				  $cust = $inv->nm_customer;
                  $invoice = $this->db->query("SELECT * FROM tr_unlocated_bank WHERE saldo !=0 ")->result();                  				  
				  if($invoice){
					foreach($invoice as $ks=>$vs){
                  ?>
						  <tr>
							  <td><?php echo $vs->tgl ?></td>
							  <td><center><?php echo $vs->keterangan ?></center></td>
							  <td><center><?php echo number_format($vs->totalpenerimaan) ?></center></td>
							  <td><center><?php echo $vs->bank ?></center></td>							 
						  </tr>
                  <?php 
						}
					  }				  
				  ?>
              </tbody>
          </table>
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
        <span class="glyphicon glyphicon-remove"></span>  Tutup</button>
        </div>
    </div>
  </div>
</div>


<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.js')?>"></script>


<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<!-- page script -->
<script type="text/javascript">

	  $(document).ready(function() {
            $('#example2').DataTable( {
	        orderCellsTop: true,
	        fixedHeader: true,
			scrollX: true,
           } );
        } );
		
		
	// DELETE DATA
	$(document).on('click', '.delete', function(e){
		e.preventDefault()
		var id = $(this).data('no_planning');
		//alert(id);
		swal({
		  title: "Anda Yakin?",
		  text: "Data SO akan di hapus.",
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
			  url:siteurl+'tools/hapus_so',
			  dataType : "json",
			  data:{'id':id},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "Data Planning berhasil dihapus.",
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

</script>
