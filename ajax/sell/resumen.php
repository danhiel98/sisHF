<?php
	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ServiceData.php");
	include ("../../core/modules/sistema/model/ConfigurationData.php");
?>
	<?php if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) { ?>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<th>Producto/Servicio</th>
					<th style="text-align:center;">Precio</th>
					<th style="text-align:center;">Cantidad</th>
					<th style="text-align:center;">Total</th>
					<th style="text-align:center;">Mantto</th>
					<th></th>
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
						<td style="width:30px; text-align:center;">
							<a data-type="<?php if($prd){echo 'prod';}elseif($srv){echo 'serv';} ?>" id="<?php if($prd){echo $c['product_id'];}elseif($srv){echo $c['service_id'];} ?>" class="btn btn-danger btn-xs btn-del"><i class="fa fa-times"></i></a>
						</td>
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
		<script type="text/javascript">
			/*
			function resumen(){
				datosResumen();
				var idSuc = $("#sOrigen").val();
				obtenerDatosDeSucursal(idSuc);
				obtenerServ();
			}
			*/
			$(function(){
				$("#groupIva").hide();
				$("[data-type=prod].btn-del").on("click",function(){
					$.ajax({
						url: "ajax/sell/quitar.php",
						type: "POST",
						data: {idProd : this.id},
						success: function(){
							console.log("Todo bien prod");
						}
					});
					obtenerInfo();
					obtener_registros();
				});
				$("[data-type=serv].btn-del").on("click",function(){
					$.ajax({
						url: "ajax/sell/quitar.php",
						type: "POST",
						data: {idServ : this.id},
						success: function(){
							console.log("Todo bien serv")
						}
					});
					obtenerInfo();
					obtener_registros();
				});
			});
		</script>
		<?php }else{ ?>
			<script type="text/javascript">
				$("#modal-body").html('<p class="alert alert-warning">No ha agregado productos.</p>');
				$("#modal-footer").html('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
			</script>
		<?php } ?>