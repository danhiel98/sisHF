<?php

	if(isset($_SESSION["cartp"])){
		$cart = $_SESSION["cartp"];

		if(count($cart)>0){
			$pdido = new PedidoData();
			$pdido->idsucursal = $_SESSION["usr_suc"];
			$pdido->idusuario = Session::getUID();
			$pdido->idcliente = $_POST["cliente"];
			$pdido->fechapedido = "NOW()";
			$pdido->fechaentrega = date("Y-m-d",strtotime($_POST["fechaEntrega"]));
			$r = $pdido->add();

			foreach($cart as $c){
				$prodPd = new PedidoData();
				$prodPd->idpedido = $r[1];
				$prodPd->cantidad = $c["cantidad"];
				if ($c["product_id"] != "" && $c["service_id"] == "") {
					$prodPd->idproducto = $c["product_id"];
					$prodPd->mantenimiento = $c["mantenimiento"];
					$prodPd->total = $c["cantidad"] * $prodPd->getProduct()->precioventa;
					$prodPd->addProdPd();

					$prods = ProductoSucursalData::getBySucursalProducto($pdido->idsucursal,$prodPd->idproducto);
					$prods->cantidad = $prods->cantidad - $prodPd->cantidad;
					$prods->updateEx();
				}elseif($c["product_id"] == "" && $c["service_id"] != ""){
					$prodPd->idservicio = $c["service_id"];
					$prodPd->total = $c["cantidad"] * $prodPd->getService()->precio;
					$prodPd->addServPd();
				}
			}

		}
	}
	unset($_SESSION["sucursal"]);
	unset($_SESSION["cartp"]);
?>
