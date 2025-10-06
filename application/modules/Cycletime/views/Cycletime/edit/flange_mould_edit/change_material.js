document.writeln("<script src='change_all.js'></script>");

//LINER
$(document).on('change', '.id_material', function(){
	var nomor 		= $(this).data('nomor');
	if(nomor != '10'){
		var id_material	= $(this).val();
		var diameter	= $("#diameter").val();
		var helpX		= $(this).parent().parent().find("td:nth-child(3) input");
		var layer		= $(this).parent().parent().find("td:nth-child(4) input");
		var thickness	= $(this).parent().parent().find("td:nth-child(5) input");
		var thick		= $(this).parent().parent().find("td:nth-child(6) input");
		var lastCost	= $(this).parent().parent().find("td:nth-child(7) input");
		var material2	= $(this).parent().parent().find("td:nth-child(2) #id_material2_"+nomor);
		var id_ori		= $(this).parent().parent().find("td:nth-child(1) #id_ori_"+nomor).val();
		var thick_hide	= $(this).parent().parent().find("td:nth-child(2) #thickness_"+nomor);
		var NoResin		= $(this).data('nomor') + 1;
		var resin		= $('#containing_'+NoResin).val();
		var materialRs	= $('#id_material2_'+NoResin);
		
		var lastRes		= $('#last_cost_'+NoResin);
		
		var resinOri	= $('#id_material2_10').val();
		
		var resinX1	= $('#id_material2_3').val();
		var resinX2	= $('#id_material2_5').val();
		var resinX3	= $('#id_material2_7').val();
		var resinX4	= $('#id_material2_9').val();
		// alert(id_ori);
		// return false;
		$.ajax({
			url: base_url +'index.php/'+active_controller+'/getMaterialx',
			cache: false,
			type: "POST",
			data: "id_material="+id_material+"&diameter="+diameter+"&resin="+resin+"&id_ori="+id_ori+"&resinOri="+resinOri,
			dataType: "json",
			success: function(data){
				helpX.val(data.weight);
				layer.val(data.layer);
				thick_hide.val(data.thickness);
				material2.val(data.resinUt);
				materialRs.val(data.resin);
				if(data.resinAk == 'Y'){
					if(resinX1 != 'MTL-1903000'){$('#id_material2_3').val(data.resinUt);}
					if(resinX2 != 'MTL-1903000'){$('#id_material2_5').val(data.resinUt);}
					if(resinX3 != 'MTL-1903000'){$('#id_material2_7').val(data.resinUt);}
					if(resinX4 != 'MTL-1903000'){$('#id_material2_9').val(data.resinUt);}
				}
				
				if(data.layer == 0){
					thick.val("0.0000");
					lastCost.val("0.000"); 
					lastRes.val("0.000"); 
				}
			}
		});
	}
});

$(document).on('keyup', '.layer', function(){
	var nomor 			= $(this).data('nomor');
	var nomorPlus		= parseFloat(nomor) + 1;
	var layer			= parseFloat($(this).val());
	var thick_hide		= parseFloat($(this).parent().parent().find("td:nth-child(2) #thickness_"+nomor).val());
	var tot_thickness	= $(this).parent().parent().find("td:nth-child(6) input");
	var HslTotThick		= layer * thick_hide;
	var containing		= parseFloat($('#containing_'+nomorPlus).val());
	
	if(isNaN(HslTotThick)){ var HslTotThick = 0;}
	tot_thickness.val(HslTotThick.toFixed(4)); 
	
	var totthicknessLin1	= parseFloat($('#total_thickness_2').val());
	var totthicknessLin2	= parseFloat($('#total_thickness_4').val());
	var totthicknessLin3	= parseFloat($('#total_thickness_6').val());
	var totthicknessLin4	= parseFloat($('#total_thickness_8').val());
	var AllThick			= totthicknessLin1 + totthicknessLin2 + totthicknessLin3 + totthicknessLin4;
	$('#thickLin').val(AllThick.toFixed(4));
	
	ChangeLuasArea();
	ChangeHasil();
	
});

