
$(document).on('change', '#mid_mtl_resin_tot3', function(){
	if($("#mid_mtl_veil3").val() != 'MTL-1903000'){
		$("#layer_resin31hide").val($(this).val());
	}
	if($("#mid_mtl_veil_add3").val() != 'MTL-1903000'){
		$("#layer_resin32hide").val($(this).val());
	}
	if($("#mid_mtl_matcsm3").val() != 'MTL-1903000'){
		$("#layer_resin33hide").val($(this).val());
	}
	if($("#mid_mtl_csm_add3").val() != 'MTL-1903000'){
		$("#layer_resin34hide").val($(this).val());
	}
});

$(document).on('change', '#mid_mtl_veil3', function(){
	var id_material	= $(this).val();
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getVeil',
		cache: false,
		type: "POST",
		data: "id_material="+$(this).val()+"&resin1="+$('#layer_resin31').val(),
		dataType: "json",
		success: function(data){
			$('#weight_veil3').val(data.micron);
			$('#thickness_veil3').val(RoundUp4(data.thickness));
			$('#layer_veil3').val(data.layer);
			$('#layer_resin31hide').val(data.resin);
		}
	});
});

$(document).on('keyup', '#layer_veil3', function(){
	var layer_veil		= $(this).val();
	var layer2		= $("#layer_veil_add3").val();
	var layer3		= $("#layer_matcsm3").val();
	var layer4		= $("#layer_csm_add3").val();
	
	var waste			= parseFloat($('#waste').val());
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	
	var thickness_veil 	= $('#thickness_veil3').val();
	var tot_thickness	= layer_veil*thickness_veil;
	
	var thickness2		= parseFloat($('#totthick_veil_add3').val());
	var thickness3		= parseFloat($('#totthick_matcsm3').val());
	var thickness4		= parseFloat($('#totthick_csm_add3').val());
	var tot_thickness2	= tot_thickness + thickness2 + thickness3 + thickness4;
	
	$('#tot_lin_thickness3').val(tot_thickness2.toFixed(4));
	$('#totthick_veil3').val(tot_thickness.toFixed(4));
	
	Hasil3(tot_thickness2, layer_veil, layer2, layer3, layer4, top_diameter, top_thickness, waste);
	rubaharea();
});

$(document).on('change', '#mid_mtl_veil_add3', function(){
	var id_material	= $(this).val();
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getVeil2',
		cache: false,
		type: "POST",
		data: "id_material="+$(this).val()+"&resin2="+$('#layer_resin32').val(),
		dataType: "json",
		success: function(data){
			$('#weight_veil_add3').val(data.micron);
			$('#thickness_veil_add3').val(RoundUp4(data.thickness));
			$('#layer_veil_add3').val(data.layer);
			$('#layer_resin32hide').val(data.resin);
		}
	});
});

$(document).on('keyup', '#layer_veil_add3', function(){
	var layer_veil		= $(this).val();
	var layer1		= $("#layer_veil3").val();
	var layer3		= $("#layer_matcsm3").val();
	var layer4		= $("#layer_csm_add3").val();
	
	var waste			= parseFloat($('#waste').val());
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	
	var thickness_veil 	= $('#thickness_veil_add3').val();
	var tot_thickness	= layer_veil*thickness_veil;
	
	var thickness1		= parseFloat($('#totthick_veil3').val());
	var thickness3		= parseFloat($('#totthick_matcsm3').val());
	var thickness4		= parseFloat($('#totthick_csm_add3').val());
	var tot_thickness2	= thickness1 + tot_thickness + thickness3 + thickness4;
	
	$('#tot_lin_thickness3').val(tot_thickness2.toFixed(4));
	$('#totthick_veil_add3').val(tot_thickness.toFixed(4));
	
	Hasil3(tot_thickness2, layer1, layer_veil, layer3, layer4, top_diameter, top_thickness, waste);
	rubaharea();
});

$(document).on('change', '#mid_mtl_matcsm3', function(){
	var id_material	= $(this).val();
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getCsm',
		cache: false,
		type: "POST",
		data: "id_material="+$(this).val()+"&resin3="+$('#layer_resin33').val(),
		dataType: "json",
		success: function(data){
			$('#weight_matcsm3').val(data.micron);
			$('#thickness_matcsm3').val(RoundUp4(data.thickness));
			$('#layer_matcsm3').val(data.layer);
			$('#layer_resin33hide').val(data.resin);
		}
	});
});

