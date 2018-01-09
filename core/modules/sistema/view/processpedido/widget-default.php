<?php
	include "loader.php";
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

			$total = 0;
			foreach($cart as $c){
				$prodPd = new PedidoData();
				$prodPd->idpedido = $r[1];
				$prodPd->cantidad = $c["cantidad"];
				if ($c["product_id"] != "" && $c["service_id"] == "") {
					$prodPd->idproducto = $c["product_id"];
					$prodPd->mantenimiento = $c["mantenimiento"];
					$prodPd->precio = $prodPd->getProduct()->precioventa;
					$prodPd->total = $prodPd->cantidad * $prodPd->precio;
					$prodPd->addProdPd();
				}elseif($c["product_id"] == "" && $c["service_id"] != ""){
					$prodPd->idservicio = $c["service_id"];
					$prodPd->precio = $prodPd->getService()->precio;
					$prodPd->total = $prodPd->cantidad * $prodPd->precio;
					$prodPd->addServPd();
				}
				$total += $prodPd->total;
			}

			$abono = new AbonoData();
			$abono->idsucursal = $_SESSION["usr_suc"];
			$abono->idusuario = Session::getUID();
			$abono->idcliente = $_POST["cliente"];
			$abono->idpedido = $r[1];
			$abono->cantidad = $_POST["cantidad"];
			$abono->numerocomprobante = $_POST["numComprobante"];
			$abono->tipocomprobante = $_POST["tipo"];
			$abono->add();

			$pdido = PedidoData::getById($r[1]);
			$pdido->restante = $total - $abono->cantidad;
			$pdido->updateRestante();

		}
		unset($_SESSION["cartp"]);
		@header("location: index.php?view=detallepedido&id=$r[1]");
	}else{
		@header("location: index.php?view=pedidos");
	}
?>
