<?php
  if (isset($_POST["editEnvio"])) {
    $data = EnvioData::getById($_POST['eid']);
    $data->idBanco = $_POST["ebanco"];
    $data->cantidad = $_POST["ecantidad"];
    $data->comprobante = $_POST["ecomprobante"];
    $data->update();
  }
?>
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Env&iacute;o</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="nombre" class="col-sm-3 control-label">Banco:</label>
            <div class="col-sm-8 controls">
              <select name="ebanco" class="form-control" id="ebanco" required>
    						<option value="">-- SELECCIONE --</option>
    						<?php foreach($bancos as $banc):?>
    							<option value="<?php echo $banc->id; ?>"><?php echo $banc->nombre;?></option>
    						<?php endforeach;?>
    					</select>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="descripcion" class="col-sm-3 control-label">Cantidad:</label>
            <div class="col-sm-8 controls">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-fw fa-dollar"></i>
                </span>
                <input type="text" name="ecantidad" class="form-control" id="ecantidad" placeholder="Cantidad De Dinero A Enviar" required data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="5">
              </div>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="ecomprobante" class="col-sm-3 control-label">Comprobante:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="ecomprobante" class="form-control" id="ecomprobante" placeholder="N&uacute;mero de comprobante" data-validation-regex-regex="[0-9A-Za-z-]*" data-validation-regex-message="Introduzca un n&uacute;mero v&aacute;lido" maxlength="32" minlength="4" required>
            </div>
          </div>
        </div>
        <input type="hidden" name="eid" id="eid">
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="editEnvio" type="submit" class="btn btn-md btn-primary" title="Modificar Env&iacute;o" ><span class="glyphicon glyphicon-floppy-saved"></span> Modificar</button>
        </div>
      </form>
    </div>
  </div>
</div>
