<?php $service = ServiceData::getById($_GET["id"]);?>
<div class="row">
	<div class="col-md-12">
	<h1>Modificar Servicio</h1>
	<br>
		<form class="form-horizontal" method="post" id="addservice" action="index.php?view=updateservice" role="form">
		  <div class="form-group">
		    <label for="nombre" class="col-lg-2 control-label">Nombre*</label>
		    <div class="col-md-6">
		      <input type="text" name="nombre" required class="form-control" id="nombre" placeholder="Nombre Del Servicio" value="<?php echo $service->nombre; ?>">
		    </div>
		  </div>
		   <div class="form-group">
		    <label for="descripcion" class="col-lg-2 control-label">Descripci&oacute;n*</label>
		    <div class="col-md-6">
		      <input type="text" name="descripcion" required class="form-control" id="descripcion" placeholder="Descripci&oacute;n Del Servicio" value="<?php echo $service->descripcion; ?>">
		    </div>
		  </div>
			<div class="form-group">
		    <label for="precio" class="col-lg-2 control-label">Precio*</label>
		    <div class="col-md-6">
		      <input type="text" name="precio" class="form-control" required id="precio" placeholder="Precio" value="<?php echo $service->precio; ?>">
		    </div>
		  </div>
			<input type="hidden" name="idServicio" value="<?php echo $service->id; ?>">
		  <p class="alert alert-info">* Campos obligatorios</p>
		  <div class="form-group">
		    <div class="col-lg-offset-2 col-lg-10">
		      <button type="submit" class="btn btn-primary">Modificar Servicio</button>
		    </div>
		  </div>
		</form>
	</div>
</div>
