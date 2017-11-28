<a class="btn btn-default" href="index.php?view=produccion"><i class="fa fa-arrow-left"></i> Regresar</a>
<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="report/onesell-word.php?id=<?php echo $_GET["id"];?>">Word 2007 (.docx)</a></li>
  </ul>
</div>
<h1>Resumen de Producci&oacute;n</h1>
<?php if(isset($_GET["id"]) && $_GET["id"] != ""):?>
<?php
  $prodxn = ProduccionData::getById($_GET["id"]);
  if (is_null($prodxn)) {
    @header("location: index.php?view=produccion");
  }
  $matP = ProduccionMPData::getAllByProdId($_GET["id"]);
  $total = 0;
  $estado = "";
  if ($prodxn->terminado == 1) {
    $estado = "Finalizado";
  }elseif ($prodxn->cancelado == 1) {
    $estado = "Cancelado";
  }else{
    $estado = "En Proceso";
  }
?>
<table class="table table-bordered">
  <tr>
    <td style="width:150px;">No.</td>
    <td><strong><?php echo $prodxn->id; ?></strong></td>
  </tr>
  <tr>
    <td style="width:150px;">Estado</td>
    <td><strong><?php echo $estado; ?></strong></td>
  </tr>
  <?php if ($estado != "En Proceso"): ?>
    <tr>
      <td style="width:150px;"><?php echo $estado; ?></td>
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
    <td><strong><?php echo $prodxn->getUser()->name." ".$prodxn->getUser()->lastname; ?></strong></td>
  </tr>
</table>
<br>
<table class="table table-bordered table-hover">
	<thead>
		<th>C&oacute;digo</th>
    <th>Nombre del Producto</th>
		<th>Cantidad</th>
	</thead>
<?php
	foreach($matP as $mpp){
?>
  <tr>
    <td><?php echo $mpp->id ;?></td>
    <td><?php echo $mpp->getMateriaPrima()->nombre ;?></td>
    <td><?php echo $mpp->cantidad ;?></td>
  </tr>
<?php
	}
	?>
</table>
<?php else:?>
	501 Internal Error
<?php endif; ?>
