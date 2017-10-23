<?php
  if (isset($_POST["addMP"])) {
    $inventary = new MateriaPrimaData();
  	$inventary->nombre = $_POST["nombre"];
  	$inventary->descripcion = $_POST["descripcion"];
  	$inventary->add();
  }
?>
<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Materia Prima</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-8">
              <input type="text" name="nombre" required class="form-control" id="nombre" placeholder="Nombre Del Producto">
            </div>
          </div>
          <div class="form-group">
            <label for="descripcion" class="col-sm-3 control-label">Descripci&oacute;n:</label>
            <div class="col-sm-8">
              <input type="text" name="descripcion" required class="form-control" id="descripcion" placeholder="Descripci&oacute;n Del Producto">
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
