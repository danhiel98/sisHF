<?php
	$user = UserData::getById(Session::getUID());
	$idSuc = $_SESSION["usr_suc"];
	$products = ProductData::getAll();
	$matPrim = MateriaPrimaData::getAll();
?>
<div class="row">
	<div class="col-md-12">
		<!-- Single button -->
		<div class="btn-group pull-right">
			<?php if(count($products) > 0): ?>
				<?php if ($idSuc == 1 && $user->getUserType()->id != 3): ?>
				<a href="index.php?view=newproducn" class="btn btn-default"><i class="icon-plus"></i> Agregar a producción</a>
				<?php endif; ?>
			<?php endif; ?>
			<?php if (count($products)>0): ?>
			<a class="btn btn-default" href="report/inventarioproducto.php"><i class="fa fa-download fa-fw"></i> Descargar</a>
			<?php endif; ?>
		</div>
		<h1><i class="glyphicon glyphicon-stats"></i> Inventario De Productos</h1>
		<div class="clearfix"></div>
		<?php
		$page = 1;
		if(isset($_GET["page"])){
			$page=$_GET["page"];
		}
		$limit=10;
		if(isset($_GET["limit"]) && $_GET["limit"]!="" && $_GET["limit"]!=$limit){
			$limit=$_GET["limit"];
		}
		if(count($products)>0){

			if($page==1){
				$curr_products = ProductData::getAllByPage($products[0]->id,$limit);
			}else{
				$curr_products = ProductData::getAllByPage($products[($page-1)*$limit]->id,$limit);
			}
			$npaginas = floor(count($products)/$limit);
			$spaginas = count($products)%$limit;

			if($spaginas>0){ $npaginas++;}
?>

	<h3>P&aacute;gina <?php echo $page." de ".$npaginas; ?></h3>
	<div class="btn-group pull-right">
	<?php
		$px=$page-1;
		if($px>0):
	?>
		<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=inventaryprod&limit=$limit&page=".($px); ?>"><i class="glyphicon glyphicon-chevron-left"></i> Atr&aacute;s </a>
	<?php endif; ?>

	<?php
		$px=$page+1;
		if($px<=$npaginas):
	?>
	<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=inventaryprod&limit=$limit&page=".($px); ?>">Adelante <i class="glyphicon glyphicon-chevron-right"></i></a>
	<?php endif; ?>
	</div>
	<div class="clearfix"></div>
	<br>
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<th>No.</th>
				<th>Nombre</th>
				<th>Descripci&oacute;n</th>
				<?php if ($idSuc == 1): ?>
				<th>Mínimo</th>
				<?php endif; ?>
				<th>Existencias</th>
				<th>Total Existencias</th>
				<th></th>
			</thead>
			<?php foreach($curr_products as $product):?>
				<?php
					$prodSuc = new ProductoSucursalData();
					$productoSucursal = $prodSuc->getBySucursalProducto($_SESSION["usr_suc"],$product->id);
					$prods = $prodSuc->getAllByProductId($product->id);
					$total = 0;
					foreach ($prods as $p) {
						$total += $p->cantidad;
					}
				?>
			<tr>
				<td><?php echo $product->id; ?></td>
				<td><?php echo $product->nombre; ?></td>
				<td><?php echo $product->descripcion; ?></td>
				<?php if ($idSuc == 1): ?>
				<td><?php echo $productoSucursal->minimo; ?></td>
				<?php endif; ?>
				<td><?php echo $productoSucursal->cantidad; ?></td>
				<td><?php echo $total; ?></td>
				<td style="width:40px;">
					<a href="index.php?view=detailprod&idProd=<?php echo $product->id; ?>" class="btn btn-default btn-sm"><i class="fa fa-bars fa-fw"></i> Detalles</a>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
	</div>	

	<div class="btn-group pull-right">
	<?php

	for($i=0;$i<$npaginas;$i++){
		echo "<a href='index.php?view=inventaryprod&limit=$limit&page=".($i+1)."' class='btn btn-default btn-sm'>".($i+1)."</a> ";
	}
	?>
	</div>
	<form class="form-inline control-group">
		<div class="controls">
			<label for="limit">Límite</label>
			<input type="hidden" name="view" value="inventaryprod">
			<input type="number" min="1" value=<?php echo $limit?> name="limit" style="width:60px;" class="form-control" maxlength="6">
		</div>
	</form>

	<div class="clearfix"></div>

		<?php
	}else{
		?>
		<div class="alert alert-warning">
			No hay productos.
		</div>
		<div class="alert alert-info">
			No se han agregado productos<?php if($idSuc == 1): ?>, puede agregar uno <a href="index.php?view=products">aqu&iacute;</a><?php endif; ?>.
		</div>
		<?php
	}
	?>
		<br><br><br><br><br>
	</div>
</div>
