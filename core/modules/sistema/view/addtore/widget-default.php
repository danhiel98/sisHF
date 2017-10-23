<?php

	if(!isset($_SESSION["reabastecerMP"])){

		$matPrim = array("idMateriaPrima"=>$_POST["idMP"], "cantidad"=>$_POST["cantidadMP"], "precio"=>$_POST["precioMP"]); //'$matPrim' antes '$product'
		$_SESSION["reabastecerMP"] = array($matPrim);
		$cart = $_SESSION["reabastecerMP"];
		$process = true;

	}else {

		$found = false;
		$cart = $_SESSION["reabastecerMP"];
		$index = 0;

		$cantActual = MateriaPrimaData::getById($_POST["idMP"]); #antes 'q'

		$can = true;

		?>

		<?php
		if($can == true){
			foreach($cart as $c){
				if($c["idMateriaPrima"] == $_POST["idMP"]){
					$found = true;
					break;
				}
				$index++;
			//	print_r($c);
			//	print "<br>";
			}

			if($found == true){
				$q1 = $cart[$index]["cantidad"];
				$q2 = $_POST["cantidadMP"];
				$cart[$index]["cantidad"] = $q1 + $q2;
				$_SESSION["reabastecerMP"] = $cart;
			}

			if($found == false){
			  $nc = count($cart);
				$matPrim = array("idMateriaPrima"=>$_POST["idMP"],"cantidad"=>$_POST["cantidadMP"],"precio"=>$_POST["precioMP"]);
				$cart[$nc] = $matPrim;
				#print_r($cart);
				$_SESSION["reabastecerMP"] = $cart;
			}

		}
	}
		print "<script>window.location='index.php?view=re';</script>";
		// unset($_SESSION["reabastecer"]);

?>
