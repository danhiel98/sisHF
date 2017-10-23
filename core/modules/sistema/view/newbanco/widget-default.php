<div class="row">
	<div class="col-md-12">
	<h1>Nuevo Banco</h1>
	<br>
		<form class="form-horizontal" method="post" id="addBanco" action="index.php?view=addbanco" role="form">

  <div class="form-group">
    <label for="txtNombre" class="col-lg-2 control-label">Nombre</label>
    <div class="col-md-6">
      <input type="text" name="txtNombre" class="form-control" id="txtNombre" placeholder="Nombre Del Banco">
    </div>
  </div>
  <div class="form-group">
    <label for="txtDireccion" class="col-lg-2 control-label">Direcci&oacute;n</label>
    <div class="col-md-6">
      <input type="text" name="txtDireccion" class="form-control" id="txtDireccion" placeholder="Direcci&oacute;n">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Tel&eacute;fono*</label>
    <div class="col-md-6">
      <input type="text" name="txtPhone" class="form-control" id="txtPhone" placeholder="Tel&eacute;fono">
    </div>
  </div>

  <p class="alert alert-info">* Campos obligatorios</p>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Banco</button>
    </div>
  </div>
</form>
	</div>
</div>
