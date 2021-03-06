<?php
	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ServiceData.php");
	include ("../../core/modules/sistema/model/ConfigurationData.php");
?>
	<?php if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])): ?>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Producto/Servicio</th>
						<th style="text-align:center;">Precio</th>
						<th style="text-align:center;">Cantidad</th>
						<th style="text-align:center;">Total</th>
						<th style="text-align:center;">Mantto</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$total = $totalx = 0;
					foreach($_SESSION["cart"] as $c):
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
					<input type="hidden" name="total" id="total" value="<?php echo $total; ?>">
					<tr>
						<td><?php echo $prod->nombre; ?></td>
						<td style="width:80px; text-align:center;">$ <?php echo number_format($prod->precioventa,2,".",","); ?></td>
						<td style="width:70px; text-align:center;"><?php echo $c["cantidad"]; ?></td>
						<td style="width:95px; text-align:center;">$ <?php echo number_format($totalx,2,".",","); ?></td>
						<td style="width:40px; text-align:center;"><span class="fa fa-<?php if($c['mantenimiento'] == 1){echo "check";}else{echo "times";} ?>"></span></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-md-5 pull-right">
				<h3>
					Total a pagar: <strong>$ <?php echo number_format($total,2,".",","); ?></strong>
				</h3>
			</div>
			<div class="col-md-5 pull-right" id="groupIva">
				<?php
					$iva = ConfigurationData::getByName("iva");
					$valorIva = $iva[0]->value * $total;
				?>
				<h3>
					IVA: <strong>$ <?php echo number_format($valorIva,2,".",","); ?></strong>
				</h3>
			</div>
		</div>
		
	<?php else: ?>
		<div class="alert alert-warning">
			<p>Aún no se han agregado productos a la venta.</p>
		</div>
	<?php endif; ?>