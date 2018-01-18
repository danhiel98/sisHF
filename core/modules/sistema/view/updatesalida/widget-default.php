<?php

include "loader.php";

if(count($_POST)>0){
    $salida = CajaChicaData::getSalidaById($_POST['id']);
    $cantidadActual = $salida->cantidad;
    
    $salida->idempleado = "NULL";
    if(!empty($_POST["empleado"])){
        $salida->idempleado = $_POST["empleado"];
    }
    $salida->cantidad = $_POST["cantidad"];
    $salida->descripcion = $_POST["descripcion"];
    
    $caja = $salida->getAll();
    $caja->salidas = $caja->salidas - $cantidadActual;
    $caja->salidas = $caja->salidas + $_POST["cantidad"];
    $caja->cantidad = $caja->entradas - $caja->salidas;
    
    if($caja->cantidad < 0){
        setcookie("errorSalida","No se puede actualizar la información.");
    }else{
        $salida->updateSalida();
        $caja->update();
        setcookie("okSalida","¡Se actualizó la información correctamente!");
    }

}
@header("location: index.php?view=sboxe&val=sal");

?>
