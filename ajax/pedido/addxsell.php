<?php
	#Archivo para agregar productos al carrito
	@session_start();
	if(!empty($_POST)){
		if(isset($_POST["product_id"]) && isset($_POST["service_id"]) && isset($_POST["cantidad"])){
			
			$prod = true; #Si es producto el que se va a agregar
			$serv = true; #Si es servicio
			
			$mantenimiento = 0; #En caso que al producto se le vaya a dar mantenimiento

			if (isset($_POST["mantenimiento"]) && $_POST["mantenimiento"] == 1) {
				$mantenimiento = 1;
			}

			if ($_POST["product_id"] == "") {
				$prod = false;
			}

			if ($_POST["service_id"] == "") {
				$serv = false;
			}
			
			if(empty($_SESSION["cartp"])){
				#Si no se ha agregado ningún producto/servicio al carrito
				$_SESSION["cartp"] = array(array("service_id"=>$_POST["service_id"],"product_id"=>$_POST["product_id"],"cantidad"=>$_POST["cantidad"],"mantenimiento"=>$mantenimiento));
			}else{
				#En caso que ya hayan productos/servicios
				$cart = $_SESSION["cartp"];
				$repeated = false; #Sirve para saber si el producto que se va a agregar ya ha sido agregado anteriormente
				foreach ($cart as $c) {
					#Recorrer el carrito para saber si ya se ha agregado el producto del cual se han enviado los datos
					if(($prod && $c["product_id"] == $_POST["product_id"]) || ($serv && $c["service_id"] == $_POST["service_id"])){
						#En caso que los datos coincidan, el producto está repetido
						$repeated = true;
						break;
					}
				}
				if($repeated){
					#Si el producto/servicio está repetido, semostrará una alerta
					print "<script>alert('Error: Producto Repetido!');</script>";
				}else{
					#Si el producto no está repetido, se agregará al carrito
					array_push($cart, array("service_id"=>$_POST["service_id"],"product_id"=>$_POST["product_id"],"cantidad"=>$_POST["cantidad"],"mantenimiento"=>$mantenimiento));
					$_SESSION["cartp"] = $cart;
				}
			}
		}
	}
?>
