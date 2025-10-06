
function LuasArea(diameter, estimasi, waste, angle, radius){
	var Luas_Area_Rumus		= (angle / 360) *((2 * 3.14 *(radius)) *(3.14 * (diameter + estimasi) + 50) / 1000000 * (1 + (waste/100)));
	if(isNaN(Luas_Area_Rumus)){
		var Luas_Area_Rumus = 0;
	}
	return Luas_Area_Rumus;
}

function Estimasi(thickLin, thickStr, thickEks){ 
	var topEST	= thickLin + thickStr + thickEks;
	if(isNaN(topEST)){
		var topEST = 0;
	}
	return topEST;
}

function ChangeHasil(){
	var ThLin		= parseFloat($('#ThLin').val());
	var ThStr		= parseFloat($('#ThStr').val());
	var ThEks		= parseFloat($('#ThEks').val());
	var minToleran	= parseFloat($('#min_toleran').val());
	var maxToleran	= parseFloat($('#max_toleran').val());
	var thickLin	= parseFloat($('#thickLin').val());
	var thickStr	= parseFloat($('#thickStr').val());
	var thickEks	= parseFloat($('#thickEks').val());  

	HasilThickness(ThLin, ThStr, ThEks, minToleran, maxToleran, thickLin, thickStr, thickEks);
}

function HasilThickness(ThLin, ThStr, ThEks, minToleran, maxToleran, thickLin, thickStr, thickEks){
	var minLinThk	= ThLin - (ThLin * minToleran);
	var maxLinThk	= ThLin + (ThLin * maxToleran);
	var minStrThk	= ThStr - (ThStr * minToleran);
	var maxStrThk	= ThStr + (ThStr * maxToleran);
	var minEksThk	= ThEks - (ThEks * minToleran);
	var maxEksThk	= ThEks + (ThEks * maxToleran);
	if(isNaN(minLinThk)){ var minLinThk = 0;}
	if(isNaN(maxLinThk)){ var maxLinThk = 0;}
	if(isNaN(minStrThk)){ var minStrThk = 0;}
	if(isNaN(maxStrThk)){ var maxStrThk = 0;}
	if(isNaN(minEksThk)){ var minEksThk = 0;}
	if(isNaN(maxEksThk)){ var maxEksThk = 0;}
	
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
	
	if(thickEks < minEksThk){var Hasil3	= "TOO LOW";}
	if(thickEks > maxEksThk){var Hasil3	= "TOO HIGH";}
	if((thickEks > minEksThk && thickEks < maxEksThk) || thickEks == 0){var Hasil3	= "OK";}
	$('#minEks').val(minEksThk.toFixed(4));
	$('#maxEks').val(maxEksThk.toFixed(4));
	// console.log(Hasil3);
	$('#hasilEks').val(Hasil3);
}

