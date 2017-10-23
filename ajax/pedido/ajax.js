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
			url : 'ajax/pedido/resultado.php',
			type : 'POST',
			dataType : 'html',
			data : {
				productos: buscar,
				sucursal: idSucursal
			},
			})
		.done(function(resultado){
			$("#tabla_resultado").html(resultado);
			$.getScript("js/jqBootstrapValidation.js",function(data, textStatus, jqxhr){
				//Lo que se va a hacer
			});
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
			url : 'ajax/pedido/resultado.php',
			type : 'POST',
			dataType : 'html',
			data : { sucursal: idSucursal },
			})
		.done(function(resultado){
			$("#tabla_resultado").html(resultado);
			$.getScript("js/jqBootstrapValidation.js",function(data, textStatus, jqxhr){
				//Lo que se va a hacer
			});
		})
	}

	$(document).on('load change', '#sOrigen', function(){
		var idSuc = $(this).val();
		obtenerDatosDeSucursal(idSuc);
	});

	function obtenerServ(){
		$.ajax({
			url: "ajax/pedido/resultadoSrv.php",
			type: "POST",
			dataType: "html"
		}).done(function(res){
			$("#resultado_srv").html(res);
		});
	}

	function datosModal(){
		$.ajax({
			url: "ajax/pedido/modal.php",
			type: "POST",
			dataType: "html"
		}).done(function(res){
			$("#modal-body").html(res);
		});
	}

	function datosResumen(){
		$.ajax({
			url: "ajax/pedido/resumen.php",
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
