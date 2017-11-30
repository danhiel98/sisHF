<?php
	include("modals/agregar.php");
	include("modals/editar.php");
?>

<script src="ajax/sucursal/ajax.js"></script>

<!-- Se obtienen todas las sucursales registradas -->
<?php $sucursal = SucursalData::getAll(); ?>

<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='icon-office'></i> Registrar Sucursal</a>
			
			<!-- Si hay más de 0 sucursales: -->
			<?php if(count($sucursal) > 0): ?>
			
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-download"></i> Descargar <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="report/sucursales.php ">Excel (.xlsx)</a></li>
				</ul>
			</div>
			
			<?php endif; ?>

		</div>
		
		<h1>Lista De Sucursales</h1>
		<br>

		<!-- Si hay más de 0 sucursales: -->
		<?php if(count($sucursal)>0): ?>
		
		<table class="table table-bordered table-hover">
			<thead>
				<th style="text-align: center; width: 45px;">No.</th>
				<th>Nombre</th>
				<th>Direcci&oacute;n</th>
				<th style="width: 100px;">Tel&eacute;fono</th>
				<th></th>
			</thead>
			
			<?php foreach($sucursal as $suc): ?>
			
			<tr>
				<td style="text-align: center;"><?php echo $suc->id; ?></td>
				<td style="max-width: 140px;"><?php echo $suc->nombre; ?></td>
				<td style="max-width: 300px;"><?php echo $suc->direccion; ?></td>
				<td style="min-width:90px;"><?php echo $suc->telefono; ?></td>
				<td style="width:40px;">
					<a data-toggle="modal" data-target="#editar" id="<?php echo $suc->id;?>" class="btn btn-warning btn-xs btn-edit">Editar</a>
				</td>
			</tr>
			
			<?php endforeach; ?>

		</table>
		
		<?php
		else:
			echo "<p class='alert alert-danger'>No hay sucursales</p>";
		endif;
		?>
	</div>
</div>
