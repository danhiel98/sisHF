<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/ClientData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/ProductData.php";
include "../core/modules/sistema/model/DevolucionData.php";
include "../core/modules/sistema/model/CausaDevolucionData.php";
include "../core/modules/sistema/model/FacturaData.php";
include "../core/modules/sistema/model/ComprobanteData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

    $id = $_GET["id"];
    $dev = DevolucionData::getById($id);
    $devProds = DevolucionData::getProdsByDev($_GET["id"]);
    
// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Detalle De Devolucion "'.$hora." ".".xlsx");


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
        ->setLastModifiedBy("Administrador")
        ->setTitle("Detalle Devolución")
        ->setSubject("Traspasos activos")
        ->setDescription("Reporte de Devolución.")
        ->setKeywords("excel php reporte devolucion")
        ->setCategory("Devolución");

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
$sheet->mergeCells('A1:C1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:C1','A7B6F8');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:C1')
    ->setCellValue('A1', 'DETALLE DE DEVOLUCÓN')
    ->setCellValue('A3', 'Tipo de Comprobante')
    ->setCellValue('A4', 'No. Comprobante')
    ->setCellValue('A5', 'Cliente')
    ->setCellValue('A6', 'Causa')
    ->setCellValue('A7', 'Fecha')
    ->setCellValue('A8', 'Reembolso');


$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("B3", $dev->getFactura()->getComprobante()->nombre)
    ->setCellValue("B4", $dev->getFactura()->numerofactura)
    ->setCellValue("B5", $dev->getFactura()->getClient()->name)
    ->setCellValue("B6", $dev->getCausa()->descripcion)
    ->setCellValue("B7", $dev->fecha)
    ->setCellValue("B8", number_format($dev->reembolso,2,".",","));

cellColor('A10:C10','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A10:C10')->applyFromArray($borders);
//$objPHPExcel->getActiveSheet()->getStyle('A2'.':D2')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A10', 'Producto')
    ->setCellValue('B10', 'Precio')
    ->setCellValue('C10', 'Cantidad');
    
$i = 11;
$total_total = 0;
foreach ($devProds as $prd) {
  
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $prd->getProduct()->nombre)
            ->setCellValue("B$i", $prd->precio)
            ->setCellValue("C$i", $prd->cantidad);
    
    $sheet = $objPHPExcel->getActiveSheet();
    $sheet->getStyle('A'.$i.':C'.$i)->applyFromArray($borders);
    $sheet->getStyle("B$i")->getNumberFormat()->setFormatCode("$#,##0.00;-$#,##0.00");
    
    $i++;
}


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Devolucions');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
