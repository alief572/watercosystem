<?php
    $ENABLE_ADD     = has_permission('master_bentuk.Add');
    $ENABLE_MANAGE  = has_permission('master_bentuk.Manage');
    $ENABLE_VIEW    = has_permission('master_bentuk.View');
    $ENABLE_DELETE  = has_permission('master_bentuk.Delete');
	$id_category1 = $this->uri->segment(3);
foreach ($results['pl'] as $pl){};
foreach ($results['scrap'] as $scr){};
foreach ($results['cogs'] as $cgs){};
foreach ($results['operating_cost'] as $opcost){};
foreach ($results['interest'] as $interest){};	
$id_category3=$pl->id_category3;
		$bookprice	= $this->db->query("SELECT * FROM ms_bookprice_material WHERE id_category3 = '$id_category3' ")->result();
		$nilai_bookprice =$bookprice[0]->nilai_bookprice;
		$kandungancu	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='13' ")->result();
		$kandunganzn	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='14' ")->result();
		$kandungansn	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='15' ")->result();
		$kandunganni	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='16' ")->result();
		$kandunganag	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='17' ")->result();
		$kandunganal	= $this->db->query("SELECT AVG(nilai_compotition) as nilai_compotition FROM child_inven_compotition WHERE id_category3='$id_category3' AND id_compotition='18' ")->result();
		$persencu = $kandungancu[0]->nilai_compotition/100;
		$persenzn = $kandunganzn[0]->nilai_compotition/100;
		$persensn = $kandungansn[0]->nilai_compotition/100;
		$persenni = $kandunganni[0]->nilai_compotition/100;
		$persenag = $kandunganag[0]->nilai_compotition/100;
		$persenal = $kandunganal[0]->nilai_compotition/100;
		$dolar	= $this->db->query("SELECT * FROM mata_uang WHERE kode='USD' ")->result();
		$kurs = $dolar[0]->kurs;
		$hariini = date('Y-m-d');
		$sepuluh_hari = mktime(0,0,0,date('n'),date('j')-10,date('Y'));
		$tendays = date("Y-m-d", $sepuluh_hari);
		$sebulan = mktime(0,0,0,date('n'),date('j')-30,date('Y'));
		$tirtydays = date("Y-m-d", $sebulan);
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
		$lme_10haricu	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$hariini' AND id_compotition='13' ")->result();
		$lme_10harizn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN 	'$tendays' AND '$hariini' AND id_compotition='14' ")->result();
		$lme_10harisn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$hariini' AND id_compotition='15' ")->result();
		$lme_10harini	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$hariini' AND id_compotition='16' ")->result();
		$lme_10hariag	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$hariini' AND id_compotition='17' ")->result();
		$lme_10harial	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE tanggal_update BETWEEN  '$tendays' AND '$hariini' AND id_compotition='18' ")->result();
		$lme_30haricu	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='13' ")->result();
		$lme_30harizn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='14' ")->result();
		$lme_30harisn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='15' ")->result();
		$lme_30harini	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='16' ")->result();
		$lme_30hariag	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='17' ")->result();
		$lme_30harial	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE MONTH(tanggal_update) =  '$blnkmrn' AND YEAR(tanggal_update) = '$yearkemaren'  AND id_compotition='18' ")->result();
		$lme_spotcu	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='13' ")->result();
		$lme_spotzn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='14' ")->result();
		$lme_spotsn	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='15' ")->result();
		$lme_spotni	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='16' ")->result();
		$lme_spotag	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='17' ")->result();
		$lme_spotal	= $this->db->query("SELECT AVG(nominal) as nominal FROM child_history_lme WHERE status='0' AND id_compotition='18' ")->result();
		$cu10 = $lme_10haricu[0]->nominal/1000;
		$zn10 = $lme_10harizn[0]->nominal/1000;
		$sn10 = $lme_10harisn[0]->nominal/1000;
		$ni10 = $lme_10harini[0]->nominal/1000;
		$ag10 = $lme_10hariag[0]->nominal/1000;
		$al10 = $lme_10harial[0]->nominal/1000;
		$cu30 = $lme_30haricu[0]->nominal/1000;
		$zn30 = $lme_30harizn[0]->nominal/1000;
		$sn30 = $lme_30harisn[0]->nominal/1000;
		$ni30 = $lme_30harini[0]->nominal/1000;
		$ag30 = $lme_30hariag[0]->nominal/1000;
		$al30 = $lme_30harial[0]->nominal/1000;
		$cuspot = $lme_spotcu[0]->nominal/1000;
		$znspot = $lme_spotzn[0]->nominal/1000;
		$snspot = $lme_spotsn[0]->nominal/1000;
		$nispot = $lme_spotni[0]->nominal/1000;
		$agspot = $lme_spotag[0]->nominal/1000;
		$alspot = $lme_spotal[0]->nominal/1000;
		$cu10fix = $cu10*$persencu;
		$zn10fix = $zn10*$persenzn;
		$sn10fix = $sn10*$persensn;
		$ni10fix = $ni10*$persenni;
		$ag10fix = $ag10*$persenag;
		$al10fix = $al10*$persenal;
		$cu30fix = $cu30*$persencu;
		$zn30fix = $zn30*$persenzn;
		$sn30fix = $sn30*$persensn;
		$ni30fix = $ni30*$persenni;
		$ag30fix = $ag30*$persenag;
		$al30fix = $al30*$persenal;
		$cuspotfix = $cuspot*$persencu;
		$znspotfix = $znspot*$persenzn;
		$snspotfix = $snspot*$persensn;
		$nispotfix = $nispot*$persenni;
		$agspotfix = $agspot*$persenag;
		$alspotfix = $alspot*$persenal;
		$lme10 = $cu10fix+$zn10fix+$sn10fix+$ni10fix+$ag10fix+$al10fix;
		$lme30 = $cu30fix+$zn30fix+$sn30fix+$ni30fix+$ag30fix+$al30fix;
		$lmespot = $cuspotfix+$znspotfix+$snspotfix+$nispotfix+$agspotfix+$alspotfix;
		$lme101 = number_format($cu10fix+$zn10fix+$sn10fix+$ni10fix+$ag10fix+$al10fix,2);
		$lme301 = number_format($cu30fix+$zn30fix+$sn30fix+$ni30fix+$ag30fix+$al30fix,2);
		$lmespot1 = number_format($cuspotfix+$znspotfix+$snspotfix+$nispotfix+$agspotfix+$alspotfix,2);				
