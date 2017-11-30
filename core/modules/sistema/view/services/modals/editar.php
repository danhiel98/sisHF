<?php
  if (isset($_POST["editService"])) {
    $service = ServiceData::getById($_POST['eid']);
    $service->nombre = $_POST["enombre"];
    $service->descripcion = $_POST["edescripcion"];
    $service->precio = $_POST["eprecio"];
    $service->update();
  }
?>
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Servicio</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="enombre" class="form-control" id="enombre" placeholder="Nombre del servicio" required onkeypress="return vNomX(event,this)" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,30}" data-validation-regex-message="Introduzca un nombre válido" maxlength="30">
            </div>
          </div>
          <div class="form-group control-group">
            <label for="direccion" class="col-sm-3 control-label">Descripci&oacute;n:</label>
            <div class="col-sm-8 controls">
              <div class="input-group">
                <textarea class="form-control" name="edescripcion" rows="3" cols="80" id="edescripcion" required placeholder="Introduzca la descripci&oacute;n del servicio" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,200}" data-validation-regex-message="Introduzca una dirección válida" maxlength="150"></textarea>
              </div>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="descripcion" class="col-sm-3 control-label">Precio:</label>
            <div class="col-sm-8 controls">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-fw fa-dollar"></i>
                </span>
                <input type="text" name="eprecio" class="form-control" id="eprecio" placeholder="Costo del servicio" required data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="1">
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" name="eid" id="eid">
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="editService" type="submit" class="btn btn-md btn-primary" title="Actualizar Datos" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