$(document).on('keyup', '.perse', function(){
	var TotResin	= parseFloat($('#last_cost_10').val());
	
	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= TotResin * perse * containing;
	
	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});

$(document).on('keyup', '.perseLinAdd', function(){
	var TotResin	= parseFloat($('#last_cost_10').val());
	
	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= TotResin * perse * containing;
	
	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});

//STRUCTURE
$(document).on('change', '.id_materialSTr', function(){
	var nomor 		= $(this).data('nomor');
	if(nomor != '13'){
		var id_material	= $(this).val();
		var diameter	= $("#diameter").val();
		var helpX		= $(this).parent().parent().find("td:nth-child(3) input");
		var layer		= $(this).parent().parent().find("td:nth-child(4) input");
		var thickness	= $(this).parent().parent().find("td:nth-child(5) input");
		var thick		= $(this).parent().parent().find("td:nth-child(6) input");
		var lastCost	= $(this).parent().parent().find("td:nth-child(7) input");
		var material2	= $(this).parent().parent().find("td:nth-child(2) #id_materialStr2_"+nomor);
		var id_ori		= $(this).parent().parent().find("td:nth-child(1) #id_oriStr_"+nomor).val();
		var thick_hide	= $(this).parent().parent().find("td:nth-child(2) #thicknessStr_"+nomor);
		var NoResin		= $(this).data('nomor') + 1;
		var resin		= $('#containingStr_'+NoResin).val();
		var materialRs	= $('#id_materialStr2_'+NoResin);
		
		var lastRes	= $('#last_costStr_'+NoResin);
		
		var resinOri	= $('#id_materialStr2_9').val();
		
		var resinX1	= $('#id_materialStr2_2').val();
		var resinX2	= $('#id_materialStr2_4').val();
		var resinX3	= $('#id_materialStr2_6').val();
		var resinX4	= $('#id_materialStr2_8').val();
		// alert(id_ori);
		// return false;
		$.ajax({
			url: base_url +'index.php/'+active_controller+'/getMaterialx',
			cache: false,
			type: "POST",
			data: "id_material="+id_material+"&diameter="+diameter+"&resin="+resin+"&id_ori="+id_ori+"&resinOri="+resinOri,
			dataType: "json",
			success: function(data){
				helpX.val(data.weight);
				layer.val(data.layer);
				thick_hide.val(data.thickness);
				material2.val(data.resinUt);
				materialRs.val(data.resin);
				if(data.resinAk == 'Y'){
					if(resinX1 != 'MTL-1903000'){$('#id_materialStr2_2').val(data.resinUt);}
					if(resinX2 != 'MTL-1903000'){$('#id_materialStr2_4').val(data.resinUt);}
					if(resinX3 != 'MTL-1903000'){$('#id_materialStr2_6').val(data.resinUt);}
					if(resinX4 != 'MTL-1903000'){$('#id_materialStr2_8').val(data.resinUt);}
				}
				
				if(data.layer == 0){
					thick.val("0.0000");
					lastCost.val("0.000"); 
					lastRes.val("0.000"); 
				}
			}
		});
	}
});

$(document).on('keyup', '.layerStr', function(){
	var nomor 			= $(this).data('nomor');
	var nomorPlus		= parseFloat(nomor) + 1;
	var layer			= parseFloat($(this).val());
	var thick_hide		= parseFloat($(this).parent().parent().find("td:nth-child(2) #thicknessStr_"+nomor).val());
	var tot_thickness	= $(this).parent().parent().find("td:nth-child(6) input");
	var HslTotThick		= layer * thick_hide;

	// alert(thick_hide);
	var containing		= parseFloat($('#containingStr_'+nomorPlus).val());
	
	if(isNaN(HslTotThick)){ var HslTotThick = 0;}
	tot_thickness.val(HslTotThick.toFixed(4));
	
	var totthicknessLin1	= parseFloat($('#total_thickness_1').val());
	var totthicknessLin2	= parseFloat($('#total_thickness_3').val());
	var totthicknessLin3	= parseFloat($('#total_thickness_5').val());
	var totthicknessLin4	= parseFloat($('#total_thickness_7').val());
	
	var AllThick			= totthicknessLin1 + totthicknessLin2 + totthicknessLin3 + totthicknessLin4;
	$('#thickStr').val(AllThick.toFixed(4));
	
	ChangeLuasArea();
	ChangeHasil();
});

