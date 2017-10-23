//$(obtener_registros());

function obtener_registros(buscar){
	$.ajax({
		url : 'core/modules/ventas/view/valUser/widget-default.php',
		type : 'POST',
		dataType : 'html',
		data : { username: buscar },
		})

	.done(function(resultado){
		$("#help-block").html(resultado);
	})
}

$(document).on('keyup', '#username', function(){
	var valorBusqueda = $(this).val();
	if (valorBusqueda!="")
	{
		obtener_registros(valorBusqueda);
	}
	else
		{
			obtener_registros();
		}
});
