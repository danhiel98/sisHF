<?php
	$cajaC = CajaChicaData::getAll();
	#include ("modals/encargado.php");
	include ("modals/ingreso.php");
	include ("modals/salida.php");
	$cajaC = CajaChicaData::getAll();
?>
<div class="row">
	<div class="col-md-12">
<div class="btn-group pull-right">
	<button class="btn btn-default" data-toggle="modal" data-target="#ingreso"><i class='fa fa-plus fa-fw'></i> Ingreso</button>
	<?php if ($cajaC->cantidad > 0): ?>
		<button class="btn btn-default" data-toggle="modal" data-target="#salida"><i class='fa fa-minus fa-fw'></i> Salida</button>
	<?php endif; ?>
</div>
	<h1><i class='fa fa-archive'></i> Caja Chica</h1>
	<div class="clearfix"></div>
	<?php
		if($cajaC != null){
	?>
		<br>
		<!--
			IMPORTANTE:
			* Hacer el diseño de la caja chica con elementos jumbotron o parecidos.
			* Debe haber un campo para registrar la cantidad mínima de dinero que debe haber en caja.
		-->
		<table class="table table-bordered table-hover" class="sbox">
			<thead>
				<th style="width: 150px;">Total Entradas</th>
				<td>$ <?php echo number_format($cajaC->entradas,2,'.',','); ?></td>
				<td style="width: 20px;"><a class="btn btn-primary btn-xs" <?php if($cajaC->entradas <= 0){ echo "disabled onclick='return false'";} ?> href="index.php?view=sboxe&val=ent"><i class="fa fa-arrow-right"></i> Historial</a></td>
			</thead>
			<thead>
				<th style="width: 150px;">Total Salidas</th>
				<td>$ <?php echo number_format($cajaC->salidas,2,'.',','); ?></td>
				<td style="width: 20px;"><a class="btn btn-primary btn-xs" <?php if($cajaC->salidas <= 0){ echo "disabled onclick='return false'";} ?> href="index.php?view=sboxe&val=sal"><i class="fa fa-arrow-right"></i> Historial</a></td>
			</thead>
		</table>
		<h1>Disponible: $ <?php echo number_format($cajaC->cantidad,2,'.',','); ?></h1>
		<?php
		}else {
		?>
		<div class="jumbotron">
			<div class="container">
				<h2>Error</h2>
				<p>Consulte al administrador del sistema.</p>
			</div>
		</div>
		<?php } ?>
		<br><br><br><br><br>
	</div>
</div>
