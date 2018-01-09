<?php
	
	include "loader.php";
	
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
			$fact->tipoComprobante = $_POST["tipo"];

			if ($_POST["tipo"] == 3){
				$fact->numerofactura = $fact->getLastRecibo($fact->idsucursal) + 1;
			}else{
				$fact->numerofactura = $_POST["numero"];				
			}
			$fact->totalLetras = $_POST["totalLetras"];			
			$r = $fact->add();
			
			foreach($cart as $c){
				$venta = new FacturaData();
				$venta->idfactura = $r[1];
				$venta->cantidad = $c["cantidad"];
				if ($c["product_id"] != "" && $c["service_id"] == "") {
					$venta->idproducto = $c["product_id"];
					$venta->precio = $venta->getProduct()->precioventa;
					$venta->mantenimiento = $c["mantenimiento"];
					$venta->total = $c["cantidad"] * $venta->precio;
					$venta->addProdV();

					$prods = ProductoSucursalData::getBySucursalProducto($fact->idsucursal,$venta->idproducto);
					$prods->cantidad = $prods->cantidad - $venta->cantidad;
					$prods->updateEx();
				}elseif($c["product_id"] == "" && $c["service_id"] != ""){
					$venta->idservicio = $c["service_id"];
					$venta->precio = $venta->getService()->precio;
					$venta->total = $c["cantidad"] * $venta->precio;
					$venta->addServV();
				}
			}
		}
	}
	unset($_SESSION["cart"]);
	@header("location: index.php?view=onesell&id=$r[1]");
?>
