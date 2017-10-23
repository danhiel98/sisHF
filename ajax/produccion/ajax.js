//$(obtener_registros());

function obtener_registros(buscar){
	$.ajax({
		url : 'ajax/produccion/resultado.php',
		type : 'POST',
		dataType : 'html',
		data : {
			productos: buscar
		},
	}).done(function(resultado){
		$.getScript("js/jqBootstrapValidation.js", function(data, textStatus, jqxhr){
			//
		});
		$("#tabla_resultado").html(resultado);
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

function producciones(tab){
	$.ajax({
		url: "ajax/produccion/consulta.php",
		type: "POST",
		dataType: "html",
		data: {
			tab : tab
		}
	}).done(function(res){
		$("#resultado").html(res);
	});
}

$(function(){
	producciones();
});
