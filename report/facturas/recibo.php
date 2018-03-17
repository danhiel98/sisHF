<?php
@session_start();
include "../../core/autoload.php";
include "../../core/modules/sistema/model/SucursalData.php";
include "../../core/modules/sistema/model/FacturaData.php";
include "../../core/modules/sistema/model/ComprobanteData.php";
include "../../core/modules/sistema/model/ClientData.php";
include "../../core/modules/sistema/model/UserData.php";
include "../../core/modules/sistema/model/EmpleadoData.php";
include "../../core/modules/sistema/model/ProductData.php";
include "../../core/modules/sistema/model/ServiceData.php";
include "../../core/modules/sistema/model/AbonoData.php";
include "../../core/modules/sistema/model/PedidoData.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])){
    $idFact = $_GET["id"];
}else{
    error();
}

$tipo = "";
$totalSumas = 0;
if (!isset($_REQUEST["abono"])){ //En caso que no sea un pago de pedido
    $factura = FacturaData::getById($idFact);
    if(is_null($factura)){
        error();
    }
    $numeroComprobante = $factura->numerofactura;
    
    $pVend = FacturaData::getAllSellsByFactId($idFact);
    $sVend = FacturaData::getAllServicesByFactId($idFact);

    foreach($pVend as $vend){
        $totalSumas += $vend->total;
    }
    foreach($sVend as $vend){
        $totalSumas += $vend->total;
    }
    $tipo = "venta";
}else{
    $factura = AbonoData::getById($idFact);
    if(is_null($factura)){
        echo "Ha ocurrido un error";
        exit();
    }
    $pVend = PedidoData::getAllProductsByPedidoId($factura->idpedido);
    $sVend = PedidoData::getAllServicesByPedidoId($factura->idpedido);
    $numeroComprobante = $factura->numerocomprobante;

    $totalSumas = $factura->cantidad;
    $tipo = "abono";
}

$totalResistros = count($pVend) + count($sVend);

$fecha = new DateTime($factura->fecha);
$direccion = utf8_decode($factura->getClient()->direccion);

//Variable que guarda el nombre del archivo PDF
$archivo="recibo-$tipo.pdf";

//Llamada al script fpdf
require('fpdf.php');

$archivoSalida = $archivo;

$pdf=new FPDF('L','mm',array(120,170));  //crea el objeto, se especifica el tamaño de página en milímetros

#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(12, 10 , 12);

#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);

$pdf->AddPage();  //Se agrega una página
$pdf->Ln(7);


$pdf->SetFont('Arial','',15);
$pdf->cell(15,5/*,"HIERRO FORJADO"*/);

$pdf->cell(100);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5/*,"RECIBO"*/);
$pdf->Ln(10);
$pdf->setX(130);
$pdf->SetFont('Arial','',10);
$pdf->Cell(10,5,"");

$pdf->Ln(20);

$pdf->SetFont('Arial','B',10);
$pdf->cell(15,5/*,"Fecha"*/);
$pdf->SetFont('Arial','',10);
$pdf->cell(20,5,$fecha->format("d/m/Y"));

$pdf->cell(80);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5/*,"POR"*/);
$pdf->SetFont('Arial','',10);
$pdf->Cell(20, 5,"$ ".number_format($totalSumas,2,".",","));
$pdf->Ln(14.5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,5/*, "NOMBRE"*/);
$pdf->SetFont('Arial','',10);
$pdf->Cell(100, 5, utf8_decode($factura->getClient()->name));
$pdf->Ln(11.5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(24,5/*, "CANTIDAD"*/);
$pdf->SetFont('Arial','',10);
$pdf->Cell(100, 5, utf8_decode($factura->totalLetras));
$pdf->Ln(11.5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(37,5/*, "CONCEPTO DE"*/);
$pdf->SetFont('Arial','',10);

$vendido = "";
$cant = 0;
foreach($pVend as $vend){
    $prod = $vend->getProduct();
    $vendido .= utf8_decode("$vend->cantidad $prod->nombre(s)");
    $cant++;
    if ($cant != $totalResistros){
        $vendido .= ", ";
    }
}
foreach($sVend as $vend){
    $serv = $vend->getService();
    $vendido .= utf8_decode("$vend->cantidad $serv->nombre(s)");
    $cant++;
    if ($cant != $totalResistros){
        $vendido .= ", ";
    }
}
$pdf->MultiCell(100, 5, "Pago de $vendido");

$pdf->setXY(15,103);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5/*, "Autorizado por"*/);
$pdf->SetFont('Arial','',10);
$pdf->Cell(50, 5, utf8_decode(""));

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5/*, "Firma de Recibido"*/);
$pdf->SetFont('Arial','',10);
$pdf->Cell(50, 5, "");
$pdf->Ln(10);


$pdf->Output($archivoSalida);//cierra el objeto pdf
/*
//Creacion de las cabeceras que generarán el archivo pdf
header ("Content-Type: application/download");
header ("Content-Disposition: attachment; filename=$archivo");
header("Content-Length: " . filesize("$archivo"));
$fp = fopen($archivo, "r");
fpassthru($fp);
fclose($fp);

//Eliminación del archivo en el servidor
unlink($archivo);
*/
header("Content-type: application/pdf");
header("Content-Length:". filesize("$archivo"));
header("Content-Disposition: inline; filename=$archivo");
readfile($archivo);
unlink($archivo);