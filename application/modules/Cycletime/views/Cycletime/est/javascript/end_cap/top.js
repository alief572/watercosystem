

$(document).on('change', '#customer', function(e){
	e.preventDefault();
	$.ajax({
		url: base_url +'index.php/'+ active_controller+'/getTolerance',
		cache: false,
		type: "POST",
		data: "cust="+this.value,
		dataType: "json",
		success: function(data){
			$("#top_toleran").html(data.option).trigger("chosen:updated");
		}
	});
});
		
$(document).on('keyup', '#top_tebal_design', function(){
			
	var waste			= parseFloat($('#waste').val());
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	
	var acuhan_1		= parseFloat($('#acuhan_1').val());
	
	var hasilAch2		= top_thickness - acuhan_1;
	// alert('Hay');
	$('#acuhan_2').val(hasilAch2.toFixed(1));
	
	//Liner Thickness
	var layer_veil1		= $("#layer_veil").val();
	var layer_veil2		= $("#layer_veil_add").val();
	var layer_veil3		= $("#layer_matcsm").val();
	var layer_veil4		= $("#layer_csm_add").val();
	var tot_thickness1	= parseFloat($('#tot_lin_thickness').val());
	
	//Struktur Thickness
	var layer1			= $("#layer_matcsm2").val();
	var layer2			= $("#layer_csm_add2").val();
	var layer3			= $("#layer_wr2").val();
	var layer4			= $("#layer_wr_add2").val();
	var layer5			= $("#layer_rooving21").val();
	var layer6			= $("#layer_rooving22").val();
	var tot_thickness2	= parseFloat($('#tot_lin_thickness2').val());
	
	//External Thickness
	var layer31			= $("#layer_veil3").val();
	var layer32			= $("#layer_veil_add3").val();
	var layer33			= $("#layer_matcsm3").val();
	var layer34			= $("#layer_csm_add3").val();
	var tot_thickness3	= parseFloat($('#tot_lin_thickness3').val());
	
	Hasil(tot_thickness1, layer_veil1, layer_veil2, layer_veil3, layer_veil4, top_diameter, top_thickness, waste);
	Hasil2(tot_thickness2, layer1, layer2, layer3, layer4, layer5, layer6, top_diameter, top_thickness, waste);
	Hasil3(tot_thickness3, layer31, layer32, layer33, layer34, top_diameter, top_thickness, waste);
	rubaharea();
}); 

$(document).on('change', '#top_typeList', function(e){
	// e.preventDefault();
	var id	= $(this).val();
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getDiameter',
		cache: false,
		type: "POST",
		data: "id="+$(this).val(),
		dataType: "json",
		success: function(data){
			$('#top_type').val(data.pipeN);
			$('#top_diameter').val(data.pipeD);
			
			var ThisD = data.pipeD;
			if(ThisD <= 450){
				var angkaRoving	= 32/68;
			}
			else if(ThisD > 450){  
				var angkaRoving	= 28/72;
			}
			else{
				var angkaRoving	= 0;
			}
			var angkaVeil	= 9/1;
			var angkaCsm	= 68/32;
			var angkaCsmStr	= 60/40;
			var angkaWr		= 45/55;
			
			//Rooving
			$('#layer_resin25').val(angkaRoving.toFixed(3));
			$('#layer_resin26').val(angkaRoving.toFixed(3));
			
			//Veil
			$('#layer_resin1').val(angkaVeil.toFixed(3));
			$('#layer_resin2').val(angkaVeil.toFixed(3));
			$('#layer_resin31').val(angkaVeil.toFixed(3));
			$('#layer_resin32').val(angkaVeil.toFixed(3));
			
			//CSM
			$('#layer_resin3').val(angkaCsm.toFixed(3));
			$('#layer_resin4').val(angkaCsm.toFixed(3));
			$('#layer_resin21').val(angkaCsmStr.toFixed(3));
			$('#layer_resin22').val(angkaCsmStr.toFixed(3));
			$('#layer_resin33').val(angkaCsm.toFixed(3));
			$('#layer_resin34').val(angkaCsm.toFixed(3));
			
			//WR
			$('#layer_resin23').val(angkaWr.toFixed(3));
			$('#layer_resin24').val(angkaWr.toFixed(3));
			
			var waste			= parseFloat($('#waste').val());
			var top_diameter	= parseFloat($('#top_diameter').val());
			var top_thickness	= parseFloat($('#top_tebal_design').val());
			
			var radius	= top_diameter/2;
			$("#radius").val(radius.toFixed(1));
			
			//Liner Thickness
			var layer_veil1		= $("#layer_veil").val();
			var layer_veil2		= $("#layer_veil_add").val();
			var layer_veil3		= $("#layer_matcsm").val();
			var layer_veil4		= $("#layer_csm_add").val();
			var tot_thickness1	= parseFloat($('#tot_lin_thickness').val());
			
			//Struktur Thickness
			var layer1			= $("#layer_matcsm2").val();
			var layer2			= $("#layer_csm_add2").val();
			var layer3			= $("#layer_wr2").val();
			var layer4			= $("#layer_wr_add2").val();
			var layer5			= $("#layer_rooving21").val();
			var layer6			= $("#layer_rooving22").val();
			var tot_thickness2	= parseFloat($('#tot_lin_thickness2').val());
			
			//External Thickness
			var layer31			= $("#layer_veil3").val();
			var layer32			= $("#layer_veil_add3").val();
			var layer33			= $("#layer_matcsm3").val();
			var layer34			= $("#layer_csm_add3").val();
			var tot_thickness3	= parseFloat($('#tot_lin_thickness3').val());
			
			
			Hasil(tot_thickness1, layer_veil1, layer_veil2, layer_veil3, layer_veil4, top_diameter, top_thickness, waste);
			Hasil2(tot_thickness2, layer1, layer2, layer3, layer4, layer5, layer6, top_diameter, top_thickness, waste);
			Hasil3(tot_thickness3, layer31, layer32, layer33, layer34, top_diameter, top_thickness, waste);
			rubaharea();
		}
	});
}); 

