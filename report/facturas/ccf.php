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
include "../../core/modules/sistema/model/AbonoData.php";
include "../../core/modules/sistema/model/PedidoData.php";

$idFact = $_GET["id"];
$abono = false;
$condicion = "";
$tipo = "";
if (!isset($_REQUEST["abono"])){ //En caso que no sea un pago de pedido
    $factura = FacturaData::getById($idFact);
    if(is_null($factura)){
        echo "Ha ocurrido un error";
        exit();
    }
    $pVend = FacturaData::getAllSellsByFactId($idFact);
    $sVend = FacturaData::getAllServicesByFactId($idFact);
    
    $totalRegistros = count($pVend) + count($sVend);
    $totalSumas = $totalSumasSinIva = $descuentoIva = $totalPagar = 0;
    $condicion = "Contado";
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
    
    $totalRegistros = count($pVend) + count($sVend);

    $numeroComprobante = $factura->numerocomprobante;
    $totalSumasP = $factura->cantidad;
    
    $descuentoPIva = $totalSumasP * 0.13;
    $totalSumasPSinIva = $totalSumasP - $descuentoPIva;
    $totalPagarP = $totalSumasPSinIva + $descuentoPIva;
    $condicion = "Crédito";
    $tipo = "abono";
}

$fecha = new DateTime($factura->fecha);
$direccion = utf8_decode($factura->getClient()->direccion);
//Variable que guarda el nombre del archivo PDF
$archivo="ccf-$tipo.pdf";

//Llamada al script fpdf
require('fpdf.php');

$archivoSalida = $archivo;

$pdf=new FPDF('P','mm',array(150,215));  //crea el objeto, se especifica el tamaño de página en milímetros
$pdf->AddPage(0);  //Se agrega una página
$pdf->SetAutoPageBreak(false,0.5);
$pdf->Ln(40);

$pdf->setX(5);
$pdf->SetFont('Arial','',9);
$pdf->Cell(14, 3/*, utf8_decode("Señor")*/);
$pdf->setXY(24,50);
$pdf->MultiCell(58, 4, utf8_decode($factura->getClient()->name));
$pdf->Ln(7);

$pdf->setX(5);
$pdf->Cell(18, 3/*, utf8_decode("Dirección")*/);
$pdf->setXY(24,60);
$pdf->MultiCell(58, 4, $direccion);

$pdf->setX(5);
$pdf->Cell(22, 3/*, "Departamento"*/);
$pdf->setXY(28,72);
$pdf->Cell(58, 4, utf8_decode($factura->getClient()->getDepto()->nombreDepto));

$pdf->setX(5);
$pdf->Cell(15, 3/*, "Giro"*/);
$pdf->setXY(20,78);
$pdf->Cell(58, 4, utf8_decode($factura->getClient()->giro));

$pdf->setXY(85,50);
$pdf->Cell(14, 3/*, utf8_decode("Fecha")*/);
$pdf->Cell(50, 3, utf8_decode($fecha->format("d/m/Y")));

$pdf->setXY(85,56);
$pdf->Cell(14, 3/*, utf8_decode("N.R.C")*/);
$pdf->Cell(50, 3, utf8_decode($factura->getClient()->nrc));

$pdf->setXY(85,61);
$pdf->Cell(14, 3/*, utf8_decode("N.I.T")*/);
$pdf->Cell(50, 3, utf8_decode($factura->getClient()->nit));

$pdf->setXY(85,66);
$pdf->Cell(14, 3/*, utf8_decode("No. Nota de Remisión")*/);
$pdf->Cell(50, 3, utf8_decode(""));

$pdf->setXY(85,71);
$pdf->Cell(14, 3/*, utf8_decode("Fecha Nota de Remisión")*/);
$pdf->Cell(50, 3, utf8_decode(""));

$pdf->setXY(95,78);
$pdf->Cell(14, 3/*, utf8_decode("Condiciones de Pago")*/);
$pdf->Cell(50, 3, utf8_decode($condicion));

$pdf->setXY(85,81);
$pdf->Cell(14, 3/*, utf8_decode("Venta a Cuenta de")*/);
$pdf->Cell(50, 3, utf8_decode(""));

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

$y = 95;
$cant = 0;
foreach($pVend as $vend){
    $cant++;
    $prod = $vend->getProduct();
    $precioSinIva = $vend->precio - ($vend->precio * 0.13);
    $totalSinIva = $vend->total - ($vend->total * 0.13);
    $pdf->setXY(14,$y);

    if(!$abono){
        $pdf->Cell(10,5.5,$vend->cantidad);
    }else{
        $pdf->Cell(10,5.5,"");
    }
    $pdf->setXY(25,$y);
    
    if(!$abono){
        $pdf->MultiCell(57,5.5,utf8_decode($prod->nombre));
    }else{
        $pdf->MultiCell(57,5.5,"$vend->cantidad $prod->nombre(s)");
    }
    $pdf->setXY(86,$y);
    
    if(!$abono){
        $pdf->Cell(17,6.2,"$".number_format($precioSinIva,2,".",","));
    }else{
        $pdf->Cell(17,6.2,"");
    }
    
    $pdf->Cell(11,5.5,"");
    $pdf->Cell(7,5.5,"");
    
    if(!$abono){
        $pdf->Cell(18,5.5,"$".number_format($totalSinIva,2,".",","));
    }else{
        if($cant == $totalRegistros){
            $pdf->Cell(18,5.5,"$".number_format($totalSumasPSinIva,2,".",","));
        }
    }

    $y += 6;
    $totalSumas += $vend->total;
    $totalSumasSinIva += $totalSinIva;
}

