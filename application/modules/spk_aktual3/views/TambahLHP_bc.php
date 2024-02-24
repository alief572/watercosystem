<?php
	$tanggal = date('Y-m-d');
foreach ($results['tr_spk'] as $tr_spk){
	}
?>
 <div class="box box-primary">
    <div class="box-body"><br>
		<form id="data-form" method="post">
<div class="row">

				<div class='box-body hide_header'>
			<table class='table table-striped table-bordered table-hover table-condensed' width='100%'>
			<thead>
			<tr class='bg-blue'>
			<th width='3%' hidden>ID Stok</th>
			<th width='15%'>No Lot</th>
			<th width='10%'>Material</th>
			<th width='10%'>Berat Mother Coil</th>
			<th width='7%'>Thickness</th>
			<th width='7%'>Density</th>
			<th width='7%'>Panjang Master Coil</th>
			<th width='7%'>Width Mother Coil</th>
			</tr>
			</thead>
			<tbody>
		<tr>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->no_surat?>' 	readonly id='no_surat' required name='no_surat'></th>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_spkproduksi?>' 	readonly id='id_spk_aktual' required name='id_spk_aktual'></th>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_stock?>' 	readonly id='id_stock' required name='id_stock'></th>
		<th><input type='text' class='form-control'  	   	value='<?= $tr_spk->lotno?>' 	readonly id='lotno' required name='lotno'></th>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_material?>' 	readonly id='id_material' required name='id_material'></th>
		<th><input type='text' class='form-control'  	   	value='<?= $tr_spk->nama_material?>' 	readonly id='nama_material' required name='nama_material'></th>
		<th><input type='text' class='form-control' 		value='<?= $tr_spk->weight?>'  	readonly id='weight' required name='weight'></th>
		<th><input type='text' class='form-control'   		value='<?= $tr_spk->thickness?>'	readonly id='thickness' required name='thickness'></th>
		<th><input type='text' class='form-control'   		value='<?= $tr_spk->density?>'	readonly id='density' required name='density'></th>
		<th><input type='text' class='form-control'  		value='<?= $tr_spk->panjang?>' 	readonly id='panjang'  required name='panjang'></th>
		<th><input type='text' class='form-control'   		value='<?= $tr_spk->width?>' 	readonly id='width'  required name='width'></th>
			
		</tr>
			</tbody>
			</table>
