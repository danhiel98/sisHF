<div class="row">
	<div class="col-md-12">
		<h1>Agregar Materia Prima</h1>
		<br>
		<form class="form-horizontal" method="post" id="addMateriaPrima" action="index.php?view=addmateriaprima" role="form">
		  <div class="form-group">
		    <label for="txtNombre" class="col-lg-2 control-label">Nombre*</label>
		    <div class="col-md-6">
		      <input type="text" name="txtNombre" required class="form-control" id="txtNombre" placeholder="Nombre Del Producto">
		    </div>
		  </div>
			<div class="form-group">
		    <label for="txtDireccion" class="col-lg-2 control-label">Descripci&oacute;n*</label>
		    <div class="col-md-6">
		      <input type="text" name="txtDescripcion" class="form-control" required id="txtDescripcion" placeholder="Descripci&oacute;n">
		    </div>
		  </div>
	  	<p class="alert alert-info">* Campos obligatorios</p>
	  	<div class="form-group">
	    	<div class="col-lg-offset-2 col-lg-10">
	      	<button type="submit" class="btn btn-primary">Agregar Materia Prima</button>
	    	</div>
	  	</div>
		</form>
	</div>
</div>
