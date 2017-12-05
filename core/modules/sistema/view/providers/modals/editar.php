<?php
  if (isset($_POST["editProv"])) {
    $data = ProviderData::getById($_POST['eid']);
    $data->nombre = $_POST["enombre"];
    $data->tipoprovee = $_POST["eprovee"];
    $data->direccion = $_POST["edireccion"];
    $data->telefono = $_POST["etelefono"];
    $data->correo = $_POST["ecorreo"];
    $data->update();
  }
?>
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i> Editar Datos De Proveedor</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="enombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="enombre" class="form-control" id="enombre" placeholder="Nombre Del Provedor" onkeypress="return vNomX(event,this)" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,30}" data-validation-regex-message="Introduzca un nombre válido" maxlength="30" required>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="eprovee" class="col-sm-3 control-label">Provee:</label>
            <div class="col-sm-8 controls">
              <select class="form-control" name="eprovee" id="eprovee" required>
        				<option value="">--SELECCIONE--</option>
                 <option value="Productos">Productos</option>
                 <option value="Servicios">Servicios</option>
                 <!--<option value="Productos Y Servicios">Productos Y Servicios</option>-->
              </select>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="edireccion" class="col-sm-3 control-label">Direcci&oacute;n:</label>
            <div class="col-sm-8 controls">
              <div class="input-group">
                <textarea class="form-control" name="edireccion" rows="3" cols="80" id="edireccion" placeholder="Introduzca la direcci&oacute;n del proveedor" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,150}" data-validation-regex-message="Introduzca una dirección válida" maxlength="150" required></textarea>
              </div>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="etelefono" class="col-sm-3 control-label">Tel&eacute;fono:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="etelefono" class="form-control" id="etelefono" placeholder="N&uacute;mero telef&oacute;nico" onkeyup="fnc(this,'-',tel,true)" onpaste="return false" required onKeyPress="return soloNumeros(event)" maxlength="9" data-validation-regex-regex="[0-9]{4}-[0-9]{4}" data-validation-regex-message="Introduzca un número de teléfono válido">
            </div>
          </div>
          <div class="form-group control-group">
            <label for="ecorreo" class="col-sm-3 control-label">Email:</label>
            <div class="col-sm-8 controls">
              <input type="email" name="ecorreo" class="form-control" id="ecorreo" placeholder="Correo Electr&oacute;nico">
            </div>
          </div>
        </div>
        <input type="hidden" name="eid" id="eid">
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="editProv" type="submit" class="btn btn-md btn-primary" title="Modificar Datos" ><span class="glyphicon glyphicon-floppy-saved"></span> Modificar</button>
        </div>
      </form>
    </div>
  </div>
</div>