$(document).on('keyup', '.perseStr', function(){
	var TotResin	= parseFloat($('#last_costStr_9').val());
	
	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= TotResin * perse * containing;
	
	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});

$(document).on('keyup', '.perseStrAdd', function(){
	var TotResin	= parseFloat($('#last_costStr_9').val());
	
	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= TotResin * perse * containing;
	
	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});

//STRUCTURE NECK 1
$(document).on('change', '.id_materialSTrN1', function(){
	var nomor 		= $(this).data('nomor');
	if(nomor != '13'){
		var id_material	= $(this).val();
		var diameter	= $("#diameter").val();
		var helpX		= $(this).parent().parent().find("td:nth-child(3) input");
		var layer		= $(this).parent().parent().find("td:nth-child(4) input");
		var thickness	= $(this).parent().parent().find("td:nth-child(5) input");
		var thick		= $(this).parent().parent().find("td:nth-child(6) input");
		var lastCost	= $(this).parent().parent().find("td:nth-child(7) input");
		var material2	= $(this).parent().parent().find("td:nth-child(2) #id_materialStr2N1_"+nomor);
		var id_ori		= $(this).parent().parent().find("td:nth-child(1) #id_oriStrN1_"+nomor).val();
		var thick_hide	= $(this).parent().parent().find("td:nth-child(2) #thicknessStrN1_"+nomor);
		var BW			= $(this).parent().parent().find("td:nth-child(1) #bwStrN1_"+nomor);
		var Jumlah		= $(this).parent().parent().find("td:nth-child(1) #jumlahStrN1_"+nomor);
		var NoResin		= $(this).data('nomor') + 1;
		var resin		= $('#containingStrN1_'+NoResin).val();
		var materialRs	= $('#id_materialStr2N1_'+NoResin);
		
		var lastRes	= $('#last_costStrN1_'+NoResin);
		
		var resinOri	= $('#id_materialStr2N1_9').val();
		
		var resinX1	= $('#id_materialStr2N1_2').val();
		var resinX2	= $('#id_materialStr2N1_4').val();
		var resinX3	= $('#id_materialStr2N1_6').val();
		var resinX4	= $('#id_materialStr2N1_8').val();
		var resinX5	= $('#id_materialStr2N1_10').val();
		var resinX6	= $('#id_materialStr2N1_12').val();
		// alert(id_ori);
		// return false;
		$.ajax({
			url: base_url +'index.php/'+active_controller+'/getMaterialx',
			cache: false,
			type: "POST",
			data: "id_material="+id_material+"&diameter="+diameter+"&resin="+resin+"&id_ori="+id_ori+"&resinOri="+resinOri,
			dataType: "json",
			success: function(data){
				helpX.val(data.weight);
				layer.val(data.layer);
				thick_hide.val(data.thickness);
				material2.val(data.resinUt);
				materialRs.val(data.resin);
				BW.val(data.bw);
				Jumlah.val(data.jumRoov);
				if(data.resinAk == 'Y'){
					if(resinX1 != 'MTL-1903000'){$('#id_materialStr2N1_2').val(data.resinUt);}
					if(resinX2 != 'MTL-1903000'){$('#id_materialStr2N1_4').val(data.resinUt);}
					if(resinX3 != 'MTL-1903000'){$('#id_materialStr2N1_6').val(data.resinUt);}
					if(resinX4 != 'MTL-1903000'){$('#id_materialStr2N1_8').val(data.resinUt);}
					if(resinX5 != 'MTL-1903000'){$('#id_materialStr2N1_10').val(data.resinUt);}
					if(resinX6 != 'MTL-1903000'){$('#id_materialStr2N1_12').val(data.resinUt);}
				}
				
				if(data.layer == 0){
					thick.val("0.0000");
					lastCost.val("0.000"); 
					lastRes.val("0.000"); 
				}
			}
		});
	}
});

