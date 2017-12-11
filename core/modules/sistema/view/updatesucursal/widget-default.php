<?php

include "loader.php";

if(count($_POST)>0){
	$sucursal = SucursalData::getById($_POST["idSucursal"]);
	$sucursal->nombre = $_POST["txtNombre"];
	$sucursal->direccion = $_POST["txtDireccion"];
	$sucursal->telefono = $_POST["txtTelefono"];
	$sucursal->update();
	print "<script>window.location='index.php?view=sucursal';</script>";
}

?>
