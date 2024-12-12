
function LuasAreaFlange(top_diameter, flange_od, waste){
	var pangkat_od			= Math.pow(flange_od, 2);
	var pangkat_dim			= Math.pow(top_diameter, 2);
	var Luas_Area_Rumus		= 3.14/4 * (pangkat_od - pangkat_dim) / 1000000 * (1+(waste/100));
	if(isNaN(Luas_Area_Rumus)){
		var Luas_Area_Rumus = 0;
	}
	return Luas_Area_Rumus;
}

function LuasAreaNeck1(top_diameter, length_neck1, est_neck1, waste){
	var Luas_Area_Rumus_Neck1		= 3.14 * (top_diameter + est_neck1) * length_neck1 / 1000000 * (1+(waste/100));
	if(isNaN(Luas_Area_Rumus_Neck1)){
		var Luas_Area_Rumus_Neck1 = 0;
	}
	return Luas_Area_Rumus_Neck1;
}

function LuasAreaNeck2(top_diameter, length_neck2, est_neck1, est_neck2, waste){
	var Luas_Area_Rumus_Neck2		= 3.14 * (top_diameter + est_neck1 + est_neck2) * length_neck2 / 1000000 * (1+(waste/100));
	if(isNaN(Luas_Area_Rumus_Neck2)){
		var Luas_Area_Rumus_Neck2 = 0;
	}
	return Luas_Area_Rumus_Neck2;
}

function BeratPlastic(area_neck_1, Luas_Area_Rumus, diameter){
	var perkalian = 1350;
	if(diameter < 25){ var perkalian = 800; }
	var HasilPlastic		= (Luas_Area_Rumus + area_neck_1) * 0.000025 * 800;
	if(isNaN(HasilPlastic)){
		var HasilPlastic = 0;
	}
	return HasilPlastic;
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
	var ThStrN1		= parseFloat($('#ThStrN1').val());
	var ThStrN2		= parseFloat($('#ThStrN2').val());
	var minToleran	= parseFloat($('#min_toleran').val());
	var maxToleran	= parseFloat($('#max_toleran').val());
	var thickLin	= parseFloat($('#thickLin').val());
	var thickStr	= parseFloat($('#thickStr').val());
	var thickEks	= parseFloat($('#thickEks').val());
	var thickStrN1	= parseFloat($('#thickStrN1').val());
	var thickStrN2	= parseFloat($('#thickStrN2').val());
	
	var minLinThk	= ThLin - (ThLin * minToleran);
	var maxLinThk	= ThLin + (ThLin * maxToleran);
	var minStrThk	= ThStr - (ThStr * minToleran);
	var maxStrThk	= ThStr + (ThStr * maxToleran);
	var minEksThk	= ThEks - (ThEks * minToleran);
	var maxEksThk	= ThEks + (ThEks * maxToleran);
	var minStrThkN1	= ThStrN1 - (ThStrN1 * minToleran);
	var maxStrThkN1	= ThStrN1 + (ThStrN1 * maxToleran);
	var minStrThkN2	= ThStrN2 - (ThStrN2 * minToleran);
	var maxStrThkN2	= ThStrN2 + (ThStrN2 * maxToleran);
	
	if(isNaN(minLinThk)){ var minLinThk = 0;}
	if(isNaN(maxLinThk)){ var maxLinThk = 0;}
	if(isNaN(minStrThk)){ var minStrThk = 0;}
	if(isNaN(maxStrThk)){ var maxStrThk = 0;}
	if(isNaN(minEksThk)){ var minEksThk = 0;}
	if(isNaN(maxEksThk)){ var maxEksThk = 0;}
	if(isNaN(minStrThkN1)){ var minStrThkN1 = 0;}
	if(isNaN(maxStrThkN1)){ var maxStrThkN1 = 0;}
	if(isNaN(minStrThkN2)){ var minStrThkN2 = 0;}
	if(isNaN(maxStrThkN2)){ var maxStrThkN2 = 0;}
	
	if(thickLin < minLinThk){var Hasil1	= "TOO LOW";}
	if(thickLin > maxLinThk){var Hasil1	= "TOO HIGH";}
	if(thickLin > minLinThk && thickLin < maxLinThk){var Hasil1	= "OK";}
	$('#minLin').val(minLinThk.toFixed(4));
	$('#maxLin').val(maxLinThk.toFixed(4));
	$('#hasilLin').val(Hasil1);
	
	if(thickStr < minStrThk){var Hasil2	= "TOO LOW";}
	if(thickStr > maxStrThk){var Hasil2	= "TOO HIGH";}
	if(thickStr > minStrThk && thickStr < maxStrThk){var Hasil2	= "OK";}
	$('#minStr').val(minStrThk.toFixed(4));
	$('#maxStr').val(maxStrThk.toFixed(4));
	$('#hasilStr').val(Hasil2);
	
	
	if(thickStrN1 < minStrThkN1){var Hasil2N1	= "TOO LOW";}
	if(thickStrN1 > maxStrThkN1){var Hasil2N1	= "TOO HIGH";}
	if(thickStrN1 > minStrThkN1 && thickStrN1 < maxStrThkN1){var Hasil2N1	= "OK";}
	$('#minStrN1').val(minStrThkN1.toFixed(4));
	$('#maxStrN1').val(maxStrThkN1.toFixed(4));
	$('#hasilStrN1').val(Hasil2N1);
	
	// console.log(Hasil2N1);
	
	if(thickStrN2 < minStrThkN2){var Hasil2N2	= "TOO LOW";}
	if(thickStrN2 > maxStrThkN2){var Hasil2N2	= "TOO HIGH";}
	if(thickStrN2 > minStrThkN2 && thickStrN2 < maxStrThkN2){var Hasil2N2	= "OK";}
	$('#minStrN2').val(minStrThkN2.toFixed(4));
	$('#maxStrN2').val(maxStrThkN2.toFixed(4));
	$('#hasilStrN2').val(Hasil2N2);
	
	if(thickEks < minEksThk){var Hasil3	= "TOO LOW";}
	if(thickEks > maxEksThk){var Hasil3	= "TOO HIGH";}
	if((thickEks > minEksThk && thickEks < maxEksThk) || thickEks == 0){var Hasil3	= "OK";} 
	$('#minEks').val(minEksThk.toFixed(4));
	$('#maxEks').val(maxEksThk.toFixed(4));
	$('#hasilEks').val(Hasil3);
}