$(document).on('keyup', '.layerStrN1', function(){
	var nomor 			= $(this).data('nomor');
	var nomorPlus		= parseFloat(nomor) + 1;
	var layer			= parseFloat($(this).val());
	var thick_hide		= parseFloat($(this).parent().parent().find("td:nth-child(2) #thicknessStrN1_"+nomor).val());
	var tot_thickness	= $(this).parent().parent().find("td:nth-child(6) input");
	var HslTotThick		= layer * thick_hide;
	
	if(isNaN(HslTotThick)){ var HslTotThick = 0;}
	tot_thickness.val(HslTotThick.toFixed(4));
	
	var totthicknessLin1	= parseFloat($('#total_thicknessN1_1').val());
	var totthicknessLin2	= parseFloat($('#total_thicknessN1_3').val());
	var totthicknessLin3	= parseFloat($('#total_thicknessN1_5').val());
	var totthicknessLin4	= parseFloat($('#total_thicknessN1_7').val());
	var totthicknessLin5	= parseFloat($('#total_thicknessN1_9').val());
	var totthicknessLin6	= parseFloat($('#total_thicknessN1_11').val());
	
	var AllThick			= totthicknessLin1 + totthicknessLin2 + totthicknessLin3 + totthicknessLin4 + totthicknessLin5 + totthicknessLin6;
	$('#thickStrN1').val(AllThick.toFixed(4));
	
	ChangeLuasArea();
	ChangeHasil();
});

$(document).on('keyup', '.perseStrN1', function(){
	var TotResin	= parseFloat($('#last_costStrN1_13').val());
	
	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= TotResin * perse * containing;
	
	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});

$(document).on('keyup', '.perseStrAddN1', function(){
	var TotResin	= parseFloat($('#last_costStrN1_13').val());
	
	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= TotResin * perse * containing;
	
	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});

//STRUCTURE NECK 2
$(document).on('change', '.id_materialSTrN2', function(){ 
	var nomor 		= $(this).data('nomor');
	if(nomor != '13'){
		var id_material	= $(this).val();
		var diameter	= $("#diameter").val();
		var helpX		= $(this).parent().parent().find("td:nth-child(3) input");
		var layer		= $(this).parent().parent().find("td:nth-child(4) input");
		var thickness	= $(this).parent().parent().find("td:nth-child(5) input");
		var thick		= $(this).parent().parent().find("td:nth-child(6) input");
		var lastCost	= $(this).parent().parent().find("td:nth-child(7) input");
		var material2	= $(this).parent().parent().find("td:nth-child(2) #id_materialStr2N2_"+nomor);
		var id_ori		= $(this).parent().parent().find("td:nth-child(1) #id_oriStrN2_"+nomor).val();
		var thick_hide	= $(this).parent().parent().find("td:nth-child(2) #thicknessStrN2_"+nomor);
		var NoResin		= $(this).data('nomor') + 1;
		var resin		= $('#containingStrN2_'+NoResin).val();
		var materialRs	= $('#id_materialStr2N2_'+NoResin);
		
		var lastRes		= $('#last_costStrN2_'+NoResin);
		
		var resinOri	= $('#id_materialStr2N2_9').val();
		
		var resinX1	= $('#id_materialStr2N2_2').val();
		var resinX2	= $('#id_materialStr2N2_4').val();
		var resinX3	= $('#id_materialStr2N2_6').val();
		var resinX4	= $('#id_materialStr2N2_8').val();
		// alert(id_ori);
		// return false;
		$.ajax({
			url: base_url +'index.php/'+active_controller+'/getMaterialx',
			cache: false,
			type: "POST",
			data: "id_material="+id_material+"&diameter="+diameter+"&resin="+resin+"&id_ori="+id_ori+"&resinOri="+resinOri,
			dataType: "json",
			success: function(data){
				helpX.val(data.weight);
				layer.val(data.layer);
				thick_hide.val(data.thickness);
				material2.val(data.resinUt);
				materialRs.val(data.resin);
				if(data.resinAk == 'Y'){
					if(resinX1 != 'MTL-1903000'){$('#id_materialStr2N2_2').val(data.resinUt);}
					if(resinX2 != 'MTL-1903000'){$('#id_materialStr2N2_4').val(data.resinUt);}
					if(resinX3 != 'MTL-1903000'){$('#id_materialStr2N2_6').val(data.resinUt);}
					if(resinX4 != 'MTL-1903000'){$('#id_materialStr2N2_8').val(data.resinUt);}
				}
				
				if(data.layer == 0){
					thick.val("0.0000");
					lastCost.val("0.000"); 
					lastRes.val("0.000"); 
				}
			}
		});
	}
});

