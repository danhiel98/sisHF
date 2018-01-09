$(function () {
	$("#employ").on("change",function(){
		var idEmp = $(this).val();
		
		if (idEmp != ""){
			$.ajax({
				url: "ajax/usuario/tipo.php",
				type: "POST",
				dataType: "html",
				data: {
					id: idEmp
				},
				success: function(data){
					
					var dato = JSON.parse(data);
					if (dato != null){
						
						var tipo = $("#tipo");
						tipo.empty();
						$("<option>").attr("value", "").html("--SELECCIONE--").appendTo(tipo);

						for (let i = 0; i < dato.length; i++) {
							$("<option>").attr("value", dato[i].id).html(dato[i].nombre).appendTo(tipo);
						}

					}
					
				}
			});
		}
	});
});

function obtener_registros(buscar,actual){
	$.ajax({
		url: 'ajax/usuario/resultado.php',
		type: 'POST',
		dataType: 'html',
		data: {
			username: buscar,
			usract: actual
		},
	})
	.done(function(resultado){
		$("#user-group").removeClass('has-warning').addClass("has-success");
			$("#adduser").removeAttr("onsubmit");
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