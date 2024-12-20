<?php
$id = $this->uri->segment(3);
$listCode	= "SELECT * FROM help_default_name ORDER BY nm_default";
$getDef		= $this->db->query($listCode)->result_array();

$getKomp		= $this->db->query("SELECT * FROM product_parent ORDER BY product_parent ASC")->result_array();
$getPN		= $this->db->query("SELECT * FROM list_help WHERE group_by = 'pressure' ORDER BY name ASC")->result_array();
$getLiner		= $this->db->query("SELECT * FROM list_help WHERE group_by = 'liner' ORDER BY name ASC")->result_array();
$getStep		= $this->db->query("SELECT * FROM cycletime_step")->result_array();
$getDefault		= $this->db->query("SELECT * FROM cycletime_default WHERE id = '".$id."'")->row();
$getDetail		= $this->db->query("SELECT * FROM cycle_time_step_detail WHERE kode = '".$getDefault->kode."'")->result();
$getDetail2		= $this->db->query("SELECT * FROM cycle_time_step_detail WHERE kode = '".$getDefault->kode."'")->result_array();
$getMachine		= $this->db->query("SELECT * FROM machine WHERE sts_mesin='Y' ORDER BY nm_mesin ASC")->result_array();

$ArrWhere		= array(
	'standart_code'		=> $getDefault->standard_code,
	'parent_product'	=> $getDefault->product_parent
);

$getNum		= $this->db->get_where('cycle_time_step',$ArrWhere)->num_rows();
$getStepNew	= $this->db->get_where('cycle_time_step',$ArrWhere)->result_array();
// echo "<pre>";
// print_r($getDetail);

