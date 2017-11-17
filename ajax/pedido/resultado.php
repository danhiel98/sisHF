<?php
	session_start();
	$host = 'localhost';
	$basededatos = 'sistemaHierroForjado';
	$usuario = 'root';
	$contrasena = '';

	$conexion = new mysqli($host, $usuario,$contrasena, $basededatos);
	if ($conexion->connect_errno){
		die("Falló la conexión:(".$conexion -> mysqli_connect_errno().")".$conexion->mysqli_connect_error());
	}

	$idSucursal = $_POST["sucursal"];
	$prod = false;

	$query="SELECT ps.idProductoSucursal, ps.idProducto, ps.idSucursal, ps.cantidad,
		p.idProducto, p.nombre, p.descripcion, p.mantenimiento, p.precioVenta FROM productoSucursal as ps
		INNER JOIN producto as p ON ps.idProducto = p.idProducto WHERE ps.idSucursal = $idSucursal AND ps.cantidad > 0";

	if(isset($_POST['productos'])){
		$prod = true;
		$q = $conexion->real_escape_string($_POST['productos']);
		$query="SELECT ps.idProductoSucursal, ps.idProducto, ps.idSucursal, ps.cantidad,
		 	p.idProducto, p.nombre, p.descripcion, p.mantenimiento, p.precioVenta FROM productoSucursal as ps
			INNER JOIN producto as p ON ps.idProducto = p.idProducto WHERE (p.nombre LIKE '%$q%'
			OR p.descripcion LIKE '%$q%') AND (ps.cantidad > 0 AND ps.idSucursal = $idSucursal)" ;
	}

	$buscarProductos = $conexion->query($query);
	if ($buscarProductos->num_rows > 0){
		?>
		<table class="table table-bordered table-hover table-responsive">
			<thead>
				<th style="width: 45px;"></th>
				<th>Producto</th>
				<th style="width: 100px;">Disponibles</th>
				<th style="width: 120px;">Precio Unitario</th>
				<th style="width: 120px;">Mantenimiento</th>
				<th style="width: 150px;"></th>
			</thead>
	<?php
		while($prod = $buscarProductos->fetch_assoc()){
			$found = false;
			$mantto = false;
			?>
				<tr>
					<?php if(isset($_SESSION["cartp"])){ foreach ($_SESSION["cartp"] as $c) {if($c["product_id"] == $prod["idProducto"]){ $found=true; if($c["mantenimiento"] == 1){ $mantto = true;} break; }}} ?>
					<td><?php echo $prod['idProducto']; ?></td>
					<td><?php echo $prod['nombre']; ?></td>
					<td style="text-align:center;"><?php echo $prod['cantidad']; ?></td>
					<td style="text-align:center;">$ <?php echo number_format($prod['precioVenta'],2,".",",") ?></td>
					<td style="text-align:center;">
						<input type="checkbox" class="mantto" id="<?php echo $prod['idProducto']; ?>" <?php if ($prod["mantenimiento"] != 1) {echo " disabled ";} if($found){echo " disabled ";} if($mantto){echo " checked ";}?>>
					</td>
					<td>
					<?php if ($found): ?>
						<a data-toggle="modal" data-target="#resumen" class="btn btn-info"><i class="fa fa-check fa-fw"></i>Agregado</a>
					<?php else: ?>
						<form class="form-inline enviar" method="POST" action="ajax/pedido/addxsell.php">
							<input type="hidden" name="product_id" value="<?php echo $prod['idProducto']; ?>">
							<input type="hidden" name="mantenimiento" value="0" id="m<?php echo $prod['idProducto']; ?>">
							<input type="hidden" name="service_id" value="" required>
							<div class="form-group control-group">
								<div class="controls">
									<input type="text" class="form-control input-sm" name="cantidad" value="1" style="width:85px;" min="1" max="<?php echo $prod['cantidad']; ?>" placeholder="Cantidad" pattern="[\d]{1,8}" onkeypress="return soloNumeros(event)" maxlength="8" required>
									<button type="submit" class="btn btn-sm btn-primary"><i class="icon-cart"></i></button>
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
						if($(this).attr("class") != "form-inline enviar has-error"){
							$.ajax({
								url: $(this).attr("action"),
								type: "POST",
								data: $(this).serialize(),
								success: function(){
									datosModal();
									datosResumen();
									var idSuc = $("#sOrigen").val();
									obtenerDatosDeSucursal(idSuc);
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
