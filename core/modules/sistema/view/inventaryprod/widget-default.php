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
			if(count($products) > 0){
				$start = 1; $limit = 10;
				if(isset($_REQUEST["start"]) && isset($_REQUEST["limit"])){
					$start = $_REQUEST["start"];
					$limit = $_REQUEST["limit"];
					#Para evitar que se muestre un error, se valida que los valores enviados no sean negativos
					if ($start <= 0 ){
						$start = 1;
					}
					if ($limit <= 0 ){
						$limit = 1;
					}
				}
				$paginas = floor(count($products)/$limit);
				$spaginas = count($products)%$limit;
				if($spaginas>0){$paginas++;}
				$products = ProductData::getAllByPage($start,$limit);
				$num = $start;
		?>

		<div class="clearfix"></div>
		<br>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nombre</th>
						<th>Descripci&oacute;n</th>
						<?php if ($idSuc == 1): ?>
						<th>Mínimo</th>
						<?php endif; ?>
						<th>Existencias</th>
						<th>Total Existencias</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($products as $product):?>
						<?php
							$prodSuc = new ProductoSucursalData();
							$productoSucursal = $prodSuc->getBySucursalProducto($_SESSION["usr_suc"],$product->id);
							$prods = $prodSuc->getAllByProductId($product->id);
							$total = 0;
							foreach ($prods as $p) {
								$total += $p->cantidad;
							}
						?>
						<tr <?php if($productoSucursal->cantidad <= $productoSucursal->minimo){echo "class='warning'";} ?>>
							<td><?php echo $num++; ?></td>
							<td><?php echo $product->nombre; ?></td>
							<td><?php echo $product->descripcion; ?></td>
							<?php if ($idSuc == 1): ?>
							<td><?php echo $productoSucursal->minimo; ?></td>
							<?php endif; ?>
							<td><?php echo $productoSucursal->cantidad; ?></td>
							<td><?php echo $total; ?></td>
							<td style="width:40px;">
								<a href="index.php?view=detailprod&idProd=<?php echo $product->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-bars fa-fw"></i> Detalles</a>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
		<div class="container-fluid">
			<div class="pull-right">
				<ul class="pagination">
					<?php if($start != 1):?>
					<?php
						$prev = "#";
						if($start != 1){
							$prev = "&start=".($start-$limit)."&limit=".$limit;
						}
					?>
					<li class="previous"><a href="index.php?view=inventaryprod<?php echo $prev; ?>">&laquo;</a></li>
					<?php endif; ?>
					<?php 
						$anterior = 1;
						for($i=1; $i<=$paginas; $i++):
							$inicio = 1;
							if ($i != 1){
								$inicio = $limit + $anterior;
								$anterior = $inicio;
							}
						?>
						<li <?php if($start == $inicio){echo "class='active'";} ?>>
							<a href="index.php?view=inventaryprod&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
						</li>
						<?php
						endfor;
					?>
					<?php if($start != $anterior): ?>
					<?php 
						$next = "#";
						if($start != $anterior){
							$next = "&start=".($start + $limit)."&limit=".$limit;
						}
					?>
					<li class="previous"><a href="index.php?view=inventaryprod<?php echo $next; ?>">&raquo;</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
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
	</div>
</div>
