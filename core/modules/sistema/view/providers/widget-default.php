<?php
	$provs =  false;
	include("modals/agregar.php");
	$providers = ProviderData::getAll();
	if (count($providers) > 0) {
		$provs = true;
		include("modals/editar.php");
	}
	$providers = ProviderData::getAll();
?>
<script src="ajax/providers/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-truck'></i> Registrar Proveedor</a>
			<?php if($provs): ?>
				<div class="btn-group pull-right">
	  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
	    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
	  			</button>
	  			<ul class="dropdown-menu" role="menu">
	    			<li><a href="report/proveedores.php "> Excel(.xmlx)</a></li>
	  			</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Directorio de Proveedores</h1>
		<br>
		<?php
		if($provs){
		?>
		<table class="table table-bordered table-hover">
			<thead>
				<th>Nombre</th>
				<th>Provee</th>
				<th>Direcci&oacute;n</th>
				<th>Tel&eacute;fono</th>
				<th>Correo Electr&oacute;nico</th>
				<th></th>
			</thead>
			<?php
			foreach($providers as $prov){
				?>
				<tr>
					<td><?php echo $prov->nombre; ?></td>
					<td><?php echo $prov->tipoprovee; ?></td>
					<td><?php echo $prov->direccion; ?></td>
					<td><?php echo $prov->telefono; ?></td>
					<td><?php echo $prov->correo; ?></td>
					<td style="width:40px;">
						<a id="<?php echo $prov->id;?>" data-toggle="modal" data-target="#editar" class="btn btn-warning btn-xs btn-edit">Editar</a>
					</td>
				</tr>
				<?php
			}
		}else{
			echo "<p class='alert alert-danger'>No hay proveedores registrados</p>";
		}
		?>
	</div>
</div>
