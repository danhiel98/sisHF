<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/PedidoData.php");

	if (isset($_POST["idFin"]) && !empty($_POST["idFin"])) {
		$id = $_POST["idFin"];
		#$pedido = PedidoData::getById($id);
		PedidoData::finalizar($id);
	}

?>