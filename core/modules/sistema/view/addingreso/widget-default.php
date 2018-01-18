<?php
    include "loader.php";
    if (isset($_POST['btnIngreso'])){
		$cajaC = CajaChicaData::getAll();

		$entradas = $cajaC->entradas;
		$salidas = $cajaC->salidas;

		$cajaC->idusuario = $_SESSION['user_id'];
		$cajaC->cantidad = $_POST['cantidad'];
		$cajaC->fecha = "NOW()";
		$cajaC->addIngreso();

		$cajaC->entradas = $entradas + $_POST['cantidad'];
		$cajaC->cantidad = $cajaC->entradas - $cajaC->salidas;
        $cajaC->update();
    }
    @header("location: index.php?view=sboxe&val=ent");   
?>