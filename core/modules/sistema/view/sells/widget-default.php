<div class="row">
	<div class="col-md-12">
		<div class="btn-group  pull-right">
			<a class="btn btn-default" href="index.php?view=sell"><i class="fa fa-usd"></i> Vender</a>
		</div>
		<h1><i class='glyphicon glyphicon-shopping-cart'></i> Lista de Ventas</h1>
		<div class="clearfix"></div>
		<?php
			$products = FacturaData::getFacturas();
			if(count($products)>0){
		?>
		<br>
		<table class="table table-bordered table-hover">
			<thead>
				<th></th>
				<th>No.</th>
				<th>Cliente</th>
				<th>Vendedor</th>
				<th>Fecha</th>
				<th>Tipo Documento</th>
				<th>Total</th>
				<th></th>
			</thead>
			<?php foreach($products as $sell):?>
			<tr>
				<td style="width:30px;">
					<a href="index.php?view=onesell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a>
				</td>
				<?php
					$prodsx = FacturaData::getAllSellsByFactId($sell->id); #Productos vendidos en la factura
					$servsx = FacturaData::getAllServicesByFactId($sell->id); #Servicios vendidos en la factura
				?>
				<td>
					<?php echo $sell->numerofactura; ?>
				</td>
				<td>
					<?php if($sell->idcliente != ""){echo $sell->getClient()->name." ".$sell->getClient()->lastname;}else{echo "----";} ?>
				</td>
				<td><?php echo $sell->getUser()->name." ".$sell->getUser()->lastname; ?></td>
				<td><?php echo $sell->fecha; ?></td>
				<td><?php echo $sell->tipo; ?></td>
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
						echo "<b>$ ".number_format($total,2,'.',',')."</b>";
					?>
				</td>
				<td style="width:30px;"><!--<a onclick="return confirm('¿Seguro que desea eliminar el registro?');" href="index.php?view=delsell&id=<?php #echo $sell->id; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>--></td>
			</tr>
			<?php endforeach; ?>
		</table>
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
