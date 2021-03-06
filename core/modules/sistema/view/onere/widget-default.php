<?php
	if( isset($_GET["id"]) && is_numeric($_GET["id"])){
  		$reab = ReabastecimientoData::getById($_GET["id"]);
  		if (is_null($reab)) {
    		@header("location: index.php?view=res");
  		}
  		$reabMP = ReabastecimientoMPData::getAllByReabId($_GET["id"]);
		$prov = $reab->getProvider();
		$total = 0;
	}else{
		error();
	}
?>

	<a class="btn btn-default" href="index.php?view=res"><i class="fa fa-arrow-left"></i> Regresar</a>
	<div class="btn-group pull-right">
		<a class="btn btn-default" href="report/resumendecompra.php?id=<?php echo $_GET["id"];?>"><i class="fa fa-download fa-fw"></i> Descargar</a>
	</div>

	<h1>Resumen de Compra</h1>
	
	<table class="table table-bordered">
		<tr>
			<th style="width:150px;">Proveedor</th>
			<td><?php echo $prov->nombre;?></td>
		</tr>
		<tr>
			<th style="width:150px;">Tipo Comprobante</th>
			<td>
			<?php
				if ($reab->tipoComprobante != null){
					echo $reab->getComprobante()->nombre;
				}else{
					echo "NINGUNO";
				}
			?>
			</td>
		</tr>
		<tr>
			<th style="width:150px;">No. Comprobante</th>
			<td><?php echo $reab->comprobante;?></td>
		</tr>
		<tr>
			<th style="width:150px;">Usuario</th>
			<td><?php echo $reab->getUser()->name." ".$reab->getUser()->lastname;?></td>
		</tr>
	</table>
	<br>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Nombre Del Producto</th>
				<th>Cantidad</th>
				<th>Precio Unitario</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach($reabMP as $rb):
				$mp = $rb->getMateriaPrima();
			?>
			<tr>
				<td><?php echo $mp->nombre ;?></td>
				<td><?php echo $rb->cantidad ;?></td>
				<td>$ <?php echo number_format($rb->precio,2,".",",") ;?></td>
				<td><b>$ <?php echo number_format($rb->total,2,".",","); $total += $rb->total;?></b></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<br><br><h1>Total: $ <?php echo number_format($total,2,'.',','); ?></h1>
