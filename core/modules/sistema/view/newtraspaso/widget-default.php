<?php
	$sucursales = SucursalData::getAll();

	$sucursalesDisponibles = array();
	foreach($sucursales as $suc){
		$usuarios = UserData::getAllBySucId($suc->id);
		if(count($usuarios) > 0){//Solamente aparecerán las sucursales donde se hayan creado usuarios previamente
			array_push($sucursalesDisponibles,$suc); 
		}
		// if($suc->id != 1){ //Si no es la principal
		// 	$usuarios = UserData::getAllBySucId($suc->id);
		// 	if(count($usuarios) > 0){//Solamente aparecerán las sucursales donde se hayan creado usuarios previamente
		// 		array_push($sucursalesDisponibles,$suc); 
		// 	}
		// }
	}
	
	if (count($sucursalesDisponibles) > 0) {
		$sucs = true;
	}

	include("modals/resumen.php");
?>
<?php if(isset($_SESSION["trasp"]) && count($_SESSION["trasp"])>0 && isset($_GET["x"])):?>
	<script type="text/javascript">
		$(function(){
			$("#btnResumen").click();
		});
	</script>
<?php endif; ?>
<script src="ajax/traspaso/ajax.js"></script>
<div class="row">
	<a href="index.php?view=traspasos" class="btn btn-default"><i class="fa fa-arrow-left fa-fw"></i>Regresar</a>
	<?php if ($sucs): ?>
	<div class="col-md-12">
		<h1>Realizar Traspaso De Productos</h1>
		<input type="hidden" name="sOrigen" id="sOrigen" value="<?php echo $_SESSION["usr_suc"]; ?>">
		<br>
		<p><b>Buscar producto por nombre o por descripci&oacute;n:</b></p>
		<div class="row">
			<div class="col-md-5 col-sm-6 col-xs-10">
				<div class="input-group">
					<input type="hidden" name="view" value="newtraspaso">
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
	</div>
	<div class="clearfix"></div>
	<br>
	<div class="col-md-12">
		<section id="tabla_resultado">
		</section>
	</div>
	<?php else: ?>
		<h1>No se pueden realizar traspasos</h1>
		<div class="jumbotron">
			<div class="container">
				<h4>Para realizar alg&uacute;n traspaso debe haber otra sucursal registrada o debe haber un usuario registrado en la sucursal de destino.</h4>
			</div>
		</div>
	<?php endif; ?>
</div>
