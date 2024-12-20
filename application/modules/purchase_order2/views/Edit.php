
<?php
	$tanggal = date('Y-m-d');
foreach ($results['head'] as $head){
}	
?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>Purchase Order</h3></label></center>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Supplier</label>
				</div>
				<div class="col-md-8"> 
					<select id="id_suplier" name="id_suplier" class='form-control input-md chosen-select'required>
						<option value="">--Pilih--</option>
							<?php foreach ($results['supplier'] as $supplier){
							$selected = ($supplier->id_suplier == $head->id_suplier)?'selected':'';	
								?> 
						<option value="<?= $supplier->id_suplier?>" <?=$selected;?>><?= strtoupper(strtolower($supplier->name_suplier))?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
				<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Local / Import</label>
				</div>
				<div class="col-md-8" id='ubahloi'>
					<select id="loi" name="loi" class="form-control select"  onchange="get_kurs()"  required>
						<option value="">--Pilih--</option>
						<?php
						if($head->loi == "Import"){
						echo"
						<option value='Import' selected>Import</option>
						<option value='Lokal'>Lokal</option>
						";
						}elseif($head->loi == "Lokal"){
						echo"
						<option value='Import'>Import</option>
						<option value='Lokal' selected>Lokal</option>
						";
						}else{
						echo"
						<option value='Import'>Import</option>
						<option value='Lokal'>Lokal</option>
						";
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
				<label for="customer">NO.PO</label>
			</div>
			<div class="col-md-8" hidden>
				<input type="text" class="form-control" id="no_po"  value="<?= $head->no_po  ?>" required name="no_po" readonly placeholder="ID PO">
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="no_surat" value="<?= $head->no_surat  ?>"  required name="no_surat" readonly placeholder="No.PR">
			</div>
		</div>
		</div>
		<div class="col-sm-6" id="input_kurs">
		
		</div>
		</div>
		<div class="col-sm-12">
			<div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
						<label for="customer">Tanggal PO</label>
					</div>
					<div class="col-md-8">
						<input type="date" class="form-control" id="tanggal" value="<?= $head->tanggal ?>" onkeyup required name="tanggal" readonly >
					</div>
				</div>
			</div>
			<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Mata Uang</label>
				</div>
				<div class="col-md-8"> 
					<select id="matauang" name="matauang" class='form-control input-md chosen-select'required>
							<?php foreach ($results['matauang'] as $supplier){
							$selected = '';	
								?> 
						<option value="<?= $supplier->kode?>" <?=$selected;?>><?= strtoupper(strtolower($supplier->kode))?></option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>
		</div>
				<!-- <div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Expect Date</label>
			</div>
			<div class="col-md-8">
				<input type="date" class="form-control" value="<?= $head->expect_tanggal  ?>"  id="expect_tanggal" required name="expect_tanggal"  >
			</div>
		</div>
		</div>
		</div> -->
				<div class="col-sm-12">
		<div class="col-sm-6">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="customer">Payment Term</label>
			</div>
			<div class="col-md-8">
				<input type="text" class="form-control" id="term" value="<?= $head->term  ?>" onkeyup required name="term" >
			</div>
		</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">PR</label>
				</div>
				<div class="col-md-8"> 
					<select id="no_pr" name="no_pr" class='form-control input-md chosen-select'required>
						<option value="0">List Empty</option>
					</select>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Price Method</label>
				</div>
				<div class="col-md-8">
						<?php
						$sel_cif = ($head->cif == 'CIF')?'selected':'';
						$sel_fob = ($head->cif == 'FOB')?'selected':'';
						$sel_loco = ($head->cif == 'LOCO')?'selected':'';
						$sel_ddu = ($head->cif == 'DDU')?'selected':'';
						$sel_fran = ($head->cif == 'FRANCO')?'selected':'';
						?>
					<select id="cif" name="cif" class="form-control select"   required>
						<option value="">--Pilih--</option>
						<option value="CIF" <?=$sel_cif;?>>CIF</option>
						<option value="FOB" <?=$sel_fob;?>>FOB</option>
						<option value="LOCO" <?=$sel_loco;?>>LOCO</option>
						<option value="DDU" <?=$sel_ddu;?>>DDU</option>
						<option value="FRANCO" <?=$sel_fran;?>>FRANCO</option>
					</select>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group row" id='kurs_place'>
			<?php
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
	$k =  number_format($nomkurs,2);
	$k10 =  number_format($nomkurs10,2);
	$k30 =  number_format($nomkurs30,2);
	if($head->loi == 'Import'){
		echo "
				<table class='col-sm-12' border='1' cellspacing='0'>
					<tr>
						<th><center>Kurs On The Spot</center></th>
						<th><center>Kurs 10 Hari</center></th>
						<th><center>Kurs 30 Hari</center></th>
					</tr>
					<tr>
						<td><center>Rp. $k  ,-</center></td>
						<td><center>Rp. $k10  ,-</center></td>
						<td><center>Rp. $k30  ,-</center></td>
					</tr>
				<table>
		";
	}else{};
			?>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group row" id='lme_place'>
			<table class='table table-bordered table-striped'>
		<thead>
		<tr>
			<th width="5">#</th>
			<th width="13%">Kompisisi</th>
			<th>Rate H-30</th>
			<th>Rate H-10</th>
			<th>Rate Saat Ini</th>
		</tr>
		</thead>

		<tbody>
		<?php if(empty($results['comp'])){ 
		}else{
		$hariini 		= date('Y-m-d');
		$satu_hari 		= mktime(0,0,0,date('n'),date('j')-1,date('Y'));
		$kemarin 		= date("Y-m-d", $satu_hari);
		$sepuluh_hari 	= mktime(0,0,0,date('n'),date('j')-14,date('Y'));
		$tendays 		= date("Y-m-d", $sepuluh_hari);
		$tglnow 		= date('d');
		$blnnow 		= date('m');
		if ($blnnow 	!= '1'){ 
		$blnkmrn	 	= $blnnow-1;
		$yearkemaren 	= date('Y');
		}else{
		$blnkmrn 		= "12";
		$yearnow 		= date('Y');
		$yearkemaren 	= $yearnow-1;
		}
			$numb3=0; foreach($results['comp'] as $comp){ $numb3++;
			$id_comp = $comp->id_compotition;
			$lme_10hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$kemarin' AND id_compotition='$id_comp' ")->result();
			$lme_30hari	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren' AND id_compotition='$id_comp' ")->result();
			?>
		<tr>
		    <td><?= $numbc; ?></td>
			<td><?= $comp->name_compotition ?></td>
			<td>$ <?= number_format( $lme_30hari[0]->nominal,2);?></td>
			<td>$ <?= number_format( $lme_10hari[0]->nominal,2);?></td>
			<td>$ <?= number_format( $comp->nominal_harga,2); ?></td>
		</tr>
		
		<?php } }  ?>
		</tbody>
		</table>
			</div>
		</div>
		<div class="col-sm-12">
				<div class="form-group row">
		<!-- <button type='button' class='btn btn-sm btn-success' title='Ambil' id='tbh_ata' data-role='qtip' onClick='addmaterial();'><i class='fa fa-plus'></i>Add</button> -->

		</div>
		<div class="form-group row" >
			<table class='table table-bordered table-striped'>
			<thead>
			<tr class='bg-blue'>
				<th>Item</th>
				<th width='8%'>Description</th>
				<th width='7%'>Width</th>
				<th width='7%'>Length</th>
				<th width='7%'>Total Weight</th>
				<th width='8%'>Rate LME</th>
				<th width='7%'>Alloy Price</th>
				<th width='7%'>Fab Cost</th>
				<th width='7%'>Unit Price</th>
				<th width='6%'>Disc %</th>
				<th width='6%'>Tax</th>
				<th width='9%'>Amount</th>
				<th width='8%'>Note</th>
				<th width='5%'>#</th>
			</tr>
			</thead>
			<tbody id="data_request">
			<?php
			$key=0;
			foreach ($results['detail'] as $val => $value){
			$key ++;

			$disabled = ($head->loi == 'Import')?'':'readonly';
			$disabled2 = ($head->loi == 'Import')?'readonly':'';

			$selected1 = ($value['rate_lme'] == 'Hari Ini')?'selected':'';
			$selected2 = ($value['rate_lme'] == 'H-10')?'selected':'';
			$selected3 = ($value['rate_lme'] == 'H-30')?'selected':'';

			echo "<tr>";
			echo 	"<td>".$value['namamaterial']."
							<input type='hidden' class='form-control input-sm' id='dt_idpr_".$key."' name='dt[".$key."][idpr]' value='".$value['idpr']."'>
							<input type='hidden' class='form-control input-sm' id='dt_idmaterial_".$key."' name='dt[".$key."][idmaterial]' value='".$value['idmaterial']."'>
							<input type='hidden' class='form-control input-sm' id='dt_namamaterial_".$key."' name='dt[".$key."][namamaterial]' value='".$value['namamaterial']."'>
							<input type='hidden' class='form-control input-sm' id='dt_qty_".$key."' name='dt[".$key."][qty]' value='".$value['qty']."'>
							<input type='hidden' class='form-control input-sm' id='dt_panjang_".$key."' name='dt[".$key."][panjang]' value='".$value['panjang']."'>
							<input type='hidden' class='form-control input-sm' id='dt_lebar_".$key."' name='dt[".$key."][lebar]' value='".$value['lebar']."'>

							<input type='hidden' class='form-control input-sm ch_diskon' id='dt_ch_diskon_".$key."'>
							<input type='hidden' class='form-control input-sm ch_pajak' id='dt_ch_pajak_".$key."'>
							<input type='hidden' class='form-control input-sm ch_jumlah' id='dt_ch_jumlah_".$key."'>

						</td>";
			echo 	"<td><input type='text' class='form-control input-sm' name='dt[".$key."][description]' id='dt_description_".$key."' value='".$value['description']."'></td>";
			echo 	"<td><input type='text' class='form-control text-right input-sm autoNumeric' name='dt[".$key."][width]' id='dt_width_".$key."'  value='".$value['width']."'></td>";
			echo 	"<td><input type='text' class='form-control text-right input-sm autoNumeric' name='dt[".$key."][length]' id='dt_length_".$key."'  value='".$value['panjang']."'></td>";
			echo 	"<td><input type='text' class='form-control text-right input-sm autoNumeric' name='dt[".$key."][totalweight]' id='dt_totalweight_".$key."' value='".$value['totalwidth']."'  onkeyup='HitAmmount(".$key.")'></td>";
			echo 	"<td>
							<select class='form-control input-sm' id='dt_ratelme_".$key."' name='dt[".$key."][ratelme]' onchange='CariPrice(".$key.")'>
								<option value=''>-Pilih-</option>
								<option value='Hari Ini' ".$selected1.">Hari ini</option>
								<option value='H-10' ".$selected2.">H-10</option>
								<option value='H-30' ".$selected3.">H-30</option>
							</select>
						</td>";
			echo 	"<td><input type='text' class='form-control text-right input-sm autoNumeric3' id='dt_alloyprice_".$key."' ".$disabled." value='".number_format($value['alloyprice'],3)."' data-decimal='.' data-thousand='' data-precision='0' data-allow-zero='' name='dt[".$key."][alloyprice]' onkeyup='HitAmmount(".$key.")'></td>";
			echo 	"<td><input type='text' class='form-control text-right input-sm autoNumeric3' id='dt_fabcost_".$key."' ".$disabled." name='dt[".$key."][fabcost]' value='".number_format($value['fabcost'],3)."' onkeyup='HitAmmount(".$key.")'></td>";
			echo 	"<td><input type='text' class='form-control text-right input-sm autoNumeric3' id='dt_hargasatuan_".$key."' ".$disabled2." name='dt[".$key."][hargasatuan]' value='".number_format($value['hargasatuan'],3)."' onkeyup='HitAmmount(".$key.")'></td>";
			echo 	"<td><input type='text' class='form-control text-right input-sm autoNumeric' id='dt_diskon_".$key."' name='dt[".$key."][diskon]' value='".number_format($value['diskon'],2)."' onkeyup='HitAmmount(".$key.")'></td>";
			echo 	"<td><input type='text' class='form-control text-right input-sm autoNumeric' id='dt_pajak_".$key."' name='dt[".$key."][pajak]' value='".number_format($value['pajak'],2)."' onkeyup='HitAmmount(".$key.")'></td>";
			echo 	"<td><input type='text' class='form-control text-right input-sm ch_jumlah_ex' id='dt_jumlahharga_".$key."' readonly name='dt[".$key."][jumlahharga]' value='".number_format($value['jumlahharga'],2)."'></td>";
			echo 	"<td><input type='text' class='form-control input-sm' id='dt_note_".$key."' name='dt[".$key."][note]' value='".$value['note']."'></td>";
			echo 	"<td>
						<button type='button' class='btn btn-sm btn-danger hapus_baris' title='Hapus Data' data-role='qtip'><i class='fa fa-close'></i></button>
					</td>";
		echo "</tr>";

		// 	$alloyprice=number_format($detail->alloyprice);
		// 	$fabcost=number_format($detail->fabcost);
		// 	$hargasatuan=number_format($detail->hargasatuan,3);
		// 	$jumlahharga=number_format($detail->jumlahharga);
		// 	echo"
		// 	<tr id='trmaterial_$loop'>
		
		// 		<td hidden><input style='font-size:90%' readonly 	type='text' 	value='".$detail->idpr."'		class='form-control' id='dt_idpr_".$loop."' 	required name='dt[".$loop."][idpr]' ></td>
		// <td hidden><input style='font-size:90%' readonly 	type='text' 	value='".$detail->idmaterial."'		class='form-control' id='dt_idmaterial_".$loop."' 	required name='dt[".$loop."][idmaterial]' ></td>
		// <td ><input	style='font-size:90%' readonly  	type='text' 	value='".$detail->namamaterial."' class='form-control' id='dt_namamaterial_".$loop."' required name='dt[".$loop."][namamaterial]' ></td>
		// <td ><input	style='font-size:90%' readonly  	type='text' 	value='".$detail->description."'	class='form-control' id='dt_description_".$loop."' 	required name='dt[".$loop."][description]' ></td>
		// <td ><input	style='font-size:90%' readonly  	type='text' 	value='".$detail->width."'			class='form-control' id='dt_width_".$loop."' 			required name='dt[".$loop."][width]'  ></td>
		// <td ><input	style='font-size:90%' readonly  	type='text' 	value='".$detail->totalwidth."'			class='form-control' id='dt_totalwidth_".$loop."' 			required name='dt[".$loop."][totalwidth]'  ></td>
		// <td hidden ><input	style='font-size:90%'	readonly  	type='number' 	value='".$detail->qty."'			class='form-control' id='dt_qty_".$loop."' 			required name='dt[".$loop."][qty]'  ></td>
		// <td ><input	style='font-size:90%'	readonly  	type='text' 	value='".$detail->rate_lme."'			class='form-control' id='dt_ratelme_".$loop."' 			required name='dt[".$loop."][ratelme]'  ></td>
		// <td ><input	style='font-size:90%'	readonly  	type='text' 	value='".$alloyprice."'			class='form-control' id='dt_alloyprice_".$loop."' 			required name='dt[".$loop."][alloyprice]'  ></td>
		// <td ><input	style='font-size:90%'	readonly  	type='text' 	value='".$fabcost."'			class='form-control' id='dt_fabcost_".$loop."' 			required name='dt[".$loop."][fabcost]'  ></td>
		// <td hidden><input	style='font-size:90%'	readonly  	type='number' 	value='".$detail->panjang."'			class='form-control' id='dt_panjang_".$loop."' 			required name='dt[".$loop."][panjang]'  ></td>
		// <td hidden><input	style='font-size:90%'	readonly  	type='number' 	value='".$detail->lebar."'			class='form-control' id='dt_lebar_".$loop."' 			required name='dt[".$loop."][lebar]'  ></td>
		// <td	><input	style='font-size:90%'	readonly  	type='text' 	value='".$hargasatuan."'	class='form-control' id='dt_hargasatuan_".$loop."' 	required name='dt[".$loop."][hargasatuan]' ></td>
		// <td	><input	style='font-size:90%'	readonly 	type='text' 	value='".$detail->diskon."'			class='form-control' id='dt_diskon_".$loop."' 		required name='dt[".$loop."][diskon]' ></td>
		// <td	><input	style='font-size:90%'	readonly	type='text' 	value='".$detail->pajak."'			class='form-control' id='dt_pajak_".$loop."' 		required name='dt[".$loop."][pajak]' ></td>
		// <td ><input	style='font-size:90%'	readonly 	type='text' 	value='".$jumlahharga."'	class='form-control' id='dt_jumlahharga_".$loop."' 	required name='dt[".$loop."][jumlahharga]' ></td>
		// <td	><input	style='font-size:90%'	readonly  	type='text' 	value='".$detail->note."'			class='form-control' id='dt_note_".$loop."' 		required name='dt[".$loop."][note]' ></td>
		// <td><button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return CancelItem($loop);'><i class='fa fa-close'></i></button></td>
		
		// </tr>
			// ";
			}
			?>
			</tbody>
			</table>
		</div>
			</div>
		
		<div class="col-sm-12">
			<div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-4">
						<label for="customer">Expect Date</label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" value="<?= date('d-M-Y', strtotime($head->expect_tanggal))  ?>"  id="expect_tanggal" required name="expect_tanggal"  readonly>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group row">
					<div class="col-md-2">
						<label for="customer">Note</label>
					</div>
					<div class="col-md-10">
						<input type="text" class="form-control"  id="note_ket" name="note_ket" value="<?=$head->note  ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Sub Total</label>
				</div>
				<div class="col-md-8" id="ForHarga">
					<input readonly type="text" class="form-control" value="<?= number_format($head->hargatotal)  ?>" id="hargatotal"  onkeyup required name="hargatotal" >
				</div>
			</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Discount</label>
				</div>
				<div class="col-md-8" id="ForDiskon">
					<input readonly type="text" class="form-control" value="<?= number_format($head->diskontotal)  ?>" id="diskontotal"  onkeyup required name="diskontotal" >
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">TAX</label>
				</div>
				<div class="col-md-8" id="ForTax">
					<input readonly type="text" class="form-control" value="<?= number_format($head->taxtotal)  ?>" id="taxtotal"  onkeyup required name="taxtotal" >
				</div>
			</div>
		</div>
		</div>
				<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="id_customer">Total Order</label>
				</div>
				<div class="col-md-8" id="ForSum">
					<input readonly type="text" class="form-control" value="<?= number_format($head->subtotal)  ?>" id="subtotal"  onkeyup required name="subtotal" >
				</div>
			</div>
		</div>
		</div>
			<center>
		<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
			</center>
				 </div>
			</div>
		</form>		   
	</div>
</div>	
	
				  
				  
		  
			  
<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){	
			var max_fields2      = 10; //maximum input boxes allowed
			var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
			var add_button2      = $(".add_field_button2"); //Add button ID			

			$(".bilangan-desimal").maskMoney();
			$('.autoNumeric3').autoNumeric('init', { vMin: 0, mDec: 3 });
			$('.autoNumeric').autoNumeric();

	SumDel();
	let id_suplier = $('#id_suplier').val();
	let no_po = "<?=$this->uri->segment(3);?>";
	if(id_suplier != '' && id_suplier != '0'){
		$.ajax({
			type	: "POST",
			url		: siteurl+'purchase_order/getPR',
			data	: {
				'id_suplier' : id_suplier,
				'no_po' : no_po
			},
			cache	: false,
			dataType: 'json',
			success:function(data){
				$('#no_pr').html(data.option).trigger("chosen:updated");
			}
		});
	}

	$(document).on('change','#id_suplier',function(){
		let id_suplier = $('#id_suplier').val();
		$.ajax({
			type	: "POST",
			url		: siteurl+'purchase_order/getPR',
			data	: {
				'id_suplier' : id_suplier
			},
			cache	: false,
			dataType: 'json',
			success:function(data){
				$('#no_pr').html(data.option).trigger("chosen:updated");
			}
		});
	});

	$(document).on('click','.hapus_baris',function(){
		$(this).parent().parent().remove();
		SumDel();
	});


	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var expect_tanggal	= $('#expect_tanggal').val();
			var loi	= $('#loi').val();
			var term	= $('#term').val();
			var cif	= $('#cif').val();
			
			var data, xhr;
				if(expect_tanggal == '' || expect_tanggal == null || loi == '' || loi == null || term == '' || term == null || cif == '' || cif == null){
					swal("Warning", "Form Tidak Boleh Kosong :)", "error");
					return false;
					}else{
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
						var baseurl=siteurl+'purchase_order/SaveEdit';
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
				}
		});
		
});
function addmaterial(){ 
		var jumlah	=$('#data_request').find('tr').length;
		var id_suplier=$("#id_suplier").val();
		var loi=$("#loi").val();
		var angka =jumlah+1;
				if( id_suplier == '' || id_suplier == null || loi == '' || loi == null){
					swal("Warning", "Silahkan Pilih Supplier Terlebih Dahulu :)", "error");
					return false;
		}else{
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/AddMaterial',
            data:"jumlah="+jumlah+"&id_suplier="+id_suplier+"&loi="+loi,
            success:function(html){
               $("#data_request").append(html);
			   $(".bilangan-desimal").maskMoney();
			   $(".chosen-select").select2({ width: '100%' });
			   $('.autoNumeric3').autoNumeric('init', { vMin: 0, mDec: 3 });
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/UbahImport',
            data:"loi="+loi,
            success:function(html){
               $("ubahloi").html(html);
            }
        });
		}
    }
	function HitungHarga(id){
        var dt_qty=$("#dt_qty_"+id).val();
		 var dt_width=$("#dt_width_"+id).val();
		 var dt_hargasatuan=$("#dt_hargasatuan_"+id).val();
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/HitungHarga',
            data:"dt_hargasatuan="+dt_hargasatuan+"&dt_qty="+dt_qty+"&id="+id,
            success:function(html){
               $("#jumlahharga_"+id).html(html);
            }
        });
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/TotalWeight',
            data:"dt_width="+dt_width+"&dt_qty="+dt_qty+"&id="+id,
            success:function(html){
               $("#totalwidth_"+id).html(html);
            }
        });
    }
		function CariPrice(id){
		 var dt_ratelme=$("#dt_ratelme_"+id).val();
		 var dt_idmaterial=$("#dt_idmaterial_"+id).val();
		 if( dt_idmaterial == '' || dt_idmaterial == null){
					swal("Warning", "Silahkan Pilih Material Terlebih Dahulu :)", "error");
					return false;
		}else{
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariPrice',
            data:"dt_ratelme="+dt_ratelme+"&dt_idmaterial="+dt_idmaterial+"&id="+id,
            success:function(html){
               $("#dt_alloyprice_"+id).val(html);
            }
        });
		}
    }
	function get_kurs(){
        var loi=$("#loi").val();
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/FormInputKurs',
            data:"loi="+loi,
            success:function(html){
               $("#input_kurs").html(html);
            }
        });
    }
