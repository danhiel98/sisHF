<div class="row">
	<div class="col-md-12">
		<a class="btn btn-default" href="<?php if(isset($_SERVER['HTTP_REFERER'])){echo $_SERVER['HTTP_REFERER'];}else{echo "index.php?view=box";} ?>"><i class="fa fa-arrow-left fa-fw"></i>Regresar</a>
		<div class="btn-group pull-right">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-download"></i> Descargar <span class="caret"></span>
			</button>
  			<ul class="dropdown-menu" role="menu">
    			<li><a href="report/boxhistory.php">Excel (.xlsx)</a></li>
  			</ul>
		</div>
		<h1><i class='fa fa-archive'></i> Cortes de Caja</h1>
		<div class="clearfix"></div>
		<?php
			$count = 0;
			$idSuc = $_SESSION["usr_suc"];
			$boxes = BoxData::getAllBySuc($idSuc);
			if(count($boxes)>0){
				$total_total = 0;
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
	<?php
		}else {
	?>
		<div class="jumbotron">
			<div class="container">
				<h2>No hay datos.</h2>
				No se ha realizado ning&uacute;n corte de caja.
			</div>
		</div>
	<?php
	}
	?>
		<br><br><br>
	</div>
</div>
