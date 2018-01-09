<?php
	$idSuc = $_SESSION["usr_suc"];
	$proveedores = ProviderData::getAll();
	
	$provs = false;
	$prods = false;

?>
<script type="text/javascript" src="ajax/buy/ajax.js"></script>
<div class="datosModal">
</div>
<a href="index.php?view=inventarymp" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
<div class="row">
	<div class="col-md-12">
		<h1>Compra de materia prima</h1>
		
		<?php if (count($proveedores) > 0): ?>

		<p><b>Buscar producto por nombre o por descripci&oacute;n:</b></p>
		<div class="row">
			<div class="col-md-5 col-sm-6 col-xs-10">
				<div class="input-group">
					<input type="text" name="product" id="busqueda" placeholder="Buscar producto" class="form-control" autofocus>
					<span class="input-group-addon"><i class="fa fa-search fa-fw"></i>Buscar</span>
				</div>
			</div>
			<div class="btn-group pull-right">
				<button type="button" id="btnResumen" class="btn btn-default" data-toggle="modal" data-target="#resumen">
					<i class="fa fa-list"></i> Ver Resumen</span>
				</button>
			</div>
		</div>
		<div class="clearfix"></div>
		<br>
		<section id="resultado"></section>

		<?php else: ?>
		<div class="alert alert-warning">
			Primero debe registrar un <a href="index.php?view=providers">proveedor</a>.
		</div>
		<?php endif; ?>

	</div>
</div>
