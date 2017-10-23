<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="index.php?view=addmateriaprima" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Materia Prima</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre del producto" onkeypress="return vNomX(event,this)" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,30}" maxlength="30" data-validation-regex-message="Introduzca un nombre válido" maxlength="50" data-validation-ajax-ajax="ajax/matprim/result.php" required>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="descripcion" class="col-sm-3 control-label">Descripci&oacute;n:</label>
            <div class="col-sm-8 controls">
              <textarea name="descripcion" class="form-control" id="descripcion" placeholder="Descripci&oacute;n del producto" data-validation-regex-regex="[Á-Úá-ú#().,_:/\w\s]{3,200}" data-validation-regex-message="Introduzca una descripción válida" maxlength="200" required></textarea>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="minimo" class="col-sm-3 control-label">M&iacute;nimo:</label>
            <div class="col-sm-8 controls">
              <input type="text" name="minimo" class="form-control" id="minimo" placeholder="Cantidad m&iacute;nima en inventario" required pattern="[0-9]*" data-validation-pattern-message="Introduzca una cantidad v&aacute;lida" maxlength="6" min="1" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="addMP" type="submit" class="btn btn-md btn-primary" title="Agregar Materia Prima" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
