<?php

if(count($_POST)>0){
	$emp = EmpleadoData::getById($_POST["idEmpleado"]);
	$emp->dui = $_POST["txtDui"];
	$emp->nit = $_POST["txtNit"];
	$emp->nombre = $_POST["txtNombre"];
	$emp->apellido = $_POST["txtApellido"];
	$emp->sexo = $_POST["txtSexo"];
	$emp->estadocivil = $_POST["txtEstadoCivil"];
	$emp->fechanacimiento = $_POST["txtFechaNacimiento"];
	$emp->nivelacademico = $_POST["txtNivelAcademico"];
	$emp->direccion = $_POST["txtDireccion"];
	$emp->idMunic = $_POST["txtMunicipio"];
	$emp->idDepto = $_POST["txtDepartamento"];
	$emp->telefono = $_POST["txtTelefono"];
	$emp->area = $_POST["txtEspecialidad"];
	$emp->idsucursal = $_POST["txtSucursal"];
	$fecha = array_reverse(preg_split("[/]",$emp->fechanacimiento));
	$emp->fechanacimiento = $fecha[0]."-".$fecha[1]."-".$fecha[2];
	$emp->update();
	include("loader.php");
}
print "<script>window.location='index.php?view=empleados';</script>";


?>
