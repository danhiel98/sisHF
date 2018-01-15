<?php
    
    include "loader.php";
    $sucursal = new SucursalData();
    if ((isset($_GET["id"]) && !empty($_GET["id"])) && !is_null($sucursal->getById($_GET["id"]))){
        $idSuc = $_GET["id"];
        if ($idSuc != 1){
            $sucursal = $sucursal->getById($idSuc);
            $empleados = EmpleadoData::getAllBySucId($sucursal->id);
            $productos = ProductoSucursalData::getAllBySucId($sucursal->id);

            $errorProd = false;
            $errorEmp = false;

            if(count($empleados) > 0){
                $errorEmp = true;
            }

            foreach($productos as $prod){
                if($prod->cantidad > 0){
                    $errorProd = true;
                    break;
                }
            }

            if(!$errorEmp && !$errorProd){
                $sucursal->del();
                setcookie("okSuc","¡Se eliminó la información correctamente!");
            }else{
                $prodMsg = "";
                if($errorProd){
                    $prodMsg = "y/o hay productos";
                }
                setcookie("errorSuc","No se puede eliminar la sucursal porque ya se han registrado empleados $prodMsg en ella.");
            }
        }else{
            setcookie("errorSuc","!Vaya! La sucursal seleccionada no se puede eliminar.");
        }
    }else{
        setcookie("errorSuc","!Vaya! Parece que no se ha podido eliminar el banco. Por favor, inténtelo nuevamente.");
    }
    Core::redir("./index.php?view=sucursal");

?>
