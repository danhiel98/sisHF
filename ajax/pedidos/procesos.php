<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/PedidoData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ProductoSucursalData.php");
	include ("../../core/modules/sistema/model/AbonoData.php");
	
	if (isset($_POST["idFin"]) && !empty($_POST["idFin"]) && isset($_POST["option"])) {
		$opcion = $_POST["option"];
		$id = $_POST["idFin"];
		$pedido = PedidoData::getById($id); #Obtener la información del pedido a través de su ID

		switch($opcion){
			case "eliminar":
				$pagos = AbonoData::getAllByPedidoId($id);
				foreach($pagos as $p){
					$p->del();
				}
				setcookie("okPdido","¡Se eliminó la información correctamente!");
				$pedido->delById($id);

				break;
			case "terminar":
				#Obtener los productos que se solicitan en el pedido
				$products = PedidoData::getAllProductsByPedidoId($pedido->id);

				$error = false; #Verificar si no hay suficientes productos para continuar
				$errorProd = array(); #Cuales son los productos insuficientes

				foreach ($products as $prd){
					$prod = ProductoSucursalData::getBySucursalProducto($_SESSION["usr_suc"],$prd->idproducto);
					$resta = $prod->cantidad - $prd->cantidad; #Cantidad de productos existentes - cantidad de productos pedidos
					if ($resta < 0){
						$error = true; #Ha encontrado al menos un error
						array_push($errorProd,$prd); #Agregar datos de los productos insuficiente encontrados
					}
				}
				
				if($pedido->restante > 0){
				?>
					<div class="alert alert-warning">
						Debe realizar el último pago para poder entregar el pedido.
						<a class="btn" id="newPago">Registrar pago</a>
					</div>
					<script>
						$("#newPago").click(function(){
							$("#agregar").modal("show");
						});
					</script>
				<?php
				}else{
					if (!$error){
						foreach ($products as $prd){
							$prod = ProductoSucursalData::getBySucursalProducto($_SESSION["usr_suc"],$prd->idproducto);
							$prod->cantidad -= $prd->cantidad;
							$prod->updateEx();
						}
						$pedido->finalizar($pedido->id);
					}else{
						?>
						<div>
							<p class="alert alert-warning">No se puede marcar como entregado el pedido porque no hay suficientes <a target="_blank" href="index.php?view=inventaryprod">productos.</a></p>
						</div>
						<div class="list-group">
							<?php foreach($errorProd as $prd): ?>
							<div class="list-group-item">
								<?php $prod = ProductoSucursalData::getBySucursalProducto($_SESSION["usr_suc"],$prd->idproducto); ?>
									<?php echo $prod->getProduct()->nombre; ?>
									<div class="pull-right">
									<span data-toggle="tooltip" title="Existentes" class="label label-danger"><?php echo $prod->cantidad; ?></span>
									<span data-toggle="tooltip" title="Necesarios" class="label label-primary"><?php echo $prd->cantidad; ?></span>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						<?php
					}
				}
				break;
			default:
				break;
		}
	}

?>
