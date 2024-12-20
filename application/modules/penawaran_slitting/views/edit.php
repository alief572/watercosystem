<?php
	$tanggal = date('Y-m-d');
		foreach ($results['head'] as $head){
	}
	$id_customer = $head->id_customer;
	$pic = $this->db->query("SELECT * FROM child_customer_pic WHERE id_customer = '$id_customer' ")->result();
?>
 <div class="box box-primary">
    <div class="box-body"><br>
		<form id="data-form" method="post">
<div class="row">
		<center><label for="customer" ><h3>Penawaran Slitting</h3></label></center>
		<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">NO.Penawaran</label>
			</div>
			<div class="col-md-8" hidden>
				<input type="text" class="form-control" id="id_slitting" value="<?= $head->id_slitting ?>"  required name="id_slitting" readonly placeholder="No.CRCL">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="no_surat" value="<?= $head->no_surat ?>"  required name="no_surat" readonly placeholder="No.Penawaran">
			</div>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Tanggal</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" id="tgl_penawaran" value="<?= $head->tgl_penawaran ?>" onkeyup required name="tgl_penawaran" readonly >
			</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">CUSTOMER</label>
				</div>
				<div class="col-md-8">
					<select id="id_customer" name="id_customer"  onchange='CariPic()'  class="form-control"required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['customers'] as $customers){
							$select = $head->id_customer == $customers->id_customer ? 'selected' : '';
								?>
						<option value="<?= $customers->id_customer?>"  <?= $select ?>><?= ucfirst(strtolower($customers->name_customer))?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Kurs</label>
			</div>
			<div class='col-md-8' id="email_slot">
					<select id="mata_uang" name="mata_uang" class="form-control select" required>
						<?php
						if($head->mata_uang == 'IDR'){
						?>
						<option value="">--Pilih--</option>
						<option value="IDR" selected>IDR(Rupiah)</option>
						<option value="USD">USD(Dolar)</option>
						<?php	
						}elseif($head->mata_uang == 'IDR'){
						?>
						<option value="">--Pilih--</option>
						<option value="IDR" >IDR(Rupiah)</option>
						<option value="USD" selected>USD(Dolar)</option>
						<?php	
						}else{
						?>
						<option value="">--Pilih--</option>
						<option value="IDR" >IDR(Rupiah)</option>
						<option value="USD">USD(Dolar)</option>
						<?php	
						}
						?>
					</select>

			</div>
		</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">PIC CUSTOMER</label>
				</div>
				<div class="col-md-8" id='list_pic'>
					<select id="pic_cutomer" name="pic_cutomer" class="form-control"required>
						<option value="">--Pilih--</option>
				<?php	
			foreach ($pic as $pic){
				$selectpic = $head->pic_customer == $pic->name_pic ? 'selected' : '';
				echo "<option value='$pic->name_pic' $selectpic>$pic->name_pic</option>";
			}
			?>
					</select>
				</div>
			</div>
		</div>
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label >VALID UNTIL</label>
			</div>
			<div class='col-md-8' >
				<input type="date" class="form-control" value="<?= $head->valid_until ?>" id="valid_until"  required name="valid_until" >
			</div>
		</div>
		</div>
		</div>
		</div>

			<br>
			<div class='box box-info'>
				<div class='box-header'>
					<h3 class='box-title'>Detail Penawaran</h3>
					<div class='box-tool pull-right'>
					</div>
				</div>
				<div class='box-body hide_header'>
					<table class='table table-striped table-bordered table-hover table-condensed' width='100%'>
			<thead>
			<tr class='bg-blue'>
			<th width='15%'>Nama Material</th>
			<th width='8%'>Berat Coil (Kg)</th>
			<th width='8%'>Density(g/cm3)</th>
			<th width='8%'>Thickness(mm)</th>
			<th width='8%'>Width (mm)</th>
			<th width='8%'>Length (M)</th>
			<th width='8%'>Waste(mm)</th>
			<th width='8%' hidden>Used</th>
			<th width='8%'>Waste(kg)</th>
			<th width='10%'>Biaya Proses</th>
			<th width='8%'>Profit</th>
			<th width='10%'>Harga Total</th>
			<th width='12%'>Harga Penawaran</th>
			<th width='6%'>#</th>
			</tr>
			</thead>
			<tbody>
			<?php
 				$id = 0;
				$loop = 0;
 						  foreach($results['detail'] AS $val2 => $val2x){
                $id++;
				$loop++;
                echo "<tr class='header_".$id."' id='trhead_".$id."'>
				";
		$material 		= $this->db->query("SELECT a.*, b.nama as alloy, c.nm_bentuk as bentuk FROM ms_inventory_category3 as a INNER JOIN ms_inventory_category2 as b ON a.id_category2 = b.id_category2 INNER JOIN ms_bentuk as c ON a.id_bentuk = c.id_bentuk WHERE a.deleted = '0' ")->result();echo "
		<th hidden><input type='text' 	 class='form-control' value='".$val2x->lotno."' id='dt_lotno_$loop' required name='dt[$loop][lotno]'></th>
		<th hidden><input type='text' 	 class='form-control' value='".$val2x->idmaterial."' id='dt_idmaterial_$loop' required name='dt[$loop][idmaterial]'></th>
		<th><input readonly type='text' class='form-control' value='".$val2x->nama_material."' id='dt_nama_material_$loop' required name='dt[$loop][nama_material]' ></th>
		<th><input type='number' 		class='form-control' value='".$val2x->berat."'  		 id='dt_berat_$loop' 			required name='dt[$loop][berat]' 			readonly onkeyup='HitungPanjang($loop)'></th>
		<th><input type='number' 		class='form-control' value='".$val2x->berat."'  		 id='dt_density_$loop' 			required name='dt[$loop][density]' 			readonly onkeyup='HitungPanjang($loop)'></th>
		<th><input type='number' 		class='form-control' value='".$val2x->density."'   id='dt_thickness_$loop' 		required name='dt[$loop][thickness]' 		readonly onkeyup='HitungPanjang($loop)'></th>
		<th><input type='number' 		class='form-control' value='".$val2x->lebar."'  		 id='dt_lebar_$loop' 	placeholder='dt_lebar_$loop' 			required name='dt[$loop][lebar]' 			readonly onkeyup='HitungPanjang($loop)'></th>
		<th><input type='number'	 	class='form-control' value='".$val2x->panjang."'  		 id='dt_panjang_$loop'  placeholder='dt_panjang_$loop'		required name='dt[$loop][panjang]' 			readonly>		</th>
		<th hidden><input type='number'	class='form-control' value='".$val2x->lebarnew."' 		 id='dt_lebarnew_$loop' placeholder='dt_lebarnew_$loop'		required name='dt[$loop][lebarnew]' 		readonly onkeyup='HitungPanjang($loop)'></th>
		<th hidden><input type='number'	class='form-control' value='".$val2x->qty."'  			 id='dt_qty_$loop'		placeholder='dt_qty_$loop'		required name='dt[$loop][qty]'      		readonly onkeyup='HitungPanjang($loop)'></th>
		<th hidden><input type='number'	class='form-control' value='".$val2x->pegangan."'  		 id='dt_pegangan_$loop' placeholder='dt_pegangan_$loop'		required name='dt[$loop][pegangan]'			readonly></th>
		<th><input type='number'	 		class='form-control' value='".$val2x->sisa."'  		 id='dt_sisa_$loop' 	placeholder='dt_sisa_$loop' 			required name='dt[$loop][sisa]' 			readonly></th>
		<th hidden><input type='number'	 		class='form-control' value='".$val2x->used."'  		 id='dt_used_$loop' 	placeholder='dt_used_$loop' 			required name='dt[$loop][used]' 			readonly></th>
		<th><input type='number'	 		class='form-control' value='".$val2x->sisakg."' 		 id='dt_sisakg_$loop' 	placeholder='dt_sisakg_$loop' 			required name='dt[$loop][sisakg]' 			readonly></th>
		<th hidden><input type='number'	class='form-control' value='".$val2x->jmlpisau."' 		 id='dt_jmlpisau_$loop' 		required name='dt[$loop][jmlpisau]' 		readonly></th>
		<th hidden><input type='number' 	class='form-control' value='".$val2x->waktu."' 		 id='dt_waktu_$loop' 			required name='dt[$loop][waktu]' 			readonly></th>
		<th><input type='number'	 		class='form-control' value='".$val2x->harga."'  		 id='dt_harga_$loop' 			required name='dt[$loop][harga]' 			readonly></th>
		<th><input type='number'			class='form-control' value='".$val2x->profit."'  		 id='dt_profit_$loop' 			required name='dt[$loop][profit]' 			readonly onkeyup='HitungPanjang($loop)'></th>
		<th><input type='number'	 		class='form-control' value='".$val2x->totalpenawaran."'  id='dt_totalpenawaran_$loop' 	required name='dt[$loop][totalpenawaran]' 	readonly></th>
		<th><input type='number'	 		class='form-control'  value='".$val2x->hargadeal."' 	 id='dt_hargadeal_$loop' 		required name='dt[$loop][hargadeal]'		></th>
		<th><button type='button' class='btn btn-sm btn-danger hapusPart' title='Hapus Part'><i class='fa fa-close'></i></button></th>				
        </tr>";
				
                $no = 0;
				$process = $this->db->query("SELECT * FROM dt_penawaran_slitting_width WHERE id_dt_slitting='".$val2x->id_dt_slitting."'")->result();
                foreach($process AS $val2D => $val2Dx){
				$no++;
      echo "<tr class='header_".$id."' id='header_".$id."_".$no."'>
				  <td align='left'>Width (mm)</td>
        <td align='left'>
        <input type='number' value='".$val2Dx->subwidth ."' name='dt[".$id."][detail][".$no."][subwidth]' readonly class='form-control input-md' placeholder='Width'  id='subwidth_".$id."_".$no."' '>
				</td>
        <td align='left'>Qty Coil</td>
        <td align='left'>
        <input type='number' value='".$val2Dx->subqty ."' name='dt[".$id."][detail][".$no."][subqty]' readonly class='form-control input-md' placeholder='Qty'   id='subqty_".$id."_".$no."' >
        </td>
		<td align='left'>Weight</td>
        <td align='left'>
        <input type='number' value='".$val2Dx->subberat ."' name='dt[".$id."][detail][".$no."][subberat]' readonly class='form-control input-md' placeholder='Berat'   id='subberat_".$id."_".$no."' >
        </td>
		<td align='left'>Weight Request</td>
        <td align='left'>
        <input type='number' value='".$val2Dx->beratreq ."' readonly name='dt[".$id."][detail][".$no."][beratreq]' class='form-control input-md formsubagain' placeholder='berat request'   id='subberatreq_".$id."_".$no."' >
        </td>
		<td align='left'>Qty Coil</td>
        <td align='left'>
        <input type='number' value='".$val2Dx->qcoil ."' readonly name='dt[".$id."][detail][".$no."][qcoil]' class='form-control input-md' placeholder='berat request'   id='subqcoil_".$id."_".$no."' >
        </td>
		<td align='center'>
		<button type='button' class='btn btn-sm btn-danger cancelSubPart' title='Delete Part'><i class='fa fa-close'></i></button>
		</td>
		</tr>";
   							}
		echo"<tr id='add_".$id."_".$no."' class='header_".$id."'>
	<td align='center'></td>
	<td align='left'><button type='button' class='btn btn-sm btn-primary addSubPart' title='Add Length'><i class='fa fa-plus'></i>&nbsp;&nbsp;Add Slitting Size</button></td>
	<td colspan='10' align='center'></td>
	</tr>";
 						  }
 			?>
							<tr id='add_<?=$id;?>'>
								<td align='center'></td>
								<td align='left'><button type='button' class='btn btn-sm btn-warning addPart' title='Add penawran'><i class='fa fa-plus'></i>&nbsp;&nbsp;Add</button></td>
								<td colspan='10'></td>
							</tr>
			</tbody>
						<thead>
			<tr class='bg-blue'>
			<th colspan='10'>Total Biaya</th>
			<th id='slot_total_peawaran'><input type='text' value="<?= $head->total_harga_penawaran ?>"  class='form-control input-md maskM' placeholder= 'Total Biaya' id='total_harga_penawaran'  readonly required name='total_harga_penawaran' ></th>
			<th width='5%' id='djancuk'>#</th>
			</tr>
			</thead>
					</table>
					<br>
		<div class="form-group row" >
		<div class="col-md-12">
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Panjang</label>
			</div>
			<div class='col-md-8' id="tpanjang_slot">
					<input type='number' class='form-control' value="<?= $head->total_panjang ?>" id='total_panjang' readonly required name='total_panjang' >
			</div>
		</div>
		</div>
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Jumlah Pisau</label>
			</div>
			<div class='col-md-8' id="jpisau_slot">
					<input type='number' class='form-control' value="<?= $head->jml_pisau ?>" id='jml_pisau' readonly required name='jml_pisau' >
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>
			<div class="col-sm-12">
		<div class="form-group row" >
		<div class="col-md-12">
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Jumlah Mother Coil</label>
			</div>
			<div class='col-md-8' id="mother_slot">
					<input type='number' class='form-control' value="<?= $head->jml_mother ?>" id='jml_mother' readonly required name='jml_mother' >
			</div>
		</div>
		</div>
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Berat Produk</label>
			</div>
			<div class='col-md-8' id="tberat_slot">
					<input type='number' class='form-control' value="<?= $head->total_berat ?>" id='total_berat' readonly required name='total_berat' >
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="form-group row" >
		<div class="col-md-12">
		<div class='col-sm-6'>
		<div class='form-group row'>
			<div class='col-md-4'>
				<label for='email_customer'>Total Waktu</label>
			</div>
			<div class='col-md-8' id="twaktu_slot">
					<input type='number' class='form-control' value="<?= $head->total_waktu ?>" id='total_waktu' readonly required name='total_waktu' >
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>
          <button type="button" class="btn btn-danger" style='float:right; margin-left:5px;' name="back" id="back"><i class="fa fa-reply"></i> Back</button>
					<button type="submit" class="btn btn-primary" style='float:right;' name="save" id="save"><i class="fa fa-save"></i> Save</button>

				</div>
			</div>
		</form>
	</div>
</div>


<script src="<?= base_url('assets/js/jquery.maskMoney.js')?>"></script>
<script src="<?= base_url('assets/js/autoNumeric.js')?>"></script>

<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';

	$(document).ready(function(){
		$('.chosen-select').select2();

		//add part
		$(document).on('click', '.addPart', function(){
			// loading_spinner();
			var get_id 		= $(this).parent().parent().attr('id');
			// console.log(get_id);
			var split_id	= get_id.split('_');
			var id 		= parseInt(split_id[1])+1;
			var id_bef 	= split_id[1];

			$.ajax({
				url: base_url+'index.php/'+active_controller+'/get_add/'+id,
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data){
					$("#add_"+id_bef).before(data.header);
					$("#add_"+id_bef).remove();
					$('.chosen_select').select2({width: '100%'});
					$('.maskM').maskMoney();
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

		//add part
		$(document).on('click', '.addSubPart', function(){
			// loading_spinner();
			var get_id 		= $(this).parent().parent().attr('id');
			// console.log(get_id);
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2])+1;
			var id_bef 		= split_id[2];

			$.ajax({
				url: base_url+'index.php/'+active_controller+'/get_add_sub/'+id+'/'+id2,
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data){
					$("#add_"+id+"_"+id_bef).before(data.header);
					$("#add_"+id+"_"+id_bef).remove();
					$('.chosen_select').select2({width: '100%'});
					$('.maskM').maskMoney();
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

		//delete part
		$(document).on('click', '.delPart', function(){
			var get_id 		= $(this).parent().parent().attr('class');
			$("."+get_id).remove();
		});
		
		$(document).on('click', '.hapusPart', function(){
			var get_id 		= $(this).parent().parent().attr('class');
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var total_harga_penawaran=$('#total_harga_penawaran').val();
		var total_panjang=$('#total_panjang').val();
		var jml_pisau=$('#jml_pisau').val();
		var jml_mother=$('#jml_mother').val();
		var total_berat=$('#total_berat').val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var jmlpisaudt=$('#dt_jmlpisau_'+id).val();
		var berat=$('#dt_berat_'+id).val();
		
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinHarga',
            data:"hargadeal="+hargadeal+"&total_harga_penawaran="+total_harga_penawaran,
            success:function(html){
               $('#slot_total_peawaran').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPanjang',
            data:"panjang="+panjang+"&total_panjang="+total_panjang+"&qty="+qty,
            success:function(html){
               $('#tpanjang_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPisau',
            data:"jmlpisaudt="+jmlpisaudt+"&jml_pisau="+jml_pisau,
            success:function(html){
               $('#jpisau_slot').html(html);
            }
        });
		$.ajax({ 
            type:"GET",
            url:siteurl+'penawaran_slitting/MinMother',
            data:"qty="+qty+"&jml_mother="+jml_mother,
            success:function(html){
               $('#mother_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinBerat',
            data:"berat="+berat+"&total_berat="+total_berat+"&qty="+qty,
            success:function(html){
               $('#tberat_slot').html(html);
			   
            }
        });
			$("."+get_id).remove();
		});

		$(document).on('click', '.delSubPart', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			$(this).parent().parent('tr').remove();
		});
		$(document).on('click', '.cancelSubPart', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subqty 		=$('#subqty_'+id+'_'+id2).val();
			var subwidth 	=$('#subwidth_'+id+'_'+id2).val();
			var subberat 	=$('#subberat_'+id+'_'+id2).val();
			var mainqty 	=$('#dt_qty_'+id).val();
			var sisa 		=$('#dt_sisa_'+id).val();
			var mainberat 	=$('#dt_berat_'+id).val();
			var mainused 	=$('#dt_used_'+id).val();
			var mainsisakg 	=$('#dt_sisakg_'+id).val();
			var mainwidth 	=$('#dt_lebarnew_'+id).val();
			var pegangan 	=$('#dt_pegangan_'+id).val();
			var lebar 	=$('#dt_lebar_'+id).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/minussubwidth',
						data:"id="+id+"&id2="+id2+"&mainwidth="+mainwidth+"&subwidth="+subwidth+"&subqty="+subqty,
						success:function(html){
						   $("#lebarnew_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/minussubqty',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#qty_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/MinusSubPisauSatuan',
						data:"id="+id+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#pisau_"+id).html(html);
						}
					}); 
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/MinusSubUsed',
						data:"id="+id+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#used_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/MinusSubSisaKg',
						data:"id="+id+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#sisakg_"+id).html(html);
						}
					}); 					
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/KunciSub',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&subwidth="+subwidth,
						success:function(html){
						   $("#header_"+id+"_"+id2).html(html);
						}
					});

					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/Minussubsisasatuan',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&subwidth="+subwidth+"&sisa="+sisa+"&mainqty="+mainqty+"&mainwidth="+mainwidth+"&pegangan="+pegangan+"&lebar="+lebar,
						success:function(html){
						   $('#sisa_'+id).html(html);
						}
					});
			$(this).parent().parent('tr').remove();
		});
		
		$(document).on('click', '.LockSubData', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subqty 		=$('#subqty_'+id+'_'+id2).val();
			var subwidth 	=$('#subwidth_'+id+'_'+id2).val();
			var subberat 	=$('#subberat_'+id+'_'+id2).val();
			var subberatreq =$('#subberatreq_'+id+'_'+id2).val();
			var subqcoil 	=$('#subqcoil_'+id+'_'+id2).val();
			var mainberat 	=$('#dt_berat_'+id).val();
			var mainused 	=$('#dt_used_'+id).val();
			var mainsisakg 	=$('#dt_sisakg_'+id).val();
			var mainqty 	=$('#dt_qty_'+id).val();
			var mainwidth 	=$('#dt_lebarnew_'+id).val();
			var pegangan 	=$('#dt_pegangan_'+id).val();
			var lebar 	=$('#dt_lebar_'+id).val();
			var sisa 	=$('#dt_sisa_'+id).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/hitungsubwidth',
						data:"id="+id+"&id2="+id2+"&mainwidth="+mainwidth+"&subwidth="+subwidth+"&subqty="+subqty,
						success:function(html){
						   $("#lebarnew_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/hitungsubqty',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#qty_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/SubUsed',
						data:"id="+id+"&id2="+id2+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#used_"+id).html(html);
						}
					});$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/SubSisaKg',
						data:"id="+id+"&id2="+id2+"&mainberat="+mainberat+"&mainused="+mainused+"&subberat="+subberat,
						success:function(html){
						   $("#sisakg_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/HitungSubPisauSatuan',
						data:"id="+id+"&subqty="+subqty+"&mainqty="+mainqty,
						success:function(html){
						   $("#pisau_"+id).html(html);
						}
					});
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/KunciSub',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&subwidth="+subwidth+"&subberat="+subberat+"&subberatreq="+subberatreq+"&subqcoil="+subqcoil,
						success:function(html){
						   $("#header_"+id+"_"+id2).html(html);
						}
					});

					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/Hitungsubsisasatuan',
						data:"id="+id+"&id2="+id2+"&subqty="+subqty+"&sisa="+sisa+"&subwidth="+subwidth+"&mainqty="+mainqty+"&mainwidth="+mainwidth+"&pegangan="+pegangan+"&lebar="+lebar,
						success:function(html){
						   $('#sisa_'+id).html(html);
						}
					});
		});
		