$(document).on('keyup', '#layer_matcsm3', function(){
	var layer_veil		= $(this).val();
	var layer1		= $("#layer_veil3").val();
	var layer2		= $("#layer_veil_add3").val();
	var layer4		= $("#layer_csm_add3").val();
	
	var waste			= parseFloat($('#waste').val());
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	
	var thickness_veil 	= $('#thickness_matcsm3').val();
	var tot_thickness	= layer_veil*thickness_veil;
	
	var thickness1		= parseFloat($('#totthick_veil3').val());
	var thickness2		= parseFloat($('#totthick_veil_add3').val());
	// var thickness3		= $('#totthick_matcsm').val();
	var thickness4		= parseFloat($('#totthick_csm_add3').val());
	var tot_thickness2	= thickness1 + thickness2 + tot_thickness + thickness4;
	
	$('#tot_lin_thickness3').val(tot_thickness2.toFixed(4));
	$('#totthick_matcsm3').val(RoundUp4(tot_thickness));
	
	Hasil3(tot_thickness2, layer1, layer2, layer_veil, layer4, top_diameter, top_thickness, waste);
	rubaharea();
});

$(document).on('change', '#mid_mtl_csm_add3', function(){
	var id_material	= $(this).val();
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getCsm2',
		cache: false,
		type: "POST",
		data: "id_material="+$(this).val()+"&resin4="+$('#layer_resin34').val(),
		dataType: "json",
		success: function(data){
			$('#weight_csm_add3').val(data.micron);
			$('#thickness_csm_add3').val(RoundUp4(data.thickness));
			$('#layer_csm_add3').val(data.layer);
			$('#layer_resin34hide').val(data.resin);
		}
	});
});

$(document).on('keyup', '#layer_csm_add3', function(){
	var layer_veil		= $(this).val();
	var layer1		= $("#layer_veil3").val();
	var layer2		= $("#layer_veil_add3").val();
	var layer3		= $("#layer_matcsm3").val();
	
	var waste			= parseFloat($('#waste').val());
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	
	var thickness_veil 	= $('#thickness_csm_add3').val();
	var tot_thickness	= layer_veil*thickness_veil;
	
	var thickness1		= parseFloat($('#totthick_veil3').val());
	var thickness2		= parseFloat($('#totthick_veil_add3').val());
	var thickness3		= parseFloat($('#totthick_matcsm3').val());
	var tot_thickness2	= thickness1 + thickness2 + thickness3 + tot_thickness;
	
	$('#tot_lin_thickness3').val(tot_thickness2.toFixed(4));
	$('#totthick_csm_add3').val(tot_thickness.toFixed(4));
	
	Hasil3(tot_thickness2, layer1, layer2, layer3, layer_veil, top_diameter, top_thickness, waste);
	rubaharea();
}); 

$(document).on('keyup', '.ChangeContainingExt', function(){
	var total_resin	= $('#last_resin_tot3').val();
	var perse		= $(this).parent().parent().find("td:nth-child(5) input").val();
	var containing	= $(this).val();
	
	var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
	
	$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
	$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);


});

$(document).on('keyup', '.ChangePerseExt', function(){
	var total_resin	= $('#last_resin_tot3').val();
	var containing		= $(this).parent().parent().find("td:nth-child(4) input").val();
	var perse	= $(this).val();
	
	var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
	
	$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
	$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);

}); 

$(document).on('keyup', '#persen_katalis3', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_resin_tot3').val();
	var layer_katalis	= $('#layer_katalis3').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
	$('#last_katalis3').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_sm3', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_resin_tot3').val();
	var layer_sm	= $('#layer_sm3').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_sm);
	$('#last_sm3').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_coblat3', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_resin_tot3').val();
	var layer_coblat	= $('#layer_coblat3').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_coblat);
	$('#last_cobalt3').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_dma3', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_resin_tot3').val();
	var layer_dma		= $('#layer_dma3').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_dma);
	$('#last_dma3').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_hydroquinone3', function(){
	var nilai				= $(this).val();
	var hasil_resin_tot 	= $('#hasil_resin_tot3').val();
	var layer_hydroquinone	= $('#layer_hydroquinone3').val();
	var Hasil				= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_hydroquinone);
	$('#last_hidro3').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_methanol3', function(){
	var nilai				= $(this).val();
	var hasil_resin_tot 	= $('#hasil_resin_tot3').val();
	var layer_methanol		= $('#layer_methanol3').val();
	var Hasil				= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_methanol);
	$('#last_methanol3').val(Hasil.toFixed(3));
});

$(document).on('keyup', '#acuhan_3', function(){
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