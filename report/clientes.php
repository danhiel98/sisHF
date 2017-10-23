<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/ClientData.php";

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
          'color' => array('rgb' => 'red'),
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

cellColor('A1:H1','A7B6F8');
cellColor('A3:H3','27D3E1');
$objPHPExcel->getActiveSheet()->getStyle('A1'.':H1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':H3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:H1')
            ->setCellValue('A1', 'CLIENTES REGISTRADOS')
            ->setCellValue('A3', 'DUI')
            ->setCellValue('B3', 'NIT')
            ->setCellValue('C3', 'NRC')
            ->setCellValue('D3', 'Nombres')
            ->setCellValue('E3', 'Apellidos')
            ->setCellValue('F3', 'Sexo')
            ->setCellValue('G3', 'Correo Electronico')
            ->setCellValue('H3', 'Telèfono');

$clientes = ClientData::getAll();
$i = 4;
foreach ($clientes as $client) {
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("A$i", $client->dui)
							->setCellValue("B$i", $client->nit)
							->setCellValue("C$i", $client->nrc)
							->setCellValue("D$i", $client->name)
              ->setCellValue("E$i", $client->lastname)
              ->setCellValue("F$i", $client->sexo)
              ->setCellValue("G$i", $client->email)
              ->setCellValue("H$i", $client->phone);
	cellColor('A'.$i.':H'.$i, 'E0FCFD');
 $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->applyFromArray($borders);
	$i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Clientes');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
