function usuarios(tab) {
	$.ajax({
		url: "ajax/users/consulta.php",
		type: "POST",
		dataType: "html",
		data: {
			tab: tab
		}
	}).done(function (res) {
		$("#resultado").html(res);
	});
}

$(function () {
	usuarios();
});

/*
function obtenerDatosDeSucursal(idSucursal){
	$.ajax({
		url : 'ajax/users/resultado.php',
		type : 'POST',
		dataType : 'html',
		data : { sucursal: idSucursal }
	}).done(function(resultado){
		$.getScript("js/bootstrap-confirmation.js", function (data, textStatus, jqxhr) {
			//
		});
		$("#tabla_resultado").html(resultado);
	})
}

function obtenerUsuarios(usr){
	$.ajax({
		url: "ajax/users/resultado.php",
		type: "POST",
		dataType: "html",
		data: {users: usr}
	}).done(function(res){
		$.getScript("js/jqBootstrapValidation.js", function (data, textStatus, jqxhr) {
			//
		});
		$("#all").html(res);
	})
}

function actualizarEstado(id){
	$.ajax({
		url: "ajax/users/procesos.php",
		type: "POST",
		data: {idUsrS: id}
	});
}

function actualizarTipo(id){
	$.ajax({
		url: "ajax/users/procesos.php",
		type: "POST",
		data: {idUsrT: id}
	});
}

$(document).on('load change', '#sucursal', function(){
	var idSuc = $(this).val();
	obtenerDatosDeSucursal(idSuc);
});

$(function(){
	obtenerUsuarios("x");
});
*/