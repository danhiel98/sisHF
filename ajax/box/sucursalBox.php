<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/ClientData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ServiceData.php");
	include ("../../core/modules/sistema/model/FacturaData.php");
	include ("../../core/modules/sistema/model/ComprobanteData.php");
	
    $idSuc = $_REQUEST["id"];
	$caja = FacturaData::getSellsUnBoxedBySuc($idSuc);
	$actualSuc = false;
	if($idSuc == $_SESSION["usr_suc"]){
		$actualSuc = true;
	}
?>
  <?php if (count($caja)>0): ?>
	<script>
		$.getScript("res/initializr/js/main.js");
	</script>
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
		$paginas = floor(count($caja)/$limit);
		$spaginas = count($caja)%$limit;
		if($spaginas>0){$paginas++;}
		$caja = FacturaData::getSellsUnBoxedBySucPage($idSuc,$start,$limit);
		$count = $start;
	?>

    <div class="clearfix"></div>
	<br>
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th></th>
					<th>No.</th>
					<th>Cliente</th>
					<th>Fecha</th>
					<th>Tipo Comprobante</th>
					<th>Total</th>
					<?php if($actualSuc): ?>
					<th></th>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($caja as $sell):?>
				<tr>
					<td style="width:30px;">
						<a href="index.php?view=onesell&id=<?php echo $sell->id; ?>&b" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a>
					</td>
					<?php
						$prodsx = FacturaData::getAllSellsByFactId($sell->id); #Productos vendidos en la factura
						$servsx = FacturaData::getAllServicesByFactId($sell->id); #Servicios vendidos en la factura
					?>
					<td>
						<?php echo $count++; ?>
					</td>
					<td>
						<?php if($sell->idcliente != ""){echo $sell->getClient()->name;}else{echo "----";} ?>
					</td>
					<td><?php echo $sell->fecha; ?></td>
					<td><?php echo $sell->getComprobante()->nombre; ?></td>
					<td>
						<?php
							$total=0;
							foreach($prodsx as $p){
								$prd = $p->getProduct();
								$total += $p->cantidad * $prd->precioventa;
							}
							foreach ($servsx as $s) {
								$srv = $s->getService();
								$total += $s->cantidad * $srv->precio;
							}
							$total_total += $total;
							echo "<b>$ ".number_format($total,2,'.',',')."</b>";
						?>
					</td>
					<?php if($actualSuc): ?>
					<td style="width: 40px;">
						<a title="¿Eliminar?" href="index.php?view=delsell&id=<?php echo $sell->id;?>" class="btn btn-danger btn-xs"
						data-toggle="confirmation-popout" data-popout="true" data-placement="left"
						data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
						data-btn-ok-class="btn-success btn-xs"
						data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
						data-btn-cancel-class="btn-danger btn-xs"
						>
							<i class="fa fa-trash fa-fw"></i>
						</a>
	
					</td>
					<?php endif; ?>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<h1>Total: <?php echo "$ ".number_format($total_total,2,".",","); ?></h1>
	<div class="pull-right">
		<ul class="pagination">
			<?php if($start != 1):?>
			<?php
				$prev = "#";
				if($start != 1){
					$prev = "?start=".($start-$limit)."&limit=".$limit."&id=".$idSuc;
				}
			?>
			<li class="previous"><a class="pag" href="ajax/box/sucursalBox.php<?php echo $prev; ?>">&laquo;</a></li>
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
					<a class="pag" href="ajax/box/sucursalBox.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit."&id=".$idSuc; ?>"><?php echo $i; ?></a>
				</li>
				<?php
				endfor;
			?>
			<?php if($start != $anterior): ?>
			<?php 
				$next = "#";
				if($start != $anterior){
					$next = "?start=".($start + $limit)."&limit=".$limit."&id=".$idSuc;
				}
			?>
			<li class="previous"><a class="pag" href="ajax/box/sucursalBox.php<?php echo $next; ?>">&raquo;</a></li>
			<?php endif; ?>
		</ul>
	</div>
	<script>
		$(".pag").on("click", function(){
			$.ajax({
				url: $(this).attr("href"),
				type: "GET",
				success: function(res){
					$("#resultado").html(res);
				}
			});
			return false;
		});
	</script>
	<?php else: ?>
		<div class="clearfix"></div>
		<br>
		<div class="alert alert-warning">
			¡Vaya! Aún no no se han realizado ventas en esta sucursal.
		</div>
	<?php endif; ?>
	</div>