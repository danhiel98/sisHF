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
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-download"></i> Descargar <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="report/sucursales.php ">Excel (.xlsx)</a></li>
				</ul>
			</div>

			<?php endif; ?>

		</div>
	
		<h1>Lista De Sucursales</h1>

		<!-- Si hay más de 0 sucursales: -->
		<?php if(count($sucursal)>0): ?>
		<?php
		
		$start = 1; $limit = 5;
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
		
		?>
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
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<th style="text-align: center; width: 45px;">No.</th>
					<th>Nombre</th>
					<th>Direcci&oacute;n</th>
					<th style="width: 100px;">Tel&eacute;fono</th>
					<th></th>
				</thead>
				
				<?php foreach($sucursal as $suc): ?>
				
				<tr>
					<td style="text-align: center;"><?php echo $suc->id; ?></td>
					<td><?php echo $suc->nombre; ?></td>
					<td><?php echo $suc->direccion; ?></td>
					<td style="min-width:90px;"><?php echo $suc->telefono; ?></td>
					<td style="width:40px;">
						<a data-toggle="modal" data-target="#editar" id="<?php echo $suc->id;?>" class="btn btn-warning btn-xs btn-edit">Editar</a>
					</td>
				</tr>
				
				<?php endforeach; ?>

			</table>
		</div>
		<?php
		else:
			echo "<p class='alert alert-danger'>No hay sucursales</p>";
		endif;
		?>
	</div>
</div>