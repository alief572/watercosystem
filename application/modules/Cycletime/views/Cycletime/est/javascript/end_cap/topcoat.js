
$(document).on('keyup', '.ChangeContainingTC', function(){
	var total_resin	= $('#last_resin41').val();
	var perse		= $(this).parent().parent().find("td:nth-child(5) input").val();
	var containing	= $(this).val();
	
	var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
	
	$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
	$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);


});

$(document).on('keyup', '.ChangePerseTC', function(){
	var total_resin	= $('#last_resin41').val();
	var containing		= $(this).parent().parent().find("td:nth-child(4) input").val();
	var perse	= $(this).val();
	
	var HasilAkhir	= parseFloat(total_resin) * parseFloat(perse) * parseFloat(containing);
	
	$(this).parent().parent().find("td:nth-child(6) input").val(HasilAkhir.toFixed(3));
	$(this).parent().parent().find("td:nth-child(1) input").val(HasilAkhir);

});

$(document).on('keyup', '#persen_katalis4', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_katalis4').val();
	var layer_katalis	= $('#layer_katalis4').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
	$('#last_katalis4').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_color4', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_color4').val();
	var layer_katalis	= $('#layer_color4').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
	$('#last_color4').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_tin4', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_tin4').val();
	var layer_katalis	= $('#layer_tin4').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
	$('#last_tin4').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_chl4', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_chl4').val();
	var layer_katalis	= $('#layer_chl4').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
	$('#last_chl4').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_stery4', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_stery4').val();
	var layer_katalis	= $('#layer_stery4').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
	$('#last_stery4').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_wax4', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_wax4').val();
	var layer_katalis	= $('#layer_wax4').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
	$('#last_wax4').val(Hasil.toFixed(3));
});
$(document).on('keyup', '#persen_mch4', function(){
	var nilai			= $(this).val();
	var hasil_resin_tot = $('#hasil_mch4').val();
	var layer_katalis	= $('#layer_mch4').val();
	var Hasil			= (parseFloat(nilai)/100) * parseFloat(hasil_resin_tot) * parseFloat(layer_katalis);
	$('#last_mch4').val(Hasil.toFixed(3));
});