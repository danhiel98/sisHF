<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/MateriaPrimaData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ProduccionData.php");
	include ("../../core/modules/sistema/model/ProductoSucursalData.php");

	if (isset($_POST["idFin"]) && !empty($_POST["idFin"])) {
		$id = $_POST["idFin"];
		$produccion = ProduccionData::getById($id);
		$produccion->finalizar();
		$prodsuc = ProductoSucursalData::getBySucursalProducto(1,$produccion->idproducto);
		$actual = $prodsuc->cantidad;
		$prodsuc->cantidad = $actual + $produccion->cantidad;
		$prodsuc->updateEx();
	}

	if (isset($_POST["idCancel"]) && !empty($_POST["idCancel"])) {
		$id = $_POST["idCancel"];
		$produccion = ProduccionData::getById($id);
		$produccion->cancelar($id);
	}

?>
