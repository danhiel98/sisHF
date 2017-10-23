<?php

if(count($_POST)>0){
	$proveedor = ProviderData::getById($_POST["idProveedor"]);
	$proveedor->nombre = $_POST["txtNombre"];
	$proveedor->tipoprovee = $_POST["txtProvee"];
	$proveedor->direccion = $_POST["txtDireccion"];
	$proveedor->telefono = $_POST["txtTelefono"];
	$proveedor->correo = $_POST["txtCorreo"];
	$proveedor->update();

	print "<script>window.location='index.php?view=providers';</script>";
}
?>
