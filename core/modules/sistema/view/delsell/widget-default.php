<?php

	$fact = new FacturaData();
	$id = $_GET["id"];
	
	if ((isset($_GET["id"]) && is_numeric($_GET["id"])) && !is_null($fact->getById($_GET["id"]))){
		$sell = $fact->getById($id);
		$prodsV = $fact->getAllSellsByFactId($id);

		foreach ($prodsV as $prod){
			$prodSuc = ProductoSucursalData::getBySucursalProducto($sell->idsucursal,$prod->idproducto);
			$prodSuc->cantidad = $prodSuc->cantidad + $prod->cantidad;
			$prodSuc->updateEx();
		}
		$sell->del();
		setcookie("okFactura","¡Se eliminó la información correctamente!");
	}else{
		setcookie("errorFactura","!Vaya! Parece que no se ha podido eliminar la información. Por favor, inténtelo nuevamente.");
	}
	Core::redir("./index.php?view=box");

?>