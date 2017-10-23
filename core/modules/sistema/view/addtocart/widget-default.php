<?php

	if(!isset($_SESSION["cart"])){
		$product = array("idProducto"=>$_POST["idProducto"],"cantidad"=>$_POST["cantidad"]);
		$_SESSION["cart"] = array($product);
		$cart = $_SESSION["cart"];
		///////////////////////////////////////////////////////////////////
		$num_succ = 0;
		$process=false;
		$errors = array();
		foreach($cart as $c){
			$cantidad = ProductData::getById($c["idProducto"]);
			if($c["cantidad"]<=$cantidad){
				$num_succ++;
			}else{
				$error = array("idProducto"=>$c["idProducto"],"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
			}
		}

		if($num_succ == count($cart)){
			$process = true;
		}

		if($process==false){
			unset($_SESSION["cart"]);
			$_SESSION["errors"] = $errors;
	?>
		<script>
			window.location="index.php?view=sell";
		</script>
	<?php
		}
	}else{
		$found = false;
		$cart = $_SESSION["cart"];
		$index=0;

		$cantidad = ProductData::getById($_POST["idProducto"]);
		$can = true;
		if($_POST["cantidad"]<=$cantidad){

		}else{
			$error = array("idProducto"=>$_POST["idProducto"],"message"=>"No hay suficiente cantidad de producto en inventario.");
			$errors[count($errors)] = $error;
			$can=false;
		}

		if($can==false){
			$_SESSION["errors"] = $errors;
	?>
		<script>
			window.location="index.php?view=sell";
		</script>
	<?php
		}
	?>

	<?php
		if($can==true){
			foreach($cart as $c){
				if($c["idProducto"] == $_POST["idProducto"]){
					echo "found";
					$found = true;
					break;
				}
				$index++;
				//	print_r($c);
				//	print "<br>";
			}

			if($found==true){
				$q1 = $cart[$index]["cantidad"];
				$q2 = $_POST["cantidad"];
				$cart[$index]["cantidad"]=$q1+$q2;
				$_SESSION["cart"] = $cart;
			}

			if($found==false){
    		$nc = count($cart);
				$product = array("idProducto"=>$_POST["idProducto"],"cantidad"=>$_POST["cantidad"]);
				$cart[$nc] = $product;
				//	print_r($cart);
				$_SESSION["cart"] = $cart;
			}
		}
	}
	print "<script>window.location='index.php?view=sell';</script>";
	// unset($_SESSION["cart"]);
?>
