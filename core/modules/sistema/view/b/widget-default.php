<div class="row">
	<div class="col-md-12">
		<!-- Single button -->
		<div class="btn-group pull-right">
			<a href="./index.php?view=boxhistory" class="btn btn-default"><i class="fa fa-clock-o"></i> Historial</a>
			<div class="btn-group">
  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
  			</button>
  			<ul class="dropdown-menu pull-right" role="menu">
    			<li><a href="report/box-word.php?id=<?php echo $_GET["id"];?>">Word 2007 (.docx)</a></li>
  			</ul>
			</div>
		</div>
		<?php
		if (!isset($_GET["id"]) || (isset($_GET["id"]) && empty($_GET["id"]))) {
			@header("location: index.php?view=box");
		}
		$box = BoxData::getById($_GET["id"]);
		$products = FacturaData::getByBoxId($_GET["id"]);
		if(count($products)>0){
			$total_total = 0;
			?>
		<h1><i class='fa fa-archive'></i> Corte de Caja #<?php echo $_GET["id"]; ?></h1>
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
				<th>Tipo Documento</th>
				<th>No.</th>
				<th>Cliente</th>
				<th>Total</th>
				<th></th>
			</thead>
			<?php foreach($products as $sell):?>
			<tr>
				<td style="width:30px;">
					<a href="index.php?view=onesell&id=<?php echo $sell->id; ?>&x=<?php echo $box->id; ?>" class="btn btn-xs btn-default"><i class="fa fa-arrow-right"></i></a>
				</td>
				<?php
					$sells = FacturaData::getAllSellsByFactId($sell->id);
				?>
				<td><?php echo $sell->tipo; ?></td>
				<td><?php echo $sell->numerofactura; ?></td>
				<td>
					<?php if($sell->idcliente != ""){echo $sell->getClient()->name." ".$sell->getClient()->lastname;}else{echo "----";} ?>
				</td>
				<td>
					<?php
						$total=0;
						foreach($sells as $s){
							$pr = $s->getProduct();
							$total += $s->cantidad * $pr->precioventa;
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
	<?php
	}else {
?>
	<div class="jumbotron">
		<div class="container">
			<h2>No hay ventas</h2>
			<p>No se ha realizado ninguna venta.</p>
		</div>
	</div>

<?php } ?>
		<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>
