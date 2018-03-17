<?php

    include "loader.php";
    if (isset($_POST) && count($_POST) > 0){
        $abono = new AbonoData();
        $abono->idsucursal = $_SESSION["usr_suc"];
        $abono->idusuario = Session::getUID();
        $abono->idpedido = $_POST["idPedido"];
        $abono->idcliente = $abono->getPedido()->idcliente;
        $abono->cantidad = $_POST["cantidad"];
        $abono->tipocomprobante = $_POST["tipoComprobante"];
        $abono->numerocomprobante = $_POST["numComprobante"];
        $abono->totalLetras = $_POST["totalLetras"];
        $abono->add();
        
        $pedido = PedidoData::getById($abono->idpedido);
        $pedido->restante = $pedido->restante - $abono->cantidad;
        $pedido->updateRestante();
        @header("location: index.php?view=pagos&idP=$pedido->id");
    }

?>