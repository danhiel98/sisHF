<script type="text/javascript" src="ajax/sell/ajax.js"></script>
<?php
	$clientes = ClientData::getAll();
	include("modals/resumen.php");
	$sucursal = SucursalData::getAll();
	$servicios = ServiceData::getAll();
?>
<!--crea este apartado-->
<?php if(isset($_SESSION["cart"]) && count($_SESSION["cart"])>0 && isset($_GET["x"])):?>
	<script type="text/javascript">
		$(function(){
			$("#btnResumen").click();
		});
	</script>
<?php endif; ?>
<div class="row">
	<div class="col-md-12">
		<h1>Venta</h1>
		<div class="btn-group pull-right">
			<button type="button" id="btnResumen" class="btn btn-default" data-toggle="modal" data-target="#resumen">
				<i class="fa fa-list"></i> Ver Resumen</span>
			</button>
		</div>
		<input type="hidden" name="sOrigen" id="sOrigen" value="<?php echo $_SESSION["usr_suc"]; ?>">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#prods">Productos</a></li>
			<li><a href="#servs">Servicios</a></li>
		</ul>
		<div class="tab-content">
			<div id="prods" class="tab-pane fade in active">
				<p><b>Buscar producto por nombre o por descripci&oacute;n:</b></p>
				<div class="row">
					<div class="col-md-5 col-sm-6 col-xs-10">
						<div class="input-group">
							<input type="text" name="product" id="busqueda" placeholder="Buscar producto" class="form-control" autofocus>
							<span class="input-group-addon"><i class="fa fa-search fa-fw"></i>Buscar</span>
						</div>
					</div>
					<div class="clearfix"></div>
					<br>
					<div class="col-md-12">
						<div id="tabla_resultado">
						</div>
					</div>
				</div>
			</div>
			<div id="servs" class="tab-pane fade">
				<p><b>Agregar servicio a la venta</b></p>
				<br>
				<div class="col-md-12" id="resultado_srv">
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".nav-tabs a").click(function(){
			$(this).tab('show');
		});
	});
</script>
