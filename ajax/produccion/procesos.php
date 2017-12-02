<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/MateriaPrimaData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ProduccionData.php");
	include ("../../core/modules/sistema/model/ProduccionMPData.php");
	include ("../../core/modules/sistema/model/ProductoSucursalData.php");

	$_SESSION["detalleError"] = "";
	if (isset($_POST["idFin"]) && !empty($_POST["idFin"])) {

		$id = $_POST["idFin"];
		$produccion = ProduccionData::getById($id);
		
		#Obtener toda la materia prima según el id de producción en donde se utilizó ()
		$materiaPrima = ProduccionMPData::getAllByProdId($produccion->id);
		$error = false; #Verificar si no hay suficiente materia prima para continuar
		$detalleError = array(); #Cuál es la materia prima insuficiente
		
		foreach ($materiaPrima as $mp){
			$matPrim = MateriaPrimaData::getById($mp->idmateriaprima);
			$resta = $matPrim->existencias - $mp->cantidad;
			if ($resta <= 0){
				$error = true;
				array_push($detalleError,$mp);
			}
		}

		if (!$error){

			if (isset($_SESSION["detalleError"])){
				unset($_SESSION["detalleError"]);
			}

			foreach ($materiaPrima as $mp){
				$matPrim = MateriaPrimaData::getById($mp->idmateriaprima);
				$matPrim->existencias -= $mp->cantidad;
				$matPrim->updateEx();
			}

			$produccion->finalizar();

			$prodsuc = ProductoSucursalData::getBySucursalProducto(1,$produccion->idproducto);
			$prodsuc->cantidad += $produccion->cantidad;
			$prodsuc->updateEx();

		}else{
			$_SESSION["detalleError"] = $detalleError;
			print_r($detalleError);
			#echo json_encode($detalleError);
		}
	}
?>
