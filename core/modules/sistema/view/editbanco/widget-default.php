<?php $banco = BancoData::getById($_GET["id"]);?>
<div class="row">
	<div class="col-md-12">
	<h1>Modificar Banco</h1>
	<br>
		<form class="form-horizontal" method="post" id="addBanco" action="index.php?view=updatebanco" role="form">
	<div class="form-group">
    <label for="txtNombre" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="txtNombre" class="form-control" id="txtNombre" placeholder="Nombre De La Sucursal" value="<?php echo $banco->nombre; ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="txtDireccion" class="col-lg-2 control-label">Direcci&oacute;n*</label>
    <div class="col-md-6">
      <input type="text" name="txtDireccion" class="form-control" id="txtDireccion" placeholder="Direcci&oacute;n De La Sucursal" value="<?php echo $banco->direccion; ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="txtTelefono" class="col-lg-2 control-label">Tel&eacute;fono*</label>
    <div class="col-md-6">
      <input type="text" name="txtTelefono" class="form-control" id="txtTelefono" placeholder="Tel&eacute;fono" value="<?php echo $banco->telefono; ?>">
    </div>
  </div>
  <p class="alert alert-info">* Campos obligatorios</p>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
			<input type="hidden" name="idBanco" value="<?php echo $banco->id;?>">
      <button type="submit" class="btn btn-primary">Actualizar Banco</button>
    </div>
  </div>
</form>
	</div>
</div>
