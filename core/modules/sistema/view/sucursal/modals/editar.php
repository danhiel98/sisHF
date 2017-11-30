<?php
  if (isset($_POST["editSucursal"])) {
    $sucursal = SucursalData::getById($_POST["eid"]);
  	$sucursal->nombre = $_POST["enombre"];
  	$sucursal->direccion = $_POST["edireccion"];
  	$sucursal->telefono = $_POST["etelefono"];
  	$sucursal->update();
  }
?>
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Sucursal</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="enombre" class="form-control" id="enombre" placeholder="Nombre De La Sucursal" onkeypress="return vNomX(event,this)" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,30}" data-validation-regex-message="Introduzca un nombre válido" maxlength="30" data-validation-ajax-ajax="ajax/sucursal/result.php" required>
		          <p class="help-block"></p>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="direccion" class="col-sm-3 control-label">Direcci&oacute;n:</label>
            <div class="col-sm-8">
              <div class="input-group controls">
                <textarea class="form-control" rows="3" cols="80" name="edireccion" id="edireccion" placeholder="Introduzca la direcci&oacute;n de la sucursal" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,150}" data-validation-regex-message="Introduzca una dirección válida" required maxlength="150"></textarea>
                <p class="help-block"></p>
              </div>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="etelefono" class="col-sm-3 control-label">Tel&eacute;fono:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="etelefono" class="form-control" id="etelefono" placeholder="N&uacute;mero telef&oacute;nico" onkeyup="fnc(this,'-',tel,true);" onpaste="return false" required onKeyPress="return soloNumeros(event);" maxlength="9" data-validation-regex-regex="[0-9]{4}-[0-9]{4}" data-validation-regex-message="Introduzca un número de teléfono válido" maxlength="9">
		          <p class="help-block"></p>
            </div>
          </div>
        </div>
        <input type="hidden" name="eid" id="eid">
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="editSucursal" type="submit" class="btn btn-md btn-primary" title="Actualizar Datos" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