function ChangeLuasArea(){
	var diameter	= parseFloat($('#diameter').val());
	var waste		= parseFloat($('#waste').val());
	
	var thickLin	= parseFloat($('#thickLin').val());
	var thickStr	= parseFloat($('#thickStr').val());
	var thickEks	= parseFloat($('#thickEks').val());
	
	var flange_od		= parseFloat($('#flange_od').val());
	var panjang_neck_1	= parseFloat($('#panjang_neck_1').val());
	var panjang_neck_2	= parseFloat($('#panjang_neck_2').val());
	var est_neck_1		= parseFloat($('#thickStrN1').val()) + thickLin;
	var est_neck_2		= parseFloat($('#thickStrN2').val());
	
	var estimasi 	= Estimasi(thickLin, thickStr, thickEks);
	
	var LuasArea	= LuasAreaFlange(diameter, flange_od, waste);
	var LuasAreaN1	= LuasAreaNeck1(diameter, panjang_neck_1, est_neck_1, waste);
	var LuasAreaN2	= LuasAreaNeck2(diameter, panjang_neck_2, est_neck_1, est_neck_2, waste);
	
	var LuasAll		= LuasArea + LuasAreaN1 + LuasAreaN2;
	
	var LuasCoat	= LuasArea + LuasAreaN1;
	
	var LastCoat	= LuasCoat * 0.3 * 1.2 * 4;
	
	if(isNaN(LastCoat)){ var LastCoat = 0;}
	$('#last_topcoat_1').val(LastCoat.toFixed(3));

	$('#estimasi').val(estimasi.toFixed(4));
	$('#est_neck_1').val(est_neck_1.toFixed(4));
	$('#est_neck_2').val(est_neck_2.toFixed(4));
	$('#area').val(LuasArea.toFixed(6));
	$('#area_neck_1').val(LuasAreaN1.toFixed(6));
	$('#area_neck_2').val(LuasAreaN2.toFixed(6));
	
	ChangeAreaToLiner(LuasArea, LuasAreaN1);
	ChangeAreaToStr(LuasArea, diameter);
	ChangeAreaToStrN1(LuasAreaN1, diameter);
	ChangeAreaToStrN2(LuasAreaN2, diameter);
	ChangeAreaToEks(LuasAll);
	
	ChangePlusTopCoat(LastCoat);
	ChangePlusTcAdd(LastCoat)
}