$(document).on('keyup', '.layerStrN2', function(){
	var nomor 			= $(this).data('nomor');
	var nomorPlus		= parseFloat(nomor) + 1;
	var layer			= parseFloat($(this).val());
	var thick_hide		= parseFloat($(this).parent().parent().find("td:nth-child(2) #thicknessStrN2_"+nomor).val());
	var tot_thickness	= $(this).parent().parent().find("td:nth-child(6) input");
	var HslTotThick		= layer * thick_hide;
	
	if(isNaN(HslTotThick)){ var HslTotThick = 0;}
	tot_thickness.val(HslTotThick.toFixed(4));
	
	var totthicknessLin1	= parseFloat($('#total_thicknessN2_1').val());
	var totthicknessLin2	= parseFloat($('#total_thicknessN2_3').val());
	var totthicknessLin3	= parseFloat($('#total_thicknessN2_5').val());
	var totthicknessLin4	= parseFloat($('#total_thicknessN2_7').val());
	
	var AllThick			= totthicknessLin1 + totthicknessLin2 + totthicknessLin3 + totthicknessLin4;
	$('#thickStrN2').val(AllThick.toFixed(4));
	ChangeLuasArea();
	ChangeHasil();

});

$(document).on('keyup', '.perseStrN2', function(){
	var TotResin	= parseFloat($('#last_costStrN2_9').val());
	
	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= TotResin * perse * containing;
	
	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});

$(document).on('keyup', '.perseStrAddN2', function(){
	var TotResin	= parseFloat($('#last_costStrN2_9').val());
	
	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= TotResin * perse * containing;
	
	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});

//EXTERNAL
$(document).on('change', '.id_materialEks', function(){
	var nomor 		= $(this).data('nomor');
	if(nomor != '9'){
		var id_material	= $(this).val();
		var diameter	= $("#diameter").val();
		var helpX		= $(this).parent().parent().find("td:nth-child(3) input");
		var layer		= $(this).parent().parent().find("td:nth-child(4) input");
		var thickness	= $(this).parent().parent().find("td:nth-child(5) input");
		var thick		= $(this).parent().parent().find("td:nth-child(6) input");
		var lastCost	= $(this).parent().parent().find("td:nth-child(7) input");
		var material2	= $(this).parent().parent().find("td:nth-child(2) #id_material2Eks_"+nomor);
		var id_ori		= $(this).parent().parent().find("td:nth-child(1) #id_oriEks_"+nomor).val();
		var thick_hide	= $(this).parent().parent().find("td:nth-child(2) #thicknessEks_"+nomor);
		var NoResin		= $(this).data('nomor') + 1;
		var resin		= $('#containingEks_'+NoResin).val();
		var materialRs	= $('#id_material2Eks_'+NoResin);
		
		var lastRes	= $('#last_costEks_'+NoResin);
		
		var resinOri	= $('#id_material2Eks_9').val();
		
		var resinX1	= $('#id_material2Eks_2').val();
		var resinX2	= $('#id_material2Eks_4').val();
		var resinX3	= $('#id_material2Eks_6').val();
		var resinX4	= $('#id_material2Eks_8').val();

		$.ajax({
			url: base_url +'index.php/'+active_controller+'/getMaterialx',
			cache: false,
			type: "POST",
			data: "id_material="+id_material+"&diameter="+diameter+"&resin="+resin+"&id_ori="+id_ori+"&resinOri="+resinOri,
			dataType: "json",
			success: function(data){
				helpX.val(data.weight);
				layer.val(data.layer);
				thick_hide.val(data.thickness);
				material2.val(data.resinUt);
				materialRs.val(data.resin);
				if(data.resinAk == 'Y'){
					if(resinX1 != 'MTL-1903000'){$('#id_material2Eks_2').val(data.resinUt);}
					if(resinX2 != 'MTL-1903000'){$('#id_material2Eks_4').val(data.resinUt);}
					if(resinX3 != 'MTL-1903000'){$('#id_material2Eks_6').val(data.resinUt);}
					if(resinX4 != 'MTL-1903000'){$('#id_material2Eks_8').val(data.resinUt);}
				}
				
				if(data.layer == 0){
					thick.val("0.0000");
					lastCost.val("0.000"); 
					lastRes.val("0.000"); 
				}
			}
		});
	}
});

