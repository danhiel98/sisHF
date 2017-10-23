var x = '<script type="text/javascript" src="js/bootstrap-confirmation.js"></script>';
x += "<script>$('[data-toggle=confirmation]').confirmation({rootSelector: '[data-toggle=confirmation]',container: 'body'});$('[data-toggle=confirmation-singleton]').confirmation({rootSelector: '[data-toggle=confirmation-singleton]',container: 'body'});$('[data-toggle=confirmation-popout]').confirmation({rootSelector: '[data-toggle=confirmation-popout]',container: 'body'});$('#confirmation-delegate').confirmation({selector: 'button'});</script>"
var f1 = "obtenerUsuarios('x');";
var y = '<script>$(".estado").on("confirmed.bs.confirmation",function(){var id = this.id;actualizarEstado(id);'+f1+'});$(".admin").on("confirmed.bs.confirmation",function(){var id = this.id;actualizarTipo(id);'+f1+'});</script>';
var f2 = "var idSuc = $('#sucursal').val();obtenerDatosDeSucursal(idSuc);"
var z = '<script>$(".estado").on("confirmed.bs.confirmation",function(){var id = this.id;actualizarEstado(id);'+f2+'});$(".admin").on("confirmed.bs.confirmation",function(){var id = this.id;actualizarTipo(id);'+f2+'});</script>';

function obtenerDatosDeSucursal(idSucursal){
	$.ajax({
		url : 'ajax/users/resultado.php',
		type : 'POST',
		dataType : 'html',
		data : { sucursal: idSucursal }
	}).done(function(resultado){
		$("#tabla_resultado").html(x+resultado+z);
	})
}

function obtenerUsuarios(usr){
	$.ajax({
		url: "ajax/users/resultado.php",
		type: "POST",
		dataType: "html",
		data: {users: usr}
	}).done(function(res){
		$("#all").html(x+res+y);
	})
}

function actualizarEstado(id){
	$.ajax({
		url: "ajax/users/resultado.php",
		type: "POST",
		data: {idUsrS: id}
	});
}

function actualizarTipo(id){
	$.ajax({
		url: "ajax/users/resultado.php",
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
