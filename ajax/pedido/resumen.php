<?php
	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ServiceData.php");
	include ("../../core/modules/sistema/model/ConfigurationData.php");
?>
	<?php if (isset($_SESSION["cartp"]) && !empty($_SESSION["cartp"])):?>
		<table class="table table-bordered">
			<thead>
				<th>Producto/Servicio</th>
				<th style="text-align:center;">Precio</th>
				<th style="text-align:center;">Cantidad</th>
				<th style="text-align:center;">Total</th>
				<th style="text-align:center;">Mantto</th>
			</thead>
			<tbody>
			<?php
			$total = $totalx = 0;
				foreach($_SESSION["cartp"] as $c):
					$prd = false;
					$srv = false;
					if ($c["product_id"] != "") {
						$prd = true;
						$prod = ProductData::getById($c["product_id"]);
						$totalx = $prod->precioventa * $c["cantidad"];
					}elseif($c["service_id"] != ""){
						$srv = true;
						$prod = ServiceData::getById($c["service_id"]);
						$prod->precioventa = $prod->precio;
						$totalx = $prod->precioventa * $c["cantidad"];
					}
					$total += $totalx;
				?>
				<tr>
					<td><?php echo $prod->nombre; ?></td>
					<td style="width:80px; text-align:center;">$ <?php echo number_format($prod->precioventa,2,".",","); ?></td>
					<td style="width:60px; text-align:center;"><?php echo $c["cantidad"]; ?></td>
					<td style="width:95px; text-align:center;">$ <?php echo number_format($totalx,2,".",","); ?></td>
					<td style="width:40px; text-align:center;"><span class="fa fa-<?php if($c['mantenimiento'] == 1){echo "check";}else{echo "times";} ?>"></span></td>
				</tr>
			</tbody>
			<?php endforeach; ?>
		</table>
		<div class="row">
			<div class="col-md-4 pull-right">
				<span style="font-size: 1.2em;">
					Restante: <strong id="restante">$ <?php echo number_format($total/2,2,".",","); ?></strong>
				</span>
			</div>
			<div class="col-md-3 pull-right">
				<span style="font-size: 1.2em;">
					Total a pagar: <strong>$ <?php echo number_format($total,2,".",","); ?></strong>
				</span>
			</div>
			<div class="col-md-3 pull-right" id="groupIva">
				<?php
					$iva = ConfigurationData::getByName("iva");
					$valorIva = $iva[0]->value * $total;
				?>
				<span style="font-size: 1.2em;">
					IVA: <strong>$ <?php echo number_format($valorIva,2,".",","); ?></strong>
				</span>
			</div>
		</div>
		<script type="text/javascript">
			$(function(){
				$("#groupIva").hide();
				$("#cantidad").val("<?php echo number_format(($total/2),2,".",""); ?>");
			});
		</script>
	<?php else: ?>
		<div class="alert alert-warning">
			<p>Aún no se han agregado productos al pedido.</p>
		</div>
	<?php endif; ?>