function LastWeight(){
	var area		= parseFloat($('#area').val());
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
	
	var Per1	= parseFloat($('#Linperse2_1').val()) /100;
	var Per2	= parseFloat($('#Linperse2_2').val()) /100;
	var Per3	= parseFloat($('#Linperse2_3').val()) /100;
	var Per4	= parseFloat($('#Linperse2_4').val()) /100;
	
	var Hasil1	= Area * Con1 * Per1;
	var Hasil2	= Area * Con2 * Per2;
	var Hasil3	= Area * Con3 * Per3;
	var Hasil4	= Area * Con4 * Per4;
	
	$('#Linlast_cost2_1').val(Math.ceil(Hasil1 * 1000)/1000);
	$('#Linlast_cost2_2').val(Math.ceil(Hasil2 * 1000)/1000);
	$('#Linlast_cost2_3').val(Math.ceil(Hasil3 * 1000)/1000);
	$('#Linlast_cost2_4').val(Math.ceil(Hasil4 * 1000)/1000);
}

function ChangePlusStrN1(Area){
	var Con1	= parseFloat($('#Lincontaining2N1_1').val());
	var Con2	= parseFloat($('#Lincontaining2N1_2').val());
	var Con3	= parseFloat($('#Lincontaining2N1_3').val());
	var Con4	= parseFloat($('#Lincontaining2N1_4').val());
	var Con5	= parseFloat($('#Lincontaining2N1_5').val());
	var Con6	= parseFloat($('#Lincontaining2N1_6').val());
	
	var Per1	= parseFloat($('#Linperse2N1_1').val()) /100;
	var Per2	= parseFloat($('#Linperse2N1_2').val()) /100;
	var Per3	= parseFloat($('#Linperse2N1_3').val()) /100;
	var Per4	= parseFloat($('#Linperse2N1_4').val()) /100;
	var Per5	= parseFloat($('#Linperse2N1_5').val()) /100;
	var Per6	= parseFloat($('#Linperse2N1_6').val()) /100;
	
	var Hasil1	= Area * Con1 * Per1;
	var Hasil2	= Area * Con2 * Per2;
	var Hasil3	= Area * Con3 * Per3;
	var Hasil4	= Area * Con4 * Per4;
	var Hasil5	= Area * Con5 * Per5;
	var Hasil6	= Area * Con6 * Per6;
	
	$('#Linlast_cost2N1_1').val(Math.ceil(Hasil1 * 1000)/1000);
	$('#Linlast_cost2N1_2').val(Math.ceil(Hasil2 * 1000)/1000);
	$('#Linlast_cost2N1_3').val(Math.ceil(Hasil3 * 1000)/1000);
	$('#Linlast_cost2N1_4').val(Math.ceil(Hasil4 * 1000)/1000);
	$('#Linlast_cost2N1_5').val(Math.ceil(Hasil5 * 1000)/1000);
	$('#Linlast_cost2N1_6').val(Math.ceil(Hasil6 * 1000)/1000);
}

