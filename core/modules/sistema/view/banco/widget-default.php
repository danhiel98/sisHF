<?php
	include 'modals/agregar.php';
	include 'modals/editar.php';
	$banco = BancoData::getAll();
?>
<script src="ajax/bancos/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-smile-o'></i> Registrar Banco </a>
			<?php if(count($banco) > 0): ?>
				<div class="btn-group pull-right">
	  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
	    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
	  			</button>
	  			<ul class="dropdown-menu" role="menu">
	    			<li><a href="report/banco.php">Excel (.xlsx)</a></li>
	  			</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Bancos Registrados</h1>
		<br>
		<?php
		if(count($banco)>0){
		?>
		<table class="table table-bordered table-hover">
			<thead>
				<th>Nombre</th>
				<th>Direcci&oacute;n</th>
				<th>Tel&eacute;fono</th>
				<th></th>
			</thead>
			<?php
			foreach($banco  as $bac){
				?>
			<tr>
				<td><?php echo $bac->nombre; ?></td>
				<td><?php echo $bac->direccion; ?></td>
				<td><?php echo $bac->telefono; ?></td>
				<td style="width:40px;">
					<a id="<?php echo $bac->id;?>" data-toggle="modal" data-target="#editar" class="btn btn-warning btn-xs btn-edit">Editar</a>
				</td>
			</tr>
				<?php
			}
		}else{
			echo "<p class='alert alert-danger'>No hay bancos registrados</p>";
		}
		?>
	</div>
</div>
