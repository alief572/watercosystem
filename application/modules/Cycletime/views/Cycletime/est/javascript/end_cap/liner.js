
$(document).on('change', '#mid_mtl_plastic', function(){
	var id_material	= $(this).val();
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getMicronPlastic',
		cache: false,
		type: "POST",
		data: "id_material="+$(this).val()+"&top_diameter="+$("#top_diameter").val(),
		dataType: "json",
		success: function(data){
			$('#micron_plastic').val(data.micron);
		}
	});
});

$(document).on('change', '#mid_mtl_veil', function(){
	var id_material	= $(this).val();
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getVeil',
		cache: false,
		type: "POST",
		data: "id_material="+$(this).val()+"&resin1="+$('#layer_resin1').val(),
		dataType: "json",
		success: function(data){
			$('#weight_veil').val(data.micron);
			$('#thickness_veil').val(RoundUp4(data.thickness));
			$('#layer_veil').val(data.layer);
			$('#layer_resin1hide').val(data.resin);
		}
	});
});

$(document).on('keyup', '#layer_veil', function(){
	var layer_veil		= $(this).val();
	var layer_veil2		= $("#layer_veil_add").val();
	var layer_veil3		= $("#layer_matcsm").val();
	var layer_veil4		= $("#layer_csm_add").val();
	
	var waste			= parseFloat($('#waste').val());
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	
	var thickness_veil 	= $('#thickness_veil').val();
	var tot_thickness	= layer_veil*thickness_veil;
	
	var thickness2		= parseFloat($('#totthick_veil_add').val());
	var thickness3		= parseFloat($('#totthick_matcsm').val());
	var thickness4		= parseFloat($('#totthick_csm_add').val());
	var tot_thickness2	= tot_thickness + thickness2 + thickness3 + thickness4;
	
	$('#tot_lin_thickness').val(tot_thickness2.toFixed(4));
	$('#totthick_veil').val(tot_thickness.toFixed(4));
	
	Hasil(tot_thickness2, layer_veil, layer_veil2, layer_veil3, layer_veil4, top_diameter, top_thickness, waste);
	rubaharea();
});

$(document).on('change', '#mid_mtl_veil_add', function(){
	var id_material	= $(this).val();
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getVeil2',
		cache: false,
		type: "POST",
		data: "id_material="+$(this).val()+"&resin2="+$('#layer_resin2').val(),
		dataType: "json",
		success: function(data){ 
			$('#weight_veil_add').val(data.micron);
			$('#thickness_veil_add').val(RoundUp4(data.thickness));
			$('#layer_veil_add').val(data.layer);
			$('#layer_resin2hide').val(data.resin);
		}
	});
});

$(document).on('keyup', '#layer_veil_add', function(){
	var layer_veil		= $(this).val();
	var layer_veil1		= $("#layer_veil").val();
	var layer_veil3		= $("#layer_matcsm").val();
	var layer_veil4		= $("#layer_csm_add").val();
	var waste			= parseFloat($('#waste').val());
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	
	var thickness_veil 	= $('#thickness_veil_add').val();
	var tot_thickness	= layer_veil*thickness_veil;
	
	var thickness1		= parseFloat($('#totthick_veil').val());
	var thickness3		= parseFloat($('#totthick_matcsm').val());
	var thickness4		= parseFloat($('#totthick_csm_add').val());
	var tot_thickness2	= thickness1 + tot_thickness + thickness3 + thickness4;
	
	$('#tot_lin_thickness').val(tot_thickness2.toFixed(4));
	$('#totthick_veil_add').val(tot_thickness.toFixed(4));
	
	Hasil(tot_thickness2, layer_veil1, layer_veil, layer_veil3, layer_veil4, top_diameter, top_thickness, waste);
	rubaharea();
});

$(document).on('change', '#mid_mtl_resin_tot', function(){ 
	if($("#mid_mtl_veil").val() != 'MTL-1903000'){
		$("#layer_resin1hide").val($(this).val());
	}
	if($("#mid_mtl_veil_add").val() != 'MTL-1903000'){
		$("#layer_resin2hide").val($(this).val());
	}
	if($("#mid_mtl_matcsm").val() != 'MTL-1903000'){
		$("#layer_resin3hide").val($(this).val());
	}
	if($("#mid_mtl_csm_add").val() != 'MTL-1903000'){
		$("#layer_resin4hide").val($(this).val());
	}
});

$(document).on('change', '#mid_mtl_matcsm', function(){
	var id_material	= $(this).val();
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getCsm',
		cache: false,
		type: "POST",
		data: "id_material="+$(this).val()+"&resin3="+$('#layer_resin3').val(),
		dataType: "json",
		success: function(data){
			$('#weight_matcsm').val(data.micron);
			$('#thickness_matcsm').val(RoundUp4(data.thickness));
			$('#layer_matcsm').val(data.layer);
			$('#layer_resin3hide').val(data.resin);
		}
	});
});

