<?php
	
	$gasto = new GastoData();
	if ((isset($_GET["id"]) && is_numeric($_GET["id"])) && !is_null($gasto->getById($_GET["id"]))){
		$gasto = $gasto->getById($_GET["id"]);
		$gasto->del();
		setcookie("okGasto","¡Se eliminó la información correctamente!");
	}else{
		setcookie("errorGasto","!Vaya! Parece que no se ha podido eliminar la información. Por favor, inténtelo nuevamente.");
	}
	Core::redir("./index.php?view=gastos");

?>
