<?php
	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ClientData.php");
	$found = false;
	$clientes = ClientData::getAll();
?>
<?php if (isset($_SESSION["cartp"]) && !empty($_SESSION["cartp"])): $found = true; ?>
	<div class="col-md-12">
		<div class="form-group control-group">
			<label for="cliente" class="col-sm-4 control-label">Cliente</label>
			<div class="col-sm-8 controls">
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
		<div class="form-group control-group">
			<label for="tipo" class="col-sm-4 control-label">Comprobante</label>
			<div class="controls col-sm-8">
				<select class="form-control" name="tipo" id="tipo" required>
					<option value="">--SELECCIONE--</option>
					<option value="1">Factura</option>
					<?php if (count($clientes)>0): ?>
						<option value="2">Cr&eacute;dito Fiscal</option>
					<?php endif; ?>
				</select>
			</div>
		</div>
		<div class="form-group control-group">
			<label for="fechaEntrega" class="col-sm-4 control-label">Fecha De Entrega:</label>
			<div class="col-sm-8 controls">
				<div class='input-group date' id='datetimepicker2'>
					<input name="fechaEntrega" type='text' class="form-control" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
		</div>
		<div class="form-group control-group">
			<label for="cantidad" class="col-sm-4 control-label">Pago</label>
			<div class="controls col-sm-8">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-fw fa-dollar"></i>
					</span>
					<input type="text" name="cantidad" class="form-control" id="cantidad" placeholder="Pago" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="5" readonly required>
				</div>
			</div>
		</div>
		<div class="form-group control-group">
			<label for="numComprobante" class="col-sm-4 control-label">No. Comprobante</label>
			<div class="controls col-sm-8">
				<input type="text" class="form-control" name="numComprobante" id="numComprobante" pattern="[0-9]{1,10}" data-validation-pattern-message="Introduzca un valor válido" placeholder="Número de comprobante" maxlength="8" required>
			</div>
		</div>
		<div class="form-group control-group" id="groupLetras">
			<label for="totalLetras" class="col-sm-4 control-label">Son</label>
			<div class="controls col-sm-8">
				<textarea class="form-control" name="totalLetras" id="totalLetras" cols="10" rows="2" maxlenght="150" placeholder="Introduzca el valor a pagar en letras" required></textarea>
			</div>
		</div>
	</div>
	<div id="resumenX">
	</div>
	<?php if ($found): ?>
		<script type="text/javascript">
			$(function(){
				var html = '<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button><a href="index.php?view=newpedido&delAll" class="btn btn-danger">Cancelar</a><button type="submit" class="btn btn-md btn-primary" title="Registrar Traspaso" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>';
				$("#modal-footer").html(html);
			});
		</script>
	<?php endif; ?>
<?php else: ?>
	<p class="alert alert-warning">No ha agregado productos.</p>
<?php endif; ?>
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
		})
	}

	$("#cliente").on("load change",function(){
		var idCliente = $(this).val();
		obtenerComprobante(idCliente);
	});

	$(function(){
		obtenerComprobante();
		datosResumen();
	});

	$(function () {
		$('#datetimepicker2').datetimepicker({
			locale: 'es',
			format: "DD-MM-YYYY",
			minDate: new Date()
		});
	});

	$("#tipo").on("change", function(){
		tipo = $(this).val();
		comprobante = $("#numComprobante");
		//groupLetras = $("#groupLetras");
		iva = $("#groupIva");
		totLetras = $("#totalLetras");
		
		iva.hide();
		totLetras.attr("required","required");

		if (tipo == 3){
			totLetras.removeAttr("required");
			totLetras.val("");
			//groupLetras.hide();
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
			//groupLetras.show();	
			comprobante.removeAttr("readonly");
			comprobante.val("");
		}
	});

</script>
