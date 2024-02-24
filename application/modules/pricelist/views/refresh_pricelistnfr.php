<?php
    $ENABLE_ADD     = has_permission('master_bentuk.Add');
    $ENABLE_MANAGE  = has_permission('master_bentuk.Manage');
    $ENABLE_VIEW    = has_permission('master_bentuk.View');
    $ENABLE_DELETE  = has_permission('master_bentuk.Delete');
foreach ($results['scrap'] as $scr){};
foreach ($results['cogs'] as $cgs){};
foreach ($results['operating_cost'] as $opcost){};
foreach ($results['interest'] as $interest){};	
$scrap = $scr->presentase_rate/100;
$cogs =$cgs->presentase_rate/100;
$operating_cost =$opcost->presentase_rate/100;
$inter  =$interest->presentase_rate/100;				
?>
 <div class="box box-primary">
    <div class="box-body">

		<form id="data-form" method="post">
			<div class="col-sm-12">
			<center><div><h1>Refresh Pricelist</h1></div></center>
					<center>
										  <div hidden>
					  <input type="text" class="form-control" id="inven1"  required name="inven1" value="<?=$id_category1?>">
						</div>
					<?php $numb = 0; foreach ($results['inventory_3'] as $inventory_3){
					$id_category3 = $inventory_3->id_category3;
					$bookprice	= $this->db->query("SELECT * FROM ms_bookprice_material WHERE id_category3='$id_category3' ")->result();
					$wayoh	= $this->db->query("SELECT * FROM ms_pricelistnfr WHERE id_category3='$id_category3' ")->result();
					
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
		$scrapbookprice = $bookprice[0]->nilai_bookprice*$scrap;
		$scraplme10 = $lme10*$scrap;
		$scraplme30 = $lme30*$scrap;
		$scraplmespot = $lmespot*$scrap;
		$cogsbookprice = $bookprice[0]->nilai_bookprice*$cogs;
		$cogslme10 = $lme10*$cogs;
		$cogslme30 = $lme30*$cogs;
		$cogslmespot = $lmespot*$cogs;
		$operating_costbookprice = $bookprice[0]->nilai_bookprice*$operating_cost;
		$operating_costlme10 = $lme10*$operating_cost;
		$operating_costlme30 = $lme30*$operating_cost;
		$operating_costlmespot = $lmespot*$operating_cost;
		$interbookprice = $bookprice[0]->nilai_bookprice*$inter;
		$interlme10 = $lme10*$inter;
		$interlme30 = $lme30*$inter;
		$interlmespot = $lmespot*$inter;
		$profitbookprice = $bookprice[0]->nilai_bookprice*$wayoh[0]->profit/100;
		$profitlme10 = $lme10*$wayoh[0]->profit10/100;
		$profitlme30 = $lme30*$wayoh[0]->profit30/100;
		$profitlmespot = $lmespot*$wayoh[0]->profitspot/100;
		$nilaiakhirbook = $bookprice[0]->nilai_bookprice+$scrapbookprice+$cogsbookprice+$operating_costbookprice+$interbookprice+$profitbookprice;
		$nilaiakhirlme10 = $lme10+$scraplme10+$cogslme10+$operating_costlme10+$interlme10+$profitlme10;
		$nilaiakhirlme30 = $lme30+$scraplme30+$cogslme30+$operating_costlme30+$interlme30+$profitlme30;
		$nilaiakhirlmespot = $lmespot+$scraplmespot+$cogslmespot+$operating_costlmespot+$interlmespot+$profitlmespot;
					$numb ++;
					?>
					<div hidden >
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][id_category3]" value="<?=$id_category3?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][book_price]" value="<?=$bookprice[0]->nilai_bookprice?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][lme10]" value="<?=$lme10?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][lme30]" value="<?=$lme30?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][lmespot]" value="<?=$lmespot?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][profit]" value="<?=$wayoh[0]->profit?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][profit10]" value="<?=$wayoh[0]->profit10?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][profit30]" value="<?=$wayoh[0]->profit30?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][profitspot]" value="<?=$wayoh[0]->profitspot?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][bottom_price]" value="<?=$nilaiakhirbook?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][bottom_price10]" value="<?=$nilaiakhirlme10?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][bottom_price30]" value="<?=$nilaiakhirlme30?>">
					<input type="text" class="form-control"  required name="plnfr[<?=$numb?>][bottom_pricespot]" value="<?=$nilaiakhirlmespot?>">
					</div>
					<?php };?>
					<button type="submit" class="btn btn-success btn-sm" name="save" id="simpan-com"><i class="fa fa-refresh"></i>Refresh</button>
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
						var baseurl=siteurl+'pricelist/saveRefreshPricelistnfr';
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