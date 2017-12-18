<?php
	$empleados = EmpleadoData::getAllBySucId($_SESSION["usr_suc"]);
	include("modals/agregar.php");
	include("modals/editar.php");
	$gastos = GastoData::getAll();
?>
<script type="text/javascript" src="ajax/gasto/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-dollar'></i> Registrar Gasto</a>
			<?php if(count($gastos) > 0) :?>
				<div class="btn-group pull-right">
				  	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				    	<i class="fa fa-download"></i> Descargar <span class="caret"></span>
				  	</button>
				  	<ul class="dropdown-menu" role="menu">
				    	<li><a href="report/gastos.php">Excel (.xlsx)</a></li>
				  	</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Gastos Realizados</h1>
		<?php
		if(count($gastos)>0):
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
			$paginas = floor(count($gastos)/$limit);
			$spaginas = count($gastos)%$limit;
			if($spaginas>0){$paginas++;}
			$gastos = GastoData::getByPage($start,$limit);
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
					<li class="previous"><a href="index.php?view=gastos<?php echo $prev; ?>">&laquo;</a></li>
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
							<a href="index.php?view=gastos&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
					<li class="previous"><a href="index.php?view=gastos<?php echo $next; ?>">&raquo;</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<th style="width:40px;">No.</th>
					<th>Responsable</th>
					<th>Descripci&oacute;n</th>
					<th>Valor</th>
					<th>No. Comprobante</th>
					<th>Fecha</th>
					<th></th>
				</thead>
				<tbody>
					<?php
					foreach($gastos as $gasto):
					?>
					<tr>
						<td><?php echo $gasto->id; ?></td>
						<td>
							<?php
								if ($gasto->idempleado != ""){
									echo $gasto->getEmpleado()->nombre." ".$gasto->getEmpleado()->apellido;
								}
							?>
						</td>
						<td><?php echo $gasto->descripcion; ?></td>
						<td>$ <?php echo $gasto->pago; ?></td>
						<td><?php echo $gasto->comprobante; ?></td>
						<td><?php echo $gasto->fecha; ?></td>
						<td style="width:60px;">
							<a data-toggle="modal" data-target="#editar" id="<?php echo $gasto->id;?>" class="btn btn-warning btn-xs btn-edit">Editar</a>
						</td>
					</tr>
						<?php
					endforeach;
					?>
				</tbody>
			</table>
		</div>
		<?php
		else:
		?>
			<p class='alert alert-warning'>No se han realizado gastos</p>
		<?php
		endif;
		?>
	</div>
</div>
