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
			
		
		<div class="box-body">
		<table id="example2" class="table table-bordered table-striped">
		<thead>
					<tr class='bg-blue'>
						<th class="text-center" width='4%'>No Urut</th>
						<th class="text-center" width='4%'>No Revenue</th>
						<th class="text-center" width='4%'>No Detail So</th>
						<th width='7%'>Tgl</th>
						<th width='18%'>Id SO</th>
						<th width='18%'>No SO</th>
						<th width='18%'>No Invoice</th>
						<th width='18%'>Id Produk</th>
						<th width='18%'>Nama Produk</th>
						<th width='7%'>Kode Barang</th>						
												
					</tr>
				</thead>
				<tbody>
		<?php if(empty($results)){
		}else{
			
			$totalinvoice=0;
			$totalhpp=0;
			$numb=0;
			$numb_urut=0;
			foreach($results AS $record){ 
			$numb++; 
			$so  = $record->no_so;
			$material = $this->db->query("select a.id_so_detail, a.id_category3,a.nama_produk,b.kode_barang FROM tr_sales_order_detail a 
									inner join ms_inventory_category3 b on a.id_category3 = b.id_category3 WHERE a.no_so='$so'")->result();
				
						
			$so = $record->no_so;		
				$invoice = $this->db->query("select no_surat FROM tr_invoice WHERE no_so='$so'")->result();
				$separator =',';
				$allinv = array();
				foreach($invoice as $inv){
				$allinv[] = $inv->no_surat;	
				$invoicing = $inv->no_surat;					
				}
				
				$invc =  implode($separator, $allinv);
				
				
			foreach($material AS $mat){
		    $numb_urut++;
			?>
		<tr>
		    <td><?= $numb_urut; ?></td>
			<td><?= $record->id ?></td>
			<td><?= $mat->id_so_detail ?></td>
			<td><?=  date('d-F-Y', strtotime($record->tgl_so)) ?></td>
			<td><?= $record->no_so ?></td>
			<td><?= $record->no_surat ?></td>
			<td><?= $invc ?></td>
			<td><?= $mat->id_category3 ?></td>
			<td><?= $mat->nama_produk ?></td>
			<td><?= $mat->kode_barang ?></td>
         

		</tr>
			<?php  } 
			
			}	?>
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
			lengthMenu:[1000,4000,5000,10000],
	        fixedHeader: true,
			scrollX: true,
            dom: 'Blfrtip',
			buttons: [
				{
                extend: 'excel',
            }],			
	        } );
        } );
		
		
	$(document).on('click', '.buktip', function(e){
		e.preventDefault();
		$("#head_title").html("<b>Penerimaan Bukti Potong</b>");
		$.ajax({
			type:'POST',
			url: base_url + active_controller+'penerimaan_buktipotong/'+$(this).data('kd_pembayaran'),
			success:function(data){
				$("#ModalView").modal();
				$("#view").html(data);
			},
			error: function() {
				swal({
				  title				: "Error Message !",
				  text				: 'Connection Timed Out ...',
				  type				: "warning",
				  timer				: 5000,
				  showCancelButton	: false,
				  showConfirmButton	: false,
				  allowOutsideClick	: false
				});
			}
		});
	});	
	$(document).on('click', '.detail', function(e){
		e.preventDefault();
		$("#head_title").html("<b>VIEW PAYMENT ["+$(this).data('id_bq')+"]</b>");
		$.ajax({
			type:'POST',
			url: base_url + active_controller+'view_penerimaan/'+$(this).data('id_bq'),
			success:function(data){
				$("#ModalView").modal();
				$("#view").html(data);
			},
			error: function() {
				swal({
				  title				: "Error Message !",
				  text				: 'Connection Timed Out ...',
				  type				: "warning",
				  timer				: 5000,
				  showCancelButton	: false,
				  showConfirmButton	: false,
				  allowOutsideClick	: false
				});
			}
		});
	});
	
	function add_inv(){ 
        window.location.href = base_url + active_controller +'modal_detail_invoice'; 
    }
	
	function add_unlocated(){ 
        window.location.href = base_url + active_controller +'unlocated'; 
    }

	$(document).on('click', '.print', function(e){
		e.preventDefault();
		var invoice = $(this).data('inv');
		// alert(invoice); return false;
		swal({
		   title: "Yakin Akan Diproses?",
		  text: "Data tidak bisa dirubah lagi !!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Ya, Proses!",
		  cancelButtonText: "Tidak, Batalkan!",
		  closeOnConfirm: true,
		  closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$('#spinnerx').show();
				window.open(base_url + active_controller+'print_invoice_fix/'+invoice);
				
			} 
			else {
			swal("Cancelled", "Data can be process again :)", "error");
			return false;
			}		
		});		
	});	
	$(document).on('click', '.print1', function(e){
		e.preventDefault();
		var invoice = $(this).data('inv');
		// alert(invoice); return false;
		swal({
		   title: "Yakin Akan Diproses?",
		  text: "Data tidak bisa dirubah lagi !!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Ya, Proses!",
		  cancelButtonText: "Tidak, Batalkan!",
		  closeOnConfirm: true,
		  closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$('#spinnerx').show();
				window.open(base_url + active_controller+'print_invoice_np_fix/'+invoice);
			} 
			else {
			swal("Cancelled", "Data can be process again :)", "error");
			return false;
			}		
		});		
	});	 
	$(document).on('click', '.print2', function(e){
		e.preventDefault();
		var invoice = $(this).data('inv');
		// alert(invoice); return false;
		swal({
		   title: "Yakin Akan Diproses?",
		  text: "Data tidak bisa dirubah lagi !!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Ya, Proses!",
		  cancelButtonText: "Tidak, Batalkan!",
		  closeOnConfirm: true,
		  closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$('#spinnerx').show();
				window.open(base_url + active_controller+'print_invoice_np_fix/'+invoice);
			} 
			else {
			swal("Cancelled", "Data can be process again :)", "error");
			return false;
			}		
		});	
	});
	$(document).on('click', '.jurnal', function(e){
		e.preventDefault();
		var invoice = $(this).data('inv');
		// alert(invoice); return false;
		swal({
		   title: "Yakin Akan Diproses?",
		  text: "Data tidak bisa dirubah lagi !!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Ya, Proses!",
		  cancelButtonText: "Tidak, Batalkan!",
		  closeOnConfirm: true,
		  closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$('#spinnerx').show();
				window.open(base_url + active_controller+'appr_jurnal/'+invoice);
				location.reload();				
			} else {
			swal("Cancelled", "Data can be process again :)", "error");
			return false;
			}
		});
	});
	$(document).on('click', '.edit', function(e){
		e.preventDefault();
		$("#head_title").html("<b>EDIT INVOICE ["+$(this).data('inv')+"]</b>"); 
		$.ajax({
			type:'POST',
			url: base_url +'invoicing/edit_invoice/'+$(this).data('inv'),
			success:function(data){
				$("#ModalView").modal();
				$("#view").html(data);
			},
			error: function() {
				swal({
				  title				: "Error Message !",
				  text				: 'Connection Timed Out ...',
				  type				: "warning",
				  timer				: 5000,
				  showCancelButton	: false,
				  showConfirmButton	: false,
				  allowOutsideClick	: false
				});
			}
		});
	});

	$(document).on('click', '.terima', function(e){
		e.preventDefault();	
		window.location.href = base_url +'penerimaan/modal_detail_invoice/'+$(this).data('inv');
	});
	
	$("#incomplete").click(function(){
		$('#dialog-data-incomplete').modal('show');
//        $("#list_item_stok").DataTable({lengthMenu:[10,15,25,30]}).draw();		
	});

</script>
