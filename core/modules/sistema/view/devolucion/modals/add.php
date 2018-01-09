<?php
  $ventas = FacturaData::getFacturas();
  $motivos = CausaDevolucionData::getAll();
?>
<script src="ajax/devolucion/ajax.js"></script>
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="index.php?view=adddevolucion" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='fa fa-reply'></i> Nueva Devoluci&oacute;n</h4>
        </div>
        <div class="modal-body">
            <div class="form-group control-group">
				<label for="numComprobante" class="col-lg-2 control-label">No. Comprobante:</label>
				<div class="col-lg-8 controls">
					<input name="numComprobante" id="numComprobante" type="text" class="form-control" required>
				</div>
		    </div>
            <div class="form-group control-group">
				<label for="cliente" class="col-lg-2 control-label">Cliente:</label>
				<div class="col-lg-8 controls">
					<input name="cliente" id="cliente" type="text" class="form-control" readonly required>
				</div>
			</div>
            <div class="form-group control-group">
				<label for="comprobante" class="col-lg-2 control-label">Tipo Comprobante:</label>
				<div class="col-lg-8 controls">
					<input name="comprobante" id="comprobante" type="text" class="form-control" readonly required>
				</div>
			</div>
            <div class="form-group control-group">
				<label for="motivo" class="col-lg-2 control-label">Motivo:</label>
				<div class="col-lg-8 controls">
					<select name="motivo" id="motivo" class="form-control" required>
                        <option value="">--SELECCIONE--</option>
                        <?php foreach ($motivos as $mot): ?>
                        <option value="<?php echo $mot->id; ?>"><?php echo $mot->descripcion; ?></option>
                        <?php endforeach; ?>
                    </select>
				</div>
			</div>
			<div class="form-group control-group">
				<label for="reembolso" class="col-lg-2 control-label">Reembolso:</label>
				<div class="col-lg-8 controls">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-fw fa-dollar"></i>
						</span>
						<input type="text" name="reembolso" onkeypress="return precio(event)" required class="form-control" id="reembolso" placeholder="Cantidad a reembolsar" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="1" required>
					</div>
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group">
                <div class="col-md-12">
                    <h2>Productos <small>Seleccione los productos que se van a devolver</small></h2>
                    <div id="resultadoProds"></div>
                </div>
			</div>
        </div>
		<input type="hidden" name="cantProds" id="cantProds" value="0">
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button id="btnOk" disabled type="submit" class="btn btn-md btn-primary" title="Registrar Devoluci&oacute;n"><span class="glyphicon glyphicon-floppy-saved"></span> Continuar</button>
        </div>
      </form>
    </div>
  </div>
</div>
