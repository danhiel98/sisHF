<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/CajaChicaData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/EmpleadoData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Entrada De Dinero CH"'.$hora." ".".xlsx");


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Caja Chica")
               ->setSubject("Servicios activos")
               ->setDescription("Reporte de Caja Chica.")
               ->setKeywords("excel php reporte Caja Chica")
               ->setCategory("Caja Chica");

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

cellColor('A1:C1','A7B6F8');
cellColor('A3:C3','27D3E1');
$objPHPExcel->getActiveSheet()->getStyle('A1'.':C1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':C3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:D1')
            ->setCellValue('A1', 'CAJA CHICA')
            ->setCellValue('A3', 'Ingresado Por')
            ->setCellValue('B3', 'Cantidad')
            ->setCellValue('C3', 'Fecha');

$cajachica = CajaChicaData::getAll();
$i = 4;
foreach ($cajachica as $caj) {
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("A$i", $caj->getEncargado()->nombre)
							->setCellValue("B$i", $caj->cantidad)
							->setCellValue("C$i", $caj->fecha);
	cellColor('A'.$i.':C'.$i, 'E0FCFD');
 $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':C'.$i)->applyFromArray($borders);
	$i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Servicios');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
