<?php

	$accion = "";
	if (isset($_GET["val"])) {
		if ($_GET["val"] == "ent" || $_GET["val"] == "sal"){
			$accion = $_GET["val"];
		}
	}else{
		@header("location: index.php?view=sbox");
	}

	include "modals/ingreso.php";
	include "modals/salida.php";

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
?>
<script src="ajax/sbox/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<a class="btn btn-default" href="index.php?view=sbox"><i class="fa fa-arrow-left"></i> Regresar</a>
		<div class="container-fluid">
			<br>
			<?php
			if (isset($_COOKIE["errorIngreso"]) && !empty($_COOKIE["errorIngreso"])):
			?>
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-warning fa-fw'></i> <?php echo $_COOKIE["errorIngreso"]; ?></p>
				</div>
			<?php
				setcookie("errorIngreso","",time()-18600);
			endif;
			?>
			<?php
			if (isset($_COOKIE["okIngreso"]) && !empty($_COOKIE["okIngreso"])):
			?>
				<br>
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-info fa-fw'></i> <?php echo $_COOKIE["okIngreso"]; ?></p>
				</div>
			<?php
				setcookie("okIngreso","",time()-18600);
			endif;
			?>

			<?php
			if (isset($_COOKIE["errorSalida"]) && !empty($_COOKIE["errorSalida"])):
			?>
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-warning fa-fw'></i> <?php echo $_COOKIE["errorSalida"]; ?></p>
				</div>
			<?php
				setcookie("errorSalida","",time()-18600);
			endif;
			?>
			<?php
			if (isset($_COOKIE["okSalida"]) && !empty($_COOKIE["okSalida"])):
			?>
				<br>
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-info fa-fw'></i> <?php echo $_COOKIE["okSalida"]; ?></p>
				</div>
			<?php
				setcookie("okSalida","",time()-18600);
			endif;
			?>
		</div>
		<?php if($accion == "ent"): ?>
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-download"></i> Descargar <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="report/cajaChicaIngreso.php">Excel (.xlsx)</a></li>
				</ul>
			</div>
			<h1><i class='fa fa-archive'></i> Entradas (Caja Chica)</h1>
			<?php
				$ingresos = CajaChicaData::getIngresos();
				if (count($ingresos) > 0) {
					$paginas = floor(count($ingresos)/$limit);
					$spaginas = count($ingresos)%$limit;
					if($spaginas>0){$paginas++;}
					$ingresos = CajaChicaData::getIngresosByPage($start,$limit);
					$num = $start;
			?>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>Ingresada Por</th>
						<th>Cantidad</th>
						<th>Fecha</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($ingresos as $ing): ?>
					<tr>
						<td><?php echo $num++; ?></td>
						<td><?php if(is_null($ing->getUsuario()->idempleado)){echo $ing->getUsuario()->fullname;}else{echo $ing->getUsuario()->getEmpleado()->nombrecompleto;} ?></td>
						<td><strong>$ <?php echo number_format($ing->cantidad, 2,'.',','); ?></strong></td>
						<td><?php echo $ing->fecha; ?></td>
						<td style="width:40px;"><a data-opc="entrada" id="<?php echo $ing->id; ?>" data-toggle="modal" data-target="#editarIngreso" class="btn btn-warning btn-xs btn-edit">Editar</a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php
				}else{
					echo "<div class='alert alert-warning'>No se han realizado ingresos a la caja chica</div>";
				}
			?>
		<?php elseif($accion == "sal"): ?>

			<div class="btn-group pull-right">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-download"></i> Descargar <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="report/cajaChicaSalida.php">Excel (.xlsx)</a></li>
				</ul>
			</div>
			
			<h1><i class='fa fa-archive'></i> Salidas (Caja Chica)</h1>
			<?php
				$salidas = CajaChicaData::getSalidas();
				if (count($salidas) > 0){
					$paginas = floor(count($salidas)/$limit);
					$spaginas = count($salidas)%$limit;
					if($spaginas>0){$paginas++;}
					$salidas = CajaChicaData::getSalidasByPage($start,$limit);
					$num = $start;
			?>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>Registrada Por</th>
						<th>Realizada Por</th>
						<th>Cantidad</th>
						<th>Descripci&oacute;n</th>
						<th>Fecha</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($salidas as $sal): ?>
					<tr>
						<td><?php echo $num++; ?></td>
						<td><?php if(is_null($sal->getUsuario()->idempleado)){echo $sal->getUsuario()->fullname;}else{echo $sal->getUsuario()->getEmpleado()->nombrecompleto;} ?></td>
						<td>
							<?php if ($sal->idempleado != null){ echo $sal->getEmpleado()->nombre." ".$sal->getEmpleado()->apellido;}; ?>
						</td>
						<td><strong>$ <?php echo number_format($sal->cantidad,2,".",","); ?></strong></td>
						<td><?php echo $sal->descripcion; ?></td>
						<td><?php echo $sal->fecha; ?></td>
						<td style="width:40px;"><a data-opc="salida" id="<?php echo $sal->id; ?>" data-toggle="modal" data-target="#editarSalida" class="btn btn-warning btn-xs btn-edit">Editar</a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php
			}else{
				echo "<div class='alert alert-warning'>No se han realizado salidas de la caja chica</div>";
			}
		?>
		<?php endif; ?>
		<?php if(isset($paginas)): ?>
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
						<li class="previous"><a href="index.php?view=sboxe&val=<?php echo $accion; ?><?php echo $prev; ?>">&laquo;</a></li>
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
								<a href="index.php?view=sboxe&val=<?php echo $accion; ?>&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
						<li class="previous"><a href="index.php?view=sboxe&val=<?php echo $accion; ?><?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
		<div class="clearfix"></div>
		<br><br><br><br>
	</div>
</div>
