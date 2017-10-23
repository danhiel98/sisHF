function obtenerDatosDeSucursal(idSucursal){
	$.ajax({
		url : 'ajax/empleados/resultado.php',
		type : 'POST',
		dataType : 'html',
		data : { sucursal: idSucursal },
		})

	.done(function(resultado){
		$("#tabla_resultado").html(resultado);
	})
}

$(document).on('load change', '#sucursal', function(){
	var idSuc = $(this).val();
	obtenerDatosDeSucursal(idSuc);
});