$(document).on('keyup', '.formsub', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subqty 		=$('#subqty_'+id+'_'+id2).val();
			var subwidth 	=$('#subwidth_'+id+'_'+id2).val();
			var maindensity 	=$('#dt_density_'+id).val();
			var mainthickness 	=$('#dt_thickness_'+id).val();
			var mainpanjang 	=$('#dt_panjang_'+id).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/HitungSubFormBerat',
						data:"id="+id+"&id2="+id2+"&maindensity="+maindensity+"&mainthickness="+mainthickness+"&mainpanjang="+mainpanjang+"&subwidth="+subwidth+"&subqty="+subqty,
						success:function(html){
						   $("#subsberat_"+id+'_'+id2).html(html);
						}
					});
		});
$(document).on('keyup', '.formsubagain', function(){
			var get_id 		= $(this).parent().parent('tr').html();
			var split_id	= get_id.split('_');
			var id 			= split_id[1];
			var id2 		= parseInt(split_id[2]);
			var subreq 		=$('#subberatreq_'+id+'_'+id2).val();
			var subrumus 	=$('#subberat_'+id+'_'+id2).val();
					$.ajax({
						type:"GET",
						url:siteurl+'penawaran_slitting/HitungSubTauApaan',
						data:"id="+id+"&id2="+id2+"&subreq="+subreq+"&subrumus="+subrumus,
						success:function(html){
						   $("#qcoils_"+id+'_'+id2).html(html);
						}
					});
		});
    //add part
		$(document).on('click', '#back', function(){
		    window.location.href = base_url + active_controller;
		});



		$('#save').click(function(e){
			e.preventDefault();
			var produk		= $('#produk').val();
			var costcenter	= $('.costcenter').val();
			var process		= $('.process').val();

			if(produk == '0' ){
				swal({
					title	: "Error Message!",
					text	: 'Product name empty, select first ...',
					type	: "warning"
				});

				$('#save').prop('disabled',false);
				return false;
			}
			if(costcenter == '0' ){
				swal({
					title	: "Error Message!",
					text	: 'Costcenter empty, select first ...',
					type	: "warning"
				});

				$('#save').prop('disabled',false);
				return false;
			}
			if(process == '0' ){
				swal({
					title	: "Error Message!",
					text	: 'Process name empty, select first ...',
					type	: "warning"
				});

				$('#save').prop('disabled',false);
				return false;
			}

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
						var baseurl=siteurl+'penawaran_slitting/save_edit';
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
	function CariPic(){
	   	var id_customer=$('#id_customer').val();

		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariPic',
            data:"id_customer="+id_customer,
            success:function(html){
               $("#list_pic").html(html);
            }
        });
	}
	
	
	function CariProperties(id){
	    var id_material=$('#dt_idmaterial_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariDensity',
            data:"id_material="+id_material+"&id="+id,
            success:function(html){
               $('#density_'+id).html(html);
            }
        });
	}
	function DeleteItem(id){
		var total_harga_penawaran=$('#total_harga_penawaran').val();
		var total_panjang=$('#total_panjang').val();
		var total_waktu=$('#total_waktu').val();
		var jml_pisau=$('#jml_pisau').val();
		var jml_mother=$('#jml_mother').val();
		var total_berat=$('#total_berat').val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var jmlpisaudt=$('#dt_jmlpisau_'+id).val();
		var berat=$('#dt_berat_'+id).val();
		var waktu=$('#dt_waktu_'+id).val();
		
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinHarga',
            data:"hargadeal="+hargadeal+"&total_harga_penawaran="+total_harga_penawaran,
            success:function(html){
               $('#slot_total_peawaran').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPanjang',
            data:"panjang="+panjang+"&total_panjang="+total_panjang+"&qty="+qty,
            success:function(html){
               $('#tpanjang_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinPisau',
            data:"jmlpisaudt="+jmlpisaudt+"&jml_pisau="+jml_pisau,
            success:function(html){
               $('#jpisau_slot').html(html);
            }
        });
		$.ajax({ 
            type:"GET",
            url:siteurl+'penawaran_slitting/MinMother',
            data:"qty="+qty+"&jml_mother="+jml_mother,
            success:function(html){
               $('#mother_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinBerat',
            data:"berat="+berat+"&total_berat="+total_berat+"&qty="+qty,
            success:function(html){
               $('#tberat_slot').html(html);
			   
            }
        });

				$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/MinTWaktu',
            data:"waktu="+waktu+"&total_waktu="+total_waktu,
            success:function(html){
               $('#twaktu_slot').html(html);
            }
        });
		 $('#stock_slot #header_'+id).remove();
		
	}
	function TambahItem(id){
	   	var lotno=$('#dt_lotno_'+id).val();
		var idmaterial=$('#dt_idmaterial_'+id).val();
		var berat=$('#dt_berat_'+id).val();
		var density=$('#dt_density_'+id).val();
		var thickness=$('#dt_thickness_'+id).val();
		var lebar=$('#dt_lebar_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var lebarnew=$('#dt_lebarnew_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var pegangan=$('#dt_pegangan_'+id).val();
		var sisa=$('#dt_sisa_'+id).val();
		var used=$('#dt_used_'+id).val();
		var sisakg=$('#dt_sisakg_'+id).val();
		var jmlpisau=$('#dt_jmlpisau_'+id).val();
		var harga=$('#dt_harga_'+id).val();
		var waktu=$('#dt_waktu_'+id).val();
		var profit=$('#dt_profit_'+id).val();
		var totalpenawaran=$('#dt_totalpenawaran_'+id).val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var nama_material=$('#dt_nama_material_'+id).val();
		var total_panjang=$('#total_panjang').val();
		var jml_pisau=$('#jml_pisau').val();
		var jml_mother=$('#jml_mother').val();
		var total_berat=$('#total_berat').val();
		var total_waktu=$('#total_waktu').val();
		var id_customer=$('#id_customer').val();
		var total_harga_penawaran=$('#total_harga_penawaran').val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/LockDetail',
            data:"lotno="+lotno+"&nama_material="+nama_material+"&waktu="+waktu+"&used="+used+"&sisakg="+sisakg+"&profit="+profit+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#trhead_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/SumHarga',
            data:"lotno="+lotno+"&total_harga_penawaran="+total_harga_penawaran+"&nama_material="+nama_material+"&waktu="+waktu+"&profit="+profit+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#slot_total_peawaran').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariTPanjang',
            data:"lotno="+lotno+"&total_harga_penawaran="+total_harga_penawaran+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#tpanjang_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariMCoils',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#mother_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariJPisau',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#jpisau_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/CariTBProduk',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#tberat_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungWaktu',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#group_waktu').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungTWaktu',
            data:"waktu="+waktu+"&total_waktu="+total_waktu,
            success:function(html){
               $('#twaktu_slot').html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungBiaya',
            data:"lotno="+lotno+"&total_panjang="+total_panjang+"&total_berat="+total_berat+"&jml_pisau="+jml_pisau+"&jml_mother="+jml_mother+"&id_customer="+id_customer+"&idmaterial="+idmaterial+"&berat="+berat+"&density="+density+"&thickness="+thickness+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&pegangan="+pegangan+"&sisa="+sisa+"&jmlpisau="+jmlpisau+"&harga="+harga+"&id="+id,
            success:function(html){
               $('#group_biaya').html(html);
            }
        });
	}
	function HitungPanjang(id){
	    var berat=$('#dt_berat_'+id).val();
		var density=$('#dt_density_'+id).val();
		var thickness=$('#dt_thickness_'+id).val();
		var lebar=$('#dt_lebar_'+id).val();
		var panjang=$('#dt_panjang_'+id).val();
		var lebarnew=$('#dt_lebarnew_'+id).val();
		var qty=$('#dt_qty_'+id).val();
		var pegangan=$('#dt_pegangan_'+id).val();
		var sisa=$('#dt_sisa_'+id).val();
		var jmlpisau=$('#dt_jmlpisau_'+id).val();
		var waktu=$('#dt_waktu_'+id).val();
		var harga=$('#dt_harga_'+id).val();
		var profit=$('#dt_profit_'+id).val();
		var totalpenawaran=$('#dt_totalpenawaran_'+id).val();
		var hargadeal=$('#dt_hargadeal_'+id).val();
		var total_panjang=$('#total_panjang').val();
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPanjang',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#panjang_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPegangan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#pegangan_'+id).html(html);
            }
        });
		
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungWaktuSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#waktu_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungHargaSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#harga_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungPisauSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#pisau_'+id).html(html);
            }
        });

		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_slitting/HitungTotalPanjangSatuan',
            data:"berat="+berat+"&density="+density+"&thickness="+thickness+"&hargadeal="+hargadeal+"&totalpenawaran="+totalpenawaran+"&profit="+profit+"&harga="+harga+"&pegangan="+pegangan+"&waktu="+waktu+"&jmlpisau="+jmlpisau+"&sisa="+sisa+"&lebar="+lebar+"&panjang="+panjang+"&lebarnew="+lebarnew+"&qty="+qty+"&id="+id,
            success:function(html){
               $('#totalpenawaran_'+id).html(html);
            }
        });
		
		

	}
</script>
