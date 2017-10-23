<?php $sucursal = SucursalData::getById($_GET["id"]);?>
<div class="row">
	<div class="col-md-12">
	<h1>Nueva Sucursal</h1>
	<br>
		<form class="form-horizontal" method="post" id="addSucursal" action="index.php?view=updatesucursal" role="form">
			<div class="form-group">
		    <label for="txtNombre" class="col-lg-2 control-label">Nombre*</label>
		    <div class="col-md-6">
		      <input type="text" name="txtNombre" class="form-control" id="txtNombre" placeholder="Nombre De La Sucursal" value="<?php echo $sucursal->nombre; ?>">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="txtDireccion" class="col-lg-2 control-label">Direcci&oacute;n*</label>
		    <div class="col-md-6">
		      <input type="text" name="txtDireccion" class="form-control" id="txtDireccion" placeholder="Direcci&oacute;n De La Sucursal" value="<?php echo $sucursal->direccion; ?>">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="txtTelefono" class="col-lg-2 control-label">Tel&eacute;fono*</label>
		    <div class="col-md-6">
		      <input type="text" name="txtTelefono" class="form-control" id="txtTelefono" placeholder="Tel&eacute;fono" value="<?php echo $sucursal->telefono; ?>">
		    </div>
		  </div>
		  <p class="alert alert-info">* Campos obligatorios</p>

		  <div class="form-group">
		    <div class="col-lg-offset-2 col-lg-10">
					<input type="hidden" name="idSucursal" value="<?php echo $sucursal->id;?>">
		      <button type="submit" class="btn btn-primary">Actualizar Sucursal</button>
		    </div>
		  </div>
		</form>
	</div>
</div>
