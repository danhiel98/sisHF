<?php

  $empleados = EmpleadoData::getAll();

  if (isset($_POST['btnSalida'])) {
    $cajaC = CajaChicaData::getAll();

    $entradas = $cajaC->entradas;
    $salidas = $cajaC->salidas;

    $cajaC->idusuario = $_SESSION['user_id'];
    $cajaC->idempleado = "null";
    if (isset($_POST['empleado']) && $_POST['empleado'] != "") {
      $cajaC->idempleado = $_POST['empleado'];
    }
    $cajaC->cantidad = $_POST['cantidad'];
    $cajaC->descripcion = $_POST['descripcion'];
    $cajaC->fecha = "NOW()";
    $cajaC->addSalida();

    $cajaC->salidas = $salidas + $_POST['cantidad'];
    $cajaC->cantidad = $cajaC->entradas - $cajaC->salidas;
    $cajaC->update();
  }
?>
<div class="modal fade" id="salida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='fa fa-minus'></i> Salida De Dinero De Caja Chica</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <label for="encargado" class="col-sm-3 control-label">Empleado:</label>
            <div class="col-sm-8 controls">
              <select class="form-control" name="empleado">
                <option value="">--NINGUNO--</option>
                <?php foreach ($empleados as $emp): ?>
                  <option value="<?php echo $emp->id; ?>"><?php echo $emp->nombre." ".$emp->apellido; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="encargado" class="col-sm-3 control-label">Cantidad:</label>
            <div class="col-sm-8 controls">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-fw fa-dollar"></i>
                </span>
                <input type="text" class="form-control" name="cantidad" required min="0.25" max="<?php echo $cajaC->cantidad; ?>" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9">
              </div>
            </div>
          </div>
          <div class="form-group control-group">
            <label for="encargado" class="col-sm-3 control-label">Descripci&oacute;n:</label>
            <div class="col-sm-8 controls">
              <textarea class="form-control" name="descripcion" rows="3" cols="50" required placeholder="Introduzca la descripci&oacute;n del gasto" data-validation-regex-regex="[Á-Úá-ú#().,_/\w\s]{3,200}" data-validation-regex-message="Introduzca una descripción válida" maxlength="200"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="btnSalida" type="submit" class="btn btn-md btn-primary" title="Registrar Salida" ><span class="glyphicon glyphicon-floppy-saved"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
