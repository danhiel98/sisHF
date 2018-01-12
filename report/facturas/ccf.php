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
include "../../core/modules/sistema/model/DireccionData.php";

$idFact = $_GET["id"];

$factura = FacturaData::getById($idFact);

$pVend = FacturaData::getAllSellsByFactId($idFact);
$sVend = FacturaData::getAllServicesByFactId($idFact);
$totalResistros = count($pVend) + count($sVend);
$totalSumas = $totalSumasSinIva = $descuentoIva = $totalPagar = 0;

$fecha = new DateTime($factura->fecha);
$direccion = utf8_decode($factura->getClient()->direccion);
//Variable que guarda el nombre del archivo PDF
$archivo="ccf-venta.pdf";

//Llamada al script fpdf
require('fpdf.php');

$archivoSalida = $archivo;

$pdf=new FPDF('P','mm',array(150,215));  //crea el objeto, se especifica el tamaño de página en milímetros
$pdf->AddPage(0);  //Se agrega una página
$pdf->Ln(30);

$pdf->setX(5);
$pdf->SetFont('Arial','',9);
$pdf->Cell(14, 3/*, utf8_decode("Señor")*/);
$pdf->setXY(24,39);
$pdf->MultiCell(58, 4, utf8_decode($factura->getClient()->name));
$pdf->Ln(7);

$pdf->setX(5);
$pdf->Cell(18, 3/*, utf8_decode("Dirección")*/);
$pdf->setXY(24,51);
$pdf->MultiCell(58, 4, utf8_decode($direccion));
$pdf->setY(60);

$pdf->setX(5);
$pdf->Cell(22, 3/*, "Departamento"*/);
$pdf->Cell(58, 4, utf8_decode($factura->getClient()->getDepto()->nombreDepto));
$pdf->Ln(7);

$pdf->setX(5);
$pdf->Cell(15, 3/*, "Giro"*/);
$pdf->Cell(58, 4, utf8_decode($factura->getClient()->giro));
$pdf->Ln(7);

$pdf->setXY(85,39);
$pdf->Cell(14, 3/*, utf8_decode("Fecha")*/);
$pdf->Cell(50, 3, utf8_decode($fecha->format("d/m/Y")));
$pdf->Ln(7);

$pdf->setXY(85,44);
$pdf->Cell(14, 3/*, utf8_decode("N.R.C")*/);
$pdf->Cell(50, 3, utf8_decode($factura->getClient()->nrc));
$pdf->Ln(7);

$pdf->setXY(85,49);
$pdf->Cell(14, 3/*, utf8_decode("N.I.T")*/);
$pdf->Cell(50, 3, utf8_decode($factura->getClient()->nit));
$pdf->Ln(7);

$pdf->setXY(85,54);
$pdf->Cell(14, 3/*, utf8_decode("No. Nota de Remisión")*/);
$pdf->Cell(50, 3, utf8_decode(""));
$pdf->Ln(7);

$pdf->setXY(85,59);
$pdf->Cell(14, 3/*, utf8_decode("Fecha Nota de Remisión")*/);
$pdf->Cell(50, 3, utf8_decode(""));
$pdf->Ln(7);

$pdf->setXY(85,64);
$pdf->Cell(14, 3/*, utf8_decode("Condiciones de Pago")*/);
$pdf->Cell(50, 3, utf8_decode(""));
$pdf->Ln(7);

$pdf->setXY(85,69);
$pdf->Cell(14, 3/*, utf8_decode("Venta a Cuenta de")*/);
$pdf->Cell(50, 3, utf8_decode(""));
$pdf->Ln(7);

$pdf->SetFont('Arial','',8);
$pdf->setXY(5,80);
$pdf->Cell(10,8,""/*,"CAN"*/);
$pdf->Cell(57,8,""/*,"DESCRIPCION"*/);
$pdf->MultiCell(17,4,""/*,"PRECIO UNITARIO"*/);
$pdf->setXY(89,80);
$pdf->MultiCell(17,4,""/*,"VTAS NO SUJETAS"*/);
$pdf->setXY(106,80);
$pdf->MultiCell(17,4,""/*,"VENTAS EXENTAS"*/);
$pdf->setXY(123,80);
$pdf->MultiCell(18,4,""/*,"VENTAS GRAVADAS"*/);

