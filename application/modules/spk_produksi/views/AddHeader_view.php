<?php
    $ENABLE_ADD     = has_permission('Trans_inquiry.Add');
    $ENABLE_MANAGE  = has_permission('Trans_inquiry.Manage');
    $ENABLE_VIEW    = has_permission('Trans_inquiry.View');
    $ENABLE_DELETE  = has_permission('Trans_inquiry.Delete');
	$tanggal = date('Y-m-d');

	$header = $results['header'];

	$id_spkproduksi = (!empty($header))?$header[0]->id_spkproduksi:'';
	$no_surat = (!empty($header))?$header[0]->no_surat:'';
	$tgl_spk_produksi = (!empty($header))?$header[0]->tgl_spk_produksi:'';
	$id_material = (!empty($header))?$header[0]->id_material:'';
	$density = (!empty($header))?$header[0]->density:'';
	$thickness = (!empty($header))?$header[0]->thickness:'';
	$width = (!empty($header))?$header[0]->width:'';
	
	$lpegangan = (!empty($header))?$header[0]->lpegangan:'';
	$lotno = (!empty($header))?$header[0]->lotno:'';
	$panjang = (!empty($header))?$header[0]->panjang:'';
	$nama_material = (!empty($header))?$header[0]->nama_material:'';

	
	$kg_process = (!empty($header))?$header[0]->kg_process:'';
	$length = (!empty($header))?$header[0]->length:'';
	$count_m = (!empty($header))?$header[0]->count_m:'';

	$id_stock = (!empty($header))?$header[0]->id_stock:'';

	$qcoil = (!empty($header))?$header[0]->qcoil:'';
	$jpisau = (!empty($header))?$header[0]->jpisau:'';
	$used = (!empty($header))?$header[0]->used:'';
	$sisa = (!empty($header))?$header[0]->sisa:'';
	$keterangan = (!empty($header))?$header[0]->keterangan:'';
	$id_spkproduksi = (!empty($header))?$header[0]->id_spkproduksi:'';
	
	$dbstock		= $this->db->query("SELECT * FROM stock_material WHERE id_stock = '".$id_stock."' ")->result();
	$detail_potongan = (!empty($dbstock[0]->detail_potongan))?json_decode($dbstock[0]->detail_potongan, true):array();
	// print_r($detail_potongan);
	
	$JUMLAH = 0;
	if(!empty($detail_potongan)){
		foreach($detail_potongan AS $val => $valx){
			if($id_spkproduksi <> $valx['kode']){
				// echo 'masuk 1';
				$JUMLAH += $valx['berat'];
			}
		}
	}
	// echo $JUMLAH;
	$weight = (!empty($header))?$header[0]->weight:'';
	
	$kgPro = 0;
	if($kg_process > 0){
		$kgPro = $kg_process;
	}
	$process = (!empty($header))?$kgPro:'';
	
	
	// foreach ($results['stock'] as $val){
	
	// print_r($results['stock']);
	// exit;
	
	// }
	
	
?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="row">
					<center><label for="customer" ><h3>SPK PRODUKSI</h3></label></center>
					<div class="col-sm-12">
						<div class="col-sm-6">
							<div class="form-group row">
								<div class="col-md-4">
									<label for="customer">NO.SPK</label>
								</div>
								<div class="col-md-8" hidden>
									<input type="text" class="form-control" id="id_spkmarketing"  required name="id_spkmarketing" readonly placeholder="No.CRCL" value='<?=$id_spkproduksi;?>'>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="no_surat"  required name="no_surat" readonly placeholder="No.SPK"value='<?=$no_surat;?>'>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<div class="col-md-4">
									<label for="customer">Tanggal</label>
								</div>
								<div class="col-md-8">
									<input type="date" class="form-control" id="tgl_penawaran" value="<?= $tanggal ?>" onkeyup required name="tgl_penawaran" readonly value='<?=$tgl_spk_produksi;?>'>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="col-sm-6">
							<div class="form-group row">
								<div class='col-md-4'>
									<label for='customer'>Material</label>
								</div>
								<div class="col-md-8">
										<select id="id_material" name="id_material" class="form-control select" onchange="Caristock()" required>
											<option value="">--Pilih--</option>
												<?php foreach ($results['material'] as $material){
													$selx = ($id_material == $material->id_category3)?'selected':'';
													?>
											<option value="<?= $material->id_category3?>" <?=$selx;?>><?= ucfirst(strtolower($material->nama))?></option>
												<?php } ?>
										</select>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<div class="col-md-4">
									<label for="no_penawaran">Lot Number</label>
								</div>
								<div class="col-md-8" id='lotnumbe_slot'>
									<select id="id_stock" name="id_stock" class="form-control select" onchange="get_produk()" required>
										<option value="">--Pilih--</option>
										<?php foreach ($results['stock'] as $val){
											
											$selx = ($id_stock == $val->id_stock)?'selected':'';
											
											?>
											<option value="<?= $val->id_stock ?>" <?=$selx;?>><?= strtoupper(strtolower($val->lotno))?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="col-sm-6">
							<div class="form-group row">
								<div class="col-md-4">
									<label for="customer">Density</label>
								</div>
								<div class="col-md-8" id="slot_density">
									<input type='number' class='form-control' id='density' onkeyup required name='density' readonly value='<?=$density;?>' >
								</div>
							</div>
							
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<div class="col-md-4">
									<label for="no_penawaran">Thickness</label>
								</div>
								<div class="col-md-8" id="slot_thickness">
									<input type='number' class='form-control' id='thickness' onkeyup required name='thickness' readonly  value='<?=$thickness;?>'>
								</div>
							</div>
						</div>
					</div>
					
					
					
					<div class="col-sm-12">
						<div class="col-sm-12">
							<div class="form-group row" >
								<table class='table table-bordered table-striped'>
									<thead>
										<tr class='bg-blue'>
											<th width='3%'>No</th>
											<th width='15%'>Material</th>
											<th width='15%'>Lot Number</th>
											<th width='7%'>Thickness</th>
											<th width='7%'>Density</th>
											<th width='7%'>Width Mother Coil (mm)</th>
											<th width='7%'>Weight Mother Coil (mm)</th>
											<th width='7%'>Kg Proses</th>
											<th width='7%'>Scrap</th>												
											<th width='7%'>Length(m)</th>
											<th width='7%'>Count(m)</th>
											<th width='7%'>Lebar Pegangan</th>
											<th width='7%'>Total coil</th>
											<th width='7%'>Jumlah pisau</th>
											<th width='7%'>Sisa potongan</th>
											<th width='7%'>Keterangan</th>
											
										</tr>
									</thead>
									<tbody id="list_tr_spk">
									   <?php $loop1=0;
									   foreach ($results['header2'] as $hd){										   
										   $loop1++;  ?>
									   <tr>
									   <td><?= $loop1 ?></td>
									   <td><?= $hd->nama_material ?></td>
									   <td><?= $hd->lotno ?></td>
									   <td><?= $hd->thickness ?></td>
									   <td><?= $hd->density ?></td>
									   <td><?= $hd->width ?></td>
									   <td><?= $hd->weight ?></td>
									  
									   <td><?= $hd->kg_process ?></td>
									   <td><?= $hd->scrap_sisa ?></td>
									   <td><?= $hd->length ?></td>
									   <td><?= $hd->count_m ?></td>
									   <td><?= $hd->lpegangan ?></td>
									   <td><?= $hd->qcoil ?></td>
									   <td><?= $hd->jpisau ?></td>
									   <td><?= $hd->sisa ?></td>
									   <td><?= $hd->keterangan ?></td>
									   </tr>
                                       									   
									 <?php  }	   ?>
									
									</tbody>
								</table>
							</div>
                          </div>		
                        </div>						  
									
    
					<div class="col-sm-12">
						<div class="col-sm-12">
						<?php if(empty($results['view'])){ ?>
							<div class="form-group row">
								<button type='button' class='btn btn-sm btn-success' title='Ambil' id='tbh_ata' data-role='qtip' onClick='GetSpk();'><i class='fa fa-plus'></i>Add</button>
							</div>
						<?php } ?>
							<div class="form-group row" >
								<table class='table table-bordered table-striped'>
									<thead>
										<tr class='bg-blue'>
											<th width='3%'>No</th>
											<th width='15%'>SPK Marketing</th>
											<th width='15%'>Customer</th>
											<th width='10%'>Nomor Alloy</th>
											<th width='7%'>Width Slitting</th>
											<th width='7%'>@KG</th>
											<th width='7%'>@Coil</th>
											<th width='7%'>Total Kg</th>
											
											<th width='7%'>Order</th>
											<th width='7%'>Produksi</th>
											<th width='7%'>Stok FG</th>
											
											<th width='5%'>Delivery Date</th>
											
											<?php if(empty($results['view'])){ ?>
											<th width='5%'>Include</th>
											<th width='5%'>Aksi</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody id="list_spk">
									<?php $loop=0;
									
									
									foreach ($results['detail'] as $dt_spk){$loop++; 
										$nosurat = $this->db->query("SELECT a.*, b.no_surat as no_surat FROM dt_spkmarketing as a INNER JOIN tr_spk_marketing as b ON a.id_spkmarketing = b.id_spkmarketing WHERE a.id_material='$id_material' ")->result();
										$cheked = ($dt_spk->checked == '1')?'checked':'';
										$readonly = ($dt_spk->no_surat == 'nonspk')?'':'readonly';
										
										$stok = $this->db->query("SELECT sum(totalweight) as totalqty FROM stock_material WHERE nama_material='$dt_spk->nmmaterial' AND width='$dt_spk->weight' AND thickness='$dt_spk->thickness'")->row();
										
										$ttlstok = $stok->totalqty;
										
									    $order = $this->db->query("SELECT qty_produk as totalwidth FROM dt_spkmarketing WHERE id_dt_spkmarketing='$dt_spk->no_surat' ")->row();
										
										
										 $get_qty_produksi = $this->db->select('SUM(totalwidth) AS qty_produksi')->get_where('dt_spk_produksi', array('no_surat'=>$dt_spk->no_surat))->result();
										 $qty_produksi   = (!empty($get_qty_produksi))?$get_qty_produksi[0]->qty_produksi:0;
										 
										 if($dt_spk->no_surat=='nonspk'){
										  $spk_produksi   = 0;
										 }
										 elseif($dt_spk->no_surat!='nonspk'){
											 $spk_produksi   = $qty_produksi;
										 }
										 $totalorder =$order->totalwidth;
										
										echo "
										<tr id='tr_$loop'>
											<th>$loop</th>
											<th><select id='used_no_surat_$loop' name='dt[$loop][no_surat]' onchange='CariDetail($loop)' class='form-control input-sm select'>
											<option value='nonspk'>Non SPK</option>";
											foreach($nosurat as $nosurat){
												$select = $dt_spk->no_surat == $nosurat->id_dt_spkmarketing ? 'selected' : '';
											echo"<option value='$nosurat->id_dt_spkmarketing' $select>$nosurat->no_surat</option>";
											}
										echo"</select></th>
											<th id='idcust_$loop' hidden><input type='text' class='form-control' 	value='$dt_spk->idcustomer' 	readonly id='used_idcustomer_$loop' required name='dt[$loop][idcustomer]'></th>
											<th id='nmcust_$loop' ><input type='text' class='form-control'  	   	value='$dt_spk->namacustomer' 	readonly id='used_namacustomer_$loop' required name='dt[$loop][namacustomer]'></th>
											<th><input type='text' class='form-control' 		value='$dt_spk->nmmaterial'  	readonly id='used_nmmaterial_$loop' required name='dt[$loop][nmmaterial]'></th>
											<th id='weight_$loop'>
												<input type='hidden' class='form-control' 		value='$dt_spk->thickness' 		readonly id='used_thickness_$loop' required name='dt[$loop][thickness]'>
												<input type='text' class='form-control change_weightc autoNumeric'   	$readonly	value='$dt_spk->weight'  id='used_weight_$loop' required name='dt[$loop][weight]'>
											</th>
											<th id='width2_$loop'><input type='text' class='form-control'   		value='$dt_spk->width' 			readonly id='used_weight2_$loop' required name='dt[$loop][weight2]'></th>
											<th id='qtyproduk_$loop'><input type='text' class='form-control change_weightc autoNumeric'  		value='$dt_spk->qtycoil' 		 id='used_qtycoil_$loop' name='dt[$loop][qtycoil]' readonly></th>
											<th id='twidth_$loop'><input type='text' class='form-control'  		value='$dt_spk->totalwidth' 	readonly id='used_totalwidth_$loop' required name='dt[$loop][totalwidth]'></th>
											<th id='order_$loop'><input type='text' class='form-control'  		value='$totalorder' 	readonly id='used_totalorder_$loop' required name='dt[$loop][totalorder]'></th>
											<th id='produksi_$loop'><input type='text' class='form-control'  		value='$spk_produksi' 	readonly id='used_totalproduksi_$loop' required name='dt[$loop][totalproduksi]'></th>
											<th id='stok_fg_$loop'><input type='text' class='form-control'  		value='$ttlstok' 	readonly id='used_stok_fg_$loop' required name='dt[$loop][stok_fg]'></th>
											<th id='delivery_$loop'><input type='date' class='form-control'   		value='$dt_spk->delivery' 	 id='used_delivery_$loop'  name='dt[$loop][delivery]'></th>";
											if(empty($results['view'])){
											echo "<th align='center'>
												<input type='checkbox' class='chk_personal' id='ch_$loop' name='dt[$loop][id]' value='$loop' $cheked>
											</th>
											<th><button type='button' class='btn btn-sm btn-danger' title='Hapus Data' data-role='qtip' onClick='return HapusItem($loop);'><i class='fa fa-close'></i></button></th>";
											}
											echo "</tr>
										";
											}
											?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					
					<center>
						<?php if(empty($results['view'])){ ?>
						<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
						<?php } ?>
						<a class="btn btn-danger btn-sm" href="<?= base_url('/spk_produksi/') ?>"  title="Edit">Kembali</a>
					</center>
				</div>
			</div>
		</form>		  
	</div>
</div>	
	
				  
				  
				  
