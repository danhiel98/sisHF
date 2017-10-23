<?php

	include "loader.php";
	if (isset($_POST["addMP"])) {
		$mp = new MateriaPrimaData();
		$mp->idusuario = Session::getUID();
		$mp->nombre = $_POST["nombre"];
		$mp->descripcion = $_POST["descripcion"];
		$mp->minimo = $_POST["minimo"];
		$mp->add();
	}

?>
<script>window.location='index.php?view=inventarymp';</script>
