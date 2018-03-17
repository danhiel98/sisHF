function obtenerTodo(){
	$.ajax({
		url : 'ajax/produccion/resultado.php',
		type : 'POST',
		dataType : 'html'
	}).done(function(resultado){
		$.getScript("js/jqBootstrapValidation.js");
		$("#tabla_resultado").html(resultado);
	});
}

function buscar(buscar) {
	$.ajax({
		url: 'ajax/produccion/buscar.php',
		type: 'POST',
		dataType: 'html',
		data: {
			productos: buscar
		},
		beforeSend: function(){
			$("#resultadoSearch").html("Cargando...");
		}
	}).done(function (resultado) {
		$.getScript("js/jqBootstrapValidation.js");
		$("#resultadoSearch").html(resultado);
	});
}

function datosResumen(){
	$.ajax({
		url: "ajax/produccion/resumen.php",
		type: "POST",
		dataType: "html",
		success: function(res){
			
			r = res.length;
			btns = $(".btn-ok");
			btnInfo = $("#btnInfo");

			if (r == 68){
				btns.hide();
				btnInfo.show();
				// btnInfo.attr("type","submit");
			}else{
				// btnInfo.attr("type","button");
				btnInfo.hide();
				btns.show();
			}
			$("#resultadoResumen").html(res);
		}
	});
}

$(document).on('keyup focus', '#busqueda', function(){
	var valorBusqueda = $(this).val();
	buscar(valorBusqueda);
});

$(function(){
	obtenerTodo();
});