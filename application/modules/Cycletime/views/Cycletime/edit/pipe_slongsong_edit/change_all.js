
function LuasArea(diameter, estimasi, length, waste){
	var Luas_Area_Rumus		= ((3.14/1000)*(diameter + estimasi))*(length/1000)*(1+waste);
	if(isNaN(Luas_Area_Rumus)){
		var Luas_Area_Rumus = 0;
	}
	return Luas_Area_Rumus;
}

function Estimasi(thickLin, thickStr){
	var topEST	= thickLin + thickStr;
	if(isNaN(topEST)){
		var topEST = 0;
	}
	return topEST;
}

function ChangeHasil(){
	var ThLin		= parseFloat($('#ThLin').val());
	var ThStr		= parseFloat($('#ThStr').val());
	var minToleran	= parseFloat($('#min_toleran').val());
	var maxToleran	= parseFloat($('#max_toleran').val());
	var thickLin	= parseFloat($('#thickLin').val());
	var thickStr	= parseFloat($('#thickStr').val()); 

	HasilThickness(ThLin, ThStr, minToleran, maxToleran, thickLin, thickStr);
}

function HasilThickness(ThLin, ThStr, minToleran, maxToleran, thickLin, thickStr){
	var minLinThk	= ThLin - (ThLin * minToleran);
	var maxLinThk	= ThLin + (ThLin * maxToleran);
	var minStrThk	= ThStr - (ThStr * minToleran);
	var maxStrThk	= ThStr + (ThStr * maxToleran);
	if(isNaN(minLinThk)){ var minLinThk = 0;}
	if(isNaN(maxLinThk)){ var maxLinThk = 0;}
	if(isNaN(minStrThk)){ var minStrThk = 0;}
	if(isNaN(maxStrThk)){ var maxStrThk = 0;}
	
	if(thickLin < minLinThk){var Hasil1	= "TOO LOW";}
	if(thickLin > maxLinThk){var Hasil1	= "TOO HIGH";}
	if(thickLin > minLinThk && thickLin < maxLinThk){var Hasil1	= "OK";}
	$('#minLin').val(minLinThk.toFixed(4));
	$('#maxLin').val(maxLinThk.toFixed(4));
	// alert(Hasil1);
	$('#hasilLin').val(Hasil1);
	
	if(thickStr < minStrThk){var Hasil2	= "TOO LOW";}
	if(thickStr > maxStrThk){var Hasil2	= "TOO HIGH";}
	if(thickStr > minStrThk && thickStr < maxStrThk){var Hasil2	= "OK";}
	$('#minStr').val(minStrThk.toFixed(4));
	$('#maxStr').val(maxStrThk.toFixed(4));
	$('#hasilStr').val(Hasil2);
}

function ChangeLuasArea(){
	var diameter	= parseFloat($('#diameter').val());
	var length		= parseFloat($('#length').val());
	var waste		= parseFloat($('#waste').val());
	
	var thickLin	= parseFloat($('#thickLin').val());
	var thickStr	= parseFloat($('#thickStr').val());
	
	var estimasi 	= Estimasi(thickLin, thickStr);
	
	var LuasAreaX 	= LuasArea(diameter, estimasi, length, waste);
	var LastCoat	= LuasAreaX * 0.25 * 1.2;
	
	if(isNaN(LastCoat)){ var LastCoat = 0;}
	$('#last_topcoat_1').val(LastCoat.toFixed(3));

	$('#estimasi').val(estimasi.toFixed(4));
	$('#area').val(LuasAreaX.toFixed(6));
	
	
	ChangeAreaToLiner(LuasAreaX);
	ChangeAreaToStr(LuasAreaX);
}

function LastWeight(){
	var area	= parseFloat($('#area').val());
	return area;
}

function ChangePlus(Area){
	var Con1	= parseFloat($('#Lincontaining_1').val());
	var Con2	= parseFloat($('#Lincontaining_2').val());
	var Con3	= parseFloat($('#Lincontaining_3').val());
	var Con4	= parseFloat($('#Lincontaining_4').val());
	var Con5	= parseFloat($('#Lincontaining_5').val());
	var Con6	= parseFloat($('#Lincontaining_6').val());
	
	var Per1	= parseFloat($('#Linperse_1').val()) /100;
	var Per2	= parseFloat($('#Linperse_2').val()) /100;
	var Per3	= parseFloat($('#Linperse_3').val()) /100;
	var Per4	= parseFloat($('#Linperse_4').val()) /100;
	var Per5	= parseFloat($('#Linperse_5').val()) /100;
	var Per6	= parseFloat($('#Linperse_6').val()) /100;
	
	var Hasil1	= Area * Con1 * Per1;
	var Hasil2	= Area * Con2 * Per2;
	var Hasil3	= Area * Con3 * Per3;
	var Hasil4	= Area * Con4 * Per4;
	var Hasil5	= Area * Con5 * Per5;
	var Hasil6	= Area * Con6 * Per6;
	
	$('#Linlast_cost_1').val(Math.ceil(Hasil1 * 1000)/1000);
	$('#Linlast_cost_2').val(Math.ceil(Hasil2 * 1000)/1000);
	$('#Linlast_cost_3').val(Math.ceil(Hasil3 * 1000)/1000);
	$('#Linlast_cost_4').val(Math.ceil(Hasil4 * 1000)/1000);
	$('#Linlast_cost_5').val(Math.ceil(Hasil5 * 1000)/1000);
	$('#Linlast_cost_6').val(Math.ceil(Hasil6 * 1000)/1000);
}