</div>		
		</div>

			<br>
			<div class='box box-info'>
				<div class='box-body'>





							<table class='table table-striped table-bordered table-hover table-condensed' width='100%'>
			<thead>
			<tr class='bg-blue'>
			<th rowspan='2'width='3%'>No</th>
			<th rowspan='2'width='15%'>Nomor. SO</th>
			<th rowspan='2'width='15%'>Customer</th>
			<th rowspan='2'width='10%'>Nomor Alloy</th>
			<th rowspan='2'width='10%'>Thickness</th>
			<th rowspan='2'width='10%'>Width</th>
			<th colspan='2' >@Coil</th>
			<th colspan='2' >Total Weight<Total weight/th>
			<th rowspan='2' width='7%'>Delivery Date</th>
			</tr>
						<tr class='bg-blue'>
			<th width='10%'>Request</th>
			<th width='10%'>Aktual</th>
			<th width='10%'>Request<Total weight/th>
			<th width='10%'>Aktual<Total weight/th>
			</tr>
			</thead>
			<tbody>
			<?php
 				$id = 0;
				$loop = 0;
 						  foreach($results['dt_spk'] AS $val2 => $val2x){
                $id++;
				$loop++;
                echo "<tr class='header_".$id."' id='trhead_".$id."'>
				";
		$material 		= $this->db->query("SELECT a.*, b.nama as alloy, c.nm_bentuk as bentuk FROM ms_inventory_category3 as a INNER JOIN ms_inventory_category2 as b ON a.id_category2 = b.id_category2 INNER JOIN ms_bentuk as c ON a.id_bentuk = c.id_bentuk WHERE a.deleted = '0' ")->result();
		echo "
			<th>$loop</th>
			<th hidden><input type='text' class='form-control' 		value='$val2x->id_dt_spkproduksi' 	readonly id='used_iddtspkproduksi_$loop' required name='dt[$loop][id_dt_spkproduksi]'></th>
			<th ><input type='text' class='form-control' 			value='$val2x->no_surat' 			readonly id='used_nosurat_$loop' required name='dt[$loop][nosurat]'></th>
			<th hidden><input type='text' class='form-control' 		value='$val2x->idcustomer' 			readonly id='used_idcustomer_$loop' required name='dt[$loop][idcustomer]'></th>
			<th><input type='text' class='form-control'  	   		value='$val2x->name_customer' 		readonly id='used_namacustomer_$loop' required name='dt[$loop][namacustomer]'></th>
			<th><input type='text' class='form-control' 			value='$val2x->nmmaterial'  		readonly id='used_nmmaterial_$loop' required name='dt[$loop][nmmaterial]'></th>
			<th><input type='number' class='form-control' 			value='$val2x->thickness' 			readonly id='used_thickness_$loop' required name='dt[$loop][thickness]'></th>
			<th><input type='number' class='form-control'   		value='$val2x->weight' 				readonly id='used_weight_$loop' required name='dt[$loop][weight]'></th>
			<th><input type='number' class='form-control'  			value='$val2x->qtycoil' 			readonly id='used_qtycoil_$loop' onkeyup='HitungTotalCoil($loop)' required name='dt[$loop][qtycoil]'></th>
			<th><input type='number' class='form-control'  			value='$val2x->qtycoil' 			readonly id='used_qtyaktual_$loop' onkeyup='HitungTotalCoil($loop)' required name='dt[$loop][qtyaktual]' ></th>
			<th hidden><input type='number' class='form-control' 	value='$val2x->width' 				readonly id='used_width_$loop' onkeyup='HitungTotalCoil($loop)' required name='dt[$loop][width]'></th>
			<th><input type='number' class='form-control'  			value='$val2x->totalwidth' 			readonly id='used_totalwidth_$loop' required name='dt[$loop][totalwidth]'></th>
			<th><input type='number' class='form-control'  			value='$val2x->totalwidth' 	 		readonly id='used_totalaktual_$loop' required name='dt[$loop][totalaktual]'></th>
			<th><input type='date' class='form-control'   			value='$val2x->delivery' 			readonly id='used_delivery_$loop' required name='dt[$loop][delivery]'></th>				
        </tr>";
				
	
	$no1 =1;
	$no2 =2;
	$no3 =3;
	$no4 =4;
	$no5 =5;
	$no6 =6;
	$no7 =7;
	$no8 =8;
	$no9 =9;
	$no10 =10;
	$no11 =11;
	
	$MATL = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='MATL1' AND id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."'")->row();
	$start1  = $MATL->start;
	$finish1 = $MATL->finish;
	$total1  = $MATL->total;
	
	$SETTING1 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='SETTING1' AND id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."'")->row();
	
	$start2  = $SETTING1->start;
	$finish2 = $SETTING1->finish;
	$total2  = $SETTING1->total;
	
	$SETTUP1 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='SETTUP1' AND id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."'")->row();
	
	$start3  = $SETTUP1->start;
	$finish3 = $SETTUP1->finish;
	$total3  = $SETTUP1->total;
	
	$QC1 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='QC1' AND id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."'")->row();
	
	$start4  = $QC1->start;
	$finish4 = $QC1->finish;
	$total4  = $QC1->total;
	
	$SETTUP2 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='SETTUP2' AND id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."'")->row();
	
	$start5  = $SETTUP2->start;
	$finish5 = $SETTUP2->finish;
	$total5  = $SETTUP2->total;
	
	$QC2 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='QC2' AND id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."'")->row();
	
	$start6  = $QC2->start;
	$finish6 = $QC2->finish;
	$total6  = $QC2->total;
	
	$SLITTING1 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='SLITTING1' AND id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."'")->row();
	
	$start7  = $SLITTING1->start;
	$finish7 = $SLITTING1->finish;
	$total7  = $SLITTING1->total;
	
	$QC3 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='QC3' AND id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."'")->row();
	
	$start8  = $QC3->start;
	$finish8 = $QC3->finish;
	$total8  = $QC3->total;
	
	$SLITTING2 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='SLITTING2' AND id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."'")->row();
	
	$start9  = $SLITTING2->start;
	$finish9 = $SLITTING2->finish;
	$total9  = $SLITTING2->total;
	
	$QC4 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='QC4' AND id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."'")->row();
	
	$start10  = $QC4->start;
	$finish10 = $QC4->finish;
	$total10  = $QC4->total;
	
	$HANDLING1 = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_proses='HANDLING1' AND id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."'")->row();
	
	$start11  = $HANDLING1->start;
	$finish11 = $HANDLING1->finish;
	$total11  = $HANDLING1->total;
	
	
	echo "<tr class='header_".$id."' id='header_".$id."_".$no1."'>";
	echo "<td></td>";
	echo "<td align='left' width='7%'>Progress Name </td>";
    echo "<td>";
    echo "<input type='hidden' name='dt[".$id."][detail][".$no1."][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses".$id."_".$no1."' value='MATL1' readonly>";
	echo "<input type='text' name='dt[".$id."][detail][".$no1."][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_".$id."_".$no1."' value='MATL  CHANGE' readonly>";
    echo "</td>";
    echo "<td align='left'>";
    echo "<input type='time' name='dt[".$id."][detail][".$no1."][start]' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no1."' value='$start1' >";
    echo "</td>";
	echo "<td align='left'>Sampai</td>";
    echo "<td>";
    echo "<input type='Time' name='dt[".$id."][detail][".$no1."][finish]' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no1."' value='$finish1' onblur='cariJam($id,$no1)' >";
    echo "</td>";
	echo "<td align='left' colspan='2'>Total</td>";
    echo "<td align='left' colspan='2'>";
    echo "<input type='text' name='dt[".$id."][detail][".$no1."][total]' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no1."' value='$total1' >";
    echo "</td>";
	// echo "<td align='center'>";
	// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
	// echo "</td>";
	echo "</tr>";
	echo "<tr class='header_".$id."' id='header_".$id."_".$no2."'>";
	echo "<td></td>";
	echo "<td align='left' width='7%'>Progress Name </td>";
    echo "<td>";
	echo "<input type='hidden' name='dt[".$id."][detail][".$no2."][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses".$id."_".$no2."' value='SETTING1' readonly>";
    echo "<input type='text' name='dt[".$id."][detail][".$no2."][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_".$id."_".$no2."' value='SETTING KNIVE' readonly>";
    echo "</td>";
    echo "<td align='left'>";
    echo "<input type='time' name='dt[".$id."][detail][".$no2."][start]' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no2."' value='$start2' >";
    echo "</td>";
	echo "<td align='left'>Sampai</td>";
    echo "<td>";
    echo "<input type='Time' name='dt[".$id."][detail][".$no2."][finish]' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no2."' value='$finish2'  onblur='cariJam($id,$no2)'>";
    echo "</td>";
	echo "<td align='left' colspan='2'>Total</td>";
    echo "<td align='left' colspan='2'>";
    echo "<input type='text' name='dt[".$id."][detail][".$no2."][total]' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no2."' value='$total2'>";
    echo "</td>";
	// echo "<td align='center'>";
	// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
	// echo "</td>";
	echo "</tr>";
	echo "<tr class='header_".$id."' id='header_".$id."_".$no3."'>";
	echo "<td></td>";
	echo "<td align='left' width='7%'>Progress Name </td>";
    echo "<td>";
	echo "<input type='hidden' name='dt[".$id."][detail][".$no3."][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses".$id."_".$no3."' value='SETTUP1' readonly>";
    echo "<input type='text' name='dt[".$id."][detail][".$no3."][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_".$id."_".$no3."' value='SETT UP' readonly>";
    echo "</td>";
    echo "<td align='left'>";
    echo "<input type='time' name='dt[".$id."][detail][".$no3."][start]' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no3."' value='$start3'>";
    echo "</td>";
	echo "<td align='left'>Sampai</td>";
    echo "<td>";
    echo "<input type='Time' name='dt[".$id."][detail][".$no3."][finish]' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no3."' value='$finish3' onblur='cariJam($id,$no3)'>";
    echo "</td>";
	echo "<td align='left' colspan='2'>Total</td>";
    echo "<td align='left' colspan='2'>";
    echo "<input type='text' name='dt[".$id."][detail][".$no3."][total]' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no3."' value='$total3'>";
    echo "</td>";
	// echo "<td align='center'>";
	// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
	// echo "</td>";
	echo "</tr>";
	echo "<tr class='header_".$id."' id='header_".$id."_".$no4."'>";
	echo "<td></td>";
	echo "<td align='left' width='7%'>Progress Name </td>";
    echo "<td>";
	echo "<input type='hidden' name='dt[".$id."][detail][".$no4."][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses".$id."_".$no4."' value='QC1' readonly>";
    echo "<input type='text' name='dt[".$id."][detail][".$no4."][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_".$id."_".$no4."' value='QC  CHECK SETTING' readonly>";
    echo "</td>";
    echo "<td align='left'>";
    echo "<input type='time' name='dt[".$id."][detail][".$no4."][start]' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no4."' value='$start4' >";
    echo "</td>";
	echo "<td align='left'>Sampai</td>";
    echo "<td>";
    echo "<input type='Time' name='dt[".$id."][detail][".$no4."][finish]' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no4."' value='$finish4' onblur='cariJam($id,$no4)'>";
    echo "</td>";
	echo "<td align='left' colspan='2'>Total</td>";
    echo "<td align='left' colspan='2'>";
    echo "<input type='text' name='dt[".$id."][detail][".$no4."][total]' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no4."' value='$total4'>";
    echo "</td>";
	// echo "<td align='center'>";
	// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
	// echo "</td>";
	echo "</tr>";
	echo "<tr class='header_".$id."' id='header_".$id."_".$no5."'>";
	echo "<td></td>";
	echo "<td align='left' width='7%'>Progress Name </td>";
    echo "<td>";
	echo "<input type='hidden' name='dt[".$id."][detail][".$no5."][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses".$id."_".$no5."' value='SETTUP2' readonly>";
    echo "<input type='text' name='dt[".$id."][detail][".$no5."][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_".$id."_".$no5."' value='SETT UP' readonly>";
    echo "</td>";
    echo "<td align='left'>";
    echo "<input type='time' name='dt[".$id."][detail][".$no5."][start]' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no5."' value='$start5' >";
    echo "</td>";
	echo "<td align='left'>Sampai</td>";
    echo "<td>";
    echo "<input type='Time' name='dt[".$id."][detail][".$no5."][finish]' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no5."' value='$finish5' onblur='cariJam($id,$no5)'>";
    echo "</td>";
	echo "<td align='left' colspan='2'>Total</td>";
    echo "<td align='left' colspan='2'>";
    echo "<input type='text' name='dt[".$id."][detail][".$no5."][total]' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no5."' value='$total5'>";
    echo "</td>";
	// echo "<td align='center'>";
	// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
	// echo "</td>";
	echo "</tr>"; 
	echo "<tr class='header_".$id."' id='header_".$id."_".$no6."'>";
	echo "<td></td>";
	echo "<td align='left' width='7%'>Progress Name </td>";
    echo "<td>";
	echo "<input type='hidden' name='dt[".$id."][detail][".$no6."][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses".$id."_".$no6."' value='QC2' readonly>";
    echo "<input type='text' name='dt[".$id."][detail][".$no6."][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_".$id."_".$no6."' value='QC  CHECK AWAL' readonly>";
    echo "</td>";
    echo "<td align='left'>";
    echo "<input type='time' name='dt[".$id."][detail][".$no6."][start]' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no6."' value='$start6'>";
    echo "</td>";
	echo "<td align='left'>Sampai</td>";
    echo "<td>";
    echo "<input type='Time' name='dt[".$id."][detail][".$no6."][finish]' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no6."' value='$finish6' onblur='cariJam($id,$no6)'>";
    echo "</td>";
	echo "<td align='left' colspan='2'>Total</td>";
    echo "<td align='left' colspan='2'>";
    echo "<input type='text' name='dt[".$id."][detail][".$no6."][total]' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no6."' value='$total6' >";
    echo "</td>";
	// echo "<td align='center'>";
	// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
	// echo "</td>";
	echo "</tr>";
	echo "<tr class='header_".$id."' id='header_".$id."_".$no7."'>";
	echo "<td></td>";
	echo "<td align='left' width='7%'>Progress Name </td>";
    echo "<td>";
	echo "<input type='hidden' name='dt[".$id."][detail][".$no7."][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses".$id."_".$no7."' value='SLITTING1' readonly>";
    echo "<input type='text' name='dt[".$id."][detail][".$no7."][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_".$id."_".$no7."' value='SLITTING PROCESS' readonly>";
    echo "</td>";
    echo "<td align='left'>";
    echo "<input type='time' name='dt[".$id."][detail][".$no7."][start]' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no7."' value='$start7'>";
    echo "</td>";
	echo "<td align='left'>Sampai</td>";
    echo "<td>";
    echo "<input type='Time' name='dt[".$id."][detail][".$no7."][finish]' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no7."' value='$finish8' onblur='cariJam($id,$no7)'>";
    echo "</td>";
	echo "<td align='left' colspan='2'>Total</td>";
    echo "<td align='left' colspan='2'>";
    echo "<input type='text' name='dt[".$id."][detail][".$no7."][total]' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no7."' value='$total7' >";
    echo "</td>";
	// echo "<td align='center'>";
	// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
	// echo "</td>";
	echo "</tr>";
	echo "<tr class='header_".$id."' id='header_".$id."_".$no8."'>";
	echo "<td></td>";
	echo "<td align='left' width='7%'>Progress Name </td>";
    echo "<td>";
	echo "<input type='hidden' name='dt[".$id."][detail][".$no8."][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses".$id."_".$no8."' value='QC3' readonly>";
    echo "<input type='text' name='dt[".$id."][detail][".$no8."][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_".$id."_".$no8."' value='QC  CHECK TENGAH' readonly>";
    echo "</td>";
    echo "<td align='left'>";
    echo "<input type='time' name='dt[".$id."][detail][".$no8."][start]' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no8."'value='$start8' >";
    echo "</td>";
	echo "<td align='left'>Sampai</td>";
    echo "<td>";
    echo "<input type='Time' name='dt[".$id."][detail][".$no8."][finish]' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no8."' value='$finish8' onblur='cariJam($id,$no8)'>";
    echo "</td>";
	echo "<td align='left' colspan='2'>Total</td>";
    echo "<td align='left' colspan='2'>";
    echo "<input type='text' name='dt[".$id."][detail][".$no8."][total]' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no8."' value='$total8' >";
    echo "</td>";
	// echo "<td align='center'>";
	// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
	// echo "</td>";
	echo "</tr>";
	echo "<tr class='header_".$id."' id='header_".$id."_".$no9."'>";
	echo "<td></td>";
	echo "<td align='left' width='7%'>Progress Name </td>";
    echo "<td>";
	echo "<input type='hidden' name='dt[".$id."][detail][".$no9."][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses".$id."_".$no9."' value='SLITTING2' readonly>";
    echo "<input type='text' name='dt[".$id."][detail][".$no9."][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_".$id."_".$no9."' value='SLITTING PROCESS' readonly>";
    echo "</td>";
    echo "<td align='left'>";
    echo "<input type='time' name='dt[".$id."][detail][".$no9."][start]' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no9."' value='$start9'>";
    echo "</td>";
	echo "<td align='left'>Sampai</td>";
    echo "<td>";
    echo "<input type='Time' name='dt[".$id."][detail][".$no9."][finish]' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no9."' value='$finish9' onblur='cariJam($id,$no9)'>";
    echo "</td>";
	echo "<td align='left' colspan='2'>Total</td>";
    echo "<td align='left' colspan='2'>";
    echo "<input type='text' name='dt[".$id."][detail][".$no9."][total]' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no9."' value='$total9' >";
    echo "</td>";
	// echo "<td align='center'>";
	// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
	// echo "</td>";
	echo "</tr>";
	echo "<tr class='header_".$id."' id='header_".$id."_".$no10."'>";
	echo "<td></td>";
	echo "<td align='left' width='7%'>Progress Name </td>";
    echo "<td>";
	echo "<input type='hidden' name='dt[".$id."][detail][".$no10."][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses".$id."_".$no10."' value='QC4' readonly>";
    echo "<input type='text' name='dt[".$id."][detail][".$no10."][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_".$id."_".$no10."' value='QC  CHECK AKHIR' readonly>";
    echo "</td>";
    echo "<td align='left'>";
    echo "<input type='time' name='dt[".$id."][detail][".$no10."][start]' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no10."' value='$start10' >";
    echo "</td>";
	echo "<td align='left'>Sampai</td>";
    echo "<td>";
    echo "<input type='Time' name='dt[".$id."][detail][".$no10."][finish]' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no10."' value='$finish10' onblur='cariJam($id,$no10)'>";
    echo "</td>";
	echo "<td align='left' colspan='2'>Total</td>";
    echo "<td align='left' colspan='2'>";
    echo "<input type='text' name='dt[".$id."][detail][".$no10."][total]' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no10."' value='$total10' >";
    echo "</td>";
	// echo "<td align='center'>";
	// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
	// echo "</td>";
	echo "</tr>";
	echo "<tr class='header_".$id."' id='header_".$id."_".$no11."'>";
	echo "<td></td>";
	echo "<td align='left' width='7%'>Progress Name </td>";
    echo "<td>";
	echo "<input type='hidden' name='dt[".$id."][detail][".$no11."][id_proses]' class='form-control input-md' placeholder='Progress Name' id='id_proses".$id."_".$no11."' value='HANDLING1' readonly>";
    echo "<input type='text' name='dt[".$id."][detail][".$no11."][namaproses]' class='form-control input-md' placeholder='Progress Name' id='namaproses_".$id."_".$no11."' value='HANDLING' readonly>";
    echo "</td>";
    echo "<td align='left'>";
    echo "<input type='time' name='dt[".$id."][detail][".$no11."][start]' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no11."' value='$start11'>";
    echo "</td>";
	echo "<td align='left'>Sampai</td>";
    echo "<td>";
    echo "<input type='Time' name='dt[".$id."][detail][".$no11."][finish]' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no11."' value='$finish11' onblur='cariJam($id,$no11)'>";
    echo "</td>";
	echo "<td align='left' colspan='2'>Total</td>";
    echo "<td align='left' colspan='2'>";
    echo "<input type='text' name='dt[".$id."][detail][".$no11."][total]' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no11."' value='$total11' >";
    echo "</td>";
	// echo "<td align='center'>";
	// echo "<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>";
	// echo "</td>";
	echo "</tr>";
	
	 $no = 12;
				$process = $this->db->query("SELECT * FROM dt_spk_produksi_lph WHERE id_dt_spkproduksi='".$val2x->id_dt_spkproduksi."' AND SUBSTRING(id_lph_spkproduksi, -2, 2) > 11")->result();
                foreach($process AS $val2D => $val2Dx){
				$no++;
      echo "<tr class='header_".$id."' id='header_".$id."_".$no."'>
	<td></td>
	<td align='left' width='7%'>Progress Name</td>
    <td>
    <input type='text' name='dt[".$id."][detail][".$no."][namaproses]' value='".$val2Dx->namaproses."' class='form-control input-md' placeholder='Progress Name'   id='namaproses_".$id."_".$no."' >
    </td>
    <td align='left'>
    <input type='time' name='dt[".$id."][detail][".$no."][start]'  value='".$val2Dx->start."' class='form-control input-md formsub' placeholder='Start Time'   id='start_".$id."_".$no."' >
    </td>
	<td align='left'>Sampai</td>
    <td>
    <input type='Time' name='dt[".$id."][detail][".$no."][finish]' value='".$val2Dx->finish."' class='form-control input-md' placeholder='berat'   id='finish_".$id."_".$no."' onblur='cariJam($id,$no)' >
    </td>
	<td align='left' colspan='2'>Total</td>
    <td align='left' colspan='2'>
    <input type='text' name='dt[".$id."][detail][".$no."][total]' value='".$val2Dx->total."' class='form-control input-md formsubagain' placeholder='Total Waktu'   id='total_".$id."_".$no."' >
    </td>
	<td align='center'>
	<button type='button' class='btn btn-sm btn-danger delSubPart' title='Delete Part'><i class='fa fa-close'></i></button>
	</td>
	</tr>
	<td colspan='7' align='center'></td>";
	
	}
	
	// echo "<td colspan='7' align='center'></td>";
	// echo"<tr id='add_".$id."_".$no."' class='header_".$id."'>
	// <td align='center'></td>
	// <td align='left'><button type='button' class='btn btn-sm btn-primary addSubPart' title='Add Length'><i class='fa fa-plus'></i>&nbsp;&nbsp;Add LHP</button></td>
	// <td colspan='10' align='center'></td>
	// </tr>";
 						  }
 			?>
			</tbody>
					</table>
			
		</div>
		</div>
		</div>
          <button type="button" class="btn btn-danger" style='float:right; margin-left:5px;' name="back" id="back"><i class="fa fa-reply"></i> Back</button>
					<!-- <button type="submit" class="btn btn-primary" style='float:right;' name="save" id="save"><i class="fa fa-save"></i> Save</button> -->

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
						var baseurl=siteurl+'spk_aktual/SaveLHP';
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
	
	function cariJam(id,urut){ 
		var waktuMulai	=$("#start_"+id+"_"+urut).val();
		var waktuSelesai  =$("#finish_"+id+"_"+urut).val();
		
		console.log(waktuMulai);
		console.log(waktuSelesai);
		
		 hours = waktuSelesai.split(':')[0] - waktuMulai.split(':')[0],
          minutes = waktuSelesai.split(':')[1] - waktuMulai.split(':')[1];
 
      if (waktuMulai <= "12:00:00" && waktuSelesai >= "13:00:00"){
        a = 1;
      }else {
        a = 0;
      }
      minutes = minutes.toString().length<2?'0'+minutes:minutes;
      if(minutes<0){ 
          hours--;
          minutes = 60 + minutes;        
      }
      hours = hours.toString().length<2?'0'+hours:hours;
	  
	  console.log(hours+ ':' + minutes);
 
      $("#total_"+id+"_"+urut).val(hours+ ':' + minutes);
	  
	  // $("#total_"+id+"_"+urut).val(hours-a);
		
		// $.ajax({
            // type:"GET",
            // url:siteurl+'spk_produksi/GetSpk',
            // data:"jumlah="+jumlah+"&id_stock="+id_stock+"&id_material="+id_material+"&thickness="+thickness+"&nama_material="+nama_material,
            // success:function(html){
               // $("#list_spk").append(html);
            // }
        // });
    }
</script>
