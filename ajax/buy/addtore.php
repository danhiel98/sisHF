<?php
	@session_start();
	if (isset($_POST) && count($_POST) == 3) {
		if(!isset($_SESSION["reabastecerMP"])){
			$matPrim = array("idMateriaPrima"=>$_POST["idMP"], "cantidad"=>$_POST["cantidadMP"], "precio"=>$_POST["precioMP"]);
			$_SESSION["reabastecerMP"] = array($matPrim);
		}else {
			$found = false;
			$cart = $_SESSION["reabastecerMP"];
			$index = 0;
		
			foreach($cart as $c){
				if($c["idMateriaPrima"] == $_POST["idMP"]){
					echo "Se ha encontrado un ID igual";
					$found = true;
					break;
				}
				$index++;
			}

			if($found){
				$cart[$index]["cantidad"] = $_POST["cantidadMP"];
				$cart[$index]["precio"] = $_POST["precioMP"];
				$_SESSION["reabastecerMP"] = $cart;
			}else{
				$matPrim = array("idMateriaPrima"=>$_POST["idMP"],"cantidad"=>$_POST["cantidadMP"],"precio"=>$_POST["precioMP"]);
				array_push($cart, $matPrim);
				$_SESSION["reabastecerMP"] = $cart;
			}
		}
		print_r($_SESSION["reabastecerMP"]);
	}
?>