?>
<div class="box box-success">
	<div class="box-body" style="">
		<table id="my-grid" class="table table-striped table-bordered table-hover table-condensed" width="100%">
			<tbody>
				<tr style='background-color: #175477; color: white; font-size: 15px;'>
					<th class="text-center" colspan='3'>HEADER</th>
				</tr>
				<tr>
					<th class="text-left" width='34%'>Item</th>
					<th class="text-left" width='66%'>Standar Value</th>
				</tr>
				<tr>
					<td class="text-left vMid">Product <span class='text-red'>*</span></b></td>
					<td class="text-left">

						<select id='komponen' name='komponen' class='chosen_select form-control inline-block' style='min-width:200px;'>
							<option value='0'>Select Component</option>
							<?php
								foreach($getKomp AS $val => $valx){
									$selected = ($getDefault->product_parent==$valx['product_parent'])?'selected':'';
									echo "<option value='".$valx['product_parent']."' ".$selected.">".strtoupper($valx['product_parent'])."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td class="text-left vMid">Standart <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<select name='standart_code' id='standart_code' class='chosen_select form-control inline-block'>
							<option value='0'>Select Default</option>
						<?php
							foreach($getDef AS $val => $valx){
								$selected = ($getDefault->standard_code==$valx['nm_default'])?'selected':'';
								echo "<option value='".$valx['nm_default']."'".$selected.">".strtoupper($valx['nm_default'])."</option>";
							}
						 ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Pressure <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<select id='pn' name='pn' class='chosen_select form-control inline-block' style='min-width:200px;'>
							<option value='0'>Select Pressure</option>
							<?php
								foreach($getPN AS $val => $valx){
									$selected = ($getDefault->pn==$valx['name'])?'selected':'';
									echo "<option value='".$valx['name']."'".$selected.">".$valx['name']."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Liner <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<select id='liner' name='liner' class='chosen_select form-control inline-block' style='min-width:200px;'>
							<option value='0'>Select Liner</option>
							<?php
								foreach($getLiner AS $val => $valx){
									$selected = ($getDefault->liner==$valx['name'])?'selected':'';
									echo "<option value='".$valx['name']."'".$selected.">".$valx['name']."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Diameter<span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?php
							echo form_input(array('type'=>'text','id'=>'diameter','name'=>'diameter','class'=>'form-control input-md inSpL numberOnly','placeholder'=>'Diameter /mm','autocomplete'=>'off','value'=>$getDefault->diameter));
							echo form_input(array('type'=>'hidden','id'=>'id','name'=>'id','value'=>$getDefault->id));
							echo form_input(array('type'=>'hidden','id'=>'kode','name'=>'kode','value'=>$getDefault->kode));
						?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Diameter 2<span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?php
							echo form_input(array('type'=>'text','id'=>'diameter2','name'=>'diameter2','class'=>'form-control input-md inSpL numberOnly','placeholder'=>'Diameter /mm','autocomplete'=>'off','value'=>$getDefault->diameter2));
						?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Standard Length</td>
					<td class="text-left">
						<?php
							echo form_input(array('type'=>'text','id'=>'standard_length','name'=>'standard_length','class'=>'form-control input-md inSpL numberOnly','placeholder'=>'Standard Length','autocomplete'=>'off','value'=>number_format($getDefault->standard_length,1)));
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		<table id="detail-step" class="table table-striped table-bordered table-hover table-condensed" width="100%">
				<thead>
					<tr style='background-color: #175477; color: white; font-size: 15px;'>
						<th class="text-center" colspan='3'><b>DETAIL STEP</b></th>
					</tr>
					<tr>
						<th class="text-left" width='50%'>STEP</th>
						<th class="text-center" width='50%'>STEP TIME(MINUTES)</th>
					</tr>
				</thead>
				<tbody id="tbody-detail">
					<?php
						if(!empty($getDetail)){
							$detNum = 0;
							foreach($getDetail2 AS $val => $valz){
								$detNum++;?>

								<tr class="addjs">
									<td style="background-color:#E0E0E0"><?=strtoupper($valz['step'])?></td>
									<td style="background-color:#E0E0E0;text-align:center">
										<input type="text" name="DataStep[<?=$detNum?>][timing]" class="form-control input-sm inSp2 numberOnly" placeholder="Input Time" maxlength="5" autocomplete="off" value="<?=$valz['timing']?>">
										<input type="hidden" name="DataStep[<?=$detNum?>][step]" class="form-control input-sm inSp2 numberOnly" placeholder="Input Time" autocomplete="off" value="<?=$valz['step']?>">
								</tr>
								<?php
							}
						}
						elseif(empty($getDetail)){
							if($getNum > 0){
								$detNum = 0;
								foreach($getStepNew AS $val2 => $valz2){
									$detNum++;?>

									<tr class="addjs">
										<td style="background-color:#E0E0E0"><?=strtoupper($valz2['step'])?></td>
										<td style="background-color:#E0E0E0;text-align:center">
											<input type="text" name="DataStep[<?=$detNum?>][timing]" class="form-control input-sm inSp2 numberOnly" placeholder="Input" maxlength="5" autocomplete="off">
											<input type="hidden" name="DataStep[<?=$detNum?>][step]" value="<?=$valz2['step']?>">
									</tr>
									<?php
								}
							}
							else{
								echo "<tr><td colspan='2'>Detail step tidak ditemukan</td></tr>";	
							}
						}
					?>
				</tbody>
		</table>
		<br>
		<table id="my-grid" class="table table-striped table-bordered table-hover table-condensed" width="100%" style="margin-top:7px">
			<tbody>
				<tr style='background-color: #175477; color: white; font-size: 15px;'>
					<th class="text-center" colspan='2'><b>MANPOWER</b></th>
				</tr>
				<tr>
					<td class="text-left vMid" width='50%'>MANPOWER</td>
					<td class="text-center" width='50%'>
						<?php
							echo form_input(array('type'=>'text','id'=>'man_power','name'=>'man_power','class'=>'form-control input-md numberOnly', 'placeholder'=>'Input MP', 'maxlength'=>'5','autocomplete'=>'off','value'=>$getDefault->man_power));
						?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">MACHINE</td>
					<td class="text-center">
						<select name='machine' id='machine' class='chosen_select form-control inline-block'>
							<option value='0'>Select Machine</option>
						<?php
							foreach($getMachine AS $val => $valx){
								$selected = ($getDefault->id_mesin == $valx['no_mesin'])?'selected':'';
								echo "<option value='".$valx['no_mesin']."' ".$selected.">".strtoupper($valx['nm_mesin'])."</option>";
							}
						 ?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		<?php
			echo form_input(array('type'=>'hidden','value'=>$id,'name'=>'id_cycle')).' ';

			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-success','style'=>'min-width:100px; float:right;','value'=>'save','content'=>'Save','id'=>'editTimeSave')).' ';
		?>
	</div>
</div>

<style>
	.inSp{
		text-align: center;
		display: inline-block;
		width: 100px;
	}
	.inSp2{
		text-align: center;
		display: inline-block;
		width: 80px;
	}
	.inSpL{
		text-align: left;
	}
	.vMid{
		vertical-align: middle !important;
	}

</style>

<script>
	$(".numberOnly").on("keypress keyup blur",function (event) {
		if ((event.which < 48 || event.which > 57 ) && (event.which < 46 || event.which > 46 )) {
			event.preventDefault();
		}
	});

	function getNum(val) {
	   if (isNaN(val) || val == '') {
		 return 0;
	   }
	   return parseFloat(val);
	}
	$(document).ready(function() {

    //ADD LIST BUTTON
    $('#addS').click(function(e){
      //console.log('a');
      var x = parseInt(document.getElementById("tbody-detail").rows.length)+1;
      var row = '<tr class="addjs">'+
            '<td style="background-color:#E0E0E0">'+
            '<a class="text-red hapus_item_js" href="javascript:void(0)" title="Hapus Item"><i class="fa fa-times"></i></a> || '+
            'Step '+x+
            '</td>'+
            '<td style="background-color:#E0E0E0;text-align:center">'+
            //'<input type="text" name="step[]"  class="form-control input-md inSp2 " required="" placeholder="Input Step">'+
						'<select name="step[]" id="step[]" class="chosen_select form-control inline-block select_step">'+
							'<option value="0">Select Step</option>'+
						'<?php foreach($getStep AS $val => $valx){ ?>'+
								'<option value="<?=$valx["step_name"]?>"><?=strtoupper($valx["step_name"])?></option>'+
						'<?php } ?>'+
						'</select>'+
						'<button type="button" id="addStep" style="font-weight: bold; font-size: 12px; margin-top: 5px; color: #175477;">Add Standart Step</button>'+

            '</td>'+
        '</tr>'
        //console.log(document.getElementById("tbody").rows[0].column[0].text);
      $('#detail-step tbody').append(row);
      /*$.ajax({
        url: siteurl+"purchaseorder/purchaseorder_pusat/konfirmasi_save",
        dataType : "json",
        type: 'POST',
        data: formdata,
        success: function(result){
          //console.log(result['msg']);
          if(result.save=='1'){
            swal({
              title: "Sukses!",
              text: result['msg'],
              type: "success",
              timer: 1500,
              showConfirmButton: false
            });
            setTimeout(function(){
              window.location.href=siteurl+'purchaseorder/purchaseorder_pusat';
            },1600);
          } else {
            swal({
              title: "Gagal!",
              text: result['msg'],
              type: "error",
              timer: 1500,
              showConfirmButton: false
            });
          };
        },
        error: function (request, error) {
          console.log(arguments);
          alert(" Can't do because: " + error);
        }
      });*/
      //$('#tbody').find('tr')
    });

    //REMOVE LIST BUTTON
    $('#detail-step tbody').on( 'click', 'a.hapus_item_js', function () {
			console.log('a');
      $(this).parents('tr').remove();

    } );
  } );

</script>
