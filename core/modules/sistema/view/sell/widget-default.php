<script type="text/javascript" src="ajax/sell/ajax.js"></script>
<?php
	$clientes = ClientData::getAll();
    $servs = ServiceData::getAll();
	$prods = ProductoSucursalData::getAllForSell($_SESSION["usr_suc"]);

    count($clientes) > 0 ? $clients = true : $clients = false;
    count($prods) > 0 ? $products = true : $products = false;
	count($servs) > 0 ? $services = true : $services = false;

	if((!$services && !$products) || !$clientes){
		@header("location: index.php?view=sells");
	}
	
	include("modals/resumen.php");
?>

<div class="row">
	<div class="col-md-12">
		<a href="index.php?view=sells" class="btn btn-default"><i class="fa fa-arrow-left fa-fw"></i>Regresar</a>
		<h1>Venta</h1>
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