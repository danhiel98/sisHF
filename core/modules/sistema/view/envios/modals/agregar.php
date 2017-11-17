<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="index.php?view=addenvio" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Registrar Env&iacute;o</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="banco" class="col-sm-3 control-label">Banco:</label>
            <div class="col-sm-8 controls">
              <select name="banco" class="form-control" id="banco" required>
    						<option value="">--SELECCIONE--</option>
    						<?php foreach($bancos as $banc):?>
    							<option value="<?php echo $banc->id; ?>"><?php echo $banc->nombre;?></option>
    						<?php endforeach;?>
    					</select>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="cantidad" class="col-sm-3 control-label">Cantidad:</label>
            <div class="col-sm-8 controls">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-fw fa-dollar"></i>
                </span>
                <input type="text" name="cantidad" class="form-control" id="cantidad" placeholder="Cantidad de dinero a enviar" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="5" required>
              </div>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="comprobante" class="col-sm-3 control-label">Comprobante:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="comprobante" class="form-control" id="comprobante" placeholder="N&uacute;mero de comprobante" data-validation-regex-regex="[0-9A-Za-z-]*" data-validation-regex-message="Introduzca un n&uacute;mero v&aacute;lido" maxlength="32" minlength="4" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="addEnvio" type="submit" class="btn btn-md btn-primary" title="Registrar Env&iacute;o" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