$y = 78;
foreach($pVend as $vend){
    $prod = $vend->getProduct();
    $precioSinIva = $vend->precio - ($vend->precio * 0.13);
    $totalSinIva = $vend->total - ($vend->total * 0.13);
    $pdf->setXY(5,$y);
    $pdf->Cell(10,6.2,$vend->cantidad);
    $pdf->setXY(15,$y);
    $pdf->MultiCell(57,6.2,$prod->nombre);
    $pdf->setXY(72,$y);
    $pdf->Cell(17,6.2,"$".number_format($precioSinIva,2,".",","));
    $pdf->Cell(17,6.2,"");
    $pdf->Cell(17,6.2,"");
    $pdf->Cell(18,6.2,"$".number_format($totalSinIva,2,".",","));
    $y += 6;
    $totalSumas += $vend->total;
    $totalSumasSinIva += $totalSinIva;
}

foreach($sVend as $vend){
    $serv = $vend->getService();
    $precioSinIva = $vend->precio - ($vend->precio * 0.13);
    $totalSinIva = $vend->total - ($vend->total * 0.13);
    $pdf->setXY(5,$y);
    $pdf->Cell(10,6.2,$vend->cantidad);
    $pdf->setXY(15,$y);
    $pdf->MultiCell(57,6.2,$serv->nombre);
    $pdf->setXY(72,$y);
    $pdf->Cell(17,6.2,"$".number_format($precioSinIva,2,".",","));
    $pdf->Cell(17,6.2,"");
    $pdf->Cell(17,6.2,"");
    $pdf->Cell(18,6.2,"$".number_format($totalSinIva,2,".",","));
    $y += 6;
    $totalSumas += $vend->total;
    $totalSumasSinIva += $totalSinIva;
}

$descuentoIva = 0.13 * $totalSumas;
$totalPagar = $descuentoIva + $totalSumasSinIva;

for ($i = $totalResistros; $i <= 12; $i++){
    $pdf->setXY(5,$y);
    $pdf->Cell(10,6.2,"");
    $pdf->setXY(15,$y);
    $pdf->MultiCell(57,6.2,"");
    $pdf->setXY(72,$y);
    $pdf->Cell(17,6.2,"");
    $pdf->Cell(17,6.2,"");
    $pdf->Cell(17,6.2,"");
    $pdf->Cell(18,6.2,"");
    $y += 6;
}

$pdf->setXY(5,$y);
$pdf->Cell(10,8,"SON");
$pdf->setXY(15,$y);
$pdf->MultiCell(57,5,utf8_decode($factura->totalLetras));

$pdf->setXY(72,$y);
$pdf->MultiCell(34,5,"Sumas");
$pdf->setXY(72,$y+5.5);
$pdf->MultiCell(51,5,"13% de IVA");
$pdf->setXY(106,$y);
$pdf->MultiCell(17,5,""); #Espacio en blanco solamente
$pdf->setXY(123,$y);
$pdf->MultiCell(18,5,"$".number_format($totalSumasSinIva,2,".",",")); #Aquí debe ir el valor de las sumas
$pdf->setXY(123,$y+5.5);
$pdf->MultiCell(18,5,"$".number_format($descuentoIva,2,".",",")); #Valor del iva retenido

$y += 11;
$pdf->setXY(5,$y);
$pdf->Cell(67,12,"");
$pdf->setXY(72,$y);
$pdf->MultiCell(51,5,"Sub-Total");
$pdf->setXY(72,$y+5.5);
$pdf->MultiCell(51,5,"Iva Retenido");
$pdf->setXY(72,$y+11);
$pdf->MultiCell(51,5,"Ventas no Sujetas");
$pdf->setXY(72,$y+16.5);
$pdf->MultiCell(51,5,"Ventas Extentas");
$pdf->setXY(72,$y+22);
$pdf->MultiCell(51,5,"Total");

$pdf->setXY(123,$y);
$pdf->MultiCell(18,5,"$".number_format($totalPagar,2,".",",")); #Subtotal
$pdf->setXY(123,$y+5.5);
$pdf->MultiCell(18,5,""); #Iva retenido
$pdf->setXY(123,$y+11);
$pdf->MultiCell(18,5,""); #Ventas no sujetas
$pdf->setXY(123,$y+16.5);
$pdf->MultiCell(18,5,""); #Ventas extentas
$pdf->setXY(123,$y+22);
$pdf->MultiCell(18,5,"$".number_format($totalPagar,2,".",",")); #Total


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