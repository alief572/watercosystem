<?php
    $ENABLE_ADD     = has_permission('master_bentuk.Add');
    $ENABLE_MANAGE  = has_permission('master_bentuk.Manage');
    $ENABLE_VIEW    = has_permission('master_bentuk.View');
    $ENABLE_DELETE  = has_permission('master_bentuk.Delete');
	$id_category1 = $this->uri->segment(3);	
	foreach ($results['penawaran'] as $penawaran){
	}	
?>
 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
					  <div class="col-sm-12">
					  <div class="col-sm-12" align="center">
					<label  for='forecast'>PENAWARAN</label>
					</div>
						<div class="input_fields_wrap2">
					<div class="col-sm-12">
						<div class="row">
						<div class="col-sm-6">
					
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Material</label>
									    </div>
									    <div class="col-md-8">
					<select id="id_category3" name="id_category3" class="form-control select" onchange="getproperties()" required>
						<option value="">-- Pilih Type --</option>
						<?php foreach ($results['inventory_3'] as $inventory_3){ 
						$select = $penawaran->id_category3 == $inventory_3->id_category3 ? 'selected' : '';
						?>
						<option value="<?= $inventory_3->id_category3?>" <?= $select ?>><?= ucfirst(strtolower($inventory_3->nama_category2))?>-<?= ucfirst(strtolower($inventory_3->nama))?>-<?= ucfirst(strtolower($inventory_3->hardness))?>-<?= ucfirst(strtolower($inventory_3->nilai_dimensi))?></option>
						<?php } ?>
					</select>
									    </div>
										</div>
						</div>
						<div class="col-sm-6" >
					
										<div class="form-group row" id="untuk_bentuk">
										<div class="col-md-4">
									    <label for="customer">Bentuk</label>
									    </div>
									    <div class="col-md-8">
										<input type='text' class='form-control' value="<?= $penawaran->bentuk_material?>"readonly id='bentuk_material'  required name='bentuk_material' placeholder='Bentuk Material'>
									    </div>
										 <div class="col-md-8" hidden>
										<input type='text' class='form-control' value="<?= $penawaran->id_bentuk?>" readonly id='id_bentuk'  required name='id_bentuk' placeholder='Bentuk Material'>
									    </div>
										</div>
						</div>						
						</div>	
					</div>
					<div class="col-sm-12">
						<div class="row">
						<div class="col-sm-6">
										<div class='form-group row'>
										<div class='col-md-4'>
									    <label for='thickness'>Thickness</label>
									    </div>
									    <div class='col-md-8' id="untuk_thickness">
										<input type='text' class='form-control' readonly id='thickness' value="<?= $penawaran->thickness?>"  required name='thickness' placeholder='Thickness'>
										</div>
										<div hidden>
										<input type='text' class='form-control' readonly id='id_child_penawaran' value="<?= $penawaran->id_child_penawaran?>"  required name='id_child_penawaran' placeholder='Thickness'>
										</div>
										</div>
						</div>
						<div class="col-sm-6">
										<div class='form-group row'>
										<div class='col-md-4'>
									    <label for='density'>Density</label>
									    </div>
									    <div class='col-md-8' id="untuk_density">
										<input type='text' class='form-control' readonly id='density' value="<?= $penawaran->density?>"  required name='density' placeholder='Density'>
									    </div>
										</div>
						</div>						
						</div>	
					</div>
					<div class="col-sm-12">
						<div class="row">
						<div class="col-sm-6">
										<div class='form-group row'>
										<div class='col-md-4'>
									    <label for='forecast'>Forecast/Month(Kg)</label>
									    </div>
									    <div class='col-md-8'>
										<input type='text' class='form-control' id='forecast' value="<?= $penawaran->forecast?>"  required name='forecast' placeholder='Forecats/Month'>
									    </div>
										</div>
						</div>	
						<div class="col-sm-6">
										<div class='form-group row'>
										<div class='col-md-4'>
									    <label for='forecast'>Kurs Digunakan</label>
									    </div>
									    <div class='col-md-8'>
										<select id="kurs_terpakai" name="kurs_terpakai" class="form-control select"  required>
										<?php if($penawaran->kurs_terpakai == 'spot'){
											echo"
										<option>-Pilih-</option>
										<option value='spot' selected >Kurs Terbaru</option>
										<option value='10'>Kurs 10 Hari</option>
										<option value='30'>Kurs 30 Hari</option>";
										
										}elseif($penawaran->kurs_terpakai == '10'){
										echo"
										<option>-Pilih-</option>
										<option value='spot'>Kurs Terbaru</option>
										<option value='10' selected>Kurs 10 Hari</option>
										<option value='30'>Kurs 30 Hari</option>";	
										}elseif($penawaran->kurs_terpakai == '30'){
										echo"
										<option>-Pilih-</option>
										<option value='spot'>Kurs Terbaru</option>
										<option value='10'>Kurs 10 Hari</option>
										<option value='30' selected>Kurs 30 Hari</option>";	
										}else{
										echo"
										<option>-Pilih-</option>
										<option value='spot'>Kurs Terbaru</option>
										<option value='10'>Kurs 10 Hari</option>
										<option value='30'>Kurs 30 Hari</option>";	
										}?>
										</select>
									    </div>
										</div>
						</div>
						<div class="col-sm-6" hidden>
										<div class='form-group row'>
										<div class='col-md-4'>
									    <label for='forecast'>Inventory1</label>
									    </div>
									    <div class='col-md-8' id="untuk_inven1">
										<input type='text' class='form-control' id='inven1'  value="<?= $penawaran->inven1?>"   required name='inven1' placeholder='Bentuk Material'>
									    </div>
										</div>
						</div>							
						</div>	
					</div>
					<div class="col-sm-12">
						<div class="row" id="untuk_pricelist">
					<?php
					$no_penawaran=$penawaran->no_penawaran;
					$npn	= $this->db->query("SELECT * FROM tr_penawaran WHERE no_penawaran = '$no_penawaran' ")->result();
					$id_kurs=$npn[0]->mata_uang;
					$id_category3=$penawaran->id_category3;
					$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
					$inven1 =$penawaran->inven1;
					if($inven1 == "I2000001"){
			$plquery	= $this->db->query("SELECT * FROM ms_pricelistfr WHERE id_category3 = '$id_category3' ")->result();
			if(empty($plquery)){
				echo "<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label>
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
					<table class='col-sm-12'>
					<tr>
						<th><center>Book Price<c/enter></th>
					</tr>
					<tr>
						<td><center>
						Price List Untuk Material Ini Belum Terinput
						</center></td>
					</tr>
					</table>
					</div>
					</div>";
			}else{
		$bottom_price = $plquery[0]->bottom_price;
			echo "	<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label>
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
					<table class='col-sm-12'>
					<tr>
						<th><center>Book Price<c/enter></th>
					</tr>
					<tr>
						<td><center>Rp. $bottom_price  ,-</center></td>
					</tr>
					</table>
					</div>
					</div>
					";};
		} elseif ($inven1 == "I2000002") {
			
			$plquery	= $this->db->query("SELECT * FROM ms_pricelistnfr WHERE id_category3 = '$id_category3' ")->result();
			if(empty($plquery)){
				echo "<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label>
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
					<table class='col-sm-12'>
					<tr>
						<th><center>Book Price<c/enter></th>
						<th><center>LME 10 Hari</center></th>
						<th><center>LME 30 Hari</center></th>
						<th><center>LME SPOT</center></th>
					</tr>
					<tr>
						<td colspan='4'><center>
						Price List Untuk Material Ini Belum Terinput
						</center></td>
					</tr>
					</table>
					</div>
					</div>";
			}else{
			$hariini = date('Y-m-d');
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
		$tendays = date("Y-m-d", $sepuluh_hari);
		$tglnow = date('d');
		$blnnow = date('m');
		if ($blnnow != '1'){ 
		$blnkmrn = $blnnow-1;
		$yearkemaren = date('Y');
		}else{
		$blnkmrn = "12";
		$yearnow = date('Y');
		$yearkemaren = $yearnow-1;
		}				
	$kurs	= $this->db->query("SELECT * FROM mata_uang WHERE kode = 'IDR' ")->result();
	$kurs10hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE tanggal_ubah BETWEEN  '$tendays' AND '$hariini' AND kode_kurs='IDR' ")->result();
	$kurs30hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM perubahan_kurs WHERE MONTH(tanggal_ubah) =  '$blnkmrn' AND YEAR(tanggal_ubah) = '$yearkemaren' AND kode_kurs='IDR' ")->result();
	$nomkurs = $kurs[0]->kurs;
	$nomkurs10 = $kurs10hari[0]->nominal;
	$nomkurs30 = $kurs30hari[0]->nominal;
		$bottom_price = number_format($plquery[0]->bottom_price,2);
		$bottom_price10 = number_format($plquery[0]->bottom_price10*$nomkurs,2);
		$bottom_price30 = number_format($plquery[0]->bottom_price30*$nomkurs,2); 
		$bottom_pricespot = number_format($plquery[0]->bottom_pricespot*$nomkurs,2);
		$bottom_priceclear = number_format($plquery[0]->bottom_price,2);
		$bottom_price10clear = number_format($plquery[0]->bottom_price10,2);
		$bottom_price30clear = number_format($plquery[0]->bottom_price30,2); 
		$bottom_pricespotclear = number_format($plquery[0]->bottom_pricespot,2);
		$bottom_pricekurs10 = number_format($plquery[0]->bottom_price,2);
		$bottom_price10kurs10 = number_format($plquery[0]->bottom_price10*$nomkurs10,2);
		$bottom_price30kurs10 = number_format($plquery[0]->bottom_price30*$nomkurs10,2);
		$bottom_pricespotkurs10 = number_format($plquery[0]->bottom_pricespot*$nomkurs10,2);
		$bottom_pricekurs30 = number_format($plquery[0]->bottom_price,2);
		$bottom_price10kurs30 = number_format($plquery[0]->bottom_price10*$nomkurs30,2);
		$bottom_price30kurs30 = number_format($plquery[0]->bottom_price30*$nomkurs30,2);
		$bottom_pricespotkurs30 = number_format($plquery[0]->bottom_pricespot*$nomkurs30,2);
				$k =  number_format($nomkurs,2);
		$k10 =  number_format($nomkurs10,2);
		$k30 =  number_format($nomkurs30,2);
			echo "	<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label> 
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
			<table class='col-sm-12' border='1' cellspacing='0'>
					<tr>
						<th>Keterangan</th>
						<th>Kurs</th>
						<th><center>Book Price<c/enter></th>
						<th><center>LME 10 Hari</center></th>
						<th><center>LME 30 Hari</center></th>
						<th><center>LME SPOT</center></th>
					</tr>
					<tr>
						<td>Kurs Terbaru</td>
						<td><center>Rp. $k  ,-</center></td>
						<td><center>Rp. $bottom_price  ,-</center></td>
						<td><center>Rp. $bottom_price10  ,-</center></td>
						<td><center>Rp. $bottom_price30  ,-</center></td>
						<td><center>Rp. $bottom_pricespot  ,-</center></td>
					</tr>
					<tr>
					<td>Kurs 10 Hari</td>
					<td><center>Rp. $k10  ,-</center></td>
						<td><center>Rp. $bottom_pricekurs10  ,-</center></td>
						<td><center>Rp. $bottom_price10kurs10  ,-</center></td>
						<td><center>Rp. $bottom_price30kurs10  ,-</center></td>
						<td><center>Rp. $bottom_pricespotkurs10  ,-</center></td>
					</tr>
					<tr>
					<td>Kurs 30 Hari</td>
					<td><center>Rp. $k30  ,-</center></td>
						<td><center>Rp. $bottom_pricekurs30  ,-</center></td>
						<td><center>Rp. $bottom_price10kurs30  ,-</center></td>
						<td><center>Rp. $bottom_price30kurs30  ,-</center></td>
						<td><center>Rp. $bottom_pricespotkurs30  ,-</center></td>
					</tr>
					<tr>
					<td>Dolar</td>
					<td> - </td>
						<td><center>-</center></td>
						<td><center>$. $bottom_price10clear  ,-</center></td>
						<td><center>$. $bottom_price30clear  ,-</center></td>
						<td><center>$. $bottom_pricespotclear  ,-</center></td>
					</tr>
					</table>
					</div>
					</div>
					";};
		};
					?>
						</div>	
					</div>
					<div class="col-sm-12" align="center">
					<label for='forecast'>HARGA PENAWARAN</label>
					</div>
					
					<div class="col-sm-12">
						<div class="row">
						<div class="col-sm-2">
										<div class='form-group row'>
										<div class='col-md-12'>
									    <label for='komisi'>Bottom Price (Rp)</label>
									    </div>
										</div>
						</div>
						<div class="col-sm-5">
						<div class='form-group row'>
									    <div class='col-md-12'>
										<input type='text' class='form-control' id='bottom' value="<?= $penawaran->bottom?>"  required name='bottom' placeholder='Bottom Price'>
									    </div>
										</div>
						</div>
						<div class="col-sm-5">
										<div class='form-group row'>
									    <div class='col-md-12'>
					<select id="dasar_harga" name="dasar_harga" class="form-control select"  required>
					<?php
					if($penawaran->dasar_harga == "Book Price"){
						echo"
						<option value=''>-- Pilih --</option>
						<option selected value='Book Price'>Book Price</option>
						<option value='LME 10 Hari'>LME 10 Hari</option>
						<option value='LME 30 Hari'>LME 30 Hari</option>
						<option value='LME SPOT'>LME SPOT</option>";
					}elseif($penawaran->dasar_harga == "LME 10 Hari"){
						echo"
						<option value=''>-- Pilih --</option>
						<option value='Book Price'>Book Price</option>
						<option selected value='LME 10 Hari'>LME 10 Hari</option>
						<option value='LME 30 Hari'>LME 30 Hari</option>
						<option value='LME SPOT'>LME SPOT</option>";
					}
					elseif($penawaran->dasar_harga == "LME 30 Hari"){
						echo"
						<option value=''>-- Pilih --</option>
						<option value='Book Price'>Book Price</option>
						<option value='LME 10 Hari'>LME 10 Hari</option>
						<option selected value='LME 30 Hari'>LME 30 Hari</option>
						<option value='LME SPOT'>LME SPOT</option>";
					}
					elseif($penawaran->dasar_harga == "LME SPOT"){
						echo"
						<option value=''>-- Pilih --</option>
						<option value='Book Price'>Book Price</option>
						<option value='LME 10 Hari'>LME 10 Hari</option>
						<option value='LME 30 Hari'>LME 30 Hari</option>
						<option selected value='LME SPOT'>LME SPOT</option>";
					}
					else{
						echo"
						<option value=''>-- Pilih --</option>
						<option value='Book Price'>Book Price</option>
						<option value='LME 10 Hari'>LME 10 Hari</option>
						<option value='LME 30 Hari'>LME 30 Hari</option>
						<option value='LME SPOT'>LME SPOT</option>";
					}
					?>

					</select>
										</div>
										</div>
						</div>
						</div>	
					</div>
					<div class="col-sm-12">
						<div class="row">
						<div class="col-sm-2">
										<div class='form-group row'>
										<div class='col-md-12'>
									    <label for='komisi'>Komisi (%)</label>
									    </div>
										</div>
						</div>
						<div class="col-sm-5">
						<div class='form-group row'>
									    <div class='col-md-12'>
										<input type='text' class='form-control' id='komisi' value="<?= $penawaran->komisi?>" required name='komisi' onkeyup="hitungkomisi()" placeholder='Komisi'>
									    </div>
										</div>
						</div>
						<div class="col-sm-5">
										<div class='form-group row'>
									    <div class='col-md-12'>
										<input type='text' class='form-control' id='keterangan' value="<?= $penawaran->keterangan?>" required name='keterangan' placeholder='Keterangan'>
										</div>
										</div>
						</div>
						</div>	
					</div>

					<div class="col-sm-12">
						<div class="row">
						<div class="col-sm-2">
										<div class='form-group row'>
										<div class='col-md-12'>
									    <label for='harga_penawaran'>Harga Penawaan</label>
									    </div>
										</div>
						</div>
						<div class="col-sm-10">
										<div class='form-group row'>
									    <div class='col-md-12' id="tempat_penawaran">
										<input type='text' class='form-control' id='harga_penawaran' value="<?= $penawaran->harga_penawaran?>"  required name='harga_penawaran' placeholder='Bentuk Material'>
									    </div>
										</div>
						</div>					
						</div>	
					</div>
						</div>
				 	<hr>
					<center>
					<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
					</center>
					</div>
				  </form>
				  
				  
				  
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