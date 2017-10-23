<?php $products = ProductData::getAll(); ?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group  pull-right">
			<a href="index.php?view=newproduct" class="btn btn-default">Agregar Producto</a>
			<?php if (count($products)>0): ?>
				<div class="btn-group pull-right">
		  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
		  			</button>
		  			<ul class="dropdown-menu" role="menu">
		    			<li><a href="report/productos.php">Excel (.xlsx)</a></li>
		  			</ul>
			</div>
			<?php endif; ?>
		</div>
		<h1>Lista de Productos</h1>
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
					<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=products&limit=$limit&page=".($px); ?>"><i class="glyphicon glyphicon-chevron-left"></i> Atr&aacute;s </a>
				<?php endif; ?>
				<?php
				$px=$page+1;
				if($px<=$npaginas):
				?>
					<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=products&limit=$limit&page=".($px); ?>">Adelante <i class="glyphicon glyphicon-chevron-right"></i></a>
				<?php endif; ?>
			</div>
			<div class="clearfix"></div>
			<br>
			<table class="table table-bordered table-hover">
				<thead>
					<th>ID</th>
					<th style="width: 80px;">Imagen</th>
					<th>Nombre</th>
					<th>Descripci&oacute;n</th>
					<th>Categoría</th>
					<th style="width: 120px;">Precio Costeo</th>
					<th style="width: 110px;">Precio Venta</th>
					<th style="width: 100px;">Req. Mantto</th>
					<th></th>
				</thead>
				<?php foreach($curr_products as $product):?>
				<tr>
					<td style="width: 50px;"><?php echo $product->id; ?></td>
					<td>
						<?php if($product->imagen!=""):?>
							<img src="storage/products/<?php echo $product->imagen;?>" style="width:64px;">
						<?php endif;?>
					</td>
					<td><?php echo $product->nombre; ?></td>
					<td><?php echo $product->descripcion; ?></td>
					<td><?php echo $product->getCategory()->nombre; ?></td>
					<td>$ <?php echo number_format($product->preciocosteo,2,'.',','); ?></td>
					<td>$ <?php echo number_format($product->precioventa,2,'.',','); ?></td>
					<td style="text-align: center;"><span class="fa <?php if($product->mantenimiento){echo "fa-check";}else{echo "fa-times";} ?>"></span></td>
					<td style="width:30px;">
						<a href="index.php?view=editproduct&id=<?php echo $product->id; ?>" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
					</td>
				</tr>
				<?php endforeach;?>
			</table>
			<div class="btn-group pull-right">
			<?php
			for($i=0;$i<$npaginas;$i++){
				echo "<a href='index.php?view=products&limit=$limit&page=".($i+1)."' class='btn btn-default btn-sm'>".($i+1)."</a> ";
			}
			?>
			</div>
			<form class="form-inline">
				<label for="limit">L&iacute;mite</label>
				<input type="hidden" name="view" value="products">
				<input type="number" value=<?php echo $limit?> name="limit" style="width:60px;" class="form-control">
			</form>
			<div class="clearfix"></div>
	<?php
	}else{
	?>
		<div class="">
			<h2>No hay productos</h2>
			<div class="alert alert-danger">
				No se han agregado productos a la base de datos, puedes agregar uno dando click en el bot&oacute;n <strong>"Agregar Producto".</strong>
			</div>
		</div>
	<?php
	}
	?>
		<br>
	</div>
</div>
