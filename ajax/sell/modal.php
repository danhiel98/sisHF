<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ClientData.php");
	$found = false;
	$clientes = ClientData::getAll();
?>
<?php if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])): $found = true; ?>

	<div class="form-group control-group">
		<label for="cliente" class="col-sm-4 control-label">Cliente</label>
		<div class="col-sm-8 controls">
			<select name="cliente" id="cliente" class="form-control <?php if(count($clientes)>0){echo 'selectpicker'; } ?>" data-live-search="true" data-size="5">
				<option value="">--NINGUNO--</option>
				<?php foreach ($clientes as $cl):?>
					<option value="<?php echo $cl->id; ?>"><?php echo $cl->name." ".$cl->lastname; ?></option>
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
		<label for="numero" class="col-sm-4 control-label">No. Comprobante</label>
		<div class="controls col-sm-8">
			<input type="text" class="form-control" name="numero" pattern="[0-9]{2,8}" data-validation-pattern-message="Introduzca un valor válido" maxlength="8" required>
		</div>
	</div>

	<input type="hidden" name="origen" value="<?php echo $_SESSION["usr_suc"]; ?>">
	<div id="resumenX">
	</div>
	<?php if ($found): ?>
		<script type="text/javascript">
			$(function(){
				var html = '<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button><a href="index.php?view=sell&delAll" class="btn btn-danger">Cancelar</a><button name="addTraspaso" type="submit" class="btn btn-md btn-primary" title="Registrar Traspaso" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>';
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
	});
</script>
