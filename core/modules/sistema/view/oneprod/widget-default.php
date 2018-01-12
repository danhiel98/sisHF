<?php if(isset($_GET["id"]) && is_numeric($_GET["id"])){
	$idProd = $_GET["id"];
	$prodxn = ProduccionData::getById($idProd);
	if (is_null($prodxn)) {
		@header("location: index.php?view=produccion");
	}
	$matP = ProduccionMPData::getAllByProdId($idProd);
	
	$estado = "";
	if ($prodxn->terminado == 1) {
		$estado = "Finalizado";
	}else{
		$estado = "En Proceso";
	}

}
?>
<a class="btn btn-default" href="index.php?view=produccion"><i class="fa fa-arrow-left"></i> Regresar</a>
<div class="btn-group pull-right">
	<a class="btn btn-default" href="report/produccion.php?idProd=<?php echo $idProd; ?>"><i class="fa fa-download fa-fw"></i>Reporte</a>
</div>
<h1>Resumen de Producci&oacute;n</h1>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<td style="width:150px;">No.</td>
			<td><strong><?php echo $idProd; ?></strong></td>
		</tr>
		<tr>
			<td style="width:150px;">Estado</td>
			<td><strong><?php echo $estado; ?></strong></td>
		</tr>
		<?php if ($estado == "Finalizado"): ?>
			<tr>
			<td style="width:150px;"><?php echo "Fecha ".$estado; ?></td>
			<td><strong><?php echo $prodxn->fechafinalizado; ?></strong></td>
			</tr>
		<?php endif; ?>
		<tr>
			<td style="width:150px;">Producto</td>
			<td><strong><?php echo $prodxn->getProduct()->nombre; ?></strong></td>
		</tr>
		<tr>
			<td style="width:150px;">Cantidad</td>
			<td><strong><?php echo $prodxn->cantidad; ?></strong></td>
		</tr>
		<tr>
			<td style="width:150px;">Fecha de inicio</td>
			<td><strong><?php echo $prodxn->fechainicio; ?></strong></td>
		</tr>
		<tr>
			<td style="width:150px;">Fecha l&iacute;mite</td>
			<td><strong><?php echo $prodxn->fechafin; ?></strong></td>
		</tr>
		<tr>
			<td style="width:150px;">Registrado por</td>
			<td><strong><?php if (!is_null($prodxn->getUser()->idempleado)){echo $prodxn->getUser()->getEmpleado()->nombrecompleto;}else{echo $prodxn->getUser()->fullname;} ?></strong></td>
		</tr>
	</table>
</div>
<br>
<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>C&oacute;digo</th>
				<th>Nombre del Producto</th>
				<th>Cantidad</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($matP as $mpp): ?>
			<tr>
				<td><?php echo $mpp->id; ?></td>
				<td><?php echo $mpp->getMateriaPrima()->nombre; ?></td>
				<td><?php echo $mpp->cantidad; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
