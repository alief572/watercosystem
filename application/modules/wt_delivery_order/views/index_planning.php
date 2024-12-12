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

	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>#</th>
			<th width="10%">No.Planning </th>
			<th width="10%">No.SO</th>
			<th>Nama Customer</th>
            <th>Marketing</th>
            <th>TOP</th>
			<th>Status<br>SPK</th>
			<th>Approval<br>Finance</th>
			<?php if($ENABLE_MANAGE) : ?>
			<th>Action</th>
			<?php endif; ?>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results)){
		}else{
			
			$numb=0; foreach($results AS $record){ $numb++; 
                $plan = $this->db->query("SELECT sum(qty_so) as total_so, sum(qty_delivery) as total_delivery, sum(qty_spk) as total_spk FROM tr_planning_delivery_detail WHERE no_planning='$record->no_planning'")->row();
			
			    if($record->top == 1){				
				$tagih = $this->db->query("SELECT * FROM view_plan_tagih_cash WHERE no_planning='$record->no_planning'")->row();
				}
				elseif($record->top == 2){
				$tagih = $this->db->query("SELECT * FROM view_plan_tagih_kredit WHERE no_planning='$record->no_planning'")->row();
				}
				elseif($record->top == 3){
				$tagih = $this->db->query("SELECT * FROM view_plan_tagih_indent1 WHERE no_planning='$record->no_planning'")->row();
				}
				elseif($record->top == 4){
				$tagih = $this->db->query("SELECT * FROM view_plan_tagih_indent2 WHERE no_planning='$record->no_planning'")->row();
				}
			?>

			<?php if ($record->status <> '6' OR $record->status <> '7' ) { ?>
			
			<?php 
			
			   if($plan->total_spk == 0  && ($plan->total_so > $plan->total_spk) )
				{
					$Statusdo = "<span class='badge bg-grey'>Belum Create SPK</span>";
				}
				elseif($plan->total_spk != 0 && ($plan->total_so > $plan->total_spk) )
				{
					
					$Statusdo = "<span class='badge bg-blue'>Parsial</span>";
				}
				elseif($plan->total_spk != 0 && ($plan->total_so == $plan->total_spk) )
				{
					
					$Statusdo = "<span class='badge bg-green'>Complete</span>";
				}

                if ($record->approval_finance != 1) {

                    $approve = "<span class='badge bg-orange'>Menunggu Approval</span>";
                } else {
                    $approve = "<span class='badge bg-green'>Approved</span>";
                }
			
			?>

		
            <tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->no_surat_planning ?></td>
			<td><?= $record->no_surat ?></td>
			<td><?= strtoupper($record->name_customer) ?></td>
            <td><?= $record->nama_sales ?></td>
            <td><?= $record->nama_top ?></td>
            <td><?= $Statusdo ?></td>
            <td><?= $approve ?></td>
			<td nowrap>
			
			<?php 
			
			//if($tagih->total_bayar_idr > $tagih->nilai_invoice):
			
			if(($plan->total_spk == 0  && ($plan->total_so > $plan->total_spk) && $record->approval_finance==1) OR ($plan->total_spk != 0 && ($plan->total_so > $plan->total_spk) && $record->approval_finance==1) ) :
			if($ENABLE_MANAGE)  : ?>
			<a class="btn btn-success btn-sm" href="<?= base_url('/wt_delivery_order/proses/?param='.$record->no_planning) ?>" title="Create SPK" data-no_inquiry="<?=$record->no_inquiry?>"> <i class="fa fa-check">Create SPK</i>
			</a> 
			<?php endif; ?>	
			<?php endif; ?>
			<?php// endif; ?>
			
			</td>
		</tr>
		<?php 	 
			     
				
				}
			 } 
			 
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

<!-- page script -->
<script type="text/javascript">
	$(document).ready(function(){
		$("#idcustomer").select2({
			placeholder: "Pilih",
			allowClear: true
		});
	});
	function getcustomer(){
        var idcus = $('#idcustomer').val();
        window.location.href = siteurl+"wt_delivery_order/addSpkdelivery/"+idcus;
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
    window.location.href = siteurl+"wt_delivery_order/proses/"+uri3+"?param="+param;

  }
</script>
