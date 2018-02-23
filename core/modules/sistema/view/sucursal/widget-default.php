<?php
	include("modals/agregar.php");
	include("modals/editar.php");
	#Se obtienen todas las sucursales registradas
	$sucursal = SucursalData::getAll();
?>

<script src="ajax/sucursal/ajax.js"></script>

<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='icon-office'></i> Registrar Sucursal</a>
			
			<!-- Si hay más de 0 sucursales: -->
			<?php if(count($sucursal) > 0): ?>
			
			<div class="btn-group pull-right">
				<a class="btn btn-default" target="_blank" href="report/sucursales.php "><i class="fa fa-download"></i> Descargar</a>
			</div>

			<?php endif; ?>

		</div>
	
		<h1>Lista De Sucursales</h1>
		<div class="container-fluid">
			<?php
			if (isset($_COOKIE["errorSuc"]) && !empty($_COOKIE["errorSuc"])):
			?>
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-warning fa-fw'></i> <?php echo $_COOKIE["errorSuc"]; ?></p>
				</div>
			<?php
				setcookie("errorSuc","",time()-18600);
			endif;
			?>
			<?php
			if (isset($_COOKIE["okSuc"]) && !empty($_COOKIE["okSuc"])):
			?>
				<br>
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-info fa-fw'></i> <?php echo $_COOKIE["okSuc"]; ?></p>
				</div>
			<?php
				setcookie("okSuc","",time()-18600);
			endif;
			?>
		</div>
		<!-- Si hay más de 0 sucursales: -->
		<?php if(count($sucursal)>0): ?>
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
		$paginas = floor(count($sucursal)/$limit);
		$spaginas = count($sucursal)%$limit;
		if($spaginas>0){$paginas++;}
		$sucursal = SucursalData::getByPage($start,$limit);
		$num = $start;
		?>
		
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th style="text-align: center; width: 45px;">No.</th>
						<th>Nombre</th>
						<th>Direcci&oacute;n</th>
						<th style="width: 100px;">Tel&eacute;fono</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($sucursal as $suc): ?>
					<tr>
						<td style="text-align: center;"><?php echo $num++; ?></td>
						<td><?php echo $suc->nombre; ?></td>
						<td><?php echo $suc->direccion; ?></td>
						<td style="min-width:90px;"><?php echo $suc->telefono; ?></td>
						<td style="width: 80px;">
							<a data-toggle="modal" data-target="#editar" id="<?php echo $suc->id;?>" class="btn btn-warning btn-xs btn-edit"><i class="fa fa-edit fa-fw"></i></a>
							<a <?php if($suc->id == 1){echo "disabled";} ?> title="¿Eliminar?" href="index.php?view=delsuc&id=<?php echo $suc->id;?>" class="btn btn-danger btn-xs"
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
					<li class="previous"><a href="index.php?view=sucursal<?php echo $prev; ?>">&laquo;</a></li>
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
							<a href="index.php?view=sucursal&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
					<li class="previous"><a href="index.php?view=sucursal<?php echo $next; ?>">&raquo;</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<?php
		else:
			echo "<p class='alert alert-danger'>No hay sucursales</p>";
		endif;
		?>
	</div>
</div>