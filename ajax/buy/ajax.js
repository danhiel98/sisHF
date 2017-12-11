function obtener_registros(buscar){
	$.ajax({
		url: 'ajax/buy/resultado.php',
		type: 'POST',
		dataType: 'html',
		data: { producto: buscar }
		})
	.done(function(resultado){
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