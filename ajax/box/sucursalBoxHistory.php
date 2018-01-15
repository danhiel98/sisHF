<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/ClientData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ServiceData.php");
	include ("../../core/modules/sistema/model/FacturaData.php");
	include ("../../core/modules/sistema/model/ComprobanteData.php");
	include ("../../core/modules/sistema/model/BoxData.php");
	
    $idSuc = $_REQUEST["id"];
	$count = 0;
	$boxes = BoxData::getAllBySuc($idSuc);
?>
<?php if(count($boxes)>0): ?>
	<?php
		$total_total = 0;
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
		$paginas = floor(count($boxes)/$limit);
		$spaginas = count($boxes)%$limit;
		if($spaginas>0){$paginas++;}
		$boxes = BoxData::getBySucPage($idSuc,$start,$limit);
	?>
	
	<br>
	<div class="table-responsive">
		<table class="table table-bordered table-hover	">
			<thead>
				<th></th>
				<th>No.</th>
				<th>Total</th>
				<th>Fecha</th>
			</thead>
			<?php foreach($boxes as $box):
				$facts = FacturaData::getByBoxId($box->id);
				$count++;
			?>
			<tr>
				<td style="width:30px;">
					<a href="./index.php?view=b&id=<?php echo $box->id."&no=".$count; ?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-right"></i></a>
				</td>
				<td style="width:50px;"><?php echo $count; ?></td>
				<td>
				<?php
					$total=0;
					foreach($facts as $fc){
						$prodsx = FacturaData::getAllSellsByFactId($fc->id); #Productos vendidos en la factura
						$servsx = FacturaData::getAllServicesByFactId($fc->id); #Servicios vendidos en la factura
						foreach ($prodsx as $p) {
							$precio = $p->total;
							$total += $precio;
						}
						foreach ($servsx as $s) {
							$precio = $s->total;
							$total += $precio;
						}
					}
					$total_total += $total;
					echo "<b>$ ".number_format($total,2,".",",")."</b>";
				?>
				</td>
				<td><?php echo $box->fecha; ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<h1>Total: <?php echo "$ ".number_format($total_total,2,".",","); ?></h1>
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
				<li class="previous"><a href="index.php?view=boxhistory<?php echo $prev; ?>">&laquo;</a></li>
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
						<a href="index.php?view=boxhistory&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
				<li class="previous"><a href="index.php?view=boxhistory<?php echo $next; ?>">&raquo;</a></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
	<?php else: ?>
	<div class="clearfix"></div>
	<br>
	<div class="alert alert-info">
		No hay datos.
	</div>
	<div class="alert alert-warning">
		No se ha realizado ning&uacute;n corte de caja en esta sucursal.
	</div>
	<?php endif; ?>