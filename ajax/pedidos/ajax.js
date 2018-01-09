function pedidos(){
	$.ajax({
		url: "ajax/pedidos/consulta.php",
		type: "POST",
		dataType: "html",
	}).done(function(res){
		$("#resultado").html(res);
	});
}

$(function(){
	pedidos();
});