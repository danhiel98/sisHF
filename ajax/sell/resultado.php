<?php
	
	session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ProductoSucursalData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");
	include ("../../core/modules/sistema/model/ServiceData.php");
	
	$idSucursal = $_SESSION["usr_suc"];
	$prod = false;

	$servicios = ServiceData::getAll();
	$productosT = ProductoSucursalData::getAllBySucId($idSucursal); #Todos los productos que hay en la sucursal
	$productos = ProductoSucursalData::getAllForSell($idSucursal); #Todos los productoq que su existencia es mayor a 0
	$cant = (count($productosT) - count($productos));
?>

<div id="prods" class="tab-pane fade in active">
	<p><b>Buscar producto por nombre:</b></p>
	<div class="row">
		<div class="col-md-5 col-sm-6 col-xs-10">
			<div class="input-group">
				<input type="text" name="product" placeholder="Buscar producto" class="form-control busqueda" data-tipo="prd" autofocus="autofocus">
				<span class="input-group-addon"><i class="fa fa-search fa-fw"></i>Buscar</span>
			</div>
		</div>
		<div class="clearfix"></div>
		<br>
		<div class="col-md-12 table-responsive" id="searchProd">
			<?php
			if($cant > 0){
				echo "<a href='index.php?view=inventaryprod' target='_blank'>Se omitieron $cant producto(s)</a>";
			}
			if (count($productos) > 0){
			?>
				<table class="table table-bordered table-hover">
					<thead>
						<th style="width: 45px;">Id</th>
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
						$cantidad = 0;
						if(isset($_SESSION["cart"])){
							foreach ($_SESSION["cart"] as $c) {
								if($c["product_id"] == $prod->idproducto){
									$found = true;
									$cantidad = $c["cantidad"];
									if($c["mantenimiento"] == 1){
										$mantto = true;
									}
									break;
								}
							}
						}
						?>
						<tr>
							<td><?php echo $prod->getProduct()->id; ?></td>
							<td><?php echo $prod->getProduct()->nombre; ?></td>
							<td><?php echo $prod->cantidad; ?></td>
							<td>$ <?php echo number_format($prod->getProduct()->precioventa,2,".",",") ?></td>
							<td align="center">
								<?php if ($prod->getProduct()->mantenimiento == 1):?>
								<input type="checkbox" class="mantto" data-id="<?php echo $prod->idproducto; ?>" id="<?php echo $prod->idproducto; ?>" <?php if($found){echo " disabled ";} if($mantto){echo " checked ";}?>>
								<?php else: ?>
								<span class="fa fa-times"></span>
								<?php endif; ?>
							</td>
							<td>
								<form class="form-inline enviar" data-type="product" method="POST" action="ajax/sell/<?php if($found){echo "quitar";}else{ echo "addxsell";} ?>.php">
									<input type="hidden" class="idProd" name="product_id" value="<?php echo $prod->idproducto; ?>">
									<input type="hidden" name="mantenimiento" value="0" id="m<?php echo $prod->idproducto; ?>">
									<input type="hidden" name="service_id" value="" required>
									<div class="form-group control-group">
										<div class="controls">
											<div class="input-group">
												<input type="text" class="form-control input-sm" name="cantidad" value="<?php if($found){echo $cantidad;}else{ echo "1";} ?>" style="max-width:65px;" min="1" max="<?php echo $prod->cantidad; ?>" placeholder="Cantidad" pattern="[\d]{1,8}" onkeypress="return soloNumeros(event)" maxlength="8" required <?php if($found){echo "disabled=disabled";} ?>>
												<span class="input-group-btn">
													<button type="submit" class="btn btn-sm <?php if($found){echo "btn-danger";}else{ echo "btn-success";} ?>"><i class="fa <?php if($found){echo "fa-times";}else{ echo "fa-cart-plus";} ?>"></i></button>
												</span>
											</div>
										</div>
									</div>
								</form>
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
		</div>
	</div>
</div>
<div id="servs" class="tab-pane fade">
	<p><b>Agregar servicio a la venta</b></p>
	<div class="row">
		<div class="col-md-5 col-sm-6 col-xs-10">
			<div class="input-group">
				<input type="text" name="product" placeholder="Buscar servicio" class="form-control busqueda" data-tipo="srv">
				<span class="input-group-addon"><i class="fa fa-search fa-fw"></i>Buscar</span>
			</div>
		</div>
		<div class="clearfix"></div>
		<br>
		<div class="col-md-12 table-responsive" id="searchServ">
			<?php
			if (count($servicios)>0):?>
				<table class="table table-bordered table-hover">
					<thead>
						<th style="width:45px;">Id</th>
						<th>Servicio</th>
						<th>Precio</th>
						<th style="width: 140px;"></th>
					</thead>
					<tbody>
					<?php foreach ($servicios as $srv): $found = false; $cantidad = 0; ?>
						<tr>
							<td><?php echo $srv->id; ?></td>
							<td><?php echo $srv->nombre; ?></td>
							<td>$ <?php echo $srv->precio; ?></td>
							<td>
								<?php if(isset($_SESSION["cart"])){ foreach ($_SESSION["cart"] as $c) { if($c["service_id"] == $srv->id){ $cantidad = $c["cantidad"]; $found=true; break; }}} ?>
								<form class="form-inline enviar" data-type="service" method="post" action="ajax/sell/<?php if($found){echo "quitar";}else{ echo "addxsell";} ?>.php">
									<input type="hidden" class="idServ" name="service_id" value="<?php echo $srv->id; ?>">
									<input type="hidden" name="product_id" value="" required>
									<div class="form-group control-group">
										<div class="controls">
											<div class="input-group">
												<input type="text" class="form-control input-sm" name="cantidad" value="<?php if($found){echo $cantidad;}else{ echo "1";} ?>" style="width:85px;" min="1" placeholder="Cantidad" pattern="[\d]{1,8}" onkeypress="return soloNumeros(event)" maxlength="8" required <?php if($found){echo "disabled=disabled";} ?>>
												<span class="input-group-btn">
													<button type="submit" class="btn btn-sm <?php if($found){echo "btn-danger";}else{ echo "btn-success";} ?>"><i class="fa <?php if($found){echo "fa-times";}else{ echo "fa-cart-plus";} ?>"></i></button>
												</span>
											</div>
										</div>
									</div>
								</form>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php else: ?>
				<div class="alert alert-warning">
					No se encontraron servicios.
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<script>
    $.getScript("ajax/sell/cart.js")
    .done(function(script, textStatus) {
		// console.log("Se cargó el script nuevamente");
    })
    .fail(function(jqxhr, settings, exception) {
        console.log("No se pudo cargar el script");
    });
</script>