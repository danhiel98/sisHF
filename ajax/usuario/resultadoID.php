<?php

    include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");
    include ("../../core/modules/sistema/model/EmpleadoData.php");
    include ("../../core/modules/sistema/model/UserTypeData.php");

    if (isset($_POST["id"]) && is_numeric($_POST["id"])){
        $id = $_POST["id"]; #Id del usuario
        $user = UserData::getById($id);

        if(!is_null($user)){
            echo json_encode($user);
        }

    }