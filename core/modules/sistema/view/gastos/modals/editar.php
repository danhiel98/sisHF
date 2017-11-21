<?php
  if (isset($_POST["editGasto"])) {
    $data = GastoData::getById($_POST['eid']);
    if ($_POST["eresponsable"] != ""){
      $data->idempleado = $_POST["eresponsable"];
    }else{
      $data->idempleado = "null";
    }
  	$data->descripcion = $_POST["edescripcion"];
  	$data->pago = $_POST["epago"];
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
            <label for="eresponsable" class="col-sm-3 control-label">Responsable:</label>
            <div class="col-sm-8 controls">
              <select name="eresponsable" class="form-control" id="eresponsable">
    						<option value="">--SELECCIONE--</option>
    						<?php foreach($empleados as $emp):?>
    							<option value="<?php echo $emp->id; ?>"><?php echo $emp->nombre." ".$emp->apellido;?></option>
    						<?php endforeach;?>
    					</select>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="nombre" class="col-sm-3 control-label">Descripci&oacute;n:</label>
            <div class="col-sm-8 controls">
              <textarea type="text" name="edescripcion" class="form-control" id="edescripcion" placeholder="Descripci&oacute;n Del Gasto" required data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,200}" data-validation-regex-message="Introduzca una descripción válida" maxlength="100"></textarea>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="descripcion" class="col-sm-3 control-label">Cantidad:</label>
            <div class="col-sm-8">
              <div class="input-group controls">
                <span class="input-group-addon">
                  <i class="fa fa-fw fa-dollar"></i>
                </span>
                <input type="text" name="epago" class="form-control" id="epago" placeholder="Cantidad A Pagar" required data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="1">
              </div>
              <p class="help-block"></p>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="ecomprobante" class="col-sm-3 control-label">Comprobante:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="ecomprobante" class="form-control" id="ecomprobante" placeholder="N&uacute;mero de comprobante" data-validation-regex-regex="[0-9A-Za-z-]*" data-validation-regex-message="Introduzca un n&uacute;mero v&aacute;lido" maxlength="32" minlength="4">
            </div>
          </div>
        </div>
        <input type="hidden" name="eid" id="eid">
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="editGasto" type="submit" class="btn btn-md btn-primary" title="Modificar Gasto" ><span class="glyphicon glyphicon-floppy-saved"></span> Modificar</button>
        </div>
      </form>
    </div>
  </div>
</div>
