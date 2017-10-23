<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="index.php?view=addservice" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='fa fa-th'></i> Registrar Servicio</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre del servicio" required onkeypress="return vNomX(event,this)" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,30}" data-validation-regex-message="Introduzca un nombre válido" maxlength="30">
            </div>
          </div>
          <div class="form-group control-group">
            <label for="direccion" class="col-sm-3 control-label">Descripci&oacute;n:</label>
            <div class="col-sm-8 controls">
              <div class="input-group">
                <textarea class="form-control" name="descripcion" rows="3" cols="80" id="descripcion" required placeholder="Introduzca la descripci&oacute;n del servicio" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,200}" data-validation-regex-message="Introduzca una dirección válida" maxlength="200"></textarea>
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
                <input type="text" name="precio" class="form-control" id="precio" placeholder="Costo del servicio" required data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="1">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="addService" type="submit" class="btn btn-md btn-primary" title="Registrar Servicio" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
