<?php
	
	$materiaP = MateriaPrimaData::getAll();
	include('modals/agregar.php');
	include('modals/editar.php');
	$providers = ProviderData::getAll();

	$matP = false; #Verificar si se ha agregado materia prima al inventario
	$provs = false; #Verifiar si se han agregado proveedores

	if (count($materiaP)>0){
		$matP = true;
	}

	if (count($providers)>0){
		$provs = true;
	}
	$u = UserData::getById(Session::getUID());
?>
<script src="ajax/matprim/mpajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-plus'></i> Agregar Materia Prima</a>
			<?php if ($matP): ?>
			<?php if ($_SESSION["usr_suc"] == 1 && ($u->tipo == 1 || $u->tipo == 2 || $u->tipo == 3)): ?>
			<a href="index.php?view=re" class="btn btn-default"><i class='fa fa-shopping-cart'></i> Realizar Compra</a>
			<?php endif; ?>  
			<div class="btn-group pull-right">
  				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-download"></i> Descargar <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="report/materiaPrima.php">Excel (.xlsx)</a></li>
				</ul>
  			</div>
			<?php endif; ?>
			
		</div>

		<h1><i class="glyphicon glyphicon-stats"></i> Inventario De Materia Prima</h1>
		<div class="clearfix"></div>
		<?php
		
		$page = 1;
		if(isset($_GET["page"])){
			$page=$_GET["page"];
		}

		$limit = 10;
		if(isset($_GET["limit"]) && $_GET["limit"]!="" && $_GET["limit"]!=$limit){
			$limit=$_GET["limit"];
		}
		
		if($matP){

			if($page == 1){
				$curr_products = MateriaPrimaData::getAllByPage($materiaP[0]->id,$limit);
			}else{
				$curr_products = MateriaPrimaData::getAllByPage($materiaP[($page-1)*$limit]->id,$limit);
			}

			$npaginas = floor(count($materiaP)/$limit);
			$spaginas = count($materiaP) % $limit;

			if($spaginas>0){ $npaginas++;}
		?>

		<h3>P&aacute;gina <?php echo $page." de ".$npaginas; ?></h3>
		<div class="btn-group pull-right">
		<?php
			$px = $page-1;
			if($px>0):
		?>
			<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=inventarymp&limit=$limit&page=".($px); ?>"><i class="glyphicon glyphicon-chevron-left"></i> Atr&aacute;s </a>
		<?php endif; ?>
		<?php
			$px=$page+1;
			if($px<=$npaginas):
		?>
			<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=inventarymp&limit=$limit&page=".($px); ?>">Adelante <i class="glyphicon glyphicon-chevron-right"></i></a>
			<?php endif; ?>
		</div>
		<div class="clearfix"></div>
			<br>
			<table class="table table-bordered table-hover">
				<thead>
					<th style="width:30px;">No.</th>
					<th>Nombre</th>
					<th>Descripci&oacute;n</th>
					<th style="width: 30px;">M&iacute;nimo</th>
					<th style="width: 30px;">Existencias</th>
					<th></th>
				</thead>
				<?php foreach($curr_products as $product):?>
				<tr class="">
					<td><?php echo $product->id; ?></td>
					<td style="max-width: 120px;"><?php echo $product->nombre; ?></td>
					<td style="max-width: 250px;"><?php echo $product->descripcion; ?></td>
					<td><?php echo $product->minimo; ?></td>
					<td style="text-align: center;"><?php echo $product->existencias; ?></td>
					<td style="width:40px;">
						<a id="<?php echo $product->id; ?>" class="btn btn-xs btn-warning btn-edit" data-toggle="modal" data-target="#editar"> Editar</a>
					</td>
				</tr>
				<?php endforeach;?>
			</table>
			<div class="btn-group pull-right">
			<?php
			for($i=0;$i<$npaginas;$i++){
				echo "<a href='index.php?view=inventarymp&limit=$limit&page=".($i+1)."' class='btn btn-default btn-sm'>".($i+1)."</a> ";
			}
			?>
			</div>
			<form class="form-inline">
				<label for="limit">Límite</label>
				<input type="hidden" name="view" value="inventarymp">
				<input type="number" min="1" value=<?php echo $limit?> name="limit" style="width:60px;" class="form-control">
			</form>
			<div class="clearfix"></div>
		<?php
		}else{
		?>
		<div class="jumbotron">
			<div class="container">
				<h2>No hay productos</h2>
				<p>No se ha agregado materia prima, puede agregar dando click en el botón <b>"Agregar Materia Prima"</b>.</p>
			</div>
		</div>
		<?php
		}
		?>
		<br><br><br>
	</div>
</div>