function ChangePlusStr(Area){
	var Con1	= parseFloat($('#Lincontaining2_1').val());
	var Con2	= parseFloat($('#Lincontaining2_2').val());
	var Con3	= parseFloat($('#Lincontaining2_3').val());
	var Con4	= parseFloat($('#Lincontaining2_4').val());
	var Con5	= parseFloat($('#Lincontaining2_5').val());
	var Con6	= parseFloat($('#Lincontaining2_6').val());
	
	var Per1	= parseFloat($('#Linperse2_1').val()) /100;
	var Per2	= parseFloat($('#Linperse2_2').val()) /100;
	var Per3	= parseFloat($('#Linperse2_3').val()) /100;
	var Per4	= parseFloat($('#Linperse2_4').val()) /100;
	var Per5	= parseFloat($('#Linperse2_5').val()) /100;
	var Per6	= parseFloat($('#Linperse2_6').val()) /100;
	
	var Hasil1	= Area * Con1 * Per1;
	var Hasil2	= Area * Con2 * Per2;
	var Hasil3	= Area * Con3 * Per3;
	var Hasil4	= Area * Con4 * Per4;
	var Hasil5	= Area * Con5 * Per5;
	var Hasil6	= Area * Con6 * Per6;
	
	$('#Linlast_cost2_1').val(Math.ceil(Hasil1 * 1000)/1000);
	$('#Linlast_cost2_2').val(Math.ceil(Hasil2 * 1000)/1000);
	$('#Linlast_cost2_3').val(Math.ceil(Hasil3 * 1000)/1000);
	$('#Linlast_cost2_4').val(Math.ceil(Hasil4 * 1000)/1000);
	$('#Linlast_cost2_5').val(Math.ceil(Hasil5 * 1000)/1000);
	$('#Linlast_cost2_6').val(Math.ceil(Hasil6 * 1000)/1000);
}

function ChangeAreaToLiner(Area){
	var value_1 		= parseFloat($('#value_1').val());
	var value_2 		= parseFloat($('#value_2').val());
	var value_4 		= parseFloat($('#value_4').val());
	var value_6 		= parseFloat($('#value_6').val());
	var value_8 		= parseFloat($('#value_8').val());
	var layer_2 		= parseFloat($('#layer_2').val());
	var layer_4 		= parseFloat($('#layer_4').val());
	var layer_6 		= parseFloat($('#layer_6').val());
	var layer_8 		= parseFloat($('#layer_8').val());
	var containing_3	= parseFloat($('#containing_3').val());
	var containing_5	= parseFloat($('#containing_5').val());
	var containing_7	= parseFloat($('#containing_7').val());
	var containing_9	= parseFloat($('#containing_9').val());
	
	var id_material_1 	= $('#id_material_1').val();
	var diameter		= $('#diameter').val();
	if(diameter < 25){var Hit = 800;}else{var Hit = 1350;}
	
	var last_cost_1 	= Area * value_1 * 1.5 * Hit ;
	var last_cost_2 	= (Area * value_2 * layer_2)/1000 ;
	var last_cost_4 	= (Area * value_4 * layer_4)/1000 ;
	var last_cost_6 	= (Area * value_6 * layer_6)/1000 ;
	var last_cost_8 	= (Area * value_8 * layer_8)/1000 ; 
	var resin3			= last_cost_2 * containing_3;
	var resin5			= last_cost_4 * containing_5;
	var resin7			= last_cost_6 * containing_7;
	var resin9			= last_cost_8 * containing_9;
	
	var resiTot		= (Area * 1.2 * 0.5) + resin3 + resin5 + resin7 + resin9;
	ChangePlus(resiTot);
	
	$('#last_cost_10').val(resiTot.toFixed(3));
	$('#last_full_10').val(resiTot);
	
	$("#last_cost_1").val(last_cost_1.toFixed(3));
	$("#last_cost_2").val(last_cost_2.toFixed(3));
	$("#last_cost_4").val(last_cost_4.toFixed(3));
	$("#last_cost_6").val(last_cost_6.toFixed(3));
	$("#last_cost_8").val(last_cost_8.toFixed(3));
	$("#last_cost_3").val(resin3.toFixed(3));
	$("#last_cost_5").val(resin5.toFixed(3));
	$("#last_cost_7").val(resin7.toFixed(3));
	$("#last_cost_9").val(resin9.toFixed(3));
}

