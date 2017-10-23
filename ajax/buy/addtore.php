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
		?>
		<?php
			foreach($cart as $c){
				if($c["idMateriaPrima"] == $_POST["idMP"]){
					$found = true;
					break;
				}
				$index++;
			}

			if($found == true){
				$cart[$index]["cantidad"] = $_POST["cantidadMP"];
				$cart[$index]["precio"] = $_POST["precioMP"];
				$_SESSION["reabastecerMP"] = $cart;
			}

			if($found == false){
				$cnt = count($cart);
				$matPrim = array("idMateriaPrima"=>$_POST["idMP"],"cantidad"=>$_POST["cantidadMP"],"precio"=>$_POST["precioMP"]);
				$cart[$cnt] = $matPrim;
				$_SESSION["reabastecerMP"] = $cart;
			}
		}
		print_r($_SESSION["reabastecerMP"]);
	}
?>
