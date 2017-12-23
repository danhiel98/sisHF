<?php

    @session_start();
    include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/CausaDevolucionData.php");
	include ("../../core/modules/sistema/model/DevolucionData.php");
    include ("../../core/modules/sistema/model/ComprobanteData.php");
	include ("../../core/modules/sistema/model/FacturaData.php");
    include ("../../core/modules/sistema/model/ProductData.php");
    include ("../../core/modules/sistema/model/ClientData.php");

    if (isset($_REQUEST["num"]) && $_REQUEST["num"] != ""){
        $num = $_REQUEST["num"]; #El numero del comprobante (Factura, CCF o Recibo)
        $fact = FacturaData::getByNumber($num);
        if (!is_null($fact)){
            $fact->nombrecliente = $fact->getClient()->fullname;
            $fact->nombrecomprobante = $fact->getComprobante()->nombre;
            echo json_encode($fact);
        }
    }