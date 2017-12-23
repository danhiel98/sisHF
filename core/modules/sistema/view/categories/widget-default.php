<?php

	include("modals/agregar.php");
	include("modals/editar.php");

?>
<script type="text/javascript" src="ajax/categorias/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-th-list'></i> Nueva Categor&iacute;a</a>
		</div>
		<h1>Categorías</h1>
		<?php
		$cats = CategoryData::getAll();
		if(count($cats)>0):
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
			$paginas = floor(count($cats)/$limit);
			$spaginas = count($cats)%$limit;
			if($spaginas>0){$paginas++;}
			$cats = CategoryData::getByPage($start,$limit);
			?>
			
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<th style="width:45px;">No.</th>
						<th>Nombre</th>
						<th></th>
					</thead>
					<tbody>
						<?php
						foreach($cats as $c):
						?>
							<tr>
								<td><?php echo $c->id; ?></td>
								<td><?php echo $c->nombre; ?></td>
								<td style="width:60px;">
									<a data-toggle="modal" data-target="#editar" id="<?php echo $c->id;?>" class="btn btn-warning btn-xs btn-edit">Editar</a>
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
						<li class="previous"><a href="index.php?view=categories<?php echo $prev; ?>">&laquo;</a></li>
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
								<a href="index.php?view=categories&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
						<li class="previous"><a href="index.php?view=categories<?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>

			<?php
		else:
		?>
			<p class='alert alert-danger'>No hay Categorías</p>
		<?php
		endif;
		?>
	</div>
</div>
