<?php
  if(isset($_GET["id"]) && $_GET["id"]!=""){
    $trasp = TraspasoData::getById($_GET["id"]);
    if (count($trasp)<=0) {
      @header("location:index.php?view=traspasos");
    }
    $prodtrasp = TraspasoData::getAllProductsByTraspasoId($_GET["id"]);
  }
?>
<a class="btn btn-default" href="index.php?view=traspasos"><i class="fa fa-arrow-left"></i> Regresar</a>
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
		<th>ID</th>
		<th>Producto</th>
		<th>Descripci&oacute;n</th>
		<th>Cantidad</th>
	</thead>
<?php
	foreach($prodtrasp as $pt){
		#$prod = $vend->getProduct();
?>
	<tr>
		<td><?php echo $pt->idproducto; ?></td>
		<td><?php echo $pt->getProduct()->nombre; ?></td>
		<td><?php echo $pt->getProduct()->descripcion; ?></td>
		<td><strong><?php echo $pt->cantidad; ?></strong></td>
	</tr>
<?php
	}
	?>
</table>
