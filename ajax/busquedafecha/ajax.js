$(function(){
	$("#btnBusca").click(function(event) {
		var desde = $('#fecInicio').val();
		var hasta = $('#fecFin').val();
		var url = 'ajax/busquedafecha/consult.php';
		$.ajax({
			type:'POST',
			url:url,
			data: {
			    fecInicio: desde,
			    fecFin: hasta
			}
		}).done(function(res){
			$("#agrega-registros").html(res);
		});
		return false;
	});

	function obtenerTodo(){
		$.ajax({
			type:'POST',
			dataType: "html",
			url: "ajax/busquedafecha/todo.php"
		}).done(function(res){
			$("#agrega-registros").html(res);
		});
	}

	obtenerTodo();
	/*
	$('#fecInicio').on('change', function(){
		var desde = $('#fecInicio').val();
		var hasta = $('#fecFin').val();
		var url = 'ajax/busquedafecha/consult.php';
		$.ajax({
			type:'POST',
			url:url,
			data: {
			    fecInicio: desde,
			    fecFin: hasta
			}
		}).done(function(res){
			$("#agrega-registros").html(res);
		});
		return false;
	});
	
	$('#fecFin').on('change', function(){
		var desde = $('#fecInicio').val();
		var hasta = $('#fecFin').val();
		var url = 'ajax/busquedafecha/consult.php';
		$.ajax({
		type:'POST',
		url:url,
		data: {
		    fecInicio: desde,
		    fecFin: hasta
		}}).done(function(res){
		$("#agrega-registros").html(res);
	});
	return false;
	});
	*/
});
