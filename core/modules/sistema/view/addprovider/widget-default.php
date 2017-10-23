<?php

	include("loader.php");
	if(count($_POST)>0){
		$proveedor = new ProviderData();
		$proveedor->idusuario = Session::getUID();
		$proveedor->nombre = $_POST["nombre"];
		$proveedor->tipoprovee = $_POST["provee"];
		$proveedor->direccion = $_POST["direccion"];
		$proveedor->telefono = $_POST["telefono"];
		$proveedor->correo = $_POST["correo"];
		$proveedor->add();
	}

?>
<script>window.location='index.php?view=providers';</script>
