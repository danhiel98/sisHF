<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
  		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    		<i class="fa fa-download"></i> Descargar <span class="caret"></span>
  		</button>
  		<ul class="dropdown-menu" role="menu">
    		<li><a href="report/boxhistory-word.php">Word 2007 (.docx)</a></li>
  		</ul>
		</div>
		<h1><i class='fa fa-archive'></i> Cortes de Caja</h1>
		<div class="clearfix"></div>
		<?php
			$boxes = BoxData::getAll();
			if(count($boxes)>0){
				$total_total = 0;
		?>
		<br>
		<table class="table table-bordered table-hover	">
			<thead>
				<th></th>
				<th>No.</th>
				<th>Total</th>
				<th>Fecha</th>
			</thead>
			<?php foreach($boxes as $box):
				$facts = FacturaData::getByBoxId($box->id);
			?>
			<tr>
				<td style="width:30px;">
					<a href="./index.php?view=b&id=<?php echo $box->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-right"></i></a>
				</td>
				<td style="width:50px;"><?php echo $box->id; ?></td>
				<td>
				<?php
					$total=0;
					foreach($facts as $fc){
						$sells = FacturaData::getAllSellsByFactId($fc->id);
						foreach ($sells as $s) {
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
		<br><br><br><br><br><br><br><br>
	</div>
</div>
