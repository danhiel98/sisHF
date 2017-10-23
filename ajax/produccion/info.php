<?php

	@session_start();

	$idProd = $_POST["producto"];
	$cantidad = $_POST["cantidad"];
	$inicio = $_POST["inicio"];
	$fin = $_POST["fin"];

	if (isset($_POST["producto"]) && isset($_POST["cantidad"]) && isset($_POST["inicio"]) && isset($_POST["fin"])) {
		$_SESSION["produccion"] = array("idProducto"=>$idProd,"cantidad"=>$cantidad,"inicio"=>$inicio,"fin"=>$fin);
	}
?>
