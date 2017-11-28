function pedidos(tab){
	$.ajax({
		url: "ajax/pedidos/consulta.php",
		type: "POST",
		dataType: "html",
		data: {
			tab : tab
		}
	}).done(function(res){
		$("#resultado").html(res);
	});
}

$(function(){
	pedidos();
});