$(document).on('keyup', '#layer_matcsm', function(){
	var layer_veil		= $(this).val();
	var layer_veil1		= $("#layer_veil").val();
	var layer_veil2		= $("#layer_veil_add").val();
	var layer_veil4		= $("#layer_csm_add").val();
	var waste			= parseFloat($('#waste').val());
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	
	var thickness_veil 	= $('#thickness_matcsm').val();
	var tot_thickness	= layer_veil*thickness_veil;
	
	var thickness1		= parseFloat($('#totthick_veil').val());
	var thickness2		= parseFloat($('#totthick_veil_add').val());
	// var thickness3		= $('#totthick_matcsm').val();
	var thickness4		= parseFloat($('#totthick_csm_add').val());
	var tot_thickness2	= thickness1 + thickness2 + tot_thickness + thickness4;
	
	$('#tot_lin_thickness').val(tot_thickness2.toFixed(4));
	$('#totthick_matcsm').val(tot_thickness.toFixed(4));
	
	Hasil(tot_thickness2, layer_veil1, layer_veil2, layer_veil, layer_veil4, top_diameter, top_thickness, waste);
	rubaharea();
});

$(document).on('change', '#mid_mtl_csm_add', function(){
	var id_material	= $(this).val();
	$.ajax({
		url: base_url +'index.php/'+active_controller+'/getCsm2',
		cache: false,
		type: "POST",
		data: "id_material="+$(this).val()+"&resin4="+$('#layer_resin4').val(),
		dataType: "json",
		success: function(data){
			$('#weight_csm_add').val(data.micron);
			$('#thickness_csm_add').val(RoundUp4(data.thickness));
			$('#layer_csm_add').val(data.layer);
			$('#layer_resin4hide').val(data.resin);
		}
	});
});

$(document).on('keyup', '#layer_csm_add', function(){
	var layer_veil		= $(this).val();
	var layer_veil1		= $("#layer_veil").val();
	var layer_veil2		= $("#layer_veil_add").val();
	var layer_veil3		= $("#layer_matcsm").val();
	var waste			= parseFloat($('#waste').val());
	var top_diameter	= parseFloat($('#top_diameter').val());
	var top_thickness	= parseFloat($('#top_tebal_design').val());
	
	var thickness_veil 	= $('#thickness_csm_add').val();
	var tot_thickness	= layer_veil*thickness_veil;
	
	var thickness1		= parseFloat($('#totthick_veil').val());
	var thickness2		= parseFloat($('#totthick_veil_add').val());
	var thickness3		= parseFloat($('#totthick_matcsm').val());
	var tot_thickness2	= thickness1 + thickness2 + thickness3 + tot_thickness;
	
	$('#tot_lin_thickness').val(tot_thickness2.toFixed(4));
	$('#totthick_csm_add').val(tot_thickness.toFixed(4));
	
	Hasil(tot_thickness2, layer_veil1, layer_veil2, layer_veil3, layer_veil, top_diameter, top_thickness, waste);
	rubaharea();
});

$(document).on('keyup', '.ChangeContaining', function(){
	var total_resin	= $('#last_resin_tot').val();
	var perse		= $(this).parent().parent().find("td:nth-child(5) input").val();
	var containing	= $(this).val();
	
	var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
	
	$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
	$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);


});

$(document).on('keyup', '.ChangePerse', function(){
	var total_resin	= $('#last_resin_tot').val();
	var containing		= $(this).parent().parent().find("td:nth-child(4) input").val();
	var perse	= $(this).val();
	
	var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
	
	$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
	$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);

});

$(document).on('keyup', '#persen_katalis', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_resin_tot').val();
	var layer_katalis	= $('#layer_katalis').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
	$('#last_katalis').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_sm', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_resin_tot').val();
	var layer_sm	= $('#layer_sm').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_sm);
	$('#last_sm').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_coblat', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_resin_tot').val();
	var layer_coblat	= $('#layer_coblat').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_coblat);
	$('#last_cobalt').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_dma', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_resin_tot').val();
	var layer_dma		= $('#layer_dma').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_dma);
	$('#last_dma').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_hydroquinone', function(){
	var nilai				= $(this).val();
	var hasil_resin_tot 	= $('#hasil_resin_tot').val();
	var layer_hydroquinone	= $('#layer_hydroquinone').val();
	var Hasil				= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_hydroquinone);
	$('#last_hidro').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_methanol', function(){
	var nilai				= $(this).val();
	var hasil_resin_tot 	= $('#hasil_resin_tot').val();
	var layer_methanol		= $('#layer_methanol').val();
	var Hasil				= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_methanol);
	$('#last_methanol').val(Hasil.toFixed(3));
});