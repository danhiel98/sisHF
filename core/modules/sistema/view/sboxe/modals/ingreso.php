<div class="modal fade" id="editarIngreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="index.php?view=updateingreso" class="form-horizontal" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i> Editar ingreso</h4>
				</div>
				<div class="modal-body">
					<div class="form-group control-group">
						<label for="encargado" class="col-sm-3 control-label">Cantidad:</label>
						<div class="col-sm-8 controls">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-fw fa-dollar"></i>
								</span>
								<input type="text" class="form-control" id="cantidad" name="cantidad" required min="1" max="9999999.99" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9">
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" id="id" name="id">
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button name="btnIngreso" type="submit" class="btn btn-md btn-primary" title="Registrar Ingreso" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
