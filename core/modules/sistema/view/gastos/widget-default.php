<?php
	include("modals/agregar.php");
	include("modals/editar.php");
	$gastos = GastoData::getAll();
?>
<script type="text/javascript" src="ajax/gasto/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-dollar'></i> Registrar Gasto</a>
			<?php if(count($gastos) > 0) :?>
				<div class="btn-group pull-right">
				  	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				    	<i class="fa fa-download"></i> Descargar <span class="caret"></span>
				  	</button>
				  	<ul class="dropdown-menu" role="menu">
				    	<li><a href="report/gastos.php">Excel (.xlsx)</a></li>
				  	</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Gastos Realizados</h1>
		<br>
		<?php
		if(count($gastos)>0){
			?>
			<table class="table table-bordered table-hover">
			<thead>
				<th>Descripci&oacute;n</th>
				<th>Valor</th>
				<th>No. Comprobante</th>
				<th>Fecha</th>
				<th></th>
			</thead>
			<?php
			foreach($gastos as $gasto){
				?>
			<tr>
				<td><?php echo $gasto->descripcion; ?></td>
				<td>$ <?php echo $gasto->pago; ?></td>
				<td><?php echo $gasto->comprobante; ?></td>
				<td><?php echo $gasto->fecha; ?></td>
				<td style="width:60px;">
					<a data-toggle="modal" data-target="#editar" id="<?php echo $gasto->id;?>" class="btn btn-warning btn-xs btn-edit">Editar</a>
				</td>
			</tr>
				<?php
			}
		}else{
			echo "<p class='alert alert-danger'>No se han realizado gastos</p>";
		}
		?>
	</div>
</div>
