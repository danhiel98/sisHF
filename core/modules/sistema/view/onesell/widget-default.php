<?php
if(isset($_GET["id"]) && $_GET["id"] != ""){
	$idFact = $_GET["id"];
  	$sell = FacturaData::getById($idFact);
	if (is_null($sell)) {
		@header("location: index.php?view=sells");
	}
	$pVend = FacturaData::getAllSellsByFactId($idFact);
	$sVend = FacturaData::getAllServicesByFactId($idFact);
	$total = 0;
	
	$comprobante = $sell->getComprobante();

	$strComp = "";

	switch($comprobante->nombre){
		case "Factura":
			$strComp = "factura";
			break;
		case "Comprobante de Crédito Fiscal":
			$strComp = "ccf";
			break;
		case "Recibo":
			$strComp = "recibo";
			break;
		default:
			break;
	}

}else{
	@header("location: index.php?view=sells");
}

?>

<?php if (isset($_GET["x"]) && !empty($_GET["x"])): ?>
	<?php $id = $_GET["x"]; ?>
	<a class="btn btn-default" href="index.php?view=b&id=<?php echo $id; ?>"><i class="fa fa-arrow-left"></i> Regresar</a>
<?php elseif(isset($_GET["b"])): ?>
	<a class="btn btn-default" href="index.php?view=box"><i class="fa fa-arrow-left"></i> Regresar</a>
<?php else: ?>
	<a class="btn btn-default" href="index.php?view=sells"><i class="fa fa-arrow-left"></i> Regresar</a>
<?php endif; ?>

<div class="btn-group pull-right">
	<a class="btn btn-default" target="_blank" href="report/facturas/<?php echo $strComp; ?>.php?id=<?php echo $idFact;?>"><i class="fa fa-download fa-fw"></i> Descargar</a>
</div>
<h1>Resumen de Venta</h1>

<?php
  if(isset($_COOKIE["selled"])){
    setcookie("selled","",time()-18600);
  }
?>
<table class="table table-bordered">
	<tr>
		<td>No. <?php echo $comprobante->nombre; ?></td>
		<td><?php echo $sell->numerofactura; ?></td>
	</tr>
	<tr>
		<td>Fecha</td>
		<td><?php echo $sell->fecha; ?></td>
	</tr>
	<?php
	if($sell->idcliente != ""):
		$client = $sell->getClient();
	?>
	<tr>
		<td style="width:150px;">Cliente</td>
		<td><?php echo $client->name;?></td>
	</tr>
	<?php endif; ?>
	<?php if($sell->idusuario != ""):
		$user = $sell->getUser();
	?>
	<tr>
		<td>Atendido por</td>
		<td><?php echo $user->name." ".$user->lastname;?></td>
	</tr>
	<?php endif; ?>
<tr>
	<td>Son</td>
	<td><?php echo $sell->totalLetras; ?></td>
</tr>
</table>
<br>
<table class="table table-bordered table-hover">
	<thead>
		<th>Nombre del Producto / Servicio</th>
		<th>Cantidad</th>
		<th>Precio Unitario</th>
		<th>Total</th>
	</thead>
<?php
	foreach($pVend as $vend):
		$prod = $vend->getProduct();
?>
  <tr>
	<td><?php echo $prod->nombre ;?></td>
	<td><?php echo $vend->cantidad ;?></td>
	<td>$ <?php echo number_format($vend->precio,2,".",",") ;?></td>
	<td><b>$ <?php echo number_format($vend->total,2,".",","); $total += $vend->total;?></b></td>
  </tr>
  <?php	endforeach;	?>
  <?php
    foreach ($sVend as $vend):
      $prod = $vend->getService();
  ?>
    <tr>
  	  <td><?php echo $prod->nombre ;?></td>
      <td><?php echo $vend->cantidad ;?></td>
  	  <td>$ <?php echo number_format($vend->precio,2,".",",") ;?></td>
  	  <td><b>$ <?php echo number_format($vend->total,2,".",","); $total += $vend->total;?></b></td>
    </tr>
  <?php endforeach; ?>
</table>
<br><br>
<div class="row">
  <div class="col-md-5 pull-right">
    <h1>Total: $ <?php echo number_format($total,2,'.',','); ?></h1>
  </div>
  <?php if ($sell->tipoComprobante == 2): ?>
  <div class="col-md-5">
    <?php
      $iva = ConfigurationData::getByName("iva");
      $valorIva = $iva[0]->value * $total;
    ?>
    <h1>IVA: $ <?php echo number_format($valorIva,2,".",","); ?></h1>
  </div>
  <?php endif; ?>
</div>
