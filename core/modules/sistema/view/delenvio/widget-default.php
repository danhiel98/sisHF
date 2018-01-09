<?php

	$envio = new EnvioData();
	if ((isset($_GET["id"]) && !empty($_GET["id"])) && !is_null($envio->getById($_GET["id"]))){
		$envio = $envio->getById($_GET["id"]);
		$envio->del();
		setcookie("okEnvio","¡Se eliminó la información correctamente!");
	}else{
		setcookie("errorEnvio","!Vaya! Parece que no se ha podido eliminar el envío. Por favor, inténtelo nuevamente.");
	}
	Core::redir("./index.php?view=envios");

?>
