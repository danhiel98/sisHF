<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/PedidoData.php";
include "../core/modules/sistema/model/AbonoData.php";
include "../core/modules/sistema/model/ClientData.php";
include "../core/modules/sistema/model/ComprobanteData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/ProductData.php";
include "../core/modules/sistema/model/ServiceData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Pagos"'.$hora." ".".xlsx");

$idPedido = $_GET["idPedido"];
$pedido = PedidoData::getById($idPedido);
$prodP = PedidoData::getAllProductsByPedidoId($idPedido);
$servP = PedidoData::getAllServicesByPedidoId($idPedido);
$pagos = AbonoData::getAllByPedidoId($idPedido);

$estadoPedido = "";
if ($pedido->entregado == 1){
    $estadoPedido = "Entregado";
}else{
    $estadoPedido = "Pendiente";
}

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Pagos")
               ->setSubject("Pagos activos")
               ->setDescription("Reporte de los Pagos")
               ->setKeywords("excel php reporte Pagos")
               ->setCategory("Pagos");

$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                                          ->setSize(10);
$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
    );

function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

$sheet = $objPHPExcel->getActiveSheet();
$sheet->mergeCells('A1:E1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:E1','A7B6F8');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:E1')
    ->setCellValue('A1', 'DETALLE DE PEDIDO')
    ->setCellValue('A3', 'Fecha De Pedido')
    ->setCellValue('A4', 'Fecha De Entrega')
    ->setCellValue('A5', 'Estado')
    ->setCellValue('A6', 'Cliente')
    ->setCellValue('A7', 'Atendido Por');

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("B3", $pedido->fechapedido)
    ->setCellValue("B4", $pedido->fechaentrega)
    ->setCellValue("B5", $estadoPedido)
    ->setCellValue("B6", $pedido->getClient()->name)
    ->setCellValue("B7", $pedido->getUser()->name." ".$pedido->getUser()->lastname);

cellColor('A9:E9','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A9:E9')->applyFromArray($borders);
//$objPHPExcel->getActiveSheet()->getStyle('A2'.':D2')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A9', 'Codigo')
    ->setCellValue('B9', 'Cantidad')
    ->setCellValue('C9', 'Producto/Servicio')
    ->setCellValue('D9', 'Precio')
    ->setCellValue('E9', 'Total');
$i = 10;
$total_total = 0;
foreach ($prodP as $prdP) {
  
  $total = 0;
  $prod = $prdP->getProduct();
  $total += $prdP->cantidad * $prod->precioventa;
  $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A$i", $prdP->idpedidoproducto)
        ->setCellValue("B$i", $prdP->cantidad)
        ->setCellValue("C$i", $prod->nombre)
        ->setCellValue("D$i", $prod->precioventa)
        ->setCellValue("E$i", $total);
  
  $sheet = $objPHPExcel->getActiveSheet();
  $sheet->getStyle('A'.$i.':E'.$i)->applyFromArray($borders);
  $sheet->getStyle("D$i:E$i")->getNumberFormat()->setFormatCode("$#,##0.00;-$#,##0.00");
  
  $i++;
  $total_total+= $total;
}

foreach ($servP as $srvP){
    
    $total = 0;
    $serv = $srvP->getService();
    $total += $srvP->cantidad * $serv->precio;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $srvP->idpedidoservicio)
            ->setCellValue("B$i", $srvP->cantidad)
            ->setCellValue("C$i", $serv->nombre)
            ->setCellValue("D$i", $serv->precio)
            ->setCellValue("E$i", $total);
    
    $sheet = $objPHPExcel->getActiveSheet();
    $sheet->getStyle('A'.$i.':E'.$i)->applyFromArray($borders);
    $sheet->getStyle("D$i:E$i")->getNumberFormat()->setFormatCode("$#,##0.00;-$#,##0.00");
    
    $i++;
    $total_total+= $total;
}
    $sheet->mergeCells("A$i:D$i")
        ->setCellValue("A$i", "Total")
        ->setCellValue("E$i", $total_total);
    $sheet->getStyle("E$i")->getNumberFormat()->setFormatCode("$#,##0.00;-$#,##0.00");

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);


$i += 2;
$ii = $i + 2;

$sheet = $objPHPExcel->getActiveSheet();
$sheet->mergeCells("A$i:G$i");
$sheet->getStyle("A$i")->getAlignment()->applyFromArray(
    array("horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor("A$i:G$i","A7B6F8");
cellColor("A$ii:G$ii","E2DFDF");
$objPHPExcel->getActiveSheet()->getStyle("A$i:G$i")->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle("A$ii:G$ii")->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells("A$i:G$i")
            ->setCellValue("A$i", "Pagos Realizados")
            ->setCellValue("A$ii", "No")
            ->setCellValue("B$ii", "Cliente")
            ->setCellValue("C$ii", "Cantidad")
            ->setCellValue("D$ii", "Fecha")
            ->setCellValue("E$ii", "Tipo Comprobante")
            ->setCellValue("F$ii", "No. Comprobante")
            ->setCellValue("G$ii", "Recibido Por");

$i = ++$ii;
$cant = count($pagos);
$num = 0;

$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.(--$cant + $i))->applyFromArray($borders); #XD
foreach ($pagos as $pag) {
    $usuario = $pag->getUser();
    if ($usuario->idempleado == null){
        $usr = $usuario->fullname;
    }else{
        $empleado = $p->getUser()->getEmpleado();
        $usr = $empleado->nombre;
    }
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", ++$num)
            ->setCellValue("B$i", $pag->getClient()->name)
            ->setCellValue("C$i", $pag->cantidad)
            ->setCellValue("D$i", $pag->fecha)
            ->setCellValue("E$i", $pag->getComprobante()->nombre)
            ->setCellValue("F$i", $pag->numerocomprobante)
            ->setCellValue("G$i", $usr);

            $sheet = $objPHPExcel->getActiveSheet();
            $sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode("$#,##0.00;-$#,##0.00");
	$i++;
}


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Pagos');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
