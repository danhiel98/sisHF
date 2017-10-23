<?php
    if (isset($_POST['btnIngreso'])){
      $cajaC = CajaChicaData::getAll();

      $entradas = $cajaC->entradas;
      $salidas = $cajaC->salidas;

      $cajaC->idusuario = $_SESSION['user_id'];
      $cajaC->cantidad = $_POST['cantidad'];
      $cajaC->fecha = "NOW()";
      $cajaC->addIngreso();

      $cajaC->entradas = $entradas + $_POST['cantidad'];
      $cajaC->cantidad = $cajaC->entradas - $cajaC->salidas;
      $cajaC->update();
    }
?>
<div class="modal fade" id="ingreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='fa fa-plus'></i> Ingreso A Caja Chica</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="encargado" class="col-sm-3 control-label">Cantidad:</label>
            <div class="col-sm-8 controls">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-fw fa-dollar"></i>
                </span>
                <input type="text" class="form-control" name="cantidad" required min="1" max="9999999.99" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="btnIngreso" type="submit" class="btn btn-md btn-primary" title="Registrar Ingreso" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
