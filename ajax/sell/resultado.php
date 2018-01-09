<?php
	
	session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ProductoSucursalData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");
	
	$idSucursal = $_SESSION["usr_suc"];
	$prod = false;

	$productos = ProductoSucursalData::getAllForSell($idSucursal);
	
	if(isset($_POST['productos'])){
		
		$productos = array();
		$prod = true;
		
		$nombreProd = $_POST['productos'];
		$products = ProductData::getLike($nombreProd);

		foreach ($products as $prd){
			$prodSuc = ProductoSucursalData::getBySucursalProducto($idSucursal,$prd->id);
			if (count($prodSuc) == 1 && $prodSuc->cantidad > 0){
				array_push($productos,$prodSuc);
			}
		}
	}
	
	if (count($productos) > 0){
		?>
		<table class="table table-bordered table-hover">
			<thead>
				<th style="width: 45px;">ID</th>
				<th>Producto</th>
				<th style="width: 200px;">Disponibles</th>
				<th style="width: 200px;">Precio Unitario</th>
				<th style="width: 120px;">Mantenimiento</th>
				<th style="width: 120px;"></th>
			</thead>
			<tbody>
			<?php
			foreach($productos as $prod){
				$found = false;
				$mantto = false;
				?>
				<tr>
					<?php
						if(isset($_SESSION["cart"])){
							foreach ($_SESSION["cart"] as $c) {
								if($c["product_id"] == $prod->idproducto){
									$found=true;
									if($c["mantenimiento"] == 1){
										$mantto = true;
									}
									break;
								}
							}
						}
					?>
					<td><?php echo $prod->getProduct()->id; ?></td>
					<td><?php echo $prod->getProduct()->nombre; ?></td>
					<td><?php echo $prod->cantidad; ?></td>
					<td>$ <?php echo number_format($prod->getProduct()->precioventa,2,".",",") ?></td>
					<td align="center">
						<?php if ($prod->getProduct()->mantenimiento == 1):?>
						<input type="checkbox" class="mantto" id="<?php echo $prod->idproducto; ?>" <?php if($found){echo " disabled ";} if($mantto){echo " checked ";}?>>
						<?php else: ?>
						<span class="fa fa-times"></span>
						<?php endif; ?>
					</td>
					<td>
					<?php if ($found): ?>
						<a data-toggle="modal" data-target="#resumen" class="btn btn-info"><i class="fa fa-check fa-fw"></i>Agregado</a>
					<?php else: ?>
						<form class="form-inline enviar" method="POST" action="ajax/sell/addxsell.php">
							<input type="hidden" name="product_id" value="<?php echo $prod->idproducto; ?>">
							<input type="hidden" name="mantenimiento" value="0" id="m<?php echo $prod->idproducto; ?>">
							<input type="hidden" name="service_id" value="" required>
							<div class="form-group control-group">
								<div class="controls">
									<input type="text" class="form-control input-sm" name="cantidad" value="1" style="max-width:65px;" min="1" max="<?php echo $prod->cantidad; ?>" placeholder="Cantidad" pattern="[\d]{1,8}" onkeypress="return soloNumeros(event)" maxlength="8" required>
									<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-cart-plus"></i></button>
									<p class="help-block"></p>
								</div>
							</div>
						</form>
					<?php endif; ?>
					</td>
				</tr>
			<?php
				}
			?>
			
			</tbody>
		</table>
		<script type="text/javascript">
			$(".mantto").on("change", function(){
				if (this.checked) {
					$("#m"+this.id).val("1");
				}else{
					$("#m"+this.id).val("0");
				}
			});

			$(document).ready(function(){
				$("form.enviar").submit(function(){
					if($(".input-sm",this).attr("aria-invalid") != "true"){
						$.ajax({
							url: $(this).attr("action"),
							type: "POST",
							data: $(this).serialize(),
							success: function(){
								obtener_registros();
								obtenerInfo();
							}
						});
					}
					return false;
				});
			});
		</script>
		<?php
		}else{
		?>
		<div class="alert alert-danger">
		<?php if ($prod): ?>
			No se encontraron coincidencias con sus criterios de búsqueda.
		<?php else: ?>
			No hay productos disponibles en esta sucursal.
		<?php endif; ?>
		</div>
	<?php
		}
?>