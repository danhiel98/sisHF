<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/PedidoData.php";
include "../core/modules/sistema/model/ClientData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/ProductData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';


    $pedido = PedidoData::getById($_GET["id"]);
    $prodP = PedidoData::getAllProductsByPedidoId($_GET["id"]);
    $servP = PedidoData::getAllServicesByPedidoId($_GET["id"]);

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Detalle De Pedido "'.$hora." ".".xlsx");


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Detalle Pedido")
               ->setSubject("Traspasos activos")
               ->setDescription("Reporte de los Traspasos a los que se hacen envíos de dinero.")
               ->setKeywords("excel php reporte Traspasos")
               ->setCategory("Pedidos");

$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                                          ->setSize(10);
$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('rgb' => '#0A0909'),
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
$sheet->setCellValueByColumnAndRow(0, 1, "test");
$sheet->mergeCells('A1:E1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:E1','A7B6F8');
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:E1')
            ->setCellValue('A1', 'PEDIDOS REGISTRADOS')
            ->setCellValue('A3', 'Fecha De Pedido')
            ->setCellValue('A4', 'Fecha De Entrega')
            ->setCellValue('A5', 'Estado')
            ->setCellValue('A6', 'Cliente')
            ->setCellValue('A7', 'Atendido Por');

$objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue("B3", $pedido->fechapedido)
              ->setCellValue("B4", $pedido->fechaentrega)
              ->setCellValue("B5", $pedido->entregado)
              ->setCellValue("B6", $pedido->getClient()->name." ".$pedido->getClient()->lastname)
              ->setCellValue("B7", $pedido->getUser()->name." ".$pedido->getUser()->lastname);

cellColor('A8:E8','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A8'.':E8')->applyFromArray($borders);
//$objPHPExcel->getActiveSheet()->getStyle('A2'.':D2')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A8', 'Codigo')
            ->setCellValue('B8', 'Cantidad')
            ->setCellValue('C8', 'Nombre P/S')
            ->setCellValue('D8', 'Precio')
            ->setCellValue('E8', 'Total');
$i = 9;
$total_total =0;
foreach ($prodP as $pt) {
  
  $total =0;
  $prod = $pt->getProduct();
  $total += $pt->cantidad * $prod->precioventa;
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue("A$i", $pt->idpedidoproducto)
              ->setCellValue("B$i", $pt->cantidad)
              ->setCellValue("C$i", $pt->getProduct()->nombre)
              ->setCellValue("D$i","$ ". $pt->getProduct()->precioventa)
              ->setCellValue("E$i","$ ". $total);
  
  $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->applyFromArray($borders);
  $i++;
  $total_total+= $total;
  $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue("A$i", "Total")
                            ->setCellValue("B$i","$ ". $total_total);
  }
                

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Traspasos');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
