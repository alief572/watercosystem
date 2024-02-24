<?php
    $ENABLE_ADD     = has_permission('Control_PO.Add');
    $ENABLE_MANAGE  = has_permission('Control_PO.Manage');
    $ENABLE_VIEW    = has_permission('Control_PO.View');
    $ENABLE_DELETE  = has_permission('Control_PO.Delete');
	
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
	</div>
	<!-- /.box-header -->
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>#</th>
			<th>Customer</th>
			<th>SPK Marketing</th>
            <th>Alloy</th>
            <th>Thickness</th>
            <th>Width</th>
            <th>Qty Order (Kg)</th>
            <th>Qty Delivery (Kg)</th>
            <th>Balance</th>
            <th>Option</th>
		</tr>
		</thead>

		<tbody>
		<?php 
            if(!empty($results)){
                $numb=0; 
                foreach($results AS $record){ $numb++;
				
				$nospkmarketing = $record->id_dt_spkmarketing;
				
				$tr = $this->db->query("SELECT 
                                        SUM(a.weight_mat) as total
										FROM dt_delivery_order_child a                                         										
									WHERE a.id_dt_spkmarketing='$nospkmarketing'                                       
                                    
                                    ")->row();
                ?>
                    <tr>
                        <td><?= $numb; ?></td>
                        <td><?= $record->name_customer ?></td>
                        <td><?= $record->no_surat ?></td>
                        <td><?= $record->no_alloy ?></td>
                        <td class='text-right'><?= number_format($record->thickness,2) ?></td>
                        <td class='text-right'><?= number_format($record->width,2) ?></td>
                        <td class='text-right'><?= number_format($record->qty_produk,2) ?></td>
                        <td class='text-right'><?= number_format($tr->total,2) ?></td>
                        <td class='text-right'><?= number_format($record->qty_produk - $tr->total,2) ?></td>
                        <td>
                            
                            <?php if($record->close_do == 'N'){ ?>
                            <button type='button' class='btn btn-sm btn-warning checked' title='Close DO' data-id_po='<?=$record->id_dt_spkmarketing;?>'><i class='fa fa-check'></i></button>
                            <?php } 
							elseif($record->close_do == 'Y'){ ?>
                            <button type='button' class='btn btn-sm btn-success'>Close</button>
                            <?php } ?>
							
                        </td>
                    </tr>
                <?php 
                } 
            }  
        ?>
		</tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>

<!-- awal untuk modal dialog -->

<div class="modal modal-default fade" id="dialog-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="head_title"><span class="fa fa-users"></span></h4>
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
    $(function() {
	    var table = $('#example1').DataTable( {
	        orderCellsTop: true,
	        fixedHeader: true
	    } );
    	$("#form-area").hide();
  	});

	$(document).on('click', '.detail', function(e){
		var id_detail = $(this).data('id_po');
		$("#head_title").html("<b>Detial View</b>");
		$.ajax({
			type:'POST',
			url:siteurl+'control_po/modal_detail/'+id_detail,
			success:function(data){
				$("#dialog-popup").modal();
				$("#ModalView").html(data);
			}
		})
	});

    $(document).on('click', '.checked', function(e){
		e.preventDefault()
		var id_po = $(this).data('id_po');

		swal({
		  title: "Anda Yakin?",
		  text: "Close DO ?",
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
			  url:siteurl+'control_do/close_do',
			  dataType : "json",
			  data:{'id_po':id_po},
			  success:function(result){
				  if(result.status == '1'){
					 swal({
						  title: "Sukses",
						  text : "DO Closed.",
						  type : "success"
						},
						function (){
							window.location.reload(true);
						});
				  } else {
					swal({
					  title : "Error",
					  text  : "Data error. Gagal Approve data",
					  type  : "error"
					});
				  }
			  },
			  error : function(){
				swal({
					  title : "Error",
					  text  : "Data error. Gagal request Ajax",
					  type  : "error"
					});
			  }
		  })
		});
		
	});
	

	
	
	
	
	

  	
	
</script>
