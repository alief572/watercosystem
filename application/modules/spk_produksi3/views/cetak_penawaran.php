<?php
    $ENABLE_ADD     = has_permission('master_bentuk.Add');
    $ENABLE_MANAGE  = has_permission('master_bentuk.Manage');
    $ENABLE_VIEW    = has_permission('master_bentuk.View');
    $ENABLE_DELETE  = has_permission('master_bentuk.Delete');
	$id_category1 = $this->uri->segment(3);	
	foreach ($results['header'] as $header){
	}	
?>
 <div class="box box-primary">
    <div class="box-body">
		<div class='col-sm-12'>
		<table 	class='col-sm-12'>
		<tr >
			<td colspan='2'>
			<table 	class='col-sm-12'>
			<tr>
				<th> PT Metalsindo Pacific</th>
				<th size ='50%'></th>
				<th size='25%'></th>
			</tr>
			</table>
			</td>
		</tr>
		<tr >
			<td colspan='2'>
			<table 	class='col-sm-12' border='1'>
			<tr align = 'center'>
				<th><center><label>Quotation</label></center></th>
			</tr>
			</table>
			</td>
		</tr>	
		<tr>
			<td size='50%'>
			<table >
			<tr align = 'center'>
				<td>
					<table size='50%'>
						<tr><td colspan='4'>Address :</td></tr>
						<tr><td colspan='4'>Jl. Jababeka XIV, Blok J no. 10 H</td></tr>
						<tr><td colspan='4'>Cikarang Industrial Estate, Bekasi 17530</td></tr>
						<tr>
						<td>PHONE :</td>
						<td>(62-21)89831726734</td>
						<td>,FAX</td>
						<td>(62-21)89831866</td>
						</tr>
						<tr><td>NPWP:</td>
						<td >21.098.204.7-414.000</td>
						<td colspan='2'></td></tr>
					</table>
				</td>
			</tr>
			</table>
			</td>
			<td size='50%'>
			<table >
			<tr>
				<td>
				<table size='50%'>
						<tr >
						<td size='30%'>QUOTE No. :</td>
						<td size='70%'><?= $header->no_surat ?></td>
						</tr>
						<tr>
						<td size='30%'>Date On.  :</td>
						<td size='70%'><?= $header->tgl_penawaran ?></td>
						</tr>
				</table>
				</td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan='2' >
			<center>
			<table class='col-sm-6' border='1'>
			<tr>
				<td><center><table>
						<tr><td>Custommer</td><td>:</td><td><?= $header->name_customer ?></td></tr>
						<tr><td>Address</td><td>:</td><td><?= $header->address_office ?></td></tr>
						<tr><td>Phone</td><td>:</td><td><?= $header->telephone ?></td></tr>
						<tr><td>FAX</td><td>:</td><td><?= $header->fax ?></td></tr>
					</table>
					<center>
					</td>
			</tr>
			</table>
			</center>
			</td>
		</tr>		
		<table>		
		</div>		  
	</div>
</div>	
	
				  
				  
				  
<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	
	$(document).ready(function(){
	
	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image	= $('#image').val();
			var idtype	= $('#inventory_4').val();
			
			var data, xhr;
			swal({
				  title: "Are you sure?",
				  text: "You will not be able to process again this data!",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-danger",
				  confirmButtonText: "Yes, Process it!",
				  cancelButtonText: "No, cancel process!",
				  closeOnConfirm: true,
				  closeOnCancel: false
				},
				function(isConfirm) {
				  if (isConfirm) {
						var formData 	=new FormData($('#data-form')[0]);
						var baseurl=siteurl+'penawaran/saveEditPenawaran';
						$.ajax({
							url			: baseurl,
							type		: "POST",
							data		: formData,
							cache		: false,
							dataType	: 'json',
							processData	: false, 
							contentType	: false,				
							success		: function(data){								
								if(data.status == 1){											
									swal({
										  title	: "Save Success!",
										  text	: data.pesan,
										  type	: "success",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									window.location.href = base_url + active_controller;
								}else{
									
									if(data.status == 2){
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}else{
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}
									
								}
							},
							error: function() {
								
								swal({
								  title				: "Error Message !",
								  text				: 'An Error Occured During Process. Please try again..',						
								  type				: "warning",								  
								  timer				: 7000,
								  showCancelButton	: false,
								  showConfirmButton	: false,
								  allowOutsideClick	: false
								});
							}
						});
				  } else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				  }
			});
		});
		
});

function getproperties(){
        var id_category3=$("#id_category3").val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran/cari_bentuk',
            data:"id_category3="+id_category3,
            success:function(html){
               $("#untuk_bentuk").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran/cari_density',
            data:"id_category3="+id_category3,
            success:function(html){
               $("#untuk_density").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran/cari_thickness',
            data:"id_category3="+id_category3,
            success:function(html){
               $("#untuk_thickness").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran/cari_pricelist',
            data:"id_category3="+id_category3,
            success:function(html){
               $("#untuk_pricelist").html(html);
            }
        });
				$.ajax({
            type:"GET",
            url:siteurl+'penawaran/cari_inven1',
            data:"id_category3="+id_category3,
            success:function(html){
               $("#untuk_inven1").html(html);
            }
        });
    }
			function hitungkomisi(){
        var bottom=$("#bottom").val();
		var komisi=$("#komisi").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'penawaran/hitung_komisi',
            data:"&bottom="+bottom+"&komisi="+komisi,
            success:function(html){
               $("#tempat_penawaran").html(html);
            }
        });
    }
	function hitungbottomspot(){
        var lmespot=$("#lmespot").val();
		var scrap=$("#scrap").val();
		var cogs=$("#cogs").val();
		var operating_cost=$("#operating_cost").val();
		var interest=$("#interest").val();
		var profit=$("#profitspot").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfrspot',
            data:"lmespot="+lmespot+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profitspot="+profitspot,
            success:function(html){
               $("#bt_pricespot").html(html);
            }
        });
    }
</script>