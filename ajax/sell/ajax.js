function obtenerTodo(){
	$.ajax({
		url: 'ajax/sell/resultado.php',
		type: 'POST',
		dataType: 'html'
	})
	.done(function (resultado){
		$.getScript("js/jqBootstrapValidation.js");
		$("#resultado").html(resultado);
	});
}

function buscar(valor, tipo){
	$.ajax({
		url: 'ajax/sell/buscar.php',
		type: 'POST',
		data: {
			tipo: tipo,
			search: valor
		},
		dataType: 'html',
		success: function(data){
			$.getScript("js/jqBootstrapValidation.js");
			if (tipo == "prd"){
				$("#searchProd").html(data);
			} else if (tipo == "srv"){
				$("#searchServ").html(data);
			}
		}
	});
}

$(document).on('keyup focus', '.busqueda', function(){
	var input = $(this);
	var valorBusqueda = input.val();
	var tipo = input.data("tipo");
	buscar(valorBusqueda, tipo);
});

function datosResumen() {
	$.ajax({
		url: "ajax/sell/resumen.php",
		type: "POST",
		dataType: "html"
	}).done(function(res){
		var btns = $(".dynamic");
		if (res.length != 102){
			btns.show();
		}else{
			btns.hide();
		}
		$("#resumenX").html(res);
	});
}

$(document).ready(function(){
	obtenerTodo();
	datosResumen();
	
	//Esta función sirve para poner el foco en el input de búsqueda del tab al que ingresemos
	//Lo que permite que se llame la función 'buscar' y se obtenga el script 'cart.js'
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		tab = $(e.target).attr("href"); // newly activated tab
		input = $(tab).find(".busqueda");
		input.focus();
	});

});