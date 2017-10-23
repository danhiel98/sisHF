<?php

if(count($_POST)>0){
	$banco = BancoData::getById($_POST["idBanco"]);
	$banco->nombre = $_POST["txtNombre"];
	$banco->direccion = $_POST["txtDireccion"];
	$banco->telefono = $_POST["txtTelefono"];
	$banco->update();

print "<script>window.location='index.php?view=banco';</script>";


}


?>
