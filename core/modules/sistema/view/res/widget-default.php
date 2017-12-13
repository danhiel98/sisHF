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
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-download"></i> Descargar <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="report/compramateriaprima.php">Excel (.xlsx)</a></li>
			</ul>
		</div>
		<?php endif; ?>
		<h1><i class='glyphicon glyphicon-shopping-cart'></i> Compras de Materia Prima</h1>
		<div class="clearfix"></div>
		<?php
			$reabs = ReabastecimientoData::getAll();
		if(count($reabs)>0){
		?>
		<br>
		<table class="table table-bordered table-hover	">
			<thead>
				<th></th>
				<th>No. Factura</th>
				<th>Proveedor</th>
				<th>Fecha</th>
				<th>Total</th>
				<th></th>
			</thead>
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
					<td style="width:30px;"><!--<a href="index.php?view=delre&id=<?php echo $re->id; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>--></td>
				</tr>
				<?php endforeach; ?>
			</table>
		<?php
		}else{
		?>
		<div class="jumbotron">
			<div class="container">
				<h2>No hay datos</h2>
				<p>No se ha realizado ninguna operacion.</p>
			</div>
		</div>
		<?php
		}
		?>
		<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>
