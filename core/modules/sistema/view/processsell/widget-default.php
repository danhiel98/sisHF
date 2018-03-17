<?php
	
	include "loader.php";
	
	if(isset($_SESSION["cart"])){
		
		$cart = $_SESSION["cart"];
		$idSuc = $_SESSION["usr_suc"];
		$idUsr = Session::getUID();

		if (count($cart) > 0){
			$fact = new FacturaData();
			$fact->idcliente = "null";
			$fact->idsucursal = $idSuc;
			if(isset($_POST["cliente"]) && !empty($_POST["cliente"])){
				$fact->idcliente = $_POST["cliente"];
			}
			$fact->idusuario = $idUsr;
			$fact->fecha = "NOW()";
			$fact->tipoComprobante = $_POST["tipo"];

			if ($_POST["tipo"] == 3){
				$fact->numerofactura = $fact->getLastRecibo($fact->idsucursal) + 1;
			}else{
				$fact->numerofactura = $_POST["numero"];				
			}
			$fact->totalLetras = $_POST["totalLetras"];			
			$r = $fact->add();
			
			$mantto = new MantenimientoData();
			$prodsMantto = array(); #Para controlar si se dará mantenimiento
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

					if ($venta->mantenimiento == 1){
						array_push(
							$prodsMantto,
							array(
								"id" => $venta->getProduct()->id,
								"cantidad" => $venta->cantidad,
								"nombre" => $venta->getProduct()->nombre,
								"meses" => $venta->getProduct()->mesesmantto
							)
						);
					}
				}elseif($c["product_id"] == "" && $c["service_id"] != ""){
					$venta->idservicio = $c["service_id"];
					$venta->precio = $venta->getService()->precio;
					$venta->total = $c["cantidad"] * $venta->precio;
					$venta->addServV();
				}
			}
			
			if (count($prodsMantto) > 0){
				// $cnt = 0;
				// $cant = count($prodsMantto);
				// foreach ($prodsMantto as $p){
				// 	$title .= $p[1]." ".$p[2];
				// 	$cnt++;
				// 	if($cnt < $cant){
				// 		($cant - 1) == $cnt ? $title .= " y " : $title .= ", "; #Operador ternario
				// 	}
				// }

				$mantto->idfactura = $venta->idfactura;
				$mantto->idsucursal = $idSuc;
				$mantto->idusuario = $idUsr;
				foreach($prodsMantto as $p){
					$fecha = new DateTime(date("Y-m-d"));
					$fecha->add(new DateInterval("P".$p['meses']."M"));
					$fecha->setTime(23, 59, 59);
					$mantto->idproducto = $p['id'];
					$mantto->title = "Mantenimiento de ".$p['cantidad']." ".$p['nombre'];
					$mantto->start = $fecha->format("Y-m-d");
					$mantto->end = $fecha->format("Y-m-d H:i:s");
					$mantto->add();
				}

				// $res = $mantto->add();
				// $prodMantto = new MantenimientoProductoData();
				// $prodMantto->idmantenimiento = $res[1];
				// foreach($prodsMantto as $p){
				// 	$prodMantto->idproducto = $p[0];
				// 	$prodMantto->add();
				// }
			}
		}
	}
	unset($_SESSION["cart"]);
	@header("location: index.php?view=onesell&id=$r[1]");
?>
