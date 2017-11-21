<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="index.php?view=addbanco" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Registrar Banco</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre del banco" onkeypress="return vNomX(event,this)" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,30}" data-validation-regex-message="Introduzca un nombre válido" maxlength="30" data-validation-ajax-ajax="ajax/bancos/result.php" required>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="direccion" class="col-sm-3 control-label">Direcci&oacute;n:</label>
            <div class="col-sm-8 controls">
              <div class="input-group">
                <textarea class="form-control" name="direccion" rows="3" cols="80" id="direccion" placeholder="Introduzca la direcci&oacute;n del banco" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,200}" data-validation-regex-message="Introduzca una dirección válida" maxlength="200"></textarea>
              </div>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="telefono" class="col-sm-3 control-label">Tel&eacute;fono:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="telefono" class="form-control" id="telefono" placeholder="N&uacute;mero telef&oacute;nico" onkeyup="fnc(this,'-',tel,true)" onpaste="return false" onKeyPress="return soloNumeros(event)" maxlength="9" data-validation-regex-regex="[0-9]{4}-[0-9]{4}" data-validation-regex-message="Introduzca un número de teléfono válido">
            </div>
          </div>
          <div class="form-group control-group">
            <label for="numeroCuenta" class="col-sm-3 control-label">Número de cuenta:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="numeroCuenta" class="form-control" id="numeroCuenta" placeholder="N&uacute;mero de cuenta bancaria" maxlength="25" data-validation-regex-regex="[0-9A-Za-z-]{10,25}" data-validation-regex-message="Introduzca un número de cuenta válido">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="addBanco" type="submit" class="btn btn-md btn-primary" title="Registrar Banco" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