foreach($sVend as $vend){
    $cant++;
    $serv = $vend->getService();
    $precioSinIva = $vend->precio - ($vend->precio * 0.13);
    $totalSinIva = $vend->total - ($vend->total * 0.13);
    $pdf->setXY(14,$y);

    if(!$abono){
        $pdf->Cell(10,5.5,$vend->cantidad);
    }else{
        $pdf->Cell(10,5.5,"");
    }
    $pdf->setXY(25,$y);
    if(!$abono){
        $pdf->MultiCell(57,5.5,$serv->nombre);
    }else{
        $pdf->MultiCell(57,5.5,"$vend->cantidad $serv->nombre(s)");
    }
    $pdf->setXY(86,$y);
    
    if(!$abono){
        $pdf->Cell(17,5.5,"$".number_format($precioSinIva,2,".",","));
    }else{
        $pdf->Cell(17,5.5,"");
    }

    $pdf->Cell(11,5.5,"");
    $pdf->Cell(7,5.5,"");
    
    if(!$abono){
        $pdf->Cell(18,5.5,"$".number_format($totalSinIva,2,".",","));
    }else{
        if($cant == $totalRegistros){
            $pdf->Cell(18,5.5,"$".number_format($totalSumasPSinIva,2,".",","));
        }
    }

    $y += 6;

    $totalSumas += $vend->total;
    $totalSumasSinIva += $totalSinIva;
}

$descuentoIva = 0.13 * $totalSumas;
$totalPagar = $descuentoIva + $totalSumasSinIva;

for ($i = $totalRegistros; $i <= 12; $i++){
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

$y -= 6;

$pdf->setXY(5,$y);
$pdf->Cell(10,8,""/*,"SON"*/);
$pdf->setXY(15,$y);
$pdf->MultiCell(57,5,utf8_decode($factura->totalLetras));

$pdf->setXY(72,$y);
$pdf->MultiCell(34,5,""/*"Sumas"*/);
$pdf->setXY(72,$y+5.5);
$pdf->MultiCell(51,5,""/*"13% de IVA"*/);
$pdf->setXY(106,$y);
$pdf->MultiCell(17,5,""); #Espacio en blanco solamente
$pdf->setXY(121,$y);
if(!$abono){
    $pdf->MultiCell(18,5,"$".number_format($totalSumasSinIva,2,".",",")); #Aquí debe ir el valor de las sumas
}else{
    $pdf->MultiCell(18,5,"$".number_format($totalSumasPSinIva,2,".",",")); #Aquí debe ir el valor de las sumas
}
$pdf->setXY(121,$y+5.5);
if(!$abono){
    $pdf->MultiCell(18,5,"$".number_format($descuentoIva,2,".",",")); #Valor del iva retenido
}else{
    $pdf->MultiCell(18,5,"$".number_format($descuentoPIva,2,".",",")); #Valor del iva retenido
}

$y += 11;
$pdf->setXY(5,$y);
$pdf->Cell(67,12,"");
$pdf->setXY(72,$y);
$pdf->MultiCell(51,5,""/*"Sub-Total"*/);
$pdf->setXY(72,$y+5.5);
$pdf->MultiCell(51,5,""/*"Iva Retenido"*/);
$pdf->setXY(72,$y+11);
$pdf->MultiCell(51,5,""/*"Ventas no Sujetas"*/);
$pdf->setXY(72,$y+16.5);
$pdf->MultiCell(51,5,""/*"Ventas Extentas"*/);
$pdf->setXY(72,$y+22);
$pdf->MultiCell(51,5,""/*"Total"*/);

$pdf->setXY(121,$y);
if(!$abono){
    $pdf->MultiCell(18,5,"$".number_format($totalPagar,2,".",",")); #Subtotal
}else{
    $pdf->MultiCell(18,5,"$".number_format($totalPagarP,2,".",",")); #Subtotal
}
$pdf->setXY(121,$y+5.5);
$pdf->MultiCell(18,5,""); #Iva retenido
$pdf->setXY(123,$y+11);
$pdf->MultiCell(18,5,""); #Ventas no sujetas
$pdf->setXY(123,$y+16.5);
$pdf->MultiCell(18,5,""); #Ventas extentas
$pdf->setXY(121,$y+22);
if(!$abono){
    $pdf->MultiCell(18,5,"$".number_format($totalPagar,2,".",",")); #Total
}else{
    $pdf->MultiCell(18,5,"$".number_format($totalPagarP,2,".",",")); #Total
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