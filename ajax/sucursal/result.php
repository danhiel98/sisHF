<?php

	@session_start();
	include("../conectarpdo.php");
	$cn = conexion();
	$valor = $_REQUEST["value"];
	$sql= "select * from sucursal where nombre = \"$valor\" and estado = 1";
	$query = $cn->query($sql);
	$datos = $query->fetchAll();
	$suc = "";
	if (count($datos) > 0 ) {
		if (!isset($_SESSION["suc_temp"]) || (isset($_SESSION["suc_temp"]) && $_SESSION["suc_temp"] != $datos[0][1])) {
		$suc = $datos[0][1];
		}
	}
	$valid = 1;
	if ($suc != "") {
		$valid = 0;
	}
	echo json_encode(
		array(
		"value" => $valor,
		"valid" => $valid,
		"message" => "Ya existe una sucursal con este nombre."
		)
	);
