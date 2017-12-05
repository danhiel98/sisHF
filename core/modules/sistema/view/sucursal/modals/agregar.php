<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class='icon-office'></i> Registrar Sucursal</h4>
      </div>
      <form action="index.php?view=addsucursal" class="form-horizontal" method="post">
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre De La Sucursal" onkeypress="return vNomX(event,this)" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,30}" data-validation-regex-message="Introduzca un nombre válido" maxlength="30" data-validation-ajax-ajax="ajax/sucursal/result.php" required>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="direccion" class="col-sm-3 control-label">Direcci&oacute;n:</label>
            <div class="col-sm-8 controls">
              <div class="input-group">
                <textarea class="form-control" rows="3" cols="80" name="direccion" id="direccion" placeholder="Introduzca la direcci&oacute;n de la sucursal" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,150}" data-validation-regex-message="Introduzca una dirección válida" required maxlength="150"></textarea>
              </div>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="telefono" class="col-sm-3 control-label">Tel&eacute;fono:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="telefono" class="form-control" id="telefono" placeholder="N&uacute;mero telef&oacute;nico" onkeyup="fnc(this,'-',tel,true);" onpaste="return false" required onKeyPress="return soloNumeros(event);" maxlength="9" data-validation-regex-regex="[0-9]{4}-[0-9]{4}" data-validation-regex-message="Introduzca un número de teléfono válido" maxlength="9">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="addSucursal" type="submit" class="btn btn-md btn-primary" title="Registrar Sucursal" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
