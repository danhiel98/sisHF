<div class="row">
	<div class="col-md-12">
	<h1>Nuevo Proveedor</h1>
	<br>
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=addprovider" role="form">
  <div class="form-group">
    <label for="txtNombre" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="txtNombre" required class="form-control" id="txtNombre" placeholder="Nombre Del Provedor">
    </div>
  </div>
   <div class="form-group">
    <label for="txtProvee" class="col-lg-2 control-label">Provee*</label>
    <div class="col-md-6">
      <select class="form-control" required name="txtProvee">
				<option value="">--SELECCIONE--</option>
         <option value="Productos">Productos</option>
         <option value="Servicios">Servicios</option>
         <option value="Productos Y Servicios">Productos Y Servicios</option>
      </select>
    </div>
  </div>
	<div class="form-group">
    <label for="txtDireccion" class="col-lg-2 control-label">Direcci&oacute;n*</label>
    <div class="col-md-6">
      <input type="text" name="txtDireccion" class="form-control" required id="txtDireccion" placeholder="Direcci&oacute;n">
    </div>
  </div>
	<div class="form-group">
    <label for="txtTelefono" class="col-lg-2 control-label">Tel&eacute;fono*</label>
    <div class="col-md-6">
      <input type="text" name="txtTelefono" required class="form-control" id="txtTelefono" placeholder="N&uacute;mero De Tel&eacute;fono">
    </div>
  </div>
    <div class="form-group">
    <label for="txtCorreo" class="col-lg-2 control-label">Email</label>
    <div class="col-md-6">
      <input type="text" name="txtCorreo" class="form-control" id="txtCorreo" placeholder="Correo Electr&oacute;nico">
    </div>
  </div>
  <p class="alert alert-info">* Campos obligatorios</p>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
    </div>
  </div>
</form>
	</div>
</div>
