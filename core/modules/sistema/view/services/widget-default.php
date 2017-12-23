<?php
	$services = ServiceData::getAll();
	include("modals/agregar.php");
	include("modals/editar.php");
	#$services = ServiceData::getAll();
?>
<script type="text/javascript" src="ajax/servicio/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-th'></i> Registrar Servicio</a>
			<?php if(count($services) > 0): ?>
			<div class="btn-group pull-right">
		  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
		  			</button>
		  			<ul class="dropdown-menu" role="menu">
		    			<li><a href="report/servicios.php">Excel (.xlsx)</a></li>
		  			</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Lista De Servicios</h1>
		<?php
			if(count($services)>0):
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
				$paginas = floor(count($services)/$limit);
				$spaginas = count($services)%$limit;
				if($spaginas>0){$paginas++;}
				$services = ServiceData::getByPage($start,$limit);
		?>
		
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<th style="width: 45px;">No.</th>
					<th>Nombre</th>
					<th>Descripci&oacute;n</th>
					<th style="width: 90px;">Precio</th>
					<th></th>
				</thead>
				<tbody>
					<?php
					foreach($services as $service):
						?>
						<tr>
							<td><?php echo $service->id; ?></td>
							<td><?php echo $service->nombre; ?></td>
							<td><?php echo $service->descripcion; ?></td>
							<td style="width: 90px;"><strong>$ <?php echo $service->precio; ?></strong></td>
							<td style="width:40px;">
								<a data-toggle="modal" data-target="#editar" id="<?php echo $service->id;?>" class="btn btn-warning btn-xs btn-edit">Editar</a>				
							</td>
						</tr>
						<?php
					endforeach;
					?>
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
					<li class="previous"><a href="index.php?view=services<?php echo $prev; ?>">&laquo;</a></li>
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
							<a href="index.php?view=services&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
					<li class="previous"><a href="index.php?view=services<?php echo $next; ?>">&raquo;</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<?php
		else:
		?>
			<p class='alert alert-danger'>No hay servicios registrados</p>
		<?php
		endif;
		?>
	</div>
</div>
