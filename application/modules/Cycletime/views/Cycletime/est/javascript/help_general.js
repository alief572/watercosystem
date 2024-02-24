
function RoundUp(x){
	var HasilRoundUp = (Math.ceil(x * 1000 ) / 1000).toFixed(3);
	return HasilRoundUp;
}

function RoundUp4(x){
	var HasilRoundUp = (Math.ceil(x * 10000 ) / 10000).toFixed(4);
	return HasilRoundUp;
}

function RoundUpEST(x){
	var HasilRoundUp = (Math.ceil(x * 10000 ) / 10000).toFixed(4);
	return HasilRoundUp;
}

function RoundUp10(x){
	var HasilRoundUp = (Math.ceil(x * 10000000000 ) / 10000000000).toFixed(10); 
	return HasilRoundUp;
}

//Only number with .
$(".numberOnly").on("keypress keyup blur",function (event) {    
	// $(this).val($(this).val().replace(/[^\d].+/, ""));
	if ((event.which < 48 || event.which > 57 ) && (event.which < 46 || event.which > 46 )) {
		event.preventDefault();
	}
});