function HitungUP(id){
       var alloyprice=$("#dt_alloyprice_"+id).val();
		 var fabcost=$("#dt_fabcost_"+id).val();
		 var diskon=$("#dt_diskon_"+id).val();
		 var pajak=$("#dt_pajak_"+id).val();
		 var qty=$("#dt_qty_"+id).val();
		 var hargasatuan=$("#dt_hargasatuan_"+id).val();
		 var loi=$("#loi").val();
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/HitungUP',
            data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&hargasatuan="+hargasatuan+"&loi="+loi,
            success:function(html){
                // $("#dt_hargasatuan_"+id).val(html); 
				HitAmmount(id)
				$('.autoNumeric3').autoNumeric('init', { vMin: 0, mDec: 3 });
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/Hitjumlah',
            data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&pajak="+pajak+"&diskon="+diskon+"&qty="+qty+"&hargasatuan="+hargasatuan+"&loi="+loi,
            success:function(html){
                $("#dt_jumlahharga_"+id).val(html); 
            }
        });
		
		$('.autoNumeric3').autoNumeric('init', { vMin: 0, mDec: 3 });
		
    }
	
	function HitungUPIm(id){
       var alloyprice=$("#dt_alloyprice_"+id).val();
		 var fabcost=$("#dt_fabcost_"+id).val();
		 var diskon=$("#dt_diskon_"+id).val();
		 var pajak=$("#dt_pajak_"+id).val();
		 var qty=$("#dt_qty_"+id).val();
		 var hargasatuan=$("#dt_hargasatuan_"+id).val();
		 var dt_width=$("#dt_totalwidth_"+id).val();
		 
		 var loi=$("#loi").val();
		 // console.log(dt_width)
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/HitungUP',
            data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&hargasatuan="+hargasatuan+"&loi="+loi,
            success:function(html){
                // $("#dt_hargasatuan_"+id).val(html); 
				HitAmmount(id)
				$('.autoNumeric3').autoNumeric('init', { vMin: 0, mDec: 3 });
            }
        });
		// $.ajax({
            // type:"GET",
            // url:siteurl+'purchase_order/Hitjumlah',
            // data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&pajak="+pajak+"&diskon="+diskon+"&qty="+qty+"&hargasatuan="+hargasatuan+"&loi="+loi+"&dt_width="+dt_width,
            // success:function(html){
                // $("#dt_jumlahharga_"+id).val(html); 
            // }
        // });		
    }
	
	function CariProperties(id){
        var idpr=$("#dt_idpr_"+id).val();
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariIdMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#idmaterial_"+id).html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariNamaMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#namaterial_"+id).html(html); 
            }
        });
				$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariPanjangMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#panjang_"+id).html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariLebarMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#lebar_"+id).html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariDescripitionMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#description_"+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariQtyMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#qty_"+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariweightMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#width_"+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTweightMaterial',
            data:"idpr="+idpr+"&id="+id,
            success:function(html){
               $("#totalwidth_"+id).html(html);
            }
        });

		var a;
		var ArrList = [];
		for(a=1; a<=100; a++){
			var dataid = $('#dt_idpr_'+a).val();
			ArrList.push(dataid); 
		}
		$.ajax({
            type:"POST",
            url:siteurl+'purchase_order/getDateExp',
            data:{
				'id_pr' : ArrList
			},
			dataType	: 'json',
            success:function(data){
				$('#expect_tanggal').val(data.minimal)
            }
        });
    }
	function LockMaterial(id){
        var idpr=$("#dt_idpr_"+id).val();
		var idmaterial=$("#dt_idmaterial_"+id).val();
		var namaterial=$("#dt_namamaterial_"+id).val();
		var description=$("#dt_description_"+id).val();
		var qty=$("#dt_qty_"+id).val();
		var width=$("#dt_width_"+id).val();
		var totalwidth=$("#dt_totalwidth_"+id).val();
		var hargasatuan=$("#dt_hargasatuan_"+id).val();
		var diskon=$("#dt_diskon_"+id).val();
		var pajak=$("#dt_pajak_"+id).val();
		var ratelme=$("#dt_ratelme_"+id).val();
		var alloyprice=$("#dt_alloyprice_"+id).val();
		var fabcost=$("#dt_fabcost_"+id).val();
		var panjang=$("#dt_panjang_"+id).val();
		var lebar=$("#dt_lebar_"+id).val();
		var jumlahharga=$("#dt_jumlahharga_"+id).val();
		var note=$("#dt_note_"+id).val();
		var subtotal=$("#subtotal").val();
		var hargatotal=$("#hargatotal").val();
		var diskontotal=$("#diskontotal").val();
		var taxtotal=$("#taxtotal").val();
		if( qty == '' || qty == null  || hargasatuan == '' || hargasatuan == null){
					swal("Warning", "Form Tidak Boleh Kosong :)", "error");
					return false;
		}else{
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/LockMatrial',
            data:"idpr="+idpr+"&id="+id+"&idmaterial="+idmaterial+"&width="+width+"&ratelme="+ratelme+"&alloyprice="+alloyprice+"&fabcost="+fabcost+"&panjang="+panjang+"&lebar="+lebar+"&totalwidth="+totalwidth+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#trmaterial_"+id).html(html);
            }
        });
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTHarga',
			data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForHarga").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTDiskon',
            data:"idpr="+idpr+"&id="+id+"&diskontotal="+diskontotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForDiskon").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTPajak',
            data:"idpr="+idpr+"&id="+id+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForTax").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariTSum',
            data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&diskontotal="+diskontotal+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForSum").html(html);
            }
        });
		}
    }
	function CancelItem(id){
        var idpr=$("#dt_idpr_"+id).val();
		var idmaterial=$("#dt_idmaterial_"+id).val();
		var namaterial=$("#dt_namamaterial_"+id).val();
		var description=$("#dt_description_"+id).val();
		var qty=$("#dt_qty_"+id).val();
		var hargasatuan=$("#dt_hargasatuan_"+id).val();
		var diskon=$("#dt_diskon_"+id).val();
		var pajak=$("#dt_pajak_"+id).val();
		var jumlahharga=$("#dt_jumlahharga_"+id).val();
		var note=$("#dt_note_"+id).val();
		var subtotal=$("#subtotal").val();
		var hargatotal=$("#hargatotal").val();
		var diskontotal=$("#diskontotal").val();
		var taxtotal=$("#taxtotal").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinHarga',
			data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForHarga").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinDiskon',
            data:"idpr="+idpr+"&id="+id+"&diskontotal="+diskontotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForDiskon").html(html); 
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinPajak',
            data:"idpr="+idpr+"&id="+id+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForTax").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'purchase_order/CariMinSum',
            data:"idpr="+idpr+"&id="+id+"&hargatotal="+hargatotal+"&diskontotal="+diskontotal+"&taxtotal="+taxtotal+"&idmaterial="+idmaterial+"&namaterial="+namaterial+"&description="+description+"&qty="+qty+"&hargasatuan="+hargasatuan+"&diskon="+diskon+"&pajak="+pajak+"&jumlahharga="+jumlahharga+"&note="+note,
            success:function(html){
               $("#ForSum").html(html);
            }
        });
		$('#data_request #trmaterial_'+id).remove();
    }