$(document).on('change', '#acuhan_1', function(){
	var liner				= $('#acuhan_1').val();
	// var struktur			= $('#acuhan_2').val();
	var external			= $('#acuhan_3').val();
	var MinToleransi		= $('#top_min_toleran').val();
	var MaxToleransi		= $('#top_max_toleran').val();
	var tot_lin_thickness	= $('#tot_lin_thickness').val();
	var tot_lin_thickness2	= $('#tot_lin_thickness2').val();
	var tot_lin_thickness3	= $('#tot_lin_thickness3').val();
	
	//pengurangan structure thickness
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	var acuhan_1		= parseFloat($('#acuhan_1').val());
	var struktur		= top_thickness - acuhan_1;
	
	$('#acuhan_2').val(struktur.toFixed(1));
	
	AcuhanMaxMin(liner, struktur, external, MinToleransi, MaxToleransi, tot_lin_thickness, tot_lin_thickness2, tot_lin_thickness3);
});



$(document).on('keyup', '#top_min_toleran', function(){
	var liner		= $('#acuhan_1').val();
	var struktur	= $('#acuhan_2').val();
	var external	= $('#acuhan_3').val();
	var MinToleransi	= $('#top_min_toleran').val();
	var MaxToleransi		= $('#top_max_toleran').val();
	var tot_lin_thickness	= $('#tot_lin_thickness').val();
	var tot_lin_thickness2	= $('#tot_lin_thickness2').val();
	var tot_lin_thickness3	= $('#tot_lin_thickness3').val(); 
	
	AcuhanMaxMin(liner, struktur, external, MinToleransi, MaxToleransi, tot_lin_thickness, tot_lin_thickness2, tot_lin_thickness3);
});

$(document).on('keyup', '#top_max_toleran', function(){
	var liner		= $('#acuhan_1').val();
	var struktur	= $('#acuhan_2').val();
	var external	= $('#acuhan_3').val();
	var MinToleransi	= $('#top_min_toleran').val();
	var MaxToleransi		= $('#top_max_toleran').val();
	var tot_lin_thickness	= $('#tot_lin_thickness').val();
	var tot_lin_thickness2	= $('#tot_lin_thickness2').val();
	var tot_lin_thickness3	= $('#tot_lin_thickness3').val();
	
	AcuhanMaxMin(liner, struktur, external, MinToleransi, MaxToleransi, tot_lin_thickness, tot_lin_thickness2, tot_lin_thickness3);
});

$(document).on('change', '#top_toleran', function(){
	if($(this).val() != 'C100-1903000'){
		$('.ToleranSt').show();
	}
	else{
		$('.ToleranSt').hide();	
		$('#top_min_toleran').val('0.125');
		$('#top_max_toleran').val('0.125');
	}
});

$(document).on('keyup', '#waste', function(){
	
	var waste			= parseFloat($('#waste').val());
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	
	var acuhan_1		= parseFloat($('#acuhan_1').val());
	
	var hasilAch2		= top_thickness - acuhan_1;
	// alert('Hay');
	$('#acuhan_2').val(hasilAch2.toFixed(1));
	
	//Liner Thickness
	var layer_veil1		= $("#layer_veil").val();
	var layer_veil2		= $("#layer_veil_add").val();
	var layer_veil3		= $("#layer_matcsm").val();
	var layer_veil4		= $("#layer_csm_add").val();
	var tot_thickness1	= parseFloat($('#tot_lin_thickness').val());
	
	//Struktur Thickness
	var layer1			= $("#layer_matcsm2").val();
	var layer2			= $("#layer_csm_add2").val();
	var layer3			= $("#layer_wr2").val();
	var layer4			= $("#layer_wr_add2").val();
	var layer5			= $("#layer_rooving21").val();
	var layer6			= $("#layer_rooving22").val();
	var tot_thickness2	= parseFloat($('#tot_lin_thickness2').val());
	
	//External Thickness
	var layer31			= $("#layer_veil3").val();
	var layer32			= $("#layer_veil_add3").val();
	var layer33			= $("#layer_matcsm3").val();
	var layer34			= $("#layer_csm_add3").val();
	var tot_thickness3	= parseFloat($('#tot_lin_thickness3').val());
	
	Hasil(tot_thickness1, layer_veil1, layer_veil2, layer_veil3, layer_veil4, top_diameter, top_thickness, waste);
	Hasil2(tot_thickness2, layer1, layer2, layer3, layer4, layer5, layer6, top_diameter, top_thickness, waste);
	Hasil3(tot_thickness3, layer31, layer32, layer33, layer34, top_diameter, top_thickness, waste);
	rubaharea();
});