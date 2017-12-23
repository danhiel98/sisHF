<?php

if(count($_POST)>0){
	
	$dev = new DevolucionData;
	$factura = new FacturaData;
	$fact = $factura->getByNumber($_POST["numComprobante"]);

	$dev->idusuario = Session::getUID();
	$dev->idfactura = $fact->id;
	$dev->idcausa = $_POST["motivo"];
	$dev->fecha = "NOW()";
	$dev->reembolso = "5";

	$r = $dev->add();

	$prods = $_SESSION["prodsDev"];
	
	foreach ($prods as $prd){
		$prod = $factura->getByFactProduct($fact->id,$prd['id']);
		$dev->iddevolucion = $r[1];
		$dev->idproducto = $prod->idproducto;
		$dev->cantidad = $prod->cantidad;
		$dev->addProds();
	}
	
}


?>