<?php

	include "loader.php";
	if(count($_POST)>0){
		
		$idSuc = $_SESSION["usr_suc"];
		$dev = new DevolucionData;
		$prodSuc = new ProductoSucursalData();
		$factura = new FacturaData;
		$fact = $factura->getByNumber($_POST["numComprobante"]);

		$dev->idsucursal = $idSuc;
		$dev->idusuario = Session::getUID();
		$dev->idfactura = $fact->id;
		$dev->idcausa = $_POST["motivo"];
		$dev->fecha = "NOW()";
		$dev->reembolso = $_POST["reembolso"];

		$r = $dev->add();

		$prods = $_SESSION["prodsDev"];
		
		foreach ($prods as $prd){
			$prod = $factura->getByFactProduct($fact->id,$prd['id']);
			$dev->iddevolucion = $r[1];
			$dev->idproducto = $prod->idproducto;
			$dev->cantidad = $prod->cantidad;
			$dev->precio = $prod->precio;
			$dev->addProds();

			$prod = $prodSuc->getBySucursalProducto($idSuc,$dev->idproducto);
			$prod->cantidad += $dev->cantidad;
			$prod->updateEx();
		}
		
	}

	@header("location: index.php?view=devolucion")

?>