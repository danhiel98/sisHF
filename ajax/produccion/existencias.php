<?php

    @session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ProductoSucursalData.php");

    $idSuc = $_SESSION["usr_suc"];

    if(isset($_POST["idProducto"]) && is_numeric($_POST["idProducto"])){
        $idProd = $_POST["idProducto"];

        $product = ProductoSucursalData::getBySucursalProducto($idSuc,$idProd);
        if(!is_null($product)){
            echo $product->cantidad;
        }
    }

?>