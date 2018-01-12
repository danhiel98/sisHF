<?php
include "../../core/autoload.php";
include "../../core/modules/sistema/model/SucursalData.php";
include "../../core/modules/sistema/model/FacturaData.php";
include "../../core/modules/sistema/model/ComprobanteData.php";
include "../../core/modules/sistema/model/ClientData.php";
include "../../core/modules/sistema/model/UserData.php";
include "../../core/modules/sistema/model/EmpleadoData.php";
include "../../core/modules/sistema/model/ProductData.php";
include "../../core/modules/sistema/model/ServiceData.php";

$idFact = $_GET["id"];

$factura = FacturaData::getById($idFact);

$pVend = FacturaData::getAllSellsByFactId($idFact);
$sVend = FacturaData::getAllServicesByFactId($idFact);
$totalResistros = count($pVend) + count($sVend);
$totalSumas = 0;

$fecha = new DateTime($factura->fecha);
$direccion = utf8_decode($factura->getClient()->direccion);
//Variable que guarda el nombre del archivo PDF
$archivo="factura-venta.pdf";

//Llamada al script fpdf
require('fpdf.php');

$archivoSalida = $archivo;

$pdf=new FPDF('P','mm',array(150,215));  //crea el objeto, se especifica el tamaño de página en milímetros
$pdf->AddPage(0);  //Se agrega una página
$pdf->Ln(30);

$pdf->cell(100);
$pdf->SetFont('Arial','',10);
$pdf->Cell(12/*, 10, "Fecha"*/);
$pdf->Cell(20, 10, $fecha->format("d/m/Y"));
$pdf->Ln(7);

$pdf->SetFont('Arial','',9);
$pdf->Cell(12/*, 10, "Cliente"*/);
$pdf->Cell(100, 10, utf8_decode($factura->getClient()->name));
$pdf->Ln(7);

$pdf->Cell(12/*, 10, "Dirección"*/);
if (strlen($direccion)>85){
    $pdf->setXY(22,55.5);
    $pdf->MultiCell(115, 3, $direccion);
    $pdf->setY(60);
}else{
    $pdf->Cell(100, 10, $direccion);
    $pdf->Ln(7);
}

$pdf->Cell(12/*, 10, "DUI o NIT"*/);
$pdf->Cell(100, 10, $factura->getClient()->dui);
$pdf->Ln(7);

$pdf->SetFont('Arial','',8);
$pdf->setXY(5,70);
$pdf->Cell(10,8,""/*,"CAN"*/);
$pdf->Cell(57,8,""/*,"DESCRIPCION"*/);
$pdf->MultiCell(17,4,""/*,"PRECIO UNITARIO"*/);
$pdf->setXY(89,70);
$pdf->MultiCell(17,4,""/*,"VTAS NO SUJETAS"*/);
$pdf->setXY(106,70);
$pdf->MultiCell(17,4,""/*,"VENTAS EXENTAS"*/);
$pdf->setXY(123,70);
$pdf->MultiCell(18,4,""/*,"VENTAS GRAVADAS"*/);

$y = 78;
foreach($pVend as $vend){
    $prod = $vend->getProduct();
    $pdf->setXY(5,$y);
    $pdf->Cell(10,5.5,$vend->cantidad);
    $pdf->setXY(15,$y);
    $pdf->MultiCell(57,5.5,$prod->nombre);
    $pdf->setXY(72,$y);
    $pdf->Cell(17,5.5,"$".number_format($vend->precio,2,".",","));
    $pdf->Cell(17,5.5,"");
    $pdf->Cell(17,5.5,"");
    $pdf->Cell(18,5.5,"$".number_format($vend->total,2,".",","));
    $y += 5.5;
    $totalSumas += $vend->total;
}

foreach($sVend as $vend){
    $serv = $vend->getService();
    $pdf->setXY(5,$y);
    $pdf->Cell(10,5.5,$vend->cantidad);
    $pdf->setXY(15,$y);
    $pdf->MultiCell(57,5.5,$serv->nombre);
    $pdf->setXY(72,$y);
    $pdf->Cell(17,5.5,"$".number_format($vend->precio,2,".",","));
    $pdf->Cell(17,5.5,"");
    $pdf->Cell(17,5.5,"");
    $pdf->Cell(18,5.5,"$".number_format($vend->total,2,".",","));
    $y += 5.5;
    $totalSumas += $vend->total;
}

for ($i = $totalResistros; $i <= 16; $i++){
    $pdf->setXY(5,$y);
    $pdf->Cell(10,5.5,"");
    $pdf->setXY(15,$y);
    $pdf->MultiCell(57,5.5,"");
    $pdf->setXY(72,$y);
    $pdf->Cell(17,5.5,"");
    $pdf->Cell(17,5.5,"");
    $pdf->Cell(17,5.5,"");
    $pdf->Cell(18,5.5,"");
    $y += 5.5;
}

$pdf->setXY(5,$y);
$pdf->Cell(10,8,""/*"SON"*/);
$pdf->setXY(15,$y);
$pdf->MultiCell(57,4,utf8_decode($factura->totalLetras));
$pdf->setXY(72,$y);
$pdf->MultiCell(34,4,""/*"SUMAS"*/);
$pdf->setXY(72,$y+4);
$pdf->MultiCell(51,4,""/*"IVA RETENIDO"*/);
$pdf->setXY(106,$y);
$pdf->MultiCell(17,4,""); #Espacio en blanco solamente
$pdf->setXY(123,$y);
$pdf->MultiCell(18,4,"$".number_format($totalSumas,2,".",",")); #Aquí debe ir el valor de las sumas
$pdf->setXY(123,$y+4);
$pdf->MultiCell(18,4,""); #Valor del iva retenido

$y += 8;
$pdf->setXY(5,$y);
$pdf->Cell(67,12,"");
$pdf->setXY(72,$y);
$pdf->MultiCell(51,4,""/*"VENTAS NO SUJETAS"*/);
$pdf->setXY(72,$y+4);
$pdf->MultiCell(51,4,""/*"VENTAS EXENTAS"*/);
$pdf->setXY(72,$y+8);
$pdf->MultiCell(51,4,""/*"VENTA TOTAL"*/);
$pdf->setXY(123,$y);
$pdf->MultiCell(18,4,""); #Ventas no sujetas
$pdf->setXY(123,$y+4);
$pdf->MultiCell(18,4,""); #Ventas exentas
$pdf->setXY(123,$y+8);
$pdf->MultiCell(18,4,"$".number_format($totalSumas,2,".",",")); #Venta total


$pdf->Output($archivoSalida);//cierra el objeto pdf

//Creacion de las cabeceras que generarán el archivo pdf
header ("Content-Type: application/download");
header ("Content-Disposition: attachment; filename=$archivo");
header("Content-Length: " . filesize("$archivo"));
$fp = fopen($archivo, "r");
fpassthru($fp);
fclose($fp);

//Eliminación del archivo en el servidor
unlink($archivo);