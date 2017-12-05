<?php

    session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ClientData.php");
    
    if (isset($_POST["idCli"]) && $_POST["idCli"] != ""){
        
        $idCliente = $_POST["idCli"];
    
        $cliente = ClientData::getById($idCliente);
    
        echo json_encode($cliente);

    }



?>