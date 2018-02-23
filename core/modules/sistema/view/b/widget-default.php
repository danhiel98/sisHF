<div class="row">
	<div class="col-md-12">
		<a href="index.php?view=boxhistory" class="btn btn-default"><i class="fa fa-arrow-left fa-fw"></i>Regresar</a>
		<?php
		if (!isset($_GET["id"]) || (isset($_GET["id"]) && empty($_GET["id"]))) {
			@header("location: index.php?view=box");
		}
		$idSuc = $_SESSION["usr_suc"];
		$boxes = BoxData::getAllBySuc($idSuc);
		$num = count($boxes);
		
		$box = BoxData::getById($_GET["id"]);
		$products = FacturaData::getByBoxId($_GET["id"]);
		
		if (isset($_GET["no"]) && is_numeric($_GET["no"])){
			$num = $_GET["no"];
		}
		if(count($products)>0){
			$total_total = 0;
			?>
		<!-- Single button -->
		<div class="btn-group pull-right">
			<a href="./index.php?view=boxhistory" class="btn btn-default"><i class="fa fa-clock-o"></i> Historial</a>
			<div class="btn-group">
				<a class="btn btn-default" href="report/corteCaja.php?id=<?php echo $_GET["id"];?>"><i class="fa fa-download fa-fw"></i> Descargar</a>
			</div>
		</div>
		<h1><i class='fa fa-archive'></i> Corte de Caja #<?php echo $num; ?></h1>
		<table class="table table-bordered">
			<tr>
				<td>Fecha</td>
				<th><?php echo $box->fecha; ?></th>
			</tr>
			<tr>
				<td>Realizado Por</td>
				<th><?php echo $box->getUser()->name." ".$box->getUser()->lastname; ?></th>
			</tr>
		</table>
		<div class="clearfix"></div>
		<br>
		<table class="table table-bordered table-hover">
			<thead>
				<th></th>
				<th>Tipo Comprobante</th>
				<th>No.</th>
				<th>Cliente</th>
				<th>Total</th>
			</thead>
			<?php foreach($products as $sell):?>
			<tr>
				<td style="width:30px;">
					<a href="index.php?view=onesell&id=<?php echo $sell->id; ?>&x=<?php echo $box->id; ?>" class="btn btn-xs btn-default"><i class="fa fa-arrow-right"></i></a>
				</td>
				<?php
					$prodsx = FacturaData::getAllSellsByFactId($sell->id); #Productos vendidos en la factura
					$servsx = FacturaData::getAllServicesByFactId($sell->id); #Servicios vendidos en la factura
				?>
				<td><?php echo $sell->getComprobante()->nombre; ?></td>
				<td><?php echo $sell->numerofactura; ?></td>
				<td>
					<?php if($sell->idcliente != ""){echo $sell->getClient()->name;}else{echo "----";} ?>
				</td>
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
			</tr>
			<?php endforeach; ?>
		</table>
		<h1>Total: <?php echo "$ ".number_format($total_total,2,".",","); ?></h1>
	<?php
	}else {
?>
	<div class="clearfix"></div>
	<br>
	<div class="jumbotron">
		<div class="container">
			<h2>No hay ventas</h2>
			<p>No se ha realizado ninguna venta.</p>
		</div>
	</div>

<?php } ?>
		<br><br><br>
	</div>
</div>
