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
include "../../core/modules/sistema/model/AbonoData.php";
include "../../core/modules/sistema/model/PedidoData.php";

$idFact = $_GET["id"];
$abono = false;
$tipo = "";
if (!isset($_REQUEST["abono"])){
    
    $factura = FacturaData::getById($idFact);
    if(is_null($factura)){
        echo "Ha ocurrido un error";
        exit();
    }
    $pVend = FacturaData::getAllSellsByFactId($idFact);
    $sVend = FacturaData::getAllServicesByFactId($idFact);
    $tipo = "venta";
}else{
    $abono = true;
    $factura = AbonoData::getById($idFact);
    if(is_null($factura)){
        echo "Ha ocurrido un error";
        exit();
    }
    $pVend = PedidoData::getAllProductsByPedidoId($factura->idpedido);
    $sVend = PedidoData::getAllServicesByPedidoId($factura->idpedido);

    $numeroComprobante = $factura->numerocomprobante;
    $totalSumasP = $factura->cantidad;
    
    $tipo = "abono";
}
$documento = "";

if ($factura->getClient()->dui != ""){
    $documento = $factura->getClient()->dui;
}elseif($factura->getClient()->nit != ""){
    $documento = $factura->getClient()->nit;
}

$totalRegistros = count($pVend) + count($sVend);
$totalSumas = 0;
$fecha = new DateTime($factura->fecha);
$direccion = utf8_decode($factura->getClient()->direccion);
//Variable que guarda el nombre del archivo PDF
$archivo="factura-$tipo.pdf";

//Llamada al script fpdf
require('fpdf.php');

$archivoSalida = $archivo;

$pdf=new FPDF('P','mm',array(150,215));  //crea el objeto, se especifica el tamaño de página en milímetros
$pdf->AddPage(0);  //Se agrega una página
$pdf->SetAutoPageBreak(false,0.5);
$pdf->Ln(29);

$pdf->cell(90);
$pdf->SetFont('Arial','',10);
$pdf->Cell(6/*, 4, "Fecha"*/);
$pdf->Cell(20, 4, $fecha->format("d/m/Y"));
$pdf->Ln(6);

$pdf->SetFont('Arial','',9);
$pdf->Cell(12/*, 4, "Cliente"*/);
$pdf->Cell(100, 4, utf8_decode($factura->getClient()->name));
$pdf->Ln(6);

$pdf->Cell(12/*, 10, "Dirección"*/);
if (strlen($direccion)>85){
    $pdf->setXY(22,55.5);
    $pdf->MultiCell(115, 3, $direccion);
    $pdf->setY(60);
}else{
    $pdf->Cell(100, 4, $direccion);
    $pdf->Ln(6);
}

$pdf->Cell(12/*, 5, "DUI o NIT"*/);
$pdf->Cell(100, 4, $documento);
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

$y = 71;
$cant = 0;
foreach($pVend as $vend){
    $cant++;
    $prod = $vend->getProduct();
    $pdf->setXY(11,$y);
  
    if(!$abono){
        $pdf->Cell(10,5.5,$vend->cantidad);
    }else{
        $pdf->Cell(10,5.5,"");
    }
    $pdf->setXY(21,$y);

    if(!$abono){
        $pdf->MultiCell(57,5.5,utf8_decode($prod->nombre));
    }else{
        $pdf->MultiCell(57,5.5,utf8_decode("$vend->cantidad $prod->nombre"));
    }
    
    $pdf->setXY(82,$y);
    
    if(!$abono){
        $pdf->Cell(14,5.5,"$".number_format($vend->precio,2,".",","));
    }else{
        $pdf->Cell(14,5.5,"");
    }

    $pdf->Cell(14,5.5,"");
    $pdf->Cell(13,5.5,"");

    if(!$abono){
        $pdf->Cell(18,5.5,"$".number_format($vend->total,2,".",","));
    }else{
        if($cant == $totalRegistros){
            $pdf->Cell(18,5.5,"$".number_format($totalSumasP,2,".",","));
        }
    }
    $y += 5.5;
    $totalSumas += $vend->total;
}

foreach($sVend as $vend){
    $cant++;
    $serv = $vend->getService();
    $pdf->setXY(11,$y);

    if(!$abono){
        $pdf->Cell(10,5.5,$vend->cantidad);
    }else{
        $pdf->Cell(10,5.5,"");
    }

    $pdf->setXY(21,$y);

    if(!$abono){
        $pdf->MultiCell(57,5.5,utf8_decode($serv->nombre));
    }else{
        $pdf->MultiCell(57,5.5,utf8_decode("$vend->cantidad $serv->nombre"));
    }
    
    $pdf->setXY(82,$y);
    
    if(!$abono){
        $pdf->Cell(14,5.5,"$".number_format($vend->precio,2,".",","));
    }else{
        $pdf->Cell(14,5.5,"");
    }

    $pdf->Cell(14,5.5,"");
    $pdf->Cell(13,5.5,"");
    
    if(!$abono){
        $pdf->Cell(18,5.5,"$".number_format($vend->total,2,".",","));
    }else{
        if($cant == $totalRegistros){
            $pdf->Cell(18,5.5,"$".number_format($totalSumasP,2,".",","));
        }
    }

    $y += 5.5;
    $totalSumas += $vend->total;
}

for ($i = $totalRegistros; $i <= 16; $i++){
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
$y += 7;
$pdf->setXY(5,$y);
$pdf->Cell(10,8,""/*"SON"*/);
$pdf->setXY(16,$y);
$pdf->MultiCell(57,4,utf8_decode($factura->totalLetras));
$pdf->setXY(72,$y);
$pdf->MultiCell(34,4,""/*"SUMAS"*/);
$pdf->setXY(72,$y+4);
$pdf->MultiCell(51,4,""/*"IVA RETENIDO"*/);
$pdf->setXY(106,$y);
$pdf->MultiCell(17,4,""); #Espacio en blanco solamente
$pdf->setXY(123,$y);
if(!$abono){
    $pdf->MultiCell(18,4,"$".number_format($totalSumas,2,".",",")); #Aquí debe ir el valor de las sumas
}else{
    $pdf->MultiCell(18,4,"$".number_format($totalSumasP,2,".",",")); #Aquí debe ir el valor de las sumas    
}
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
$pdf->setXY(123,$y+12);
if(!$abono){
    $pdf->MultiCell(18,12,"$".number_format($totalSumas,2,".",","));
}else{
    $pdf->MultiCell(18,12,"$".number_format($totalSumasP,2,".",","));    
}


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