<?php
	$gasto = GastoData::getById($_GET["id"]);
?>
<div class="row">
	<div class="col-md-12">
	<h1>Modificar Gasto</h1>
	<br>
		<form class="form-horizontal" method="post" id="addgasto" action="index.php?view=updategasto" role="form">
		  <div class="form-group">
		    <label for="descripcion" class="col-lg-2 control-label">Descripci&oacute;n*</label>
		    <div class="col-md-6">
		      <input type="text" name="descripcion" required class="form-control" id="descripcion" placeholder="Descripci&oacute;n Del Gasto" value="<?php echo $gasto->descripcion; ?>">
		    </div>
		  </div>
		   <div class="form-group">
		    <label for="pago" class="col-lg-2 control-label">Cantidad $*</label>
		    <div class="col-md-6">
		      <input type="text" name="pago" required class="form-control" id="pago" placeholder="Cantidad A Pagar" value="<?php echo $gasto->pago; ?>">
		    </div>
		  </div>
			<input type="hidden" name="idGasto" value="<?php echo $gasto->id; ?>">
		  <p class="alert alert-info">* Campos obligatorios</p>
		  <div class="form-group">
		    <div class="col-lg-offset-2 col-lg-10">
		      <button type="submit" class="btn btn-primary">Actualizar Gasto</button>
		    </div>
		  </div>
		</form>
	</div>
</div>
