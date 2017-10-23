<?php
  if (isset($_POST["editMP"])) {
    $matPrim = MateriaPrimaData::getById($_POST["eid"]);
    $matPrim->id = $_POST["eid"];
    $matPrim->nombre = $_POST["enombre"];
  	$matPrim->descripcion = $_POST["edescripcion"];
  	$matPrim->update();
  }
?>
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Materia Prima</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="eid" id="eid">
          <div class="form-group">
            <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-8">
              <input type="text" name="enombre" required class="form-control" id="enombre" placeholder="Nombre Del Producto">
            </div>
          </div>
          <div class="form-group">
            <label for="descripcion" class="col-sm-3 control-label">Descripci&oacute;n:</label>
            <div class="col-sm-8">
              <input type="text" name="edescripcion" required class="form-control" id="edescripcion" placeholder="Descripci&oacute;n Del Producto">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="editMP" type="submit" class="btn btn-md btn-primary" title="Agregar Materia Prima" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
