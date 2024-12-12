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
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">

<div class="box">
	<div class="box-header">
			<form method="post" action="<?= base_url() ?>reports/tampilkan_do_so" autocomplete="off">
				<div class="row">
					<div class="col-sm-10">
						<div class="col-sm-2">
							<div class="form-group">
								<br>
								<label>Tanggal</label>
								<input type="date" name="tanggal" id="tanggal" class="form-control input-sm">
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

		<span class="pull-right">
		</span>
	</div>
	
	<!-- /.box-header -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example2" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>#</th>
			<th>Tgl Revenue</th>
			<th>Tgl SO</th>
			<th>No SO</th>
			<th>Tgl DO</th>
			<th>No DO</th>
			<th>Id Material</th>
            <th width="10%">Nama Barang</th>
			<th>Kode Barang</th>
            <th>Kode Mas</th>
			<th>Qty SO</th>
			<th>Qty DO</th>
			<th>Harga Jual</th>
			<th>Nilai Diskon</th>
			<th>Total Harga Jual</th>
			<th>Costbook</th>
			<th>Total HPP</th>
			<th>Profit</th>
			
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results)){
		}else{
			
			
			$totalhpp1=0;
			$totalgrandtotal=0;
			$numb=0;
			foreach($results AS $record){ 
			$numb++; 
			
			$total_do = $record->total_do;
			$totalhpp = $record->cost_book*$total_do;
			$material = $record->id_category3;
			$noso 	  = $record->no_so;
			$nodo 	  = $record->no_do;
			
			$totalhpp1  += $record->cost_book*$total_do;
			$totalgrandtotal  += $record->total_harga;
			   
			  
			  $totalhppformat  = number_format($totalhpp1,2);
			  $totalgrandtotalformat  = number_format($totalgrandtotal,2);
			  
			  
			  
			
			
			
			$mat = $this->db->query("SELECT kode_barang, kode_mas FROM ms_inventory_category3 WHERE id_category3 ='$material' ")->row();
			$so = $this->db->query("SELECT no_surat, tgl_so FROM tr_sales_order WHERE no_so ='$noso' ")->row();
			// $do = $this->db->query("SELECT no_surat, tgl_do FROM tr_delivery_order WHERE no_do ='$nodo' ")->row();
			
		?>
			
			   
			<tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->tgl_so ?></td>
			<td><?= $so->tgl_so ?></td>
			<td><?= $so->no_surat ?></td>
			<td><?= $record->tgl_do ?></td>
			<td><?= $record->no_surat ?></td>
            <td><?= $record->id_category3 ?></td>
			<td><?= $record->nama_produk ?></td>            
			<td><?= $mat->kode_barang ?></td>
			<td><?= $mat->kode_mas ?></td>
			<td><?= $record->qty_so ?></td>
			<td><?= $record->total_do ?></td>
			<td><?= number_format($record->harga_satuan) ?></td>
			<td><?= number_format($record->nilai_diskon) ?></td>
			<td><?= number_format($record->total_harga) ?></td>			
			<td><?= number_format($record->cost_book) ?></td>
			<td><?= number_format($totalhpp) ?></td>
			<td><?= number_format($record->total_harga - $totalhpp  ) ?></td>
			
			
		</tr>
		<?php 	 
			}
				
	    ?>
		</tbody>
		
		<tfoot>
		<tr>
		    <td></td>
			<td>Total</td>			
            <td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td align="right"><?=$totalgrandtotalformat?></td>
			<td></td>
			<td align="right"><?=$totalhppformat?></td>
			<td></td>
			</tr> 
		</tfoot>
		
	<?php 	 
			}
				
	    ?>
		
		</table>
	</div>
	<!-- /.box-body -->
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
			lengthMenu:[10,1000,4000,5000,10000],
	        fixedHeader: true,
			scrollX: true,
            dom: 'Blfrtip',
			buttons: [
				{
                extend: 'excel',
            }],			
	        } );
        } );
		
		
	$(document).on('click', '.edit', function(e){
		var id = $(this).data('no_penawaran');
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Edit Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'wt_penawaran/editPenawaran/'+id,
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
		var id = $(this).data('no_penawaran');
		// alert(id);
		$("#head_title").html("<i class='fa fa-list-alt'></i><b>Detail Inventory</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'penawaran/ViewHeader/'+id,
			data:{'id':id},
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
				
			}
		})
	});
	
	
	
	// CLOSE PENAWARAN
	$(document).on('click','.close_penawaran', function(e){
		e.preventDefault();
		var id = $(this).data('no_penawaran');
		
		$("#head_title").html("Closing Penawaran");
		$.ajax({
			type:'POST',
			url: base_url + active_controller+'/modal_closing_penawaran/'+id,
			success:function(data){
				$("#ModalViewX").modal();
				$("#viewX").html(data);

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

  	$(function() {
    	  
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
