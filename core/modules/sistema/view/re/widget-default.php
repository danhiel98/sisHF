<?php
	#$clientes = ClientData::getAll();
	$proveedores = ProviderData::getAll();
	//include("modals/resumen.php");
	#$sucursal = SucursalData::getAll();
?>
<script type="text/javascript" src="ajax/buy/ajax.js"></script>
<div class="datosModal">
</div>
<div class="row">
	<div class="col-md-12">
		<h1>Compra de materia prima</h1>
		<p><b>Buscar producto por nombre o por descripci&oacute;n:</b></p>
		<form>
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
		</form>
	</div>
	<div class="clearfix"></div>
	<br>
	<div class="col-md-12">
		<section id="resultado">
		</section>
	</div>
</div>