function ChangeAreaToStr(Area){
	var valueStr_1 		= parseFloat($('#valueStr_1').val());
	var valueStr_3 		= parseFloat($('#valueStr_3').val());
	var valueStr_5 		= parseFloat($('#valueStr_5').val());
	var valueStr_7 		= parseFloat($('#valueStr_7').val());
	var valueStr_9 		= parseFloat($('#valueStr_9').val());
	var valueStr_11 	= parseFloat($('#valueStr_11').val());
	
	var layerStr_1 		= parseFloat($('#layerStr_1').val());
	var layerStr_3 		= parseFloat($('#layerStr_3').val());
	var layerStr_5 		= parseFloat($('#layerStr_5').val());
	var layerStr_7 		= parseFloat($('#layerStr_7').val());
	var layerStr_9 		= parseFloat($('#layerStr_9').val());
	var layerStr_11 	= parseFloat($('#layerStr_11').val());
	
	var containingStr_2		= parseFloat($('#containingStr_2').val());
	var containingStr_4		= parseFloat($('#containingStr_4').val());
	var containingStr_6		= parseFloat($('#containingStr_6').val());
	var containingStr_8		= parseFloat($('#containingStr_8').val());
	var containingStr_10	= parseFloat($('#containingStr_10').val());
	var containingStr_12	= parseFloat($('#containingStr_12').val());
	
	var bwStr_9 		= parseFloat($('#bwStr_9').val());
	var jumlahStr_9 	= parseFloat($('#jumlahStr_9').val());
	var bwStr_11 		= parseFloat($('#bwStr_11').val());
	var jumlahStr_11 	= parseFloat($('#jumlahStr_11').val());
	
	var last_costStr_1 		= (Area * valueStr_1 * layerStr_1)/1000 ;
	var last_costStr_3 		= (Area * valueStr_3 * layerStr_3)/1000 ;
	var last_costStr_5 		= (Area * valueStr_5 * layerStr_5)/1000 ;
	var last_costStr_7 		= (Area * valueStr_7 * layerStr_7)/1000 ; 
	var last_costStr_9 		= ((valueStr_9 * 0.001 * jumlahStr_9 * 100)/(bwStr_9/10)) * (2/1000) * layerStr_9 * Area;
	var last_costStr_11 	= ((valueStr_11 * 0.001 * jumlahStr_11 * 100)/(bwStr_11/10)) * (2/1000) * layerStr_11 * Area;
	
	if(isNaN(last_costStr_9)){var last_costStr_9 = 0;}
	if(isNaN(last_costStr_11)){var last_costStr_11 = 0;}
	
	var resin2			= last_costStr_1 * containingStr_2;
	var resin4			= last_costStr_3 * containingStr_4;
	var resin6			= last_costStr_5 * containingStr_6;
	var resin8			= last_costStr_7 * containingStr_8;
	var resin10			= last_costStr_9 * containingStr_10;
	var resin12			= last_costStr_11 * containingStr_12;
	
	var resiTot			= resin2 + resin4 + resin6 + resin8 + resin10 + resin12;
	ChangePlusStr(resiTot);
	
	$('#last_costStr_13').val(resiTot.toFixed(3));
	$('#last_fullStr_13').val(resiTot);

	$("#last_costStr_1").val(last_costStr_1.toFixed(3));
	$("#last_costStr_3").val(last_costStr_3.toFixed(3));
	$("#last_costStr_5").val(last_costStr_5.toFixed(3));
	$("#last_costStr_7").val(last_costStr_7.toFixed(3));
	$("#last_costStr_9").val(last_costStr_9.toFixed(3));
	$("#last_costStr_11").val(last_costStr_11.toFixed(3));
	
	$("#last_costStr_2").val(resin2.toFixed(3));
	$("#last_costStr_4").val(resin4.toFixed(3));
	$("#last_costStr_6").val(resin6.toFixed(3));
	$("#last_costStr_8").val(resin8.toFixed(3));
	$("#last_costStr_10").val(resin10.toFixed(3));
	$("#last_costStr_12").val(resin12.toFixed(3));
}

function ChangePlusAdd(Area){
	var AddLinNum	= parseFloat($('#AddLinNum').val());
	var a;
	for(a=1; a <= AddLinNum; a++){
		var Con		= parseFloat($('#Addcontaining_'+a).val());
		var Per		= parseFloat($('#Addperse_'+a).val()) /100;
		var Hasil	= Area * Con * Per;
		$('#Addlast_cost_'+a).val(Math.ceil(Hasil * 1000)/1000);
	}
}

function ChangePlusStrAdd(Area){
	var AddStrNum	= parseFloat($('#AddStrNum').val());
	var a;
	for(a=1; a <= AddStrNum; a++){
		var Con		= parseFloat($('#Addcontaining2_'+a).val());
		var Per		= parseFloat($('#Addperse2_'+a).val()) /100;
		var Hasil	= Area * Con * Per;
		$('#Addlast_cost2_'+a).val(Math.ceil(Hasil * 1000)/1000);
	}
}
