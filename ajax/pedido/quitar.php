<?php

	@session_start();
	if ((isset($_POST["idProd"]) && !empty($_POST["idProd"])) || (isset($_POST["idServ"]) && !empty($_POST["idServ"]))) {
		if(!empty($_SESSION["cartp"])){
			$prd = false;
			$srv = false;
			if (isset($_POST["idProd"])) {
				$prd = true;
			}elseif (isset($_POST["idServ"])) {
				$srv = true;
			}

			$cart = $_SESSION["cartp"];
			if(count($cart) <= 1){
				unset($_SESSION["cartp"]);
			}else{
				$newcart = array();
				foreach($cart as $c){
					if ($prd) {
						if(($c["product_id"] != $_POST["idProd"])){
							$newcart[] = $c;
						}
					}elseif($srv){
						if(($c["service_id"] != $_POST["idServ"])){
							$newcart[] = $c;
						}
					}
				}
				$_SESSION["cartp"] = $newcart;
			}
		}
	}

?>
