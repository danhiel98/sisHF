<?php

    //En este archivo se cargarán las tareas que debe hacer el empresario (Mantenimientos)
    @session_start();
	include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/MantenimientoData.php");
    include ("../../core/modules/sistema/model/ClientData.php");
    include ("../../core/modules/sistema/model/UserData.php");
    include ("../../core/modules/sistema/model/FacturaData.php");
    include ("../../core/modules/sistema/model/PedidoData.php");
    include ("../../core/modules/sistema/model/ProductData.php");
    include ("../../core/modules/sistema/model/SucursalData.php");
    
    $idSuc = $_SESSION["usr_suc"];
    $idUsr = Session::getUID();

    $manttos = MantenimientoData::getAllBySucId($idSuc);

    if($idUsr == 1){
        $manttos = MantenimientoData::getAll();
    }
    
    $todo = array(
        "success" => 1,
        "result" => $manttos
    );

    echo json_encode($todo);

?>