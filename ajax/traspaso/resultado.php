<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ProductoSucursalData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");


	$idSucursal = $_POST["sucursal"];
	$prod = false;

	$prodSuc = ProductoSucursalData::getAllBySucId($idSucursal);

	if(isset($_POST['productos'])){
		$prod = true;
		$prodSuc = array();
		$prodx = ProductData::getLike($_POST['productos']);
		if (count($prodx)>0) {
			foreach ($prodx as $pr) {
				$ps = ProductoSucursalData::getBySucursalProducto($idSucursal,$pr->id);
				if ($ps != null) {
					array_push($prodSuc,$ps);
				}
			}
		}
	}

	if (count($prodSuc)>0):
		$_SESSION["origen"] = $idSucursal;
?>
		<table class="table table-bordered table-hover table-responsive">
			<thead>
				<th style="width: 45px;">ID</th>
				<th>Nombre</th>
				<th>Descripción</th>
				<th>Existencias</th>
				<th style="width: 140px;"></th>
			</thead>
	<?php
		foreach ($prodSuc as $pr):
			$found = false;
			?>
			<tr>
				<td><?php echo $pr->getProduct()->id; ?></td>
				<td><?php echo $pr->getProduct()->nombre; ?></td>
				<td><?php echo $pr->getProduct()->descripcion; ?></td>
				<td><?php echo $pr->cantidad; ?></td>
				<td>
				<?php if(isset($_SESSION["trasp"])){ foreach ($_SESSION["trasp"] as $c) { if($c["product_id"] == $pr->getProduct()->id){ $found=true; break; }}} ?>
					<?php if ($found): ?>
						<a data-toggle="modal" data-target="#resumen" class="btn btn-info">Agregado</a>
					<?php else: ?>
						<form class="form-inline" method="post" action="index.php?view=addexchange">
							<input type="hidden" name="product_id" value="<?php echo $pr->getProduct()->id; ?>">
							<div class="form-group control-group">
								<div class="controls">
									<input type="text" class="form-control input-sm" name="cantidad" value="1" style="max-width: 70px;" min="1" max="<?php echo $pr->cantidad; ?>" placeholder="Cantidad" pattern="[\d]{1,8}" onkeypress="return soloNumeros(event)" maxlength="8" required>
									<button type="submit" class="btn btn-sm btn-success" id="<?php echo $pr->getProduct()->id; ?>"><i class="fa fa-cart-plus fa-fw"></i></button>
									<p class="help-block"></p>
								</div>
	  						</div>
						</form>
					<?php endif; ?>
					</td>
				</tr>
	<?php
		endforeach;
	?>
		</table>
	<?php
	else:
	?>
		<div class="alert alert-danger">
		<?php if ($prod): ?>
				No se encontraron coincidencias con sus criterios de búsqueda.
		<?php else: ?>
				No hay productos disponibles en la sucursal actual.
		<?php endif; ?>
		</div>
	<?php
	endif;
?>
