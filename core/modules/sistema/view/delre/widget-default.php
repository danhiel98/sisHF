<?php

	$reab = new ReabastecimientoData();
	$id = $_GET["id"];
	
	if ((isset($_GET["id"]) && is_numeric($_GET["id"])) && !is_null($reab->getById($_GET["id"]))){
		$re = $reab->getById($id);
		$prodsR = ReabastecimientoMPData::getAllByReabId($id);

		$error = false;
		
		foreach ($prodsR as $prod){
			$matPrim = MateriaPrimaData::getById($prod->idmateriaprima);
			$matPrim->existencias = $matPrim->existencias - $prod->cantidad;
			if($matPrim->existencias < 0){
				$error = true;
				break;
			}
		}

		if(!$error){
			foreach ($prodsR as $prod){
				$matPrim = MateriaPrimaData::getById($prod->idmateriaprima);
				$matPrim->existencias = $matPrim->existencias - $prod->cantidad;
				$matPrim->updateEx();
			}
			$re->del();
			setcookie("okCompra","¡Se eliminó la información correctamente!");
		}else{
			setcookie("errorCompra","!Vaya! No se puede eliminar la compra porque ya se ha utilizado la materia prima.");
		}

	}else{
		setcookie("errorCompra","!Vaya! Parece que no se ha podido eliminar la información. Por favor, inténtelo nuevamente.");
	}
	Core::redir("./index.php?view=res");

?>