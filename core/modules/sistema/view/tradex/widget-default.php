<?php
	if(isset($_GET["id"]) && is_numeric($_GET["id"])){
		$trasp = TraspasoData::getById($_GET["id"]);
		if (count($trasp)<=0) {
		@header("location:index.php?view=traspasos");
		}
		$prodtrasp = TraspasoData::getAllProductsByTraspasoId($_GET["id"]);
	}else{
		error();
	}
?>
	<a class="btn btn-default btn-back" href="index.php?view=traspasos"><i class="fa fa-arrow-left"></i> Regresar</a>
	<div class="btn-group pull-right">
		<a class="btn btn-default" href="report/traspasodetalle.php?id=<?php echo $_GET["id"];?>"><i class="fa fa-download fa-fw"></i> Descargar</a>
	</div>
	<h1>Resumen De Traspaso</h1>
	<table class="table table-bordered">
		<tr>
			<th style="width:150px;">Fecha</th>
			<td><?php echo $trasp->fecha; ?></td>
		</tr>
		<tr>
			<th style="width:150px;">Origen</hd>
			<td><?php echo $trasp->getSucursalO()->nombre; ?></td>
		</tr>
		<tr>
			<th style="width:150px;">Destino<htd>
			<td><?php echo $trasp->getSucursalD()->nombre; ?></td>
		</tr>
		<tr>
			<th style="width:150px;">Realizado por:<htd>
			<td><?php echo $trasp->getUser()->name." ".$trasp->getUser()->lastname; ?></td>
		</tr>
	</table>
	<table class="table table-bordered table-hover table-responsive">
		<thead>
			<th>Producto</th>
			<th>Descripci&oacute;n</th>
			<th>Cantidad</th>
		</thead>
		<tbody>
			<?php foreach($prodtrasp as $pt): ?>
				<tr>
					<td><?php echo $pt->getProduct()->nombre; ?></td>
					<td><?php echo $pt->getProduct()->descripcion; ?></td>
					<td style="width: 50px;"><strong><?php echo $pt->cantidad; ?></strong></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<script>
		btnBack = $(".btn-back");
		vHash = document.location.hash;
		href = btnBack.attr("href") + vHash;
		btnBack.attr("href",href);
	</script>