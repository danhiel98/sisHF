
<script src="ajax/devolucion/ajax.js"></script>
<div class="row">
	<div class="col-md-12">

		<div class="page-header">
    		<h1>Nueva Devoluci&oacute;n</h1>
		</div>
		
		<form class="form form-horizontal" action="index.php?view=adddevolucion">
			<div class="form-group control-group">
				<label for="numComprobante" class="col-lg-2 control-label">No. Comprobante:</label>
				<div class="col-lg-4 controls">
					<input name="numComprobante" id="numComprobante" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group control-group">
				<label for="cliente" class="col-lg-2 control-label">Cliente:</label>
				<div class="col-lg-4 controls">
					<input name="cliente" id="cliente" type="text" class="form-control" readonly>
				</div>
			</div>
			<div class="form-group control-group">
				<label for="comprobante" class="col-lg-2 control-label">Tipo Comprobante:</label>
				<div class="col-lg-4 controls">
					<input name="comprobante" id="comprobante" type="text" class="form-control" readonly>
				</div>
			</div>
			<div class="col-lg-12">
				<h2>Productos <small>Seleccione los productos que se van a devolver</small></h2>
			</div>
			<div id="resultadoProds"></div>
		</form>

  </div>
</div>