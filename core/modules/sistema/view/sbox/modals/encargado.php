<?php $empleados = EmpleadoData::getAll(); ?>
<?php
if (isset($_POST["encargado"])) {
	$caja = new CajaChicaData();
	$caja->idencargado = $_POST["encargado"];
	$caja->actualizarEncargado();
}
?>
<div class="modal fade" id="cambiarEncargado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="" class="form-horizontal" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Cambiar Encargado De Caja Chica</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="encargado" class="col-sm-3 control-label">Encargado:</label>
						<div class="col-sm-8">
							<select class="form-control" name="encargado" required>
								<option value="">-- SELECCIONE --</option>
								<?php foreach ($empleados as $emp): ?>
								<option value=" <?php echo $emp->id; ?> "><?php echo $emp->nombre." ".$emp->apellido; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-md btn-primary" title="Modificar Encargado" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
