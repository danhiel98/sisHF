<?php
	include "loader.php";
	if (isset($_POST['btnSalida'])) {
		$cajaC = CajaChicaData::getAll();

		$entradas = $cajaC->entradas;
		$salidas = $cajaC->salidas;

		$cajaC->idusuario = $_SESSION['user_id'];
		$cajaC->idempleado = "null";
		if (isset($_POST['empleado']) && $_POST['empleado'] != "") {
			$cajaC->idempleado = $_POST['empleado'];
		}
		$cajaC->cantidad = $_POST['cantidad'];
		$cajaC->descripcion = $_POST['descripcion'];
		$cajaC->fecha = "NOW()";
		$cajaC->addSalida();

		$cajaC->salidas = $salidas + $_POST['cantidad'];
		$cajaC->cantidad = $cajaC->entradas - $cajaC->salidas;
		$cajaC->update();
	}
	@header("location: index.php?view=sboxe&val=sal");
?>