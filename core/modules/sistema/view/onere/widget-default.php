<a class="btn btn-default" href="index.php?view=res"><i class="fa fa-arrow-left"></i> Regresar</a>
<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="report/onere-word.php?id=<?php echo $_GET["id"];?>">Word 2007 (.docx)</a></li>
  </ul>
</div>
<h1>Resumen de Compra</h1>
<?php if(isset($_GET["id"]) && $_GET["id"]!=""):
  $reab = ReabastecimientoData::getById($_GET["id"]);
  $reabMP = ReabastecimientoMPData::getAllByReabId($_GET["id"]);
  $total = 0;
?>
  <table class="table table-bordered">
  <?php if($reab->idproveedor!=""):
    $prov = $reab->getProvider();
  ?>
    <tr>
    	<th style="width:150px;">Proveedor</th>
    	<td><?php echo $prov->nombre;?></td>
    </tr>
    <tr>
    	<th style="width:150px;">Tipo Comprobante</th>
    	<td><?php echo $reab->tipo;?></td>
    </tr>
    <tr>
    	<th style="width:150px;">No. Comprobante</th>
    	<td><?php echo $reab->comprobante;?></td>
    </tr>
    <tr>
      <th style="width:150px;">Usuario</th>
    	<td><?php echo $reab->getUser()->name." ".$reab->getUser()->lastname;?></td>
    </tr>
  <?php endif; ?>
  </table>
  <br>
  <table class="table table-bordered table-hover">
  	<thead>
  		<th>C&oacute;digo</th>
      <th>Nombre Del Producto</th>
  		<th>Cantidad</th>
  		<th>Precio Unitario</th>
  		<th>Total</th>
  	</thead>
  <?php
  	foreach($reabMP as $rb){
  		$mp = $rb->getMateriaPrima();
  ?>
  <tr>
  	<td><?php echo $mp->id ;?></td>
    <td><?php echo $mp->nombre ;?></td>
  	<td><?php echo $rb->cantidad ;?></td>
  	<td>$ <?php echo number_format($rb->precio,2,".",",") ;?></td>
  	<td><b>$ <?php echo number_format($rb->total,2,".",","); $total += $rb->total;?></b></td>
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
