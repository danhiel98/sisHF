<?php
	
	include "loader.php";
	
	if(count($_POST)>0){
		$user = ClientData::getById($_POST["user_id"]);
		$user->dui = $_POST["txtDui"];
		$user->nit = $_POST["txtNit"];
		$user->name = $_POST["txtNombre"];
		$user->lastname = $_POST["txtApellido"];
		$user->sexo = $_POST["txtSexo"];
		$user->direccion = $_POST["txtDireccion"];
		$user->birth = $_POST["txtFechaNacimiento"];
		$user->email = $_POST["txtEmail"];
		$user->phone = $_POST["txtPhone"];
		$user->nrc = $_POST["txtNrc"];
		if ($user->birth != "") {
			$fecha = array_reverse(preg_split("[/]",$user->birth));
			$user->birth = $fecha[0]."-".$fecha[1]."-".$fecha[2];
		}
		include("loader.php");
		$user->update();
	}
	print "<script>window.location='index.php?view=clients';</script>";

?>
