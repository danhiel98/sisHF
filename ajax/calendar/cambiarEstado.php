<?php
    
    @session_start();
	include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/MantenimientoData.php");
    include ("../../core/modules/sistema/model/ClientData.php");
    include ("../../core/modules/sistema/model/UserData.php");
    include ("../../core/modules/sistema/model/FacturaData.php");
    include ("../../core/modules/sistema/model/PedidoData.php");
    include ("../../core/modules/sistema/model/ProductData.php");
    include ("../../core/modules/sistema/model/SucursalData.php");

    if(!isset($_POST["id"]) || !is_numeric($_POST["id"])){
        error();
    }
    $id = $_POST["id"];
    $mantto = MantenimientoData::getById($id);
    if($mantto->realizado == 0){
        $mantto->finish();
    }else{
        $mantto->revert();
    }
?>