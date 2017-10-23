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
  $prod = ProductData::getById($_GET["id"]);
  $envios = EnvioProdData::getAllProductsByFactId($_GET["id"]);
  $total = 0;
?>
<table class="table table-bordered">
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
		<th>Codigo</th>
		<th>Cantidad</th>
		<th>Nombre del Producto</th>
		<th>Precio Unitario</th>
		<th>Total</th>
	</thead>
<?php
	foreach($vendidos as $vend){
		$prod = $vend->getProduct();
?>
  <tr>
    <td><?php echo $prod->id ;?></td>
    <td><?php echo $vend->cantidad ;?></td>
	  <td><?php echo $prod->nombre ;?></td>
	  <td>$ <?php echo number_format($prod->precioventa,2,".",",") ;?></td>
	  <td><b>$ <?php echo number_format($vend->cantidad*$prod->precioventa,2,".",","); $total += $vend->cantidad*$prod->precioventa;?></b></td>
  </tr>
<?php
	}
	?>
</table>
<br><br><h1>Total: $ <?php echo number_format($total,2,'.',','); ?></h1>
	<?php

?>
<?php else:?>
	501 Internal Error
<?php endif; ?>
