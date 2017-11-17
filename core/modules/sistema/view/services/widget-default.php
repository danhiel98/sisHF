<?php
	$services = ServiceData::getAll();
	include("modals/agregar.php");
	include("modals/editar.php");
	$services = ServiceData::getAll();
?>
<script type="text/javascript" src="ajax/servicio/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-th'></i> Registrar Servicio</a>
			<?php if(count($services) > 0): ?>
			<div class="btn-group pull-right">
		  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
		  			</button>
		  			<ul class="dropdown-menu" role="menu">
		    			<li><a href="report/servicios.php">Excel (.xlsx)</a></li>
		  			</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Lista De Servicios</h1>
		<br>
		<?php
			if(count($services)>0){
				// si hay usuarios
		?>

			<table class="table table-bordered table-hover">
			<thead>
				<th style="width: 45px;">No.</th>
				<th>Nombre</th>
				<th>Descripci&oacute;n</th>
				<th>Precio</th>
				<th></th>
			</thead>
			<?php
			foreach($services as $service){
				?>
				<tr>
					<td><?php echo $service->id; ?></td>
					<td><?php echo $service->nombre; ?></td>
					<td><?php echo $service->descripcion; ?></td>
					<td><strong>$ <?php echo $service->precio; ?></strong></td>
					<td style="width:40px;">
						<a data-toggle="modal" data-target="#editar" id="<?php echo $service->id;?>" class="btn btn-warning btn-xs btn-edit">Editar</a>
						<!--<a onclick="return confirm('¿Seguro que desea eliminar el registro?')" href="index.php?view=delservice&id=<?php echo $service->id;?>" class="btn btn-danger btn-xs">Eliminar</a>-->
					</td>
				</tr>
				<?php

			}
		}else{
			echo "<p class='alert alert-danger'>No hay servicios registrados</p>";
		}
		?>
	</div>
</div>
