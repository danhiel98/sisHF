<?php
	
	$u = UserData::getById(Session::getUID());

	if ($_SESSION["usr_suc"] != 1){
		error();
	}

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
					<a class="btn btn-default" href="report/materiaPrima.php"><i class="fa fa-download fa-fw"></i> Descargar</a>
				</div>
			<?php endif; ?>
		</div>
		<h1><i class="glyphicon glyphicon-stats"></i> Inventario De Materia Prima</h1>
		<div class="container-fluid">
			<?php
			if (isset($_COOKIE["errorMatPrim"]) && !empty($_COOKIE["errorMatPrim"])):
			?>
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-warning fa-fw'></i> <?php echo $_COOKIE["errorMatPrim"]; ?></p>
				</div>
			<?php
				setcookie("errorMatPrim","",time()-18600);
			endif;
			?>
			<?php
			if (isset($_COOKIE["okMatPrim"]) && !empty($_COOKIE["okMatPrim"])):
			?>
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-info fa-fw'></i> <?php echo $_COOKIE["okMatPrim"]; ?></p>
				</div>
			<?php
				setcookie("okMatPrim","",time()-18600);
			endif;
			?>
		</div>
		<div class="clearfix"></div>
		<?php
		if($matP){
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
			$paginas = floor(count($materiaP)/$limit);
			$spaginas = count($materiaP)%$limit;
			if($spaginas>0){$paginas++;}
			$materiaP = MateriaPrimaData::getAllByPage($start,$limit);
			$num = $start;
		?>
		<div class="clearfix"></div>
		<br>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th style="width:30px;">No.</th>
						<th>Nombre</th>
						<th>Descripci&oacute;n</th>
						<th>M&iacute;nimo</th>
						<th>Existencias</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($materiaP as $prod):?>
					<tr class="<?php if($prod->existencias <= $prod->minimo){echo 'warning';} ?>">
						<td><?php echo $num++; ?></td>
						<td><?php echo $prod->nombre; ?></td>
						<td ><?php echo $prod->descripcion; ?></td>
						<td style="text-align: center; width: 50px;"><?php echo $prod->minimo; ?></td>
						<td style="text-align: center; width: 50px;"><?php echo $prod->existencias; ?></td>
						<td style="width: 80px;">
							<a id="<?php echo $prod->id; ?>" class="btn btn-xs btn-warning btn-edit" data-toggle="modal" data-target="#editar"><i class="fa fa-edit fa-fw"></i></a>
							<a title="¿Eliminar?" href="index.php?view=delmp&id=<?php echo $prod->id;?>" class="btn btn-danger btn-xs"
								data-toggle="confirmation-popout" data-popout="true" data-placement="left"
								data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
								data-btn-ok-class="btn-success btn-xs"
								data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
								data-btn-cancel-class="btn-danger btn-xs"
								>
									<i class="fa fa-trash fa-fw"></i>
							</a>
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
					<li class="previous"><a href="index.php?view=inventarymp<?php echo $prev; ?>">&laquo;</a></li>
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
							<a href="index.php?view=inventarymp&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
					<li class="previous"><a href="index.php?view=inventarymp<?php echo $next; ?>">&raquo;</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<?php
		}else{
		?>
		<div class="jumbotron">
			<div class="container">
				<h2>No hay productos</h2>
				No se ha agregado materia prima, puede agregar dando click en el botón <b>"Agregar Materia Prima"</b>.
			</div>
		</div>
		<?php
		}
		?>
		<br><br><br>
	</div>
</div>
