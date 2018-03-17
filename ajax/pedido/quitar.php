<?php

	@session_start();
	if ((isset($_POST["product_id"]) && !empty($_POST["product_id"])) || (isset($_POST["service_id"]) && !empty($_POST["service_id"]))) {
		if(!empty($_SESSION["cartp"])){
			$prd = false;
			$srv = false;
			if (isset($_POST["product_id"])) {
				$prd = true;
			}elseif (isset($_POST["service_id"])) {
				$srv = true;
			}

			$cart = $_SESSION["cartp"];
			if(count($cart) <= 1){
				unset($_SESSION["cartp"]);
			}else{
				$newcart = array();
				foreach($cart as $c){
					if ($prd) {
						if(($c["product_id"] != $_POST["product_id"])){
							$newcart[] = $c;
						}
					}elseif($srv){
						if(($c["service_id"] != $_POST["service_id"])){
							$newcart[] = $c;
						}
					}
				}
				$_SESSION["cartp"] = $newcart;
			}
		}
	}

?>
