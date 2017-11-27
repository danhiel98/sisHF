<?php if (isset($_GET["x"]) && !empty($_GET["x"])): ?>
  <?php $id = $_GET["x"]; ?>
  <a class="btn btn-default" href="index.php?view=b&id=<?php echo $id; ?>"><i class="fa fa-arrow-left"></i> Regresar</a>
<?php elseif(isset($_GET["b"])): ?>
  <a class="btn btn-default" href="index.php?view=box"><i class="fa fa-arrow-left"></i> Regresar</a>
<?php else: ?>
  <a class="btn btn-default" href="index.php?view=sells"><i class="fa fa-arrow-left"></i> Regresar</a>
<?php endif; ?>

<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="report/onesell-word.php?id=<?php echo $_GET["id"];?>">Word 2007 (.docx)</a></li>
  </ul>
</div>
<h1>Resumen de Venta</h1>
<?php if(isset($_GET["id"]) && $_GET["id"]!=""):?>
<?php
  $sell = FacturaData::getById($_GET["id"]);
  if (is_null($sell)) {
    @header("location: index.php?view=sells");
  }
  $pVend = FacturaData::getAllSellsByFactId($_GET["id"]);
  $sVend = FacturaData::getAllServicesByFactId($_GET["id"]);
  $total = 0;
?>
<?php
  if(isset($_COOKIE["selled"])){
    setcookie("selled","",time()-18600);
  }
?>
<table class="table table-bordered">
  <tr>
    <td>No. <?php echo $sell->tipo; ?></td>
    <td><?php echo $sell->numerofactura; ?></td>
  </tr>
  <tr>
    <td>Fecha</td>
    <td><?php echo $sell->fecha; ?></td>
  </tr>
  <?php if($sell->idcliente != ""):
    $client = $sell->getClient();
    ?>
  <tr>
	   <td style="width:150px;">Cliente</td>
	   <td><?php echo $client->name." ".$client->lastname;?></td>
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
</table>
<br>
<table class="table table-bordered table-hover">
	<thead>
		<th>C&oacute;digo</th>
		<th>Cantidad</th>
		<th>Nombre del Producto / Servicio</th>
		<th>Precio Unitario</th>
		<th>Total</th>
	</thead>
<?php
	foreach($pVend as $vend):
		$prod = $vend->getProduct();
?>
  <tr>
    <td><?php echo $prod->id ;?></td>
    <td><?php echo $vend->cantidad ;?></td>
	  <td><?php echo $prod->nombre ;?></td>
	  <td>$ <?php echo number_format($prod->precioventa,2,".",",") ;?></td>
	  <td><b>$ <?php echo number_format($vend->cantidad*$prod->precioventa,2,".",","); $total += $vend->cantidad*$prod->precioventa;?></b></td>
  </tr>
  <?php	endforeach;	?>
  <?php
    foreach ($sVend as $vend):
      $prod = $vend->getService();
  ?>
    <tr>
      <td><?php echo $prod->id ;?></td>
      <td><?php echo $vend->cantidad ;?></td>
  	  <td><?php echo $prod->nombre ;?></td>
  	  <td>$ <?php echo number_format($prod->precio,2,".",",") ;?></td>
  	  <td><b>$ <?php echo number_format($vend->cantidad*$prod->precio,2,".",","); $total += $vend->cantidad*$prod->precio;?></b></td>
    </tr>
  <?php endforeach; ?>
</table>
<br><br>
<h1>Total: $ <?php echo number_format($total,2,'.',','); ?></h1>
<?php else:?>
	501 Internal Error
<?php endif; ?>
