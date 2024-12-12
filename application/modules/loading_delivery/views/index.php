<?php
    $ENABLE_ADD     = has_permission('Loading_delivery.Add');
    $ENABLE_MANAGE  = has_permission('Loading_delivery.Manage');
    $ENABLE_VIEW    = has_permission('Loading_delivery.View');
    $ENABLE_DELETE  = has_permission('Loading_delivery.Delete');
	$last_dateX = date('d-m-Y', strtotime($results[0]->value1)).' - '.date('d-m-Y', strtotime($results[0]->value2));
	
	// echo $last_dateX; exit;
?>

<div class="box">
	<div class="box-header">
		<span class="pull-right">
			<div class="input-group">
				Range Date
				<input type="text" class="form-control float-right" id="range_picker" readonly value='<?=$last_dateX;?>'>
			</div>
		</span>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<div id="tmp_loading" style='padding: 20px;'></div>
	</div>
	<!-- /.box-body -->
</div>

<div class="modal fade" id="ModalView">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id='head_title'>Default Modal</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body" id="view">
			
		</div>
		<div class="modal-footer justify-content-between">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<link rel="stylesheet" href="<?= base_url('assets/daterangepicker.css')?>">
<script src="<?= base_url('assets/daterangepicker.js')?>"></script>

<style>
    #range_picker{
		cursor: pointer;
	}
	
	.tableFixHead {
		overflow: auto;
		position: sticky;
		top: 0;
	}

	.thead, .th {
		position: sticky;
		top: 0;
		z-index: 9999;
		background: #e1e1e1;
		color: black;
	}

	.tfoot, .th {
		position: sticky;
		bottom: 0;
		z-index: 9999;
		background: white;
		color: black;
	}

	.td:first-child{
		position:sticky;
		left:0;
		z-index: 999;
		background-color:white;
	}

	.th:first-child {
		position:sticky;
		left:0;
		z-index: 9999;
		background-color:white;
	}
	
</style>
<!-- page script -->
<script type="text/javascript">
	$(document).ready(function(){
        $('#range_picker').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
		
		var range		= $('#range_picker').val();
		var tgl_awal 	= '0';
		var tgl_akhir 	= '0';
		if(range != ''){
		var sPLT 		= range.split(' - ');
		var tgl_awal 	= sPLT[0];
		var tgl_akhir 	= sPLT[1];
		}

		// loading_spinner();
		$.ajax({
			url: base_url+active_controller+'get_loading_machine/'+tgl_awal+'/'+tgl_akhir,
			cache: false,
			type: "POST",
			dataType: "json",
			success: function(data){
				$("#tmp_loading").html(data.header);
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
		
		$('#range_picker').on('apply.daterangepicker', function(ev, picker) {
			// var machine		= $('#machine').val();
			var range		= $('#range_picker').val();
			var tgl_awal 	= '0';
			var tgl_akhir 	= '0';
			if(range != ''){
			var sPLT 		= range.split(' - ');
			var tgl_awal 	= sPLT[0];
			var tgl_akhir 	= sPLT[1];
			}
			// loading_spinner();
			$.ajax({
				url: base_url+active_controller+'/get_loading_machine/'+tgl_awal+'/'+tgl_akhir,
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data){
					$("#tmp_loading").html(data.header);
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
		
		$(document).on('click','.change_loading', function(e){
			e.preventDefault();
			var id_dt_spkmarketing		= $(this).data('id_dt_spkmarketing');
			var delivery= $(this).data('delivery');
			var id_spkmarketing		= $(this).data('id_spkmarketing');
			// alert(id_sch+", "+tgl_produksi);
			
			// loading_spinner();
			$("#head_title").html("Change Loading");
			$.ajax({
				type:'POST',
				url: base_url + active_controller+'/modal_change_loading/'+id_dt_spkmarketing+'/'+delivery+'/'+id_spkmarketing,
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
		
		$(document).on('click','#update_loading', function(e){
			e.preventDefault();
			
			swal({
			  title: "Anda Yakin?",
			  text: "Data akan di process.",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-info",
			  confirmButtonText: "Ya, Process!",
			  cancelButtonText: "Batal",
			  closeOnConfirm: false
			},
			function(){
					var formData 	=new FormData($('#form_update_loading')[0]);
						var baseurl = base_url + active_controller +'/modal_change_loading';
			  $.ajax({
					type:'POST',
					url:baseurl,
					dataType 	: "json",
					data		: formData,
					cache		: false,
					dataType	: 'json',
					processData	: false,
					contentType	: false,
				  success:function(result){
					  if(result.status == '1'){
						 swal({
							  title: "Sukses",
							  text : "Data berhasil diprocess.",
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
		
	});
</script>
