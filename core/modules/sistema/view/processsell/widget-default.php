<?php

	if(isset($_SESSION["cart"])){
		$cart = $_SESSION["cart"];

		if(count($cart)>0){
			$fact = new FacturaData();
			$fact->idcliente = "null";
			$fact->idsucursal = $_SESSION["usr_suc"];
			if(isset($_POST["cliente"]) && !empty($_POST["cliente"])){
				$fact->idcliente = $_POST["cliente"];
			}
			$fact->idusuario = Session::getUID();
			$fact->fecha = "NOW()";
			if (isset($_POST["tipo"])) {
				switch ($_POST["tipo"]) {
					case 1:
						$fact->tipo = "Factura";
						break;
					case 2:
						$fact->tipo = "CCF";
					default:
						break;
				}
				$fact->numerofactura = $_POST["numero"];
				$fact->tipo = $_POST["tipo"];
			}
			$r = $fact->add();

			foreach($cart as $c){
				$venta = new FacturaData();
				$venta->idfactura = $r[1];
				$venta->cantidad = $c["cantidad"];
				if ($c["product_id"] != "" && $c["service_id"] == "") {
					$venta->idproducto = $c["product_id"];
					$venta->mantenimiento = $c["mantenimiento"];
					$venta->total = $c["cantidad"] * $venta->getProduct()->precioventa;
					$venta->addProdV();

					$prods = ProductoSucursalData::getBySucursalProducto($fact->idsucursal,$venta->idproducto);
					$prods->cantidad = $prods->cantidad - $venta->cantidad;
					$prods->updateEx();
				}elseif($c["product_id"] == "" && $c["service_id"] != ""){
					$venta->idservicio = $c["service_id"];
					$venta->total = $c["cantidad"] * $venta->getService()->precio;
					$venta->addServV();
				}
			}
		}
	}
	unset($_SESSION["sucursal"]);
	unset($_SESSION["cart"]);
	@header("location: index.php?view=onesell&id=$r[1]");
?>