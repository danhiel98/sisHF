<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/PedidoData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ProductoSucursalData.php");
	include ("../../core/modules/sistema/model/AbonoData.php");
	include ("../../core/modules/sistema/model/MantenimientoData.php");
	
	if (isset($_POST["idFin"]) && !empty($_POST["idFin"]) && isset($_POST["option"])) {
		
		$idSuc = $_SESSION["usr_suc"];
		$idUsr = Session::getUID();
		$opcion = $_POST["option"];
		$id = $_POST["idFin"];
		$pedido = PedidoData::getById($id); #Obtener la información del pedido a través de su ID

		switch($opcion){
			case "eliminar":
				$pedido = PedidoData::getById($id);
				if (!is_null($pedido)){
					$pagos = AbonoData::getAllByPedidoId($id);
					$prodsV = $pedido->getAllProductsByPedidoId($id);
					$mantto = MantenimientoData::getByIdPedido($id);
					
					# Si el pedido ya se habia entregado, se va a 'reembolsar' los productos
					if ($pedido->entregado == 1){
						foreach ($prodsV as $prod){
							$prodSuc = ProductoSucursalData::getBySucursalProducto($pedido->idsucursal,$prod->idproducto);
							$prodSuc->cantidad = $prodSuc->cantidad + $prod->cantidad;
							$prodSuc->updateEx();
						}
					}

					foreach($pagos as $p){
						$p->del();
					}
					if(!is_null($mantto)){
						$mantto->del();
					}
					setcookie("okPdido","¡Se eliminó la información correctamente!");
					$pedido->del();
				}else{
					setcookie("okPdido","¡No se pudo eliminar la información!");
				}

				break;
			case "terminar":
				#Obtener los productos que se solicitan en el pedido
				$products = PedidoData::getAllProductsByPedidoId($pedido->id);

				$error = false; #Verificar si no hay suficientes productos para continuar
				$errorProd = array(); #Cuales son los productos insuficientes
				
				$mantto = new MantenimientoData();
				$prodsMantto = array();
				foreach ($products as $prd){
					$prod = ProductoSucursalData::getBySucursalProducto($idSuc,$prd->idproducto);
					$resta = $prod->cantidad - $prd->cantidad; #Cantidad de productos existentes - cantidad de productos pedidos
					if ($resta < 0){
						$error = true; #Ha encontrado al menos un error
						array_push($errorProd,$prd); #Agregar datos de los productos insuficiente encontrados
					}
					if ($prd->mantenimiento == 1){
						array_push(
							$prodsMantto,
							array(
								"id" => $prd->idproducto,
								"cantidad" => $prd->cantidad,
								"nombre" => $prd->getProduct()->nombre,
								"meses" => $prd->getProduct()->mesesmantto
							)
						);
					}
				}

				if($pedido->restante > 0){
				?>
					<div class="alert alert-warning">
						Debe realizar el último pago para poder entregar el pedido.
						<a href="#" id="newPago">Registrar pago</a>
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
							$prod = ProductoSucursalData::getBySucursalProducto($idSuc,$prd->idproducto);
							$prod->cantidad -= $prd->cantidad;
							$prod->updateEx();
						}
						$pedido->finalizar($pedido->id);

						if (count($prodsMantto) > 0){
							$mantto->idpedido = $pedido->id;
							$mantto->idsucursal = $idSuc;
							$mantto->idusuario = $idUsr;
							foreach($prodsMantto as $p){
								$fecha = new DateTime(date("Y-m-d"));
								$fecha->add(new DateInterval("P".$p['meses']."M"));
								$fecha->setTime(23, 59, 59);
								$mantto->idproducto = $p['id'];
								$mantto->title = "Mantenimiento de ".$p['cantidad']." ".$p['nombre'];
								$mantto->start = $fecha->format("Y-m-d");
								$mantto->end = $fecha->format("Y-m-d H:i:s");
								$mantto->add();
							}
						}

					}else{
						?>
						<div>
							<p class="alert alert-warning">No se puede marcar como entregado el pedido porque no hay suficientes <a target="_blank" href="index.php?view=inventaryprod">productos.</a></p>
						</div>
						<div class="list-group">
							<?php foreach($errorProd as $prd): ?>
							<div class="list-group-item">
								<?php $prod = ProductoSucursalData::getBySucursalProducto($idSuc,$prd->idproducto); ?>
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
