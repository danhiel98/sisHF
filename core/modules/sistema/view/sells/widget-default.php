<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a class="btn btn-default" href="index.php?view=sell"><i class="fa fa-usd"></i> Vender</a>
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-download"></i> Descargar <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="report/pedidos.php">Excel (.xlsx)</a></li>
			</ul>
		</div>
		<h1><i class='glyphicon glyphicon-shopping-cart'></i> Lista de Ventas</h1>
		<div class="clearfix"></div>
       	<div>
		    <label for="inicio" class="col-lg-2 control-label">Fecha De Inicio</label><div class='col-md-2'>
			<div class="form-group">
				<div class='input-group date' id='datetimepicker6'>
					<input type='text' class="form-control" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
		</div>
		<label for="inicio" class="col-lg-2 control-label">Fecha Fin</label>
		<div class='col-md-2'>
			<div class="form-group">
				<div class='input-group date' id='datetimepicker7'>
					<input type='text' class="form-control" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
		</div>
		<div class="btn-group pull-center">
			<button type="button" id="btnResumen" class="btn btn-default" data-toggle="modal" data-target="#ver">
				<i class="fa fa-search"></i> Buscar</span>
			</button>
		</div>

		<script type="text/javascript">
			$(function () {
				$('#datetimepicker6').datetimepicker({
					format: "DD/MM/YYYY",
					locale: "es"
				});
				$('#datetimepicker7').datetimepicker({
				format: "DD/MM/YYYY",
				locale: "es",
				useCurrent: false //Important! See issue #1075
				});
				$("#datetimepicker6").on("dp.change", function (e) {
				$('#datetimepicker7').data("DateTimePicker").minDate(e.date);
				});
				$("#datetimepicker7").on("dp.change", function (e) {
				$('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
				});
			});
		</script>  
	</div>
	
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