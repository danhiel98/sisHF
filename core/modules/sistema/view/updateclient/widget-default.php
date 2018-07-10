<?php
	
	include "loader.php";
	
	if(count($_POST)>0){
		$client = ClientData::getById($_POST["user_id"]);
		$client->dui = $_POST["txtDui"];
		$client->iddepto = $_POST["departamento"];
		$client->giro = $_POST["giro"];
		$client->nit = $_POST["txtNit"];
		$client->name = $_POST["txtNombre"];
		$client->sexo = $_POST["txtSexo"];
		$client->direccion = $_POST["txtDireccion"];
		$client->birth = $_POST["txtFechaNacimiento"];
		$client->email = $_POST["email"];
		$client->phone = $_POST["txtPhone"];
		$client->nrc = $_POST["txtNrc"];
		if ($client->birth != "") {
			$fecha = array_reverse(preg_split("[/]", $client->birth));
			$client->birth = $fecha[0]."-".$fecha[1]."-".$fecha[2];
		}
		$client->update();
	}
	print "<script>window.location='index.php?view=clients';</script>";

?>