function HapusItem(id){
		$('#data_request #trmaterial_'+id).remove();
		
	}
	
	// function HitAmmount(id){
    //   	  var alloyprice=$("#dt_alloyprice_"+id).val();
	// 	 var fabcost=$("#dt_fabcost_"+id).val();
	// 	 var diskon=$("#dt_diskon_"+id).val();
	// 	 var pajak=$("#dt_pajak_"+id).val();
	// 	 var qty=$("#dt_qty_"+id).val();
	// 	 var hargasatuan=$("#dt_hargasatuan_"+id).val();
	// 	 var dt_width=$("#dt_totalwidth_"+id).val();
		 
	// 	 var loi=$("#loi").val();
	// 	$.ajax({
    //         type:"GET",
    //         url:siteurl+'purchase_order/Hitjumlah',
    //         data:"fabcost="+fabcost+"&alloyprice="+alloyprice+"&pajak="+pajak+"&diskon="+diskon+"&qty="+qty+"&hargasatuan="+hargasatuan+"&loi="+loi+"&dt_width="+dt_width,
    //         success:function(html){
    //             $("#dt_jumlahharga_"+id).val(html); 
    //         }
    //     });		
		
    // }
	
	function HitAmmount(id){
      	var alloyprice 	= getNum($("#dt_alloyprice_"+id).val().split(",").join(""));
		var fabcost		= getNum($("#dt_fabcost_"+id).val().split(",").join(""));
		var diskon		= getNum($("#dt_diskon_"+id).val().split(",").join(""));
		var pajak		= getNum($("#dt_pajak_"+id).val().split(",").join(""));
		var qty			= getNum($("#dt_qty_"+id).val().split(",").join(""));
		var hargasatuan	= getNum($("#dt_hargasatuan_"+id).val().split(",").join(""));
		var dt_width	= getNum($("#dt_totalweight_"+id).val().split(",").join(""));
		var loi			= $("#loi").val();

		if(loi == 'Import'){
			var total 	= Number(alloyprice) + Number(fabcost);
			var jumlah 	= total * dt_width;	

			$("#dt_hargasatuan_"+id).val(number_format(total,3));
		}
		else{
			var total 	= hargasatuan;
			var jumlah 	= hargasatuan * dt_width;
		}

		var tot_pajak 	= pajak / 100 * jumlah;
		var tot_diskon = diskon / 100 * jumlah;
		var tot_jumlah = jumlah - tot_diskon + tot_pajak;

		

		$("#dt_jumlahharga_"+id).val(number_format(jumlah,3));

		$("#dt_ch_pajak_"+id).val(tot_pajak);
		$("#dt_ch_diskon_"+id).val(tot_diskon);
		$("#dt_ch_jumlah_"+id).val(tot_jumlah);

		var SUM_JML = 0
		var SUM_DIS = 0
		var SUM_PJK = 0
		var SUM_JMX = 0

		$(".ch_diskon" ).each(function() {
			SUM_DIS += Number($(this).val());
		});

		$(".ch_pajak" ).each(function() {
			SUM_PJK += Number($(this).val());
		});

		$(".ch_jumlah" ).each(function() {
			SUM_JML += Number($(this).val());
		});

		$(".ch_jumlah_ex" ).each(function() {
			SUM_JMX += Number($(this).val().split(",").join(""));
		});

		$("#hargatotal").val(number_format(SUM_JMX));
		$("#diskontotal").val(number_format(SUM_DIS));
		$("#taxtotal").val(number_format(SUM_PJK));
		$("#subtotal").val(number_format(SUM_JML));

    }

	function SumDel(){
		var SUM_JML = 0
		var SUM_DIS = 0
		var SUM_PJK = 0
		var SUM_JMX = 0

		$(".ch_diskon" ).each(function() {
			SUM_DIS += Number($(this).val());
		});

		$(".ch_pajak" ).each(function() {
			SUM_PJK += Number($(this).val());
		});

		$(".ch_jumlah" ).each(function() {
			SUM_JML += Number($(this).val());
		});

		$(".ch_jumlah_ex" ).each(function() {
			SUM_JMX += Number($(this).val().split(",").join(""));
		});

		$("#hargatotal").val(number_format(SUM_JMX));
		$("#diskontotal").val(number_format(SUM_DIS));
		$("#taxtotal").val(number_format(SUM_PJK));
		$("#subtotal").val(number_format(SUM_JML));

    }

	function number_format (number, decimals, dec_point, thousands_sep) {
		// Strip all characters but numerical ones.
		number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + Math.round(n * k) / k;
			};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}

	function getNum(val) {
		if (isNaN(val) || val == '') {
			return 0;
		}
		return parseFloat(val);
	}
	
</script>
<script src="<?= base_url('assets/js/jquery.maskMoney.js')?>"></script>
<script src="<?= base_url('assets/js/autoNumeric.js')?>"></script>
<script>
	$(function() {
		$('.chosen-select').select2({ width: '100%' }); 
		$('select').select2({ width: '100%' }); 
		$('#tanggal').datepicker({
			format : 'yyyy-mm-dd'
			// minDate: 0
		});
    });
</script>