<?php
	$materiaP = MateriaPrimaData::getAll();
	$matP = false;
	if (count($materiaP)>0){
		$matP = true;
	}
?>
<div class="row">
	<div class="col-md-12">
		<?php if ($matP): ?>
		<div class="btn-group pull-right">
			<a href="index.php?view=re" class="btn btn-default"><i class='fa fa-shopping-cart'></i> Realizar Compra</a>
			<!--
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-download"></i> Descargar <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="report/compramateriaprima.php">Excel (.xlsx)</a></li>
			</ul>
			-->
		</div>
		<?php endif; ?>
		<h1><i class='glyphicon glyphicon-shopping-cart'></i> Compras de Materia Prima</h1>
		<?php
			$reabs = ReabastecimientoData::getAll();
			if(count($reabs)>0):
				
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
				$paginas = floor(count($reabs)/$limit);
				$spaginas = count($reabs)%$limit;
				if($spaginas>0){$paginas++;}
				$reabs = ReabastecimientoData::getByPage($start,$limit);

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
						<li class="previous"><a href="index.php?view=res<?php echo $prev; ?>">&laquo;</a></li>
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
								<a href="index.php?view=res&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
						<li class="previous"><a href="index.php?view=res<?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>

			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<th></th>
						<th>No. Factura</th>
						<th>Proveedor</th>
						<th>Fecha</th>
						<th>Total</th>
						<th></th>
					</thead>
					<tbody>
					<?php foreach($reabs as $re):?>
						<?php
							$total = 0;
							$reabT = ReabastecimientoMPData::getAllByReabId($re->id);
						?>
						<tr>
							<td style="width:30px;"><a href="index.php?view=onere&id=<?php echo $re->id; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>
							<td style="width:125px;">
								<?php echo $re->comprobante; ?>
							</td>
							<td>
								<?php echo $re->getProvider()->nombre;?>
							</td>
							<td>
								<?php echo $re->fecha; ?>
							</td>
							<td>
								<strong>$
								<?php foreach($reabT as $rb){
									$total += $rb->total;
								}?>
								<?php echo number_format($total,2,'.',','); ?>
								</strong>
							</td>
							<td></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php
		else:
		?>
		<div class="jumbotron">
			<div class="container">
				<h2>No hay datos</h2>
				<p>No se ha realizado ninguna operacion.</p>
			</div>
		</div>
		<?php
		endif;
		?>
		<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>
