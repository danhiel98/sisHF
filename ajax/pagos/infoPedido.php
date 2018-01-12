<?php

    session_start();
	include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/PedidoData.php");
    include ("../../core/modules/sistema/model/ClientData.php");

    if (isset($_POST["idPedido"]) && $_POST["idPedido"] != ""){
        $id = $_POST["idPedido"];
        $pedido = PedidoData::getById($id);
        if ($pedido){
            $pedido->nombreC = $pedido->getClient()->name;
            echo json_encode($pedido);
        }
    }

?>