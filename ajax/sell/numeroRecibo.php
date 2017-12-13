<?php

    #Este archivo sirve para consultar el id del último recibo entregado

    session_start();
	include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/FacturaData.php");

    $numero = FacturaData::getLastRecibo();
    $numero += 1;

    echo json_encode($numero);
    
?>