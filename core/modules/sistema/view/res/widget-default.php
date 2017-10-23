<div class="row">
	<div class="col-md-12">
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
					<td style="width:40px;">
						<?php echo $re->id; ?>
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
