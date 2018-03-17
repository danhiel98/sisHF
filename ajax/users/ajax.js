/*
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
*/

function obtenerDatosDeSucursal(idSucursal){
	$.ajax({
		url : 'ajax/users/resultado.php',
		type : 'POST',
		dataType : 'html',
		data : { sucursal: idSucursal }
	}).done(function(resultado){
		btnRep = $("#reporteEPS");
		chars = resultado.length;
		if (chars != 771 && chars != 839){
			btnRep.attr("href","report/usuario.php?idSuc=" + idSucursal);
			btnRep.show();
		}else{
			btnRep.removeAttr("href");
			btnRep.hide();
		}
		$("#resultadoSucursal").html(resultado);
	})
}

/*
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

$(function(){
	obtenerUsuarios("x");
});
*/

$(document).on('load change', '#sucursal', function () {
	var idSuc = $(this).val();
	obtenerDatosDeSucursal(idSuc);
});