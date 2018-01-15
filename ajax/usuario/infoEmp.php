<?php

    include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");
    include ("../../core/modules/sistema/model/EmpleadoData.php");
    include ("../../core/modules/sistema/model/UserTypeData.php");
    
    if (isset($_POST["id"]) && !empty($_POST["id"])){
        
        $id = $_POST["id"];
        $emp = EmpleadoData::getById($id);
        
        if (!is_null($emp)){
            $emp->nombreSucursal = $emp->getSucursal()->nombre;
            
            echo json_encode($emp);

        }
    }