function ChangePlusStrN2(Area){
	var Con1	= parseFloat($('#Lincontaining2N2_1').val());
	var Con2	= parseFloat($('#Lincontaining2N2_2').val());
	var Con3	= parseFloat($('#Lincontaining2N2_3').val());
	var Con4	= parseFloat($('#Lincontaining2N2_4').val());
	
	var Per1	= parseFloat($('#Linperse2N2_1').val()) /100;
	var Per2	= parseFloat($('#Linperse2N2_2').val()) /100;
	var Per3	= parseFloat($('#Linperse2N2_3').val()) /100;
	var Per4	= parseFloat($('#Linperse2N2_4').val()) /100;
	
	var Hasil1	= Area * Con1 * Per1;
	var Hasil2	= Area * Con2 * Per2;
	var Hasil3	= Area * Con3 * Per3;
	var Hasil4	= Area * Con4 * Per4;
	
	$('#Linlast_cost2N2_1').val(Math.ceil(Hasil1 * 1000)/1000);
	$('#Linlast_cost2N2_2').val(Math.ceil(Hasil2 * 1000)/1000);
	$('#Linlast_cost2N2_3').val(Math.ceil(Hasil3 * 1000)/1000);
	$('#Linlast_cost2N2_4').val(Math.ceil(Hasil4 * 1000)/1000);
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

function ChangeAreaToLiner(Area, AreaN1){
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
	
	var last_cost_1 	= BeratPlastic(AreaN1, Area, diameter);
	var last_cost_2 	= (((Area + AreaN1) * value_2 * layer_2)/1000) * 1.2 ;
	var last_cost_4 	= (((Area + AreaN1) * value_4 * layer_4)/1000) * 1.2 ;
	var last_cost_6 	= (((Area + AreaN1) * value_6 * layer_6)/1000) * 1.1 ;
	var last_cost_8 	= (((Area + AreaN1) * value_8 * layer_8)/1000) * 1.1 ; 
	var resin3			= last_cost_2 * containing_3;
	var resin5			= last_cost_4 * containing_5;
	var resin7			= last_cost_6 * containing_7;
	var resin9			= last_cost_8 * containing_9;
	var resiTot			= ((Area + AreaN1) * 1.2 * 0.3) + resin3 + resin5 + resin7 + resin9;
	
	ChangePlus(resiTot);
	ChangePlusAdd(resiTot);
	
	
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

function ChangeAreaToStr(Area, diameter){
	var valueStr_1 		= parseFloat($('#valueStr_1').val());
	var valueStr_3 		= parseFloat($('#valueStr_3').val());
	var valueStr_5 		= parseFloat($('#valueStr_5').val());
	var valueStr_7 		= parseFloat($('#valueStr_7').val());
	
	var layerStr_1 		= parseFloat($('#layerStr_1').val());
	var layerStr_3 		= parseFloat($('#layerStr_3').val());
	var layerStr_5 		= parseFloat($('#layerStr_5').val());
	var layerStr_7 		= parseFloat($('#layerStr_7').val());
	
	var containingStr_2		= parseFloat($('#containingStr_2').val());
	var containingStr_4		= parseFloat($('#containingStr_4').val());
	var containingStr_6		= parseFloat($('#containingStr_6').val());
	var containingStr_8		= parseFloat($('#containingStr_8').val());
	
	var last_costStr_1 		= (Area * valueStr_1 * layerStr_1)/1000 ;
	var last_costStr_3 		= (Area * valueStr_3 * layerStr_3)/1000 ;
	var last_costStr_5 		= (Area * valueStr_5 * layerStr_5)/1000 ;
	var last_costStr_7 		= (Area * valueStr_7 * layerStr_7)/1000 ; 
	
	var kali = 1.1;
	if(diameter > 600){
		var kali = 1.05;
	}	
	
	var resin2			= last_costStr_1 * containingStr_2 * kali;
	var resin4			= last_costStr_3 * containingStr_4 * kali;
	var resin6			= last_costStr_5 * containingStr_6 * kali;
	var resin8			= last_costStr_7 * containingStr_8 * kali;
	
	var resiTot			= resin2 + resin4 + resin6 + resin8;
	ChangePlusStr(resiTot);
	ChangePlusStrAdd(resiTot);
	
	$('#last_costStr_9').val(resiTot.toFixed(3));
	$('#last_fullStr_9').val(resiTot);

	$("#last_costStr_1").val(last_costStr_1.toFixed(3));
	$("#last_costStr_3").val(last_costStr_3.toFixed(3));
	$("#last_costStr_5").val(last_costStr_5.toFixed(3));
	$("#last_costStr_7").val(last_costStr_7.toFixed(3));
	
	$("#last_costStr_2").val(resin2.toFixed(3));
	$("#last_costStr_4").val(resin4.toFixed(3));
	$("#last_costStr_6").val(resin6.toFixed(3));
	$("#last_costStr_8").val(resin8.toFixed(3));
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
	ChangePlusEksAdd(resiTot);
	
	
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

function ChangeAreaToStrN1(Area, diameter){
	var valueStr_1 		= parseFloat($('#valueStrN1_1').val());
	var valueStr_3 		= parseFloat($('#valueStrN1_3').val());
	var valueStr_5 		= parseFloat($('#valueStrN1_5').val());
	var valueStr_7 		= parseFloat($('#valueStrN1_7').val());
	var valueStr_9 		= parseFloat($('#valueStrN1_9').val());
	var valueStr_11 	= parseFloat($('#valueStrN1_11').val());
	
	var layerStr_1 		= parseFloat($('#layerStrN1_1').val());
	var layerStr_3 		= parseFloat($('#layerStrN1_3').val());
	var layerStr_5 		= parseFloat($('#layerStrN1_5').val());
	var layerStr_7 		= parseFloat($('#layerStrN1_7').val());
	var layerStr_9 		= parseFloat($('#layerStrN1_9').val());
	var layerStr_11 	= parseFloat($('#layerStrN1_11').val());
	
	var containingStr_2		= parseFloat($('#containingStrN1_2').val());
	var containingStr_4		= parseFloat($('#containingStrN1_4').val());
	var containingStr_6		= parseFloat($('#containingStrN1_6').val());
	var containingStr_8		= parseFloat($('#containingStrN1_8').val());
	var containingStr_10	= parseFloat($('#containingStrN1_10').val());
	var containingStr_12	= parseFloat($('#containingStrN1_12').val());
	
	var bwStr_9 		= parseFloat($('#bwStrN1_9').val());
	var jumlahStr_9 	= parseFloat($('#jumlahStrN1_9').val());
	var bwStr_11 		= parseFloat($('#bwStrN1_11').val());
	var jumlahStr_11 	= parseFloat($('#jumlahStrN1_11').val());
	
	var last_costStr_1 		= (Area * valueStr_1 * layerStr_1)/1000 ;
	var last_costStr_3 		= (Area * valueStr_3 * layerStr_3)/1000 ;
	var last_costStr_5 		= (Area * valueStr_5 * layerStr_5)/1000 ;
	var last_costStr_7 		= (Area * valueStr_7 * layerStr_7)/1000 ; 
	var last_costStr_9 		= ((valueStr_9 * 0.001 * jumlahStr_9 * 100)/(bwStr_9/10)) * (2/1000) * layerStr_9 * Area;
	var last_costStr_11 	= ((valueStr_11 * 0.001 * jumlahStr_11 * 100)/(bwStr_11/10)) * (2/1000) * layerStr_11 * Area;
	
	if(isNaN(last_costStr_9)){var last_costStr_9 = 0;}
	if(isNaN(last_costStr_11)){var last_costStr_11 = 0;}
	
	var kali = 1.1;
	if(diameter > 600){
		var kali = 1.05;
	}	
	
	var resin2			= last_costStr_1 * containingStr_2 * kali;
	var resin4			= last_costStr_3 * containingStr_4 * kali;
	var resin6			= last_costStr_5 * containingStr_6 * kali;
	var resin8			= last_costStr_7 * containingStr_8 * kali;
	var resin10			= last_costStr_9 * containingStr_10 * kali;
	var resin12			= last_costStr_11 * containingStr_12 * kali;
	
	var resiTot			= resin2 + resin4 + resin6 + resin8 + resin10 + resin12;
	ChangePlusStrN1(resiTot);
	ChangePlusStrAddN1(resiTot);
	
	$('#last_costStrN1_13').val(resiTot.toFixed(3));
	$('#last_fullStrN1_13').val(resiTot);

	$("#last_costStrN1_1").val(last_costStr_1.toFixed(3));
	$("#last_costStrN1_3").val(last_costStr_3.toFixed(3));
	$("#last_costStrN1_5").val(last_costStr_5.toFixed(3));
	$("#last_costStrN1_7").val(last_costStr_7.toFixed(3));
	$("#last_costStrN1_9").val(last_costStr_9.toFixed(3));
	$("#last_costStrN1_11").val(last_costStr_11.toFixed(3));
	
	$("#last_costStrN1_2").val(resin2.toFixed(3));
	$("#last_costStrN1_4").val(resin4.toFixed(3));
	$("#last_costStrN1_6").val(resin6.toFixed(3));
	$("#last_costStrN1_8").val(resin8.toFixed(3));
	$("#last_costStrN1_10").val(resin10.toFixed(3));
	$("#last_costStrN1_12").val(resin12.toFixed(3));
}

function ChangeAreaToStrN2(Area, diameter){
	var valueStr_1 		= parseFloat($('#valueStrN2_1').val());
	var valueStr_3 		= parseFloat($('#valueStrN2_3').val());
	var valueStr_5 		= parseFloat($('#valueStrN2_5').val());
	var valueStr_7 		= parseFloat($('#valueStrN2_7').val());
	
	var layerStr_1 		= parseFloat($('#layerStrN2_1').val());
	var layerStr_3 		= parseFloat($('#layerStrN2_3').val());
	var layerStr_5 		= parseFloat($('#layerStrN2_5').val());
	var layerStr_7 		= parseFloat($('#layerStrN2_7').val());
	
	var containingStr_2		= parseFloat($('#containingStrN2_2').val());
	var containingStr_4		= parseFloat($('#containingStrN2_4').val());
	var containingStr_6		= parseFloat($('#containingStrN2_6').val());
	var containingStr_8		= parseFloat($('#containingStrN2_8').val());
	
	var last_costStr_1 		= (Area * valueStr_1 * layerStr_1)/1000 ;
	var last_costStr_3 		= (Area * valueStr_3 * layerStr_3)/1000 ;
	var last_costStr_5 		= ((Area * valueStr_5 * layerStr_5)/1000) * 1.1;
	var last_costStr_7 		= ((Area * valueStr_7 * layerStr_7)/1000) * 1.1;
	
	var kali = 1.1;
	if(diameter > 600){
		var kali = 1.05;
	}	
	
	var resin2			= last_costStr_1 * containingStr_2 * kali;
	var resin4			= last_costStr_3 * containingStr_4 * kali;
	var resin6			= last_costStr_5 * containingStr_6 * kali;
	var resin8			= last_costStr_7 * containingStr_8 * kali;
	
	var resiTot			= resin2 + resin4 + resin6 + resin8;
	ChangePlusStrN2(resiTot);
	ChangePlusStrAddN2(resiTot);
	
	$('#last_costStrN2_9').val(resiTot.toFixed(3));
	$('#last_fullStrN2_9').val(resiTot);

	$("#last_costStrN2_1").val(last_costStr_1.toFixed(3));
	$("#last_costStrN2_3").val(last_costStr_3.toFixed(3));
	$("#last_costStrN2_5").val(last_costStr_5.toFixed(3));
	$("#last_costStrN2_7").val(last_costStr_7.toFixed(3));
	
	$("#last_costStrN2_2").val(resin2.toFixed(3));
	$("#last_costStrN2_4").val(resin4.toFixed(3));
	$("#last_costStrN2_6").val(resin6.toFixed(3));
	$("#last_costStrN2_8").val(resin8.toFixed(3));
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

function ChangePlusStrAddN2(Area){
	var AddStrNum	= parseFloat($('#AddStrNumN2').val());
	var a;
	for(a=1; a <= AddStrNum; a++){
		var Con		= parseFloat($('#Addcontaining2N2_'+a).val());
		var Per		= parseFloat($('#Addperse2N2_'+a).val()) /100;
		var Hasil	= Area * Con * Per;
		$('#Addlast_cost2N2_'+a).val(Math.ceil(Hasil * 1000)/1000);
	}
}

function ChangePlusStrAddN1(Area){
	var AddStrNum	= parseFloat($('#AddStrNumN1').val());
	var a;
	for(a=1; a <= AddStrNum; a++){
		var Con		= parseFloat($('#Addcontaining2N1_'+a).val());
		var Per		= parseFloat($('#Addperse2N1_'+a).val()) /100;
		var Hasil	= Area * Con * Per; 
		$('#Addlast_cost2N1_'+a).val(Math.ceil(Hasil * 1000)/1000);
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


