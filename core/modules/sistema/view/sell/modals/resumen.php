<?php
	
	if (isset($_GET["delAll"])){
		include("loader.php");
		unset($_SESSION["cart"]);	
		print "<script>window.location='index.php?view=sell';</script>";
	}
	
	$products = ProductData::getAll();

?>
<div class="modal fade" id="resumen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form action="index.php?view=processsell" class="form-horizontal" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class='fa fa-list'></i> Resumen De Venta</h4>
				</div>
				<div class="modal-body">
					<div class="form-group col-md-2">
						<label for="cliente" class="col-md-12 control-label">Cliente</label>
					</div>	
					<div class="form-group control-group col-md-5">
						<div class="col-md-12 controls">
							<select name="cliente" id="cliente" class="form-control <?php if(count($clientes)>0){echo 'selectpicker'; } ?>" data-live-search="true" data-size="5">
								<option value="">--NINGUNO--</option>
								<?php foreach ($clientes as $cl):?>
									<option value="<?php echo $cl->id; ?>"><?php echo $cl->name; ?></option>
								<?php endforeach; ?>
								<script type="text/javascript">
									$(function(){
										$('.selectpicker').selectpicker('refresh');
									});
								</script>
							</select>
						</div>
					</div>

					<div class="form-group col-md-2">
						<label for="tipo" class="col-md-12 control-label">Comprobante</label>
					</div>
					<div class="form-group control-group col-md-4">
						<div class=" col-md-12 controls">
							<select class="form-control" name="tipo" id="tipo" style="font-size: 0.85em;" required>
								<option value="">--SELECCIONE--</option>
								<option value="1">Factura</option>
								<?php if (count($clientes)>0): ?>
									<option value="2">Cr&eacute;dito Fiscal</option>
								<?php endif; ?>
							</select>
						</div>
					</div>

					<div class="clearfix"></div>

					<div class="form-group col-md-2">
						<label for="numero" class="col-md-12 control-label">No. Comprobante</label>
					</div>
					<div class="form-group control-group col-md-4">
						<div class="col-md-12 controls">
							<input type="text" class="form-control" id="numComprobante" name="numero" pattern="[0-9]{1,10}" data-validation-pattern-message="Introduzca un valor válido" maxlength="8" required>
						</div>
					</div>

					<div class="form-group col-md-2">
						<label for="numero" class="col-md-12 control-label">Son</label>
					</div>
					<div class="form-group control-group col-md-5">
						<div class="col-md-12 controls">
							<textarea class="form-control" name="totalLetras" id="totalLetras" cols="10" rows="2" maxlenght="150" required></textarea>
						</div>
					</div>

					<div class="clearfix"></div>

					<!-- <input type="hidden" name="origen" value="<?php echo $_SESSION["usr_suc"]; ?>"> -->

					<div id="resumenX"></div>
				</div>
				<div class="modal-footer">
					<div class="pull-left">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
					<a class="dynamic btn btn-danger" href="index.php?view=sell&delAll" title="Cancelar" style="display: none;"><i class="fa fa-times"></i> Cancelar</a>
					<button type="submit" class="dynamic btn btn-success" title="Guardar Venta" style="display: none;"><i class="glyphicon glyphicon-floppy-saved"></i> Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	function obtenerComprobante(dato){
		$.ajax({
			url : 'ajax/sell/resultadoComprobante.php',
			type : 'POST',
			dataType : 'html',
			data : { idCliente: dato }
			})
		.done(function(resultado){
			$("#tipo").html(resultado);
		});
	}

	$("#cliente").on("load change",function(){
		var idCliente = $(this).val();
		obtenerComprobante(idCliente);
	});
	
	$(function(){
		obtenerComprobante();
	});

	$("#tipo").on("change", function(){
		tipo = $(this).val();
		comprobante = $("#numComprobante");
		iva = $("#groupIva");
		totLetras = $("#totalLetras");
		
		iva.hide();
		totLetras.attr("required","required");

		if (tipo == 3){
			totLetras.removeAttr("required");
			totLetras.val("");
			$.ajax({
				url: "ajax/sell/numeroRecibo.php",
				type: "POST",
				dataType: "json",
				success: function(data){
					comprobante.attr("disabled","disabled");
					comprobante.val(data);
				}
			});
		}else{
			if (tipo == 2){
				iva.show();
			}
			comprobante.removeAttr("disabled");
			comprobante.val("");
		}
	});

	$('#resumen').on('show.bs.modal', function () {
		datosResumen();
	});

</script>