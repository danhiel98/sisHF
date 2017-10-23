<?php
	if(!empty($_POST)){
		if(isset($_POST["product_id"]) && isset($_POST["service_id"]) && isset($_POST["cantidad"])){
			$prod = true;
			$serv = true;
			if ($_POST["product_id"] == "") {
				$prod = false;
			}
			if ($_POST["service_id"] == "") {
				$serv = false;
			}

			if(empty($_SESSION["cart"])){
				$_SESSION["cart"] = array(array("service_id"=>$_POST["service_id"],"product_id"=>$_POST["product_id"],"cantidad"=> $_POST["cantidad"]));
			}else{
				$cart = $_SESSION["cart"];
				$repeated = false;
				foreach ($cart as $c) {
					if(($prod && $c["product_id"] == $_POST["product_id"]) || ($serv && $c["service_id"] == $_POST["service_id"])){
						$repeated=true;
						break;
					}
				}
				if($repeated){
					print "<script>alert('Error: Producto Repetido!');</script>";
				}else{
					array_push($cart, array("service_id"=>$_POST["service_id"],"product_id"=>$_POST["product_id"],"cantidad"=> $_POST["cantidad"]));
					$_SESSION["cart"] = $cart;
				}
			}
		}
	}
	#print_r($_SESSION["cart"]);
?>
