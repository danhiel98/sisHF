<?php

	include("modals/agregar.php");
	include("modals/editar.php");

?>
<script type="text/javascript" src="ajax/categorias/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-th-list'></i> Nueva Categor&iacute;a</a>
		</div>
		<h1>Categorías</h1>
		<br>
		<?php
		$cats = CategoryData::getAll();
		if(count($cats)>0){
			?>
			<table class="table table-bordered table-hover">
				<thead>
					<th style="width:80px;">No.</th>
					<th>Nombre</th>
					<th></th>
				</thead>
			<?php
			foreach($cats as $c){
				?>
				<tr>
					<td><?php echo $c->id; ?></td>
					<td><?php echo $c->nombre; ?></td>
					<td style="width:60px;">
						<a data-toggle="modal" data-target="#editar" id="<?php echo $c->id;?>" class="btn btn-warning btn-xs btn-edit">Editar</a>
						<!--<a href="index.php?view=delcategory&id=<?php #echo $c->id;?>" class="btn btn-danger btn-xs">Eliminar</a>-->
					</td>
				</tr>
				<?php
			}
		}else{
			echo "<p class='alert alert-danger'>No hay Categorías</p>";
		}
		?>
	</div>
</div>