function ChangeLuasArea(){
	var diameter	= parseFloat($('#diameter').val());
	var waste		= parseFloat($('#waste').val());
	var radius		= parseFloat($('#radius').val());
	var angle		= parseFloat($('#angle').val());
	
	var thickLin	= parseFloat($('#thickLin').val());
	var thickStr	= parseFloat($('#thickStr').val());
	var thickEks	= parseFloat($('#thickEks').val());
	
	var estimasi 	= Estimasi(thickLin, thickStr, thickEks);
	
	var LuasAreaX 	= LuasArea(diameter, estimasi, waste, angle, radius);
	var LastCoat	= LuasAreaX * 0.25 * 1.2;
	
	if(isNaN(LastCoat)){ var LastCoat = 0;}
	$('#last_topcoat_1').val(LastCoat.toFixed(3));

	$('#estimasi').val(estimasi.toFixed(4));
	$('#area').val(LuasAreaX.toFixed(6));
	
	
	ChangeAreaToLiner(LuasAreaX);
	ChangeAreaToStr(LuasAreaX);
	ChangeAreaToEks(LuasAreaX);
	
	ChangePlusTopCoat(LastCoat);
	ChangePlusTcAdd(LastCoat)
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

function ChangePlusEks(Area){
	var Con1	= parseFloat($('#Lincontaining3_1').val());
	var Con2	= parseFloat($('#Lincontaining3_2').val());
	var Con3	= parseFloat($('#Lincontaining3_3').val());
	var Con4	= parseFloat($('#Lincontaining3_4').val());
	var Con5	= parseFloat($('#Lincontaining3_5').val());
	var Con6	= parseFloat($('#Lincontaining3_6').val());
	
	var Per1	= parseFloat($('#Linperse3_1').val()) /100;
	var Per2	= parseFloat($('#Linperse3_2').val()) /100;
	var Per3	= parseFloat($('#Linperse3_3').val()) /100;
	var Per4	= parseFloat($('#Linperse3_4').val()) /100;
	var Per5	= parseFloat($('#Linperse3_5').val()) /100;
	var Per6	= parseFloat($('#Linperse3_6').val()) /100;
	
	var Hasil1	= Area * Con1 * Per1;
	var Hasil2	= Area * Con2 * Per2;
	var Hasil3	= Area * Con3 * Per3;
	var Hasil4	= Area * Con4 * Per4;
	var Hasil5	= Area * Con5 * Per5;
	var Hasil6	= Area * Con6 * Per6;
	
	$('#Linlast_cost3_1').val(Math.ceil(Hasil1 * 1000)/1000);
	$('#Linlast_cost3_2').val(Math.ceil(Hasil2 * 1000)/1000);
	$('#Linlast_cost3_3').val(Math.ceil(Hasil3 * 1000)/1000);
	$('#Linlast_cost3_4').val(Math.ceil(Hasil4 * 1000)/1000);
	$('#Linlast_cost3_5').val(Math.ceil(Hasil5 * 1000)/1000);
	$('#Linlast_cost3_6').val(Math.ceil(Hasil6 * 1000)/1000);
}

function ChangePlusTopCoat(Area){
	var Con2	= parseFloat($('#cont_topcoat_2').val());
	var Con3	= parseFloat($('#cont_topcoat_3').val());
	var Con4	= parseFloat($('#cont_topcoat_4').val());
	var Con5	= parseFloat($('#cont_topcoat_5').val());
	var Con6	= parseFloat($('#cont_topcoat_6').val());
	var Con7	= parseFloat($('#cont_topcoat_7').val());
	var Con8	= parseFloat($('#cont_topcoat_8').val());
	
	var Per2	= parseFloat($('#perse_topcoat_2').val()) /100;
	var Per3	= parseFloat($('#perse_topcoat_3').val()) /100;
	var Per4	= parseFloat($('#perse_topcoat_4').val()) /100;
	var Per5	= parseFloat($('#perse_topcoat_5').val()) /100;
	var Per6	= parseFloat($('#perse_topcoat_6').val()) /100;
	var Per7	= parseFloat($('#perse_topcoat_7').val()) /100;
	var Per8	= parseFloat($('#perse_topcoat_8').val()) /100;
	
	var Hasil2	= Area * Con2 * Per2;
	var Hasil3	= Area * Con3 * Per3;
	var Hasil4	= Area * Con4 * Per4;
	var Hasil5	= Area * Con5 * Per5;
	var Hasil6	= Area * Con6 * Per6;
	var Hasil7	= Area * Con7 * Per7;
	var Hasil8	= Area * Con8 * Per8;
	
	$('#last_topcoat_2').val(Math.ceil(Hasil2 * 1000)/1000);
	$('#last_topcoat_3').val(Math.ceil(Hasil3 * 1000)/1000);
	$('#last_topcoat_4').val(Math.ceil(Hasil4 * 1000)/1000);
	$('#last_topcoat_5').val(Math.ceil(Hasil5 * 1000)/1000);
	$('#last_topcoat_6').val(Math.ceil(Hasil6 * 1000)/1000);
	$('#last_topcoat_7').val(Math.ceil(Hasil7 * 1000)/1000);
	$('#last_topcoat_8').val(Math.ceil(Hasil8 * 1000)/1000);
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

function ChangeAreaToEks(Area){
	var valueEks_1 		= parseFloat($('#valueEks_1').val());
	var valueEks_3 		= parseFloat($('#valueEks_3').val());
	var valueEks_5 		= parseFloat($('#valueEks_5').val());
	var valueEks_7 		= parseFloat($('#valueEks_7').val());
	
	var layerEks_1 		= parseFloat($('#layerEks_1').val());
	var layerEks_3 		= parseFloat($('#layerEks_3').val());
	var layerEks_5 		= parseFloat($('#layerEks_5').val());
	var layerEks_7 		= parseFloat($('#layerEks_').val());
	
	var containingEks_2	= parseFloat($('#containingEks_2').val());
	var containingEks_4	= parseFloat($('#containingEks_4').val());
	var containingEks_6	= parseFloat($('#containingEks_6').val());
	var containingEks_8	= parseFloat($('#containingEks_8').val());
	
	var last_cost_1 	= (Area * valueEks_1 * layerEks_1)/1000 ;
	var last_cost_3 	= (Area * valueEks_3 * layerEks_3)/1000 ;
	var last_cost_5 	= (Area * valueEks_5 * layerEks_5)/1000 ;
	var last_cost_7 	= (Area * valueEks_7 * layerEks_7)/1000 ; 
	
	if(isNaN(last_cost_7)){var last_cost_7 = 0;}
	
	var resin2			= last_cost_1 * containingEks_2;
	var resin4			= last_cost_3 * containingEks_4;
	var resin6			= last_cost_5 * containingEks_6;
	var resin8			= last_cost_7 * containingEks_8;
	
	var resiTot		= resin2 + resin4 + resin6 + resin8;
	ChangePlusEks(Area);
	$('#last_costEks_9').val(resiTot.toFixed(3));
	$('#last_fullEks_9').val(resiTot);
	
	$("#last_costEks_1").val(last_cost_1.toFixed(3));
	$("#last_costEks_3").val(last_cost_3.toFixed(3));
	$("#last_costEks_5").val(last_cost_5.toFixed(3));
	$("#last_costEks_7").val(last_cost_7.toFixed(3));
	
	$("#last_costEks_2").val(resin2.toFixed(3));
	$("#last_costEks_4").val(resin4.toFixed(3));
	$("#last_costEks_6").val(resin6.toFixed(3));
	$("#last_costEks_8").val(resin8.toFixed(3));
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

function ChangePlusEksAdd(Area){
	var AddEksNum	= parseFloat($('#AddEksNum').val());
	var a;
	for(a=1; a <= AddEksNum; a++){
		var Con		= parseFloat($('#Addcontaining3_'+a).val());
		var Per		= parseFloat($('#Addperse3_'+a).val()) /100;
		var Hasil	= Area * Con * Per;
		$('#Addlast_cost3_'+a).val(Math.ceil(Hasil * 1000)/1000);
	}
}

function ChangePlusTcAdd(Area){
	var AddTcNum	= parseFloat($('#AddTcNum').val());
	var a;
	for(a=1; a <= AddTcNum; a++){
		var Con		= parseFloat($('#Addcontaining4_'+a).val());
		var Per		= parseFloat($('#Addperse4_'+a).val()) /100;
		var Hasil	= Area * Con * Per;
		$('#Addlast_cost4_'+a).val(Math.ceil(Hasil * 1000)/1000);
	}
}