$(document).on('keyup', '.layerEks', function(){
	var nomor 			= $(this).data('nomor');
	var nomorPlus		= parseFloat(nomor) + 1;
	var layer			= parseFloat($(this).val());
	var thick_hide		= parseFloat($(this).parent().parent().find("td:nth-child(2) #thicknessEks_"+nomor).val());
	var tot_thickness	= $(this).parent().parent().find("td:nth-child(6) input");
	var lastWeight		= $(this).parent().parent().find("td:nth-child(7) input");
	var HslTotThick		= layer * thick_hide;
	
	var containing		= parseFloat($('#containingEks_'+nomorPlus).val());
	
	if(isNaN(HslTotThick)){ var HslTotThick = 0;}
	tot_thickness.val(HslTotThick.toFixed(4));
	
	var totthicknessLin1	= parseFloat($('#total_thicknessEks_1').val());
	var totthicknessLin2	= parseFloat($('#total_thicknessEks_3').val());
	var totthicknessLin3	= parseFloat($('#total_thicknessEks_5').val());
	var totthicknessLin4	= parseFloat($('#total_thicknessEks_7').val());
	var AllThick			= totthicknessLin1 + totthicknessLin2 + totthicknessLin3 + totthicknessLin4;
	$('#thickEks').val(AllThick.toFixed(4));
	ChangeLuasArea();
	ChangeHasil();
	
});

$(document).on('keyup', '.perseEks', function(){
	var TotResin	= parseFloat($('#last_costEks_9').val());
	
	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= TotResin * perse * containing;
	
	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});


$(document).on('keyup', '.conEks', function(){
	var TotResin	= parseFloat($('#last_costEks_9').val());
	
	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= TotResin * perse * containing;
	
	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});

$(document).on('keyup', '.perseEksAdd', function(){
	var TotResin	= parseFloat($('#last_costEks_9').val());
	
	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= TotResin * perse * containing;
	
	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});

//TOPCOAT
$(document).on('keyup', '.perseTc', function(){
	var LastCoat	= parseFloat($('#last_topcoat_1').val()); 

	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= LastCoat * perse * containing;

	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});

$(document).on('keyup', '.perseTcAdd', function(){
	var LastCoat	= parseFloat($('#last_topcoat_1').val());

	var perse		= parseFloat($(this).val() / 100);
	var containing	= parseFloat($(this).parent().parent().find("td:nth-child(3) input").val());
	var lastWeight	= $(this).parent().parent().find("td:nth-child(5) input");
	
	var Hasil		= LastCoat * perse * containing;

	if(isNaN(Hasil)){ var Hasil = 0;}
	lastWeight.val(Hasil.toFixed(3));
});