?>
 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
					  <div class="col-sm-12">
						<div class="input_fields_wrap2">
											<div class="row" hidden>
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Book Price (Rp/kg)</label>
									    </div>
									    <div class="col-md-6">
					<input type="text" class="form-control" id="inven1"  required name="inven1" placeholder="Book Price (Rp/kg)" value="<?=$id_category1?>">
					<input type="text" class="form-control" id="id_pricelistnfr"  required name="id_pricelistnfr" placeholder="Book Price (Rp/kg)" value="<?=$pl->id_pricelistnfr?>">
									    </div>
										</div>
						 </div>				
						<div class="row">
										<div class="form-group row">
										<div class="col-md-4">
									    <label for="customer">Material</label>
									    </div>
									    <div class="col-md-6">
					<select id="id_category3" name="id_category3" readonly class="form-control select" onchange="hitungharga()" required>
						<option value="">-- Pilih Type --</option>
						<?php foreach ($results['inventory_3'] as $inventory_3){ 
						$select = $pl->id_category3 == $inventory_3->id_category3 ? 'selected' : '';
						?>
						<option value="<?= $inventory_3->id_category3?>" <?= $select ?>><?= ucfirst(strtolower($inventory_3->nama_category2))?>-<?= ucfirst(strtolower($inventory_3->nama))?>-<?= ucfirst(strtolower($inventory_3->hardness))?>-<?= ucfirst(strtolower($inventory_3->nilai_dimensi))?></option>
						<?php } ?>
					</select>
									    </div>
										</div>
						</div>	
					<div class="row">
					<table class="col-sm-12">
						<tr>
						<th>#</th>
						<th>Book Price (Rp/Kg)</th>
						<th>Harga Lme rate 10 hari(Rp/Kg)</th>
						<th>Harga Lme rate 30 hari(Rp/Kg)</th>
						<th>Harga Lme SPOT(Rp/Kg)</th>
						</tr>
						<tr id="head_price">
						<th>Harga Satuan</th>
						<td><input type="text" class="form-control" value="<?= $nilai_bookprice  ?>" id="book_price"  required name="book_price" placeholder="Book Price (Rp/kg)" ></td>
						<td><input type="text" class="form-control" value="<?= $lme101 ?>" id="lme101" readonly required name="lme101" placeholder="Book Price (Rp/kg)" ></td>
						<td><input type="text" class="form-control" value="<?= $lme301 ?>" id="lme301" readonly required name="lme301" placeholder="Book Price (Rp/kg)" ></td>
						<td><input type="text" class="form-control" value="<?= $lmespot1 ?>" id="lmespot1" readonly required name="lmespot1" placeholder="Book Price (Rp/kg)" ></td>
						<td hidden><input type="text" class="form-control" value="<?= $lme10 ?>" id="lme10" readonly required name="lme10" placeholder="Book Price (Rp/kg)" ></td>
						<td hidden><input type="text" class="form-control" value="<?= $lme30 ?>" id="lme30" readonly required name="lme30" placeholder="Book Price (Rp/kg)" ></td>
						<td hidden><input type="text" class="form-control" value="<?= $lmespot ?>" id="lmespot" readonly required name="lmespot" placeholder="Book Price (Rp/kg)" ></td>
						</tr>
						<tr>
						<th>SCRAP (%)</th>
						<td><input type="text" class="form-control" value="<?=$scr->presentase_rate?>" id="scrap"  readonly required name="scrap" placeholder="Book Price (Rp/kg)" value="<?=$scr->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?=$scr->presentase_rate?>" id="scrap1" readonly required name="scrap1" placeholder="Book Price (Rp/kg)" value="<?=$scr->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?=$scr->presentase_rate?>" id="scrap2" readonly required name="scrap2" placeholder="Book Price (Rp/kg)" value="<?=$scr->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?=$scr->presentase_rate?>" id="scrap3" readonly required name="scrap3" placeholder="Book Price (Rp/kg)" value="<?=$scr->presentase_rate?>"></td>
						</tr>
						<tr>
						<th>COGS (%)</th>
						<td><input type="text" class="form-control" value="<?= $cgs->presentase_rate?>" id="cogs"  readonly required name="cogs" placeholder="Book Price (Rp/kg)" value="<?= $cgs->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?= $cgs->presentase_rate?>" id="cogs1" readonly required name="cogs1" placeholder="Book Price (Rp/kg)" value="<?= $cgs->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?= $cgs->presentase_rate?>" id="cogs2" readonly required name="cogs2" placeholder="Book Price (Rp/kg)" value="<?= $cgs->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?= $cgs->presentase_rate?>" id="cogs3" readonly required name="cogs3" placeholder="Book Price (Rp/kg)" value="<?= $cgs->presentase_rate?>"></td>
						</tr>
						<th>Operating Cost (%)</th>
						<td><input type="text" class="form-control" value="<?= $opcost->presentase_rate?>" id="operating_cost"  readonly required name="operating_cost" placeholder="Book Price (Rp/kg)" value="<?= $opcost->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?= $opcost->presentase_rate?>" id="operating_cost1"  readonly required name="operating_cost1" placeholder="Book Price (Rp/kg)" value="<?= $opcost->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?= $opcost->presentase_rate?>" id="operating_cost2"  readonly required name="operating_cost2" placeholder="Book Price (Rp/kg)" value="<?= $opcost->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?= $opcost->presentase_rate?>" id="operating_cost3"  readonly required name="operating_cost3" placeholder="Book Price (Rp/kg)" value="<?= $opcost->presentase_rate?>"></td>
						</tr>
						<th>Interest inventory (%)</th>
						<td><input type="text" class="form-control" value="<?= $interest->presentase_rate?>" id="interest"  readonly required name="interest" placeholder="Book Price (Rp/kg)" value="<?= $interest->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?= $interest->presentase_rate?>" id="interest1"  readonly required name="interest1" placeholder="Book Price (Rp/kg)" value="<?= $interest->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?= $interest->presentase_rate?>" id="interest2"  readonly required name="interest2" placeholder="Book Price (Rp/kg)" value="<?= $interest->presentase_rate?>"></td>
						<td><input type="text" class="form-control" value="<?= $interest->presentase_rate?>" id="interest3"  readonly required name="interest3" placeholder="Book Price (Rp/kg)" value="<?= $interest->presentase_rate?>"></td>
						</tr>
						<th>Profit (%)</th>
						<td><input type="text" class="form-control" value="<?= $pl->profit ?>" id="profit"      onkeyup="hitungbottom()" required name="profit" placeholder="Profit" ></td>
						<td><input type="text" class="form-control" value="<?= $pl->profit10 ?>" id="profit10"    onkeyup="hitungbottom10()"  required name="profit10" placeholder="Profit" ></td>
						<td><input type="text" class="form-control" value="<?= $pl->profit30 ?>" id="profit30"    onkeyup="hitungbottom30()"  required name="profit30" placeholder="Profit" ></td>
						<td><input type="text" class="form-control" value="<?= $pl->profitspot ?>"id="profitspot"  onkeyup="hitungbottomspot()" required name="profitspot" placeholder="Profit" ></td>
						</tr >
						<th>Bottom price</th>
						<td id="bt_price1" ><input type="text" value="<?= number_format($pl->bottom_price,2) ?>" class="form-control" id="bottom_price1"   required name="bottom_price1" placeholder="Book Price (Rp/kg)" ></td>
						<td id="bt_price" hidden><input type="text" value="<?= $pl->bottom_price ?>" class="form-control" id="bottom_price"   required name="bottom_price" placeholder="Book Price (Rp/kg)" ></td>
						<td id="bt_price101" ><input type="text" value="<?= number_format($pl->bottom_price10,2) ?>" class="form-control" id="bottom_price101"   required name="bottom_price101" placeholder="Book Price (Rp/kg)" ></td>
						<td id="bt_price10" hidden><input type="text" value="<?= $pl->bottom_price10 ?>" class="form-control" id="bottom_price10"   required name="bottom_price10" placeholder="Book Price (Rp/kg)" ></td>
						<td id="bt_price301" ><input type="text" value="<?= number_format($pl->bottom_price30,2) ?>" class="form-control" id="bottom_price301"   required name="bottom_price301" placeholder="Book Price (Rp/kg)" ></td>
						<td id="bt_price30"hidden><input type="text" value="<?= $pl->bottom_price30 ?>" class="form-control" id="bottom_price30"   required name="bottom_price30" placeholder="Book Price (Rp/kg)" ></td>
						<td id="bt_pricespot1" ><input type="text" value="<?= number_format($pl->bottom_pricespot,2) ?>" class="form-control" id="bottom_pricespot1"   required name="bottom_pricespot1" placeholder="Book Price (Rp/kg)" ></td>
						<td id="bt_pricespot" hidden><input type="text" value="<?= $pl->bottom_pricespot ?>" class="form-control" id="bottom_pricespot"   required name="bottom_pricespot" placeholder="Book Price (Rp/kg)" ></td>
						</tr>
					</table>
					</div>
						</div>
				 	<hr>
					<center>
					<!--<button type="submit" class="btn btn-primary btn-sm add_field_button2" name="save"><i class="fa fa-plus"></i>Add Main Produk</button>
					--><button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-save"></i>Simpan</button>
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
						var baseurl=siteurl+'pricelist/saveEditPricelistnfr';
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
									window.location.href = base_url + active_controller+'/detailnfr/'+data.code;
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

