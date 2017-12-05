	//$(obtener_registros());
	$.ajaxSetup({
  	error: function( jqXHR, textStatus, errorThrown ) {
    	if (jqXHR.status === 0) {
      	alert('No conectado: Verifique su conexión a internet.');
      } else if (jqXHR.status == 404) {
        alert('No se encontró la página solicitada [404]');
      } else if (jqXHR.status == 500) {
        alert('Error interno del servidor [500].');
      } else if (textStatus === 'parsererror') {
        alert('Requested JSON parse failed.');
      } else if (textStatus === 'timeout') {
        alert('Time out error.');
      } else if (textStatus === 'abort') {
        alert('Solicitud abortada.');
      } else {
        alert('Error desconocido: ' + jqXHR.responseText);
      }
    }
	});

	function obtener_registros(idSucursal,buscar){
		$.ajax({
			url : 'ajax/sell/resultado.php',
			type : 'POST',
			dataType : 'html',
			data : {
				productos: buscar,
				sucursal: idSucursal
			},
			})
		.done(function(resultado){
			$.getScript("js/jqBootstrapValidation.js", function (data, textStatus, jqxhr) {
				//Acciones a realizar
			});
			$("#tabla_resultado").html(resultado);
		});
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
			url : 'ajax/sell/resultado.php',
			type : 'POST',
			dataType : 'html',
			data : { sucursal: idSucursal },
			})
		.done(function(resultado){
			$.getScript("js/jqBootstrapValidation.js", function (data, textStatus, jqxhr) {
				//Acciones a realizar
			});
			$("#tabla_resultado").html(resultado);
		})
	}

	$(document).on('load change', '#sOrigen', function(){
		var idSuc = $(this).val();
		obtenerDatosDeSucursal(idSuc);
	});

	function obtenerServ(){
		$.ajax({
			url: "ajax/sell/resultadoSrv.php",
			type: "POST",
			dataType: "html"
		}).done(function(res){
			$("#resultado_srv").html(res);
		});
	}

	function datosModal(){
		$.ajax({
			url: "ajax/sell/modal.php",
			type: "POST",
			dataType: "html"
		}).done(function(res){
			$("#modal-body").html(res);
		});
	}

	function datosResumen(){
		$.ajax({
			url: "ajax/sell/resumen.php",
			type: "POST",
			dataType: "html"
		}).done(function(res){
			$("#resumenX").html(res);
		});
	}

	$(document).ready(function(){
		datosModal();
		datosResumen();
		obtenerServ();
	});
