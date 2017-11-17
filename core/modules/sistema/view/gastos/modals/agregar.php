<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="index.php?view=addgasto" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='fa fa-dollar'></i> Registrar Gasto</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="nombre" class="col-sm-3 control-label">Descripci&oacute;n:</label>
            <div class="col-sm-8 controls">
              <textarea type="text" name="descripcion" class="form-control" id="descripcion" placeholder="Descripci&oacute;n del gasto" required data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s-]{3,200}" data-validation-regex-message="Introduzca una descripción válida" maxlength="100"></textarea>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="descripcion" class="col-sm-3 control-label">Cantidad:</label>
            <div class="col-sm-8">
              <div class="input-group controls">
                <span class="input-group-addon">
                  <i class="fa fa-fw fa-dollar"></i>
                </span>
                <input type="text" name="pago" class="form-control" id="pago" placeholder="Cantidad a pagar" required data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="1">
              </div>
              <p class="help-block"></p>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="comprobante" class="col-sm-3 control-label">Comprobante:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="comprobante" class="form-control" id="comprobante" placeholder="N&uacute;mero de comprobante" data-validation-regex-regex="[0-9A-Za-z-]*" data-validation-regex-message="Introduzca un n&uacute;mero v&aacute;lido" maxlength="32" minlength="4">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="addGasto" type="submit" class="btn btn-md btn-primary" title="Registrar Gasto" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
