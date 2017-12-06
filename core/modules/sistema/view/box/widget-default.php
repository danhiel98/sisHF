<?php
	$boxes = BoxData::getAll();
	$caja = FacturaData::getSellsUnBoxed();
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<?php if (count($boxes)>0): ?>
				<a href="index.php?view=boxhistory" class="btn btn-default "><i class="fa fa-clock-o"></i> Historial</a>
			<?php endif; ?>
			<?php if (count($caja)>0): ?>
				<a href="index.php?view=processbox" class="btn btn-primary ">Procesar Datos <i class="fa fa-arrow-right"></i></a>
			<?php endif; ?>
		</div>
		<h1><i class='fa fa-archive'></i> Caja</h1>
		<div class="clearfix"></div>
		<?php
			if(count($caja)>0){
				$total_total = 0;
		?>
		<br>
		<table class="table table-bordered table-hover">
			<thead>
				<th></th>
				<th>No.</th>
				<th>Cliente</th>
				<th>Fecha</th>
				<th>Tipo Comprobante</th>
				<th>Total</th>
				<th></th>
			</thead>
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
					<?php echo $sell->id; ?>
				</td>
				<td>
					<?php if($sell->idcliente != ""){echo $sell->getClient()->name." ".$sell->getClient()->lastname;}else{echo "----";} ?>
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
				<td style="width:30px;"><!--<a onclick="return confirm('¿Seguro que desea eliminar el registro?');" href="index.php?view=delsell&id=<?php #echo $sell->id; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>--></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<h1>Total: <?php echo "$ ".number_format($total_total,2,".",","); ?></h1>
		<div class="clearfix"></div>
	<?php
		}else{
	?>
		<div class="jumbotron">
			<div class="container">
				<h2>No hay ventas</h2>
				<p>No se ha realizado ninguna venta.</p>
			</div>
		</div>
<?php
}
?>
		<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>
