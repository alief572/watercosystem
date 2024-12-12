<?php
    $ENABLE_ADD     = has_permission('Penawaran.Add');
    $ENABLE_MANAGE  = has_permission('Penawaran.Manage');
    $ENABLE_VIEW    = has_permission('Penawaran.View');
    $ENABLE_DELETE  = has_permission('Penawaran.Delete');
	
?>
<style type="text/css">
thead input {
	width: 100%;
}
</style>
<div id='alert_edit' class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.css')?>">

<div class="box">
	<!-- /.box-header -->
	<div class="box-header"><b>Filter Produk : </b>
      <select id="idcustomer" name="idcustomer" class="form-control input-sm select" style="width: 25%;" tabindex="-1" required onchange="getcustomer()">
          <option value=""></option>
          <?php
            $cus='';
            foreach(@$customer as $kc=>$vc){
              $selected = '';
              if($this->uri->segment(3) == $vc->id_category3){
                   $selected = 'selected="selected"';
                   $cus = $vc->nama;
              }
              ?>
          <option value="<?php echo $vc->id_category3; ?>" <?php echo set_select('nm_customer', $vc->id_customer, isset($data->nama) && $data->id_category3 == $vc->id_customer) ?> <?php echo $selected?>>
            <?php echo $vc->id_category3.' , '.$vc->nama.' | '.$vc->kode_barang ?>
          </option>
          <?php } ?>
      </select>
    </div>
	<div class="box-body">
		<table id="example2" class="table table-bordered table-st riped">
		<thead>
		
					
				
		  <tr align='center'>
			<th width="5%" rowspan='2'>#</th>
            <th width="10%" rowspan='2'>Tgl Transaksi</th>
			<th width="10%" rowspan='2'>No.Transaksi</th>
			<th rowspan='2' width="10%">Jenis Transaksi</th>
			 <th rowspan='2' width="10%">Id Produk</th>
            <th rowspan='2' width="10%">Produk</th>
          	<th width='50' align="center" colspan='3'>AWAL</th>
            <th width='50' align="center" colspan='2'>TRANSAKSI</th>
            <th width='50' align="center" colspan='3'>AKHIR</th>
            
          </tr>
			
		   <tr align='center'>
			<th width='50'>Stock</th>
			<th width='50'>Booking</th>
			<th width='50'>Free Stock</th>
			<th width='50'>In/Out</th>
			<th width='50'>Booking</th>
			<th width='50'>Stock</th>
			<th width='50'>Booking</th>
			<th width='50'>Free Stock</th>
          </tr>
		</thead>

		<tbody>
		<?php if(empty($results)){
		}else{
			
			$numb=0; foreach($results AS $record){ $numb++; 
			  
			?>

		<tr>
		    <td width="5%"><?= $numb; ?></td>
            <td width="10%"><?= $record->created_on ?></td>
			<td width="10%"><?= $record->no_surat ?></td>
			<td width="10%"> <?= ucfirst($record->transaksi) ?></td>
			 <td width="10%"><?= $record->id_category3 ?></td>
            <td width="10%"><?= $record->nama ?></td>
           
			
            <td width='50'><?= $record->qty ?></td>
			<td width='50'><?= $record->qty_book ?></td>
			<td width='50'><?= $record->qty_free ?></td>
			
			<td width='50'><?php if(ucfirst($record->transaksi)=='Incoming' || ucfirst($record->transaksi)=='Adjustment plus'){echo  $record->qty_transaksi; } else if(ucfirst($record->transaksi)=='Delivery order' || ucfirst($record->transaksi)=='Adjustment minus' ) {echo  $record->qty_transaksi*(-1); } else {echo 0;} ?> </td>
			<td width='50'><?php if(ucfirst($record->transaksi)=='Sales order'){echo  $record->qty_transaksi; } else if(ucfirst($record->transaksi)=='Delivery order') {echo  $record->qty_transaksi*(-1); } else {echo 0;} ?> </td>
		   
            <td width='50'><?= $record->qty_akhir ?></td>           
            <td width='50'><?= $record->qty_book_akhir ?></td>           
            <td width='50'><?= $record->qty_free_akhir ?></td>
		</tr>
		<?php 	 }
				}
		 ?>
		</tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>

<!-- awal untuk modal dialog -->
<!-- Modal -->
<div class="modal modal-primary" id="dialog-rekap" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<div class="modal modal-default fade" id="dialog-popup" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span>&nbsp;Data Penawaran</h4>
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

<!-- modal -->
<div class="modal modal-default fade" id="ModalViewX"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id='head_title'>Closing Penawaran</h4>
		</div>
		<div class="modal-body" id="viewX">
			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal" id='close_penawaran'>Save</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
            dom: 'Blfrtip',
			buttons: [
				{
                extend: 'excel',
            }],			
	        } );
        } );
		
		
	$(document).ready(function(){
		$("#idcustomer").select2({
			placeholder: "Pilih",
			allowClear: true
		});
	});
	function getcustomer(){
        var idcus = $('#idcustomer').val();
        window.location.href = siteurl+"stock_material/view_kartu_stok/"+idcus;
    }
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

	


	function cekcus(idcus,no,ppn,id,set){
    var table = $('#example1').DataTable();
    var cek = $('#'+set);
    //alert(cek.value);
    if (cek.is(":checked")) {
      table.column(2).search( id ).draw();
    }
    else{
      table.column(2).search('').draw();
    }

    var customer = $('#cekcustomer').val();
	var cekppn   = $('#cekppn').val();
    var reason = [];
    // if($('#cekcustomer').val() == ""){
        // $('#cekcustomer').val(idcus);
	if($('#cekcustomer').val() == ""){
     	$('#cekcustomer').val(idcus);
    }else{
        if(customer != idcus){
          swal({
              title: "Peringatan!",
              text: "Customer tidak boleh berbeda",
              type: "error",
              timer: 1500,
              showConfirmButton: false
          });
          $("#set_choose_do"+no).attr("checked", false);
        }
    }
	
	
    var jumcus = 0;
    $(".set_choose_do:checked").each(function() {
        reason.push($(this).val());
        jumcus++;
    });
    $('#cekcus').val(reason.join(';'));
    if(jumcus == 0){
      $('#cekcustomer').val('');
	  
    }
  }

	function proses_do(){
    var param = $('#cekcus').val();
    var uri3 = '<?php echo $this->uri->segment(3)?>';
    window.location.href = siteurl+"stock_material/proses/"+uri3+"?param="+param;

  }
</script>
