function obtener_registros(buscar,actual){
	$.ajax({
		url : 'ajax/usuario/resultado.php',
		type : 'POST',
		dataType : 'html',
		data : {
			username: buscar,
			usract: actual
		 },
		})
	.done(function(resultado){
    $("#user-group").removeClass('has-warning').addClass("has-success");
    $(".username").attr('aria-invalid','false');
		$(".username").html(resultado);
	})
}

$(document).on('keyup change', '#username', function(){
	var valorBusqueda = $(this).val();
	var actual = $("#usr").val();
	if (valorBusqueda==""){
    $("#user-group").removeClass('has-success has-warning');
	}else{
		obtener_registros(valorBusqueda,actual);
	}
});
