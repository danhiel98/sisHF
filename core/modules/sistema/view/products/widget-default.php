<?php 
	$idSuc = $_SESSION["usr_suc"];
	$products = ProductData::getAll();
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<?php if ($idSuc == 1): ?>
			<a href="index.php?view=newproduct" class="btn btn-default"><i class="fa fa-glass fa-fw"></i> Agregar Producto</a>
			<?php endif; ?>
			<?php if (count($products)>0): ?>
				<div class="btn-group pull-right">
					<a class="btn btn-default" href="report/productos.php"><i class="fa fa-download fa-fw"></i> Descargar</a>
				</div>
			<?php endif; ?>
		</div>
		
		<h1>Lista de Productos</h1>
		<div class="clearfix"></div>
		
		<?php
		if(count($products)>0):
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
						<th style="width: 80px;">Imagen</th>
						<th>Nombre</th>
						<th>Descripci&oacute;n</th>
						<th>Categoría</th>
						<th style="width: 120px;">Precio Costeo</th>
						<th style="width: 110px;">Precio Venta</th>
						<th style="width: 100px;">Req. Mantto</th>
						<?php if ($idSuc == 1): ?>
						<th></th>
					</tr>
					<?php endif; ?>
				</thead>
				<?php foreach($products as $product):?>
				<tr>
					<td style="width: 50px;"><?php echo $num++; ?></td>
					<td>
						<?php if($product->imagen !="" && file_exists("storage/products/".$product->imagen)):?>
							<img src="storage/products/<?php echo $product->imagen;?>" style="width:64px;">
						<?php endif;?>
					</td>
					<td><?php echo $product->nombre; ?></td>
					<td><?php echo $product->descripcion; ?></td>
					<td><?php echo $product->getCategory()->nombre; ?></td>
					<td>$ <?php echo number_format($product->preciocosteo,2,'.',','); ?></td>
					<td>$ <?php echo number_format($product->precioventa,2,'.',','); ?></td>
					<td style="text-align: center;"><span class="fa <?php if($product->mantenimiento){echo "fa-check";}else{echo "fa-times";} ?>"></span></td>
					<?php if ($idSuc == 1): ?>
					<td style="width:30px;">
						<a href="index.php?view=editproduct&id=<?php echo $product->id; ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
					</td>
					<?php endif; ?>
				</tr>
				<?php endforeach;?>
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
					<li class="previous"><a href="index.php?view=products<?php echo $prev; ?>">&laquo;</a></li>
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
							<a href="index.php?view=products&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
					<li class="previous"><a href="index.php?view=products<?php echo $next; ?>">&raquo;</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="clearfix"></div>
	<?php else: ?>
		<div class="col-md-12">
			<div class="alert alert-warning">
				No hay productos.
			</div>
			<div class="alert alert-info">
				No se han agregado productos a la base de datos<?php if($idSuc == 1): ?>, puede agregar uno dando clic en el bot&oacute;n <strong>"Agregar Producto"</strong><?php endif; ?>.
			</div>
		</div>
	<?php endif; ?>
		<br>
	</div>
</div>
