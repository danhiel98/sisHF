<?php

	if (isset($_POST['id']) && isset($_POST["opc"])) {
		include("../conectarpdo.php");
		$cn = conexion();
		$id = $_POST['id'];
		$opcion = $_POST['opc'];
		if($opcion == "entrada"){
			$sql= "select * from ingresoCajaChica where idIngresoCajaChica = $id and estado = 1";
		}elseif($opcion == "salida"){
			$sql= "select * from salidaCajaChica where idSalidaCajaChica = $id and estado = 1";			
		}
		
		$query = $cn->query($sql);
		$datos = $query->fetchAll();
		echo json_encode($datos);
	}

?>
