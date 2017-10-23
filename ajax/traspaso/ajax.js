//$(obtener_registros());

function obtener_registros(idSucursal,buscar){
	$.ajax({
		url : 'ajax/traspaso/resultado.php',
		type : 'POST',
		dataType : 'html',
		data : {
			productos: buscar,
			sucursal: idSucursal
		},
	}).done(function(resultado){
		var valid = "<script src='js/jqBootstrapValidation.js'></script><script>$(function () { $('input,select,textarea').not('[type=submit]').jqBootstrapValidation(); } );";
		valid += " function soloNumeros(e){key = (window.Event) ? e.which : e.keyCode; return (key >= 48 && key <= 57 || key >= 8 && key <= 31 || key == 0);}</script>"
		$("#tabla_resultado").html(valid+resultado);
	})
}

$(document).on('keyup focus', '#busqueda', function(){
	var valorBusqueda = $(this).val();
	var idSucursal = $("#sOrigen").val();
	if (valorBusqueda != "") {
		obtener_registros(idSucursal,valorBusqueda);
	}else {
		obtener_registros(idSucursal);
	}
});


function obtenerDatosDeSucursal(idSucursal){
	$.ajax({
		url : 'ajax/traspaso/resultado.php',
		type : 'POST',
		dataType : 'html',
		data : { sucursal: idSucursal },
		})

	.done(function(resultado){
		var valid = "<script src='js/jqBootstrapValidation.js'></script><script>$(function () { $('input,select,textarea').not('[type=submit]').jqBootstrapValidation(); } );";
		valid += " function soloNumeros(e){key = (window.Event) ? e.which : e.keyCode; return (key >= 48 && key <= 57 || key >= 8 && key <= 31 || key == 0);}</script>"
		$("#tabla_resultado").html(valid+resultado);
	})
}

$(function(){
	$("#sOrigen").on("load change",function(){
		var idSuc = $(this).val();
		obtenerDatosDeSucursal(idSuc);
	});
});

/*
function agregarProducto(idProducto, cantidad){
	$.ajax({
		url : 'ajax/traspaso/resultadoProd.php',
		type : 'POST',
		dataType : 'html',
		data : {
			idProd: idProducto,
			cant: cantidad
		},
		})
	.done(function(resultado){
		$("btn-add").html(resultado);
	})
}

$(document).on('click', '.btn-add', function(){
	var idProducto = this.id;
	var idx = "v"+idProducto;
	var cantidad = $("#"+idx).val();
	agregarProducto(idProducto, cantidad);
});
*/
