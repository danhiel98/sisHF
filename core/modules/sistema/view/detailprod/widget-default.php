<?php
	if(isset($_GET["idProd"]) && !empty($_GET["idProd"])):
		$product = ProductData::getById($_GET["idProd"]);
		$traspasos = TraspasoData::getAllTraspasosByProductId($_GET["idProd"]);
		if(is_null($product)){
			@header("location: index.php?view=inventaryprod");
		}
?>
		<a class="btn btn-default" href="index.php?view=inventaryprod"><i class="fa fa-arrow-left"></i> Regresar</a>
		<div class="row">
			<div class="col-md-12">
				<h1><?php echo $product->nombre; ?> <small>Detalles De Existencias</small></h1>
			</div>
		</div>
		<div class="row">
		<?php $prodSuc = ProductoSucursalData::getAllByProductId($product->id); ?>
		<?php foreach ($prodSuc as $ps): ?>
			<div class="col-md-4">
				<div class="jumbotron">
					<center>
						<h2><?php echo $ps->getSucursal()->nombre; ?></h2>
						<h1><?php echo $ps->cantidad; ?></h1>
					</center>
				</div>
			</div>
		<?php endforeach; ?>
			<br>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php if(count($traspasos)>0):?>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>No.</th>
							<th>Origen</th>
							<th>Destino</th>
							<th>Cantidad</th>
							<th>Fecha</th>
						</tr>
					</thead>
				<?php $n = 0; ?>
				<?php foreach($traspasos as $ts):?>
					<tr>
						<td><?php echo ++$n; ?></td>
						<td><?php echo $ts->getTraspaso()->getSucursalO()->nombre; ?></td>
						<td><?php echo $ts->getTraspaso()->getSucursalD()->nombre; ?></td>
						<td><?php echo $ts->cantidad; ?></td>
						<td><?php echo $ts->getTraspaso()->fecha; ?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			<?php else: ?>
				<div class="alert alert-warning">
					No se han realizado traspasos de este producto.
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php else: ?>
	<script type="text/javascript">
		window.location = "index.php?view=inventaryprod";
	</script>
<?php endif; ?>
