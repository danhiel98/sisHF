<?php
	$idSuc = $_SESSION["usr_suc"];
	$sucs = false;
	$sucursales = SucursalData::getAll();
	$prodSuc = ProductoSucursalData::getAllForSell($idSuc);

	$sucursalesDisponibles = array();
	foreach($sucursales as $suc){
		if($suc->id != 1){ //Si no es la principal
			$usuarios = UserData::getAllBySucId($suc->id);
			if(count($usuarios) > 0){//Solamente aparecerán las sucursales donde se hayan creado usuarios previamente
				array_push($sucursalesDisponibles,$suc); 
			}
		}
	}

	if (count($sucursalesDisponibles) > 0) {
		$sucs = true;
	}

	$traspasos = TraspasoData::getAllBySuc($idSuc);
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group  pull-right">
			<?php if ($sucs && count($prodSuc)>0): ?>
			<a href="index.php?view=newtraspaso" class="btn btn-default"><i class="fa fa-exchange"></i> Registrar Traspaso</a>
			<?php endif; ?>
			<?php if (count($traspasos)>0): ?>
				<div class="btn-group pull-right">
	  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
	    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
	  			</button>
	  			<ul class="dropdown-menu" role="menu">
	    			<li><a href="report/traspasos.php">Excel (.xlsx)</a></li>
	  			</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Traspasos Realizados</h1>
		<div class="container-fluid">
			<?php
			if (isset($_COOKIE["errorTrasp"]) && !empty($_COOKIE["errorTrasp"])):
			?>
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-warning fa-fw'></i> <?php echo $_COOKIE["errorTrasp"]; ?></p>
				</div>
			<?php
				setcookie("errorTrasp","",time()-18600);
			endif;
			?>
			<?php
			if (isset($_COOKIE["okTrasp"]) && !empty($_COOKIE["okTrasp"])):
			?>
				<br>
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-info fa-fw'></i> <?php echo $_COOKIE["okTrasp"]; ?></p>
				</div>
			<?php
				setcookie("okTrasp","",time()-18600);
			endif;
			?>
		</div>
		<?php
			if(count($traspasos)>0){
		?>
		<div class="clearfix"></div>
		<?php
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
			$paginas = floor(count($traspasos)/$limit);
			$spaginas = count($traspasos)%$limit;
			if($spaginas>0){$paginas++;}
			$traspasos = TraspasoData::getAllBySucPage($idSuc,$start,$limit);
		?>
			<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th></th>
						<th>No.</th>
						<th>Origen</th>
						<th>Destino</th>
						<th>Fecha</th>
						<th>Registrado Por</th>
						<th style="width: 40px;"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($traspasos as $trasp): ?>
					<tr>
						<td style="width:30px;">
							<a href="index.php?view=tradex&id=<?php echo $trasp->id; ?>" title="Detalles de traspaso" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a>
						</td>
						<td><?php echo $trasp->id; ?></td>
						<td>
							<?php echo $trasp->getSucursalO()->nombre; ?>
						</td>
						<td>
							<?php echo $trasp->getSucursalD()->nombre; ?>
						</td>
						<td><?php echo $trasp->fecha; ?></td>
						<td><?php if(!is_null($trasp->getUser()->idempleado)){echo $trasp->getUser()->getEmpleado()->nombrecompleto;}else{echo $trasp->getUser()->fullname;}?></td>
						<td>
							<a title="¿Eliminar?" href="index.php?view=deltrasp&id=<?php echo $trasp->id;?>" class="btn btn-danger btn-xs"
							data-toggle="confirmation-popout" data-popout="true" data-placement="left"
							data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
							data-btn-ok-class="btn-success btn-xs"
							data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
							data-btn-cancel-class="btn-danger btn-xs">
								<i class="fa fa-trash fa-fw"></i>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
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
						<li class="previous"><a href="index.php?view=traspasos<?php echo $prev; ?>">&laquo;</a></li>
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
								<a href="index.php?view=traspasos&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
						<li class="previous"><a href="index.php?view=traspasos<?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
			<?php
			}else{
			?>
			<div class="jumbotron">
				<div class="container">
					<?php if ($sucs): ?>
						<h2>No se han registrado traspasos</h2>
						<?php if(count($prodSuc) > 0): ?>
						Puede registrar uno dando clic en el boton <b>"Registrar Traspaso"</b>
						<?php else: ?>
						No hay <a href="index.php?view=inventaryprod">productos</a> disponibles para realizar el traspaso.
						<?php endif; ?>
					<?php else: ?>
						<h2>No se pueden registrar traspasos</h2>
						<?php if(count($sucursales) < 2): ?>
						Para ello debe haber m&aacute;s de una sucursal registradas.
						<a href="index.php?view=sucursal">Ir a sucursales</a>
						<?php else: ?>
						Para realizar traspasos a otra sucursal debe haber al menos un <a href="index.php?view=users">usuario</a> registrado en la sucursal de destino.
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		<?php
		}
		?>
		<br><br><br><br>
	</div>
</div>
