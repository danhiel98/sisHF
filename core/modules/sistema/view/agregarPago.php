<script src="ajax/pagos/ajax.js"></script>
<div class="modal fade" id="agregar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class='fa fa-list'></i> Nuevo Pago</h4>
            </div>
            <form action="index.php?view=processpago" class="form-horizontal" method="POST">
                <div class="modal-body">
                    <div class="form-group control-group">
                        <label for="idPedido" class="col-sm-3 control-label">No. Pedido</label>
                        <div class="col-sm-8 controls">
                            <input type="text" name="idPedido" class="form-control" id="idPedido" placeholder="N&uacute;mero de pedido" onKeyPress="return soloNumeros(event)" maxlength="6" data-validation-regex-regex="[0-9]{1,6}" data-validation-regex-message="Introduzca un número de pedido válido" required value="<?php echo $id; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group control-group">
                        <label for="cliente" class="col-sm-3 control-label">Cliente</label>
                        <div class="col-sm-8 controls">
                            <input type="text" name="cliente" class="form-control" id="cliente" placeholder="Nombre del cliente" maxlength="100" readonly="readonly" required>
                        </div>
                    </div>
                    <div class="form-group control-group">
                        <label for="cantidad" class="col-sm-3 control-label">Cantidad</label>
                        <div class="col-sm-8 controls">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-fw fa-dollar"></i>
                                </span>
                                <input type="text" name="cantidad" class="form-control" id="cantidad" placeholder="Cantidad de dinero de pago" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="1" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group control-group">
                        <label for="restante" class="col-sm-3 control-label">Restante</label>
                        <div class="col-sm-8 controls">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-fw fa-dollar"></i>
                                </span>
                                <input type="text" name="restante" class="form-control" id="restante" placeholder="Cantidad de dinero restante" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="0" readonly="readonly" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group control-group">
                        <label for="tipoComprobante" class="col-sm-3 control-label">Tipo Comprobante</label>
                        <div class="col-sm-8 controls">
                            <select class="form-control" name="tipoComprobante" id="tipoComprobante" required></select>
                        </div>
                    </div>
                    <div class="form-group control-group">
                        <label for="numComprobante" class="col-sm-3 control-label">No. Comprobante</label>
                        <div class="col-sm-8 controls">
                            <input type="text" class="form-control" name="numComprobante" id="numComprobante" maxlength="16">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-success" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#tipoComprobante").on("change", function(){
		tipo = $(this).val();
		comprobante = $("#numComprobante");
		groupLetras = $("#groupLetras");
		iva = $("#groupIva");
		totLetras = $("#totalLetras");
		
		iva.hide();
		totLetras.attr("required","required");

		if (tipo == 3){
			totLetras.removeAttr("required");
			totLetras.val("");
			groupLetras.hide();
			$.ajax({
				url: "ajax/sell/numeroRecibo.php",
				type: "POST",
				dataType: "json",
				success: function(data){
					comprobante.attr("readonly","readonly");
					comprobante.val(data);
				}
			});
		}else{
			if (tipo == 2){
				iva.show();
			}
			groupLetras.show();	
			comprobante.removeAttr("readonly");
			comprobante.val("");
		}
	});
</script>