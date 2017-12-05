<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="index.php?view=addprovider" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='fa fa-truck'></i> Registrar Proveedor</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre Del Provedor" onkeypress="return vNomX(event,this)" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,30}" data-validation-regex-message="Introduzca un nombre válido" maxlength="30" required>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="provee" class="col-sm-3 control-label">Provee:</label>
            <div class="col-sm-8 controls">
              <select class="form-control" name="provee" required>
        				<option value="">--SELECCIONE--</option>
                 <option value="Productos">Productos</option>
                 <option value="Servicios">Servicios</option>
                 <!--<option value="Productos Y Servicios">Productos Y Servicios</option>-->
              </select>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="direccion" class="col-sm-3 control-label">Direcci&oacute;n:</label>
            <div class="col-sm-8 controls">
              <div class="input-group">
                <textarea class="form-control" name="direccion" rows="3" cols="80" id="direccion" placeholder="Introduzca la direcci&oacute;n del proveedor" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,150}" data-validation-regex-message="Introduzca una dirección válida" maxlength="150" required></textarea>
              </div>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="telefono" class="col-sm-3 control-label">Tel&eacute;fono:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="telefono" class="form-control" id="telefono" placeholder="N&uacute;mero telef&oacute;nico" onkeyup="fnc(this,'-',tel,true)" onpaste="return false" required onKeyPress="return soloNumeros(event)" maxlength="9" data-validation-regex-regex="[0-9]{4}-[0-9]{4}" data-validation-regex-message="Introduzca un número de teléfono válido">
            </div>
          </div>
          <div class="form-group control-group">
            <label for="correo" class="col-sm-3 control-label">Email:</label>
            <div class="col-sm-8 controls">
              <input type="email" name="correo" class="form-control" id="correo" placeholder="Correo Electr&oacute;nico">
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
