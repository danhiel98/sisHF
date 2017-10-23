//$(obtener_registros());

function obtener_registros(buscar){
	$.ajax({
		url : 'ajax/buy/resultado.php',
		type : 'POST',
		dataType : 'html',
		data : { producto: buscar }
		})
	.done(function(resultado){
		//var valid = "<script src='js/jqBootstrapValidation.js'></script><script>$(function () { $('input,select,textarea').not('[type=submit]').jqBootstrapValidation(); } );";
		//valid += " function soloNumeros(e){key = (window.Event) ? e.which : e.keyCode; return (key >= 48 && key <= 57 || key >= 8 && key <= 31 || key == 0);}</script>"
		//$("#resultado").html(valid+resultado);
		$("#resultado").html(resultado);
		$(".datosModal").load("ajax/buy/modal.php");
		$.getScript("js/jqBootstrapValidation.js",function(data, textStatus, jqxhr){
			//Acciones a realizar
		});
	})
}

$(document).on('keyup focus', '#busqueda', function(){
	var valorBusqueda = $(this).val();
	if (valorBusqueda != "") {
		obtener_registros(valorBusqueda);
	}else {
		obtener_registros();
	}
});

function obtenerConNRC(dato){
	$.ajax({
		url : 'ajax/sell/resultado2.php',
		type : 'POST',
		dataType : 'html',
		data : { tipo: dato },
		})
	.done(function(resultado){
		$("#cliente").html(resultado);
	})
}

$("#tipo").on("load change",function(){
	var tipo = $(this).val();
	if (tipo == 2) {
		obtenerConNRC("CCF");
	}else{
		obtenerConNRC();
	}
});