function hitungharga(){
        var id_category3=$("#id_category3").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungharganfr',
            data:"id_category3="+id_category3,
            success:function(html){
               $("#head_price").html(html);
            }
        });
    }
	function hitungbottom(){
        var book_price=$("#book_price").val();
		var scrap=$("#scrap").val();
		var cogs=$("#cogs").val();
		var operating_cost=$("#operating_cost").val();
		var interest=$("#interest").val();
		var profit=$("#profit").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfr',
            data:"book_price="+book_price+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit="+profit,
            success:function(html){
               $("#bt_price").html(html);
            }
        });
				 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfr1',
            data:"book_price="+book_price+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit="+profit,
            success:function(html){
               $("#bt_price1").html(html);
            }
        });
    }
		function hitungbottom10(){
        var lme10=$("#lme10").val();
		var scrap=$("#scrap").val();
		var cogs=$("#cogs").val();
		var operating_cost=$("#operating_cost").val();
		var interest=$("#interest").val();
		var profit10=$("#profit10").val(); 
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfr10',
            data:"lme10="+lme10+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit10="+profit10,
            success:function(html){
               $("#bt_price10").html(html);
            }
        });
				 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfr101',
            data:"lme10="+lme10+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit10="+profit10,
            success:function(html){
               $("#bt_price101").html(html);
            }
        });
    }
			function hitungbottom30(){
        var lme30=$("#lme30").val();
		var scrap=$("#scrap").val();
		var cogs=$("#cogs").val();
		var operating_cost=$("#operating_cost").val();
		var interest=$("#interest").val();
		var profit30=$("#profit30").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfr30',
            data:"&lme30="+lme30+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit30="+profit30,
            success:function(html){
               $("#bt_price30").html(html);
            }
        });
				 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfr301',
            data:"&lme30="+lme30+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profit30="+profit30,
            success:function(html){
               $("#bt_price301").html(html);
            }
        });
    }
				function hitungbottomspot(){
        var lmespot=$("#lmespot").val();
		var scrap=$("#scrap").val();
		var cogs=$("#cogs").val();
		var operating_cost=$("#operating_cost").val();
		var interest=$("#interest").val();
		var profitspot=$("#profitspot").val();
		 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfrspot',
            data:"lmespot="+lmespot+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profitspot="+profitspot,
            success:function(html){
               $("#bt_pricespot").html(html);
            }
        });
				 $.ajax({
            type:"GET",
            url:siteurl+'pricelist/hitungbottomnfrspot1',
            data:"lmespot="+lmespot+"&scrap="+scrap+"&cogs="+cogs+"&operating_cost="+operating_cost+"&interest="+interest+"&profitspot="+profitspot,
            success:function(html){
               $("#bt_pricespot1").html(html);
            }
        });
    }
</script>