<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/MateriaPrimaData.php");
	include ("../../core/modules/sistema/model/ReabastecimientoMPData.php");
	#include ("../../core/modules/sistema/model/SucursalData.php");

	$matP = false;
	$materiaP = MateriaPrimaData::getAll();

	if(isset($_POST['productos'])){
		$matP = true;
		$materiaP = MateriaPrimaData::getLike($_POST['productos']);
	}

	if (count($materiaP)>0):
?>
		<table class="table table-bordered table-hover table-responsive">
			<thead>
				<th style="width: 45px;">ID</th>
				<th>Nombre</th>
				<th>Descripción</th>
				<th style="width:50px;">Existencias</th>
				<th style="width: 140px;">Comprar</th>
			</thead>
	<?php
		foreach ($materiaP as $mp):
			$found = false;
			#if ($mp->existencias > 0):
			?>
			<tr>
				<td><?php echo $mp->id; ?></td>
				<td><?php echo $mp->nombre; ?></td>
				<td><?php echo $mp->descripcion; ?></td>
				<td><?php echo $mp->existencias; ?></td>
				<td>
				<?php if(isset($_SESSION["productn"])){ foreach ($_SESSION["productn"] as $c) { if($c["product_id"] == $mp->id){ $found=true; break; }}} ?>
					<?php if ($found): ?>
						<a data-toggle="modal" data-target="#resumen" class="btn btn-info">Agregado</a>
					<?php else: ?>
						<form class="form-inline" method="post" action="index.php?view=addprodxn">
							<input type="hidden" name="product_id" value="<?php echo $mp->id; ?>">
							<div class="form-group control-group">
								<div class="controls">
									<input type="text" name="cantidad" value="1" style="width:80px;" min="1" class="form-control" placeholder="Cantidad" pattern="[\d]{1,8}" onkeypress="return soloNumeros(event)" maxlength="8" required>
									<button type="submit" id="<?php echo $mp->id; ?>" class="btn btn-sm btn-success"><i class="fa fa-cart-plus fa-fw"></i></button>
									<p class="help-block"></p>
								</div>
	  					</div>
						</form>
					<?php endif; ?>
					</td>
				</tr>
		<?php
			#endif; 
		endforeach;
		?>
		</table>
	<?php
	else:
	?>
		<div class="alert alert-danger">
		<?php if ($matP): ?>
				No se encontraron coincidencias con sus criterios de búsqueda.
		<?php else: ?>
				No hay productos disponibles en la sucursal actual.
		<?php endif; ?>
		</div>
	<?php
	endif;
?>
