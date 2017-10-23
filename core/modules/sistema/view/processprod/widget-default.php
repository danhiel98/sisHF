<?php

	if(isset($_SESSION["productn"])){
		$prodxn = $_SESSION["productn"];

		if(count($prodxn)>0){
			$prod = new ProduccionData();
			$prod->idusuario = Session::getUID();
			$prod->idproducto = $_POST["producto"];
			$prod->fechainicio = $_POST["inicio"];
			$prod->fechafin = $_POST["fin"];
			$prod->cantidad = $_POST["cantidad"];
			$fecha = array_reverse(preg_split("[/]",$prod->fechainicio));
			$prod->fechainicio = $fecha[0]."-".$fecha[1]."-".$fecha[2];
			$fecha = array_reverse(preg_split("[/]",$prod->fechafin));
			$prod->fechafin = $fecha[0]."-".$fecha[1]."-".$fecha[2];
			$r = $prod->add();

			foreach($prodxn as $c){
				$prx = new ProduccionMPData();
				$prx->idproduccion = $r[1];
				$prx->idmateriaprima = $c["product_id"];
				$prx->cantidad = $c["cantidad"];
				$prx->add();
			}
		}
	}
	unset($_SESSION["productn"]);
	unset($_SESSION["produccion"]);
	header("location: index.php?view=oneprod&id=$r[1]");
?>
