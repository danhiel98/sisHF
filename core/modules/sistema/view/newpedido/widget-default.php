<script type="text/javascript" src="ajax/pedido/ajax.js"></script>
<?php
	$sucursal = SucursalData::getAll();
	$clientes = ClientData::getAll();
	$servicios = ServiceData::getAll();
	$productos = ProductData::getAll();
	include("modals/resumen.php");
	if ((!count($productos) > 0 && !count($servicios) > 0) || !count($clientes)>0){
		@header("location: index.php?view=pedidos");
	}
?>

<div class="row">
	<div class="col-md-12">
		<a class="btn btn-default" href="index.php?view=pedidos"><i class="fa fa-arrow-left"></i> Regresar</a>
		<h1>Pedido</h1>
		<div class="btn-group pull-right">
			<button type="button" id="btnResumen" class="btn btn-default" data-toggle="modal" data-target="#resumen">
				<i class="fa fa-list"></i> Ver Resumen</span>
			</button>
		</div>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#prods">Productos</a></li>
			<li><a data-toggle="tab" href="#servs">Servicios</a></li>
		</ul>
		<div class="tab-content" id="resultado"></div>
	</div>
</div>
