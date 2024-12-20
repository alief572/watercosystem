<?php

$listCode	= "SELECT * FROM help_default_name ORDER BY nm_default";
$getDef		= $this->db->query($listCode)->result_array();

$getKomp		= $this->db->query("SELECT * FROM product_parent ORDER BY product_parent ASC")->result_array();
$getPN			= $this->db->query("SELECT * FROM list_help WHERE group_by = 'pressure' ORDER BY name ASC")->result_array();
$getLiner		= $this->db->query("SELECT * FROM list_help WHERE group_by = 'liner' ORDER BY name ASC")->result_array();
$getMachine		= $this->db->query("SELECT * FROM machine WHERE sts_mesin='Y' ORDER BY nm_mesin ASC")->result_array();


?>
<div class="box box-success">
	<div class="box-body" style="">
		<table id="my-grid" class="table table-striped table-bordered table-hover table-condensed" width="100%">
			<tbody>
				<tr style='background-color: #175477; color: white; font-size: 15px;'>
					<th class="text-center" colspan='3'>HEADER</th>
				</tr>
				<tr>
					<th class="text-left" width='40%'>Item</th>
					<th class="text-left" width='60%'>Standar Value</th>
				</tr>
				<tr>
					<td class="text-left vMid">Product <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<select id='komponen' name='komponen' class='chosen_select form-control inline-block input-md' style='min-width:200px;'>
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
					<td class="text-left vMid">Standart <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<select name='standart_code' id='standart_code' class='chosen_select form-control inline-block input-md'>
							<option value='0'>Select Default</option>
						<?php
							foreach($getDef AS $val => $valx){
								echo "<option value='".$valx['nm_default']."'>".strtoupper($valx['nm_default'])."</option>";
							}
						 ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid"></td>
					<td style="text-align:left">
						<a id="search_step" class="btn btn-md btn-warning"><i class="fa fa-search"></i> Search Step</a>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Pressure <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<select id='pn' name='pn' class='chosen_select form-control inline-block input-md' style='min-width:200px;'>
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
						<select id='liner' name='liner' class='chosen_select form-control inline-block input-md' style='min-width:200px;'>
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
					<td class="text-left vMid">Diameter <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?php
							echo form_input(array('type'=>'text','id'=>'diameter','name'=>'diameter','class'=>'form-control input-md inSpL numberOnly','placeholder'=>'Diameter /mm','autocomplete'=>'off'));
						?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Diameter 2 <span class='text-red'>*</span></b></td>
					<td class="text-left">
						<?php
							echo form_input(array('type'=>'text','id'=>'diameter2','name'=>'diameter2','class'=>'form-control input-md inSpL numberOnly','placeholder'=>'Diameter /mm','autocomplete'=>'off'));
						?>
					</td>
				</tr>
				<tr>
					<td class="text-left vMid">Standard Length</td>
					<td class="text-left">
						<?php
							echo form_input(array('type'=>'text','id'=>'standard_length','name'=>'standard_length','class'=>'form-control input-md inSpL numberOnly','placeholder'=>'Standard Length','autocomplete'=>'off'));
						?>
					</td>
				</tr>


			</tbody>
		</table>
		<br>
		<table id="detail-time" class="table table-striped table-bordered table-hover table-condensed" width="100%">
			<thead>
				<tr style='background-color: #175477; color: white; font-size: 15px;'>
					<th class="text-center" colspan='3'><b>DETAIL TIME</b></th>
				</tr>
				<tr>
					<th class="text-left" width='40%'>STEP</th>
					<th class="text-center" width='60%'>TIMING (MINUTES)</th>
				</tr>
			</thead>
			<tbody id="tbody-detail"></tbody>
		</table>
    <br>
		<table id="my-grid" class="table table-striped table-bordered table-hover table-condensed" width="100%" style="margin-top:7px">
			<tbody>
				<tr style='background-color: #175477; color: white; font-size: 15px;'>
					<th class="text-center" colspan='2'><b>MANPOWER</b></th>
				</tr>
				<tr>
					<td class="text-left vMid" width='40%'>MANPOWER</td>
					<td class="text-center" width='60%'>
						<?php
							echo form_input(array('type'=>'text','id'=>'man_power','name'=>'man_power','class'=>'form-control input-md numberOnly', 'placeholder'=>'Input Man Power', 'maxlength'=>'5','autocomplete'=>'off'));
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
								echo "<option value='".$valx['no_mesin']."'>".strtoupper($valx['nm_mesin'])."</option>";
							}
						 ?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
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
    $('#addM').click(function(e){
      //console.log('a');
      var x = parseInt(document.getElementById("tbody-detail").rows.length)+1;
      var row = '<tr class="addjs">'+
            '<td style="background-color:#E0E0E0">'+
            '<a class="text-red hapus_item_js" href="javascript:void(0)" title="Hapus Item"><i class="fa fa-times"></i></a> || Input Material Name :'+
            '<input type="text" name="material[]"  class="form-control input-md" required="" style="width:50%;display:inline-block">'+
            '</td>'+
            '<td style="background-color:#E0E0E0;text-align:center">'+
            '<input type="text" name="material_time[]"  class="form-control input-md inSp2 numberOnly" required="" onkeyup="this.value = this.value.match(/^-?\\\d*[.]?\\\d*$/)" placeholder="Input Time">'+
            '</td>'+
        '</tr>'
        //console.log(document.getElementById("tbody").rows[0].column[0].text);
      $('#detail-time tbody tr:last').after(row);
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
    $('#detail-time tbody').on( 'click', 'a.hapus_item_js', function () {

      $(this).parents('tr').remove();

    } );

		$(document).on('click', '#search_step', function(){
			var komponen				= $('#komponen').val();
			var standart_code			= $('#standart_code').val();

			if(komponen == '' || komponen == null || komponen == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Component Input is Empty, please input first ...',
				  type	: "warning"
				});
				//$('#simpan-bro').prop('disabled',false);
				return false;
			}

			if(standart_code == '' || standart_code == null || standart_code == 0){
				swal({
				  title	: "Error Message!",
				  text	: 'Standard Code Input is Empty, please input first ...',
				  type	: "warning"
				});
				//$('#simpan-bro').prop('disabled',false);
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
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
					loading_spinner();
					var formData  	= new FormData($('#form_proses_bro')[0]);
					$.ajax({
						url			: base_url+'index.php/'+active_controller+'/getStepData',
						type		: "POST",
						data		: formData,
						cache		: false,
						dataType	: 'json',
						processData	: false,
						contentType	: false,
						success		: function(data){
							if(data.status == 1){
								swal({
									  title	: "Success!",
									  text	: 'Data has been added',
									  type	: "success",
									  timer	: 1000,
									  showCancelButton	: false,
									  showConfirmButton	: false,
									  allowOutsideClick	: false
									});
								// window.location.href = base_url + active_controller+'/'+data_url;
								/*$("#select_step").each(function() {

								$("#ModalView2").modal('hide');
								$("#head_title").html("<b>ADD DEFAULT</b>");
								$("#view").load(base_url +'index.php/'+ active_controller+'/modalAdd_Step/');
								$("#ModalView").modal();
								});*/
								//console.log(data.step['diameter']);
								$("#id").val(data.step['id']);
								$("#diameter").val(data.step['diameter']);
								$("#diameter2").val(data.step['diameter2']);
								$("#standard_length").val(data.step['standard_length']);
								$("#tbody-detail").append(data.stepDetail);

							}
							else{
								swal({
								  title	: "Failed!",
								  text	: data.pesan,
								  type	: "warning",
								  timer	: 5000,
								  showCancelButton	: false,
								  showConfirmButton	: false,
								  allowOutsideClick	: false
								});
							}
						},
						error: function() {
							swal({
							  title				: "Error Message !",
							  text				: 'An Error Occured During Process. Please try again..',
							  type				: "warning",
							  timer				: 5000,
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
  } );
</script>
