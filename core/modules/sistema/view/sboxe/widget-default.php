<?php

if (isset($_GET["val"]) && $_GET["val"] == "ent" || $_GET["val"] == "sal") {
	$accion = $_GET["val"];
}else{
	echo "<script>window.location = 'index.php?view=sbox'</script>";
}

?>
<div class="row">
	<div class="col-md-12">
		
		<?php if($accion == "ent"): ?>
		<a class="btn btn-default" href="index.php?view=sbox"><i class="fa fa-arrow-left"></i> Regresar</a>
		<div class="btn-group pull-right">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    		<i class="fa fa-download"></i> Descargar <span class="caret"></span>
  		</button>
  		<ul class="dropdown-menu" role="menu">
    		<li><a href="report/cajaChicaIngreso.php">Excel (.xlsx)</a></li>
  		</ul>
		</div>
		<h1><i class='fa fa-archive'></i> Entradas De Dinero En Caja Chica</h1>
		<?php
			$ingresos = CajaChicaData::getIngresos();
			if (count($ingresos) > 0) {
		?>
		<table class="table table-bordered table-hover">
			<thead>
				<th>No.</th>
				<th>Ingresada Por</th>
				<th>Cantidad</th>
				<th>Fecha</th>
				<th></th>
			</thead>
			<?php foreach ($ingresos as $ing): ?>
			<tr>
				<td><?php echo $ing->id; ?></td>
				<td><?php echo $ing->getUsuario()->name." ".$ing->getUsuario()->lastname; ?></td>
				<td><strong>$ <?php echo number_format($ing->cantidad, 2,'.',','); ?></strong></td>
				<td><?php echo $ing->fecha; ?></td>
				<td style="width:40px;"><a class="btn btn-warning btn-xs">Editar</a></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php
			}else{
				echo "<div class='alert alert-warning'>No se han realizado ingresos a la caja chica</div>";
			}
		?>
		<?php elseif($accion == "sal"): ?>

		<a class="btn btn-default" href="index.php?view=sbox"><i class="fa fa-arrow-left"></i> Regresar</a>
		<div class="btn-group pull-right">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    		<i class="fa fa-download"></i> Descargar <span class="caret"></span>
  		</button>
  		<ul class="dropdown-menu" role="menu">
    		<li><a href="report/cajaChicaSalida.php">Excel (.xlsx)</a></li>
  		</ul>
		</div>
		
		<h1><i class='fa fa-archive'></i> Salidas De Dinero De Caja Chica</h1>
		<?php
			$salidas = CajaChicaData::getSalidas();
			if (count($salidas) > 0){
		?>
		<table class="table table-bordered table-hover">
			<thead>
				<th>No.</th>
				<th>Registrada Por</th>
				<th>Realizada Por</th>
				<th>Cantidad</th>
				<th>Descripci&oacute;n</th>
				<th>Fecha</th>
				<th></th>
			</thead>
			<?php foreach ($salidas as $sal): ?>
			<tr>
				<td><?php echo $sal->id; ?></td>
				<td><?php echo $sal->getUsuario()->name." ".$sal->getUsuario()->lastname; ?></td>
				<td>
					<?php if ($sal->idempleado != null){ echo $sal->getEmpleado()->nombre." ".$sal->getEmpleado()->apellido;}; ?>
				</td>
				<td><strong>$ <?php echo number_format($sal->cantidad,2,".",","); ?></strong></td>
				<td><?php echo $sal->descripcion; ?></td>
				<td><?php echo $sal->fecha; ?></td>
				<td style="width:40px;"><a class="btn btn-warning btn-xs">Editar</a></td>
			</tr>
			<?php endforeach; ?>
			<?php
		}else{
			echo "<div class='alert alert-warning'>No se han realizado salidas de la caja chica</div>";
		}
			?>
		</table>
		<?php endif; ?>
		<div class="clearfix"></div>
		<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>
