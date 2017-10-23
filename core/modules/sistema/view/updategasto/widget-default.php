<?php

if(count($_POST)>0){
	$data = GastoData::getById($_POST['idGasto']);
	$data->descripcion = $_POST["descripcion"];
	$data->pago = $_POST["pago"];
	$data->update();

	print "<script>window.location='index.php?view=gastos';</script>";

}

?>
