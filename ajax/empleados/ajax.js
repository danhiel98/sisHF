function obtenerDatosDeSucursal(idSucursal){
	$.ajax({
		url : 'ajax/empleados/resultado.php',
		type : 'POST',
		dataType : 'html',
		data : { sucursal: idSucursal },
	})
	.done(function(resultado){
		btnRep = $("#reporteEPS");
		if (resultado.length != 72 && resultado.length != 104){
			btnRep.attr("href", "report/empleados.php?idEmple=" + idSucursal);
			btnRep.show();
		}else{
			btnRep.removeAttr("href");
			btnRep.hide();
		}
		$("#tabla_resultado").html(resultado);
	})
}

$(".nav > li").on("click",function(){
	var idSuc = $("#sucursal").val();
	obtenerDatosDeSucursal(idSuc);
});

$(document).on('load change', '#sucursal', function(){
	var idSuc = $(this).val();
	obtenerDatosDeSucursal(idSuc);
});