<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/ClientData.php";
include "../core/modules/sistema/model/DireccionData.php";

date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');
header('Content-Disposition: attachment;filename="Clientes "'.$hora." ".".xlsx");

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Clientes")
               ->setSubject("Clientes activos")
               ->setDescription("Reporte de los Clientes")
               ->setKeywords("excel php reporte Clientes")
               ->setCategory("Clientes");

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
$sheet->setCellValueByColumnAndRow(0, 1, "test");
$sheet->mergeCells('A1:G1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:G1','A7B6F8');
cellColor('A3:G3','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:G1')
        ->setCellValue('A1', 'CLIENTES REGISTRADOS')
        ->setCellValue('A3', 'DUI')
        ->setCellValue('B3', 'NIT')
        ->setCellValue('C3', 'NRC')
        ->setCellValue('D3', 'Nombres')
        ->setCellValue('E3', 'Departamento')
        ->setCellValue('F3', 'Correo Electrónico')
        ->setCellValue('G3', 'Teléfono');

$clientes = ClientData::getAll();
$i = 4;
foreach ($clientes as $client) {
	$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A$i", $client->dui)
        ->setCellValue("B$i", $client->nit)
        ->setCellValue("C$i", $client->nrc)
        ->setCellValue("D$i", $client->name)
        ->setCellValue("E$i", $client->getDepto()->nombreDepto)
        ->setCellValue("F$i", $client->email)
        ->setCellValue("G$i", $client->phone);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->applyFromArray($borders);
	$i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Clientes');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
