<?php

include "loader.php";

if(count($_POST)>0){
    $ingreso = CajaChicaData::getIngresoById($_POST['id']);
    
    $cantidadActual = $ingreso->cantidad;
    
    $ingreso->cantidad = $_POST["cantidad"];
    
    $caja = $ingreso->getAll();
    $caja->entradas = $caja->entradas - $cantidadActual;
    $caja->entradas = $caja->entradas + $_POST["cantidad"];
    $caja->cantidad = $caja->entradas - $caja->salidas;
    
    if($caja->cantidad < 0){
        setcookie("errorIngreso","No se puede actualizar la información.");
    }else{
        $ingreso->updateIngreso();
        $caja->update();
        setcookie("okIngreso","¡Se actualizó la información correctamente!");
    }

}
@header("location: index.php?view=sboxe&val=ent");

?>
