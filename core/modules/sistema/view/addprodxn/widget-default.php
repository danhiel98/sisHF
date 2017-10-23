<?php
	if(!empty($_POST)){
		if(isset($_POST["product_id"]) && isset($_POST["cantidad"])){
			// si es el primer producto simplemente lo agregamos
			if(empty($_SESSION["productn"])){
				$_SESSION["productn"] = array(array("product_id"=>$_POST["product_id"],"cantidad"=> $_POST["cantidad"]));
			}else{
				// apartie del segundo producto:
				$cart = $_SESSION["productn"];
				$repeated = false;
				// recorremos el carrito en busqueda de producto repetido
				foreach ($cart as $c) {
					// si el producto esta repetido rompemos el ciclo
					if($c["product_id"] == $_POST["product_id"]){
						$repeated = true;
						break;
					}
				}
				// si el producto es repetido no hacemos nada, simplemente redirigimos
				if($repeated){
					print "<script>alert('Error: Producto Repetido!');</script>";
				}else{
					// si el producto no esta repetido entonces lo agregamos a la variable cart y despues asignamos la variable cart a la variable de sesion
					array_push($cart, array("product_id"=>$_POST["product_id"],"cantidad"=> $_POST["cantidad"]));
					$_SESSION["productn"] = $cart;
				}
			}
			print "<script>window.location='index.php?view=newproducn';</script>";
		}
	}
?>
