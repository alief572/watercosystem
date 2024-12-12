<?php

$listCode	= "SELECT * FROM help_default_name ORDER BY nm_default";
$getDef		= $this->db->query($listCode)->result_array();

$getKomp		= $this->db->query("SELECT * FROM product_parent ORDER BY product_parent ASC")->result_array();
$getPN		= $this->db->query("SELECT * FROM list_help WHERE group_by = 'pressure' ORDER BY name ASC")->result_array();
$getLiner		= $this->db->query("SELECT * FROM list_help WHERE group_by = 'liner' ORDER BY name ASC")->result_array();
$getStep		= $this->db->query("SELECT * FROM cycletime_step")->result_array();


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
									echo "<option value='".$valx['product_parent']."'>".strtoupper($valx['product_parent'])."</option>";
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
									echo "<option value='".$valx['name']."'>".$valx['name']."</option>";
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
									echo "<option value='".$valx['name']."'>".$valx['name']."</option>";
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
								echo "<option value='".$valx['nm_default']."'>".strtoupper($valx['nm_default'])."</option>";
							}
						 ?>
						</select>
						<button type='button' id='addP' style='font-weight: bold; font-size: 12px; margin-top: 5px; color: #175477;'>Add Standart Default</button>
					</td>
				</tr>
				<!--
				<tr>
					<td class="text-left vMid">Diameter <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?php
							// echo form_input(array('type'=>'text','id'=>'diameter','name'=>'diameter','class'=>'form-control input-sm inSpL numberOnly','placeholder'=>'Diameter /mm','autocomplete'=>'off'));
						?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Diameter 2 <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?php
							// echo form_input(array('type'=>'text','id'=>'diameter2','name'=>'diameter2','class'=>'form-control input-sm inSpL numberOnly','placeholder'=>'Diameter /mm','autocomplete'=>'off'));
						?>
					</td>
				</tr>
				-->
				<div>
				<tr id='standartlength'>
					<td class="text-left vMid">Standard Length</td>
					<td class="text-left">
						<?php
							echo form_input(array('type'=>'text','id'=>'standard_length','name'=>'standard_length','class'=>'form-control input-md inSpL numberOnly','placeholder'=>'Standard Length','autocomplete'=>'off'));
						?>
					</td>
				</tr>
				</div>

			</tbody>
		</table>
		<br>
		<table id="detail-step" class="table table-striped table-bordered table-hover table-condensed" width="100%">
				<thead>
					<tr style='background-color: #175477; color: white; font-size: 15px;'>
						<th class="text-center" colspan='3'><b>DETAIL STEP</b></th>
					</tr>
					<tr>
						<th class="text-left" width='50%'>Step Num.</th>
						<th class="text-center" width='50%'>Step Detail</th>
					</tr>
				</thead>
				<tbody id="tbody-detail">
				</tbody>
		</table>
		<br>
		<a class="btn btn-sm btn-success" id="addS">Add Step</a>
		<br>
		<?php
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-success','style'=>'min-width:100px; float:right;','value'=>'save','content'=>'Save','id'=>'addDefaultSave')).' ';
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
	//=====================================Arwant=====================================
	$(document).ready(function(){
		$('#standartlength').hide();
		
		$('#komponen').change(function(){
			if($(this).val() == 'pipe' || $(this).val() == 'pipe slongsong'){
				$('#standartlength').show();
			}
			else{
				$('#standartlength').hide();
			}
		});
	});
	//===================================End Arwant=====================================

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
            //'<input type="text" name="step[]"  class="form-control input-sm inSp2 " required="" placeholder="Input Step">'+
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
