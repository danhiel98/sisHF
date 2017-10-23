<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/ServiceData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Servicios")
               ->setSubject("Servicios activos")
               ->setDescription("Reporte de los Servicios.")
               ->setKeywords("excel php reporte Servicios")
               ->setCategory("Servicios");

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
            ->mergeCells('A1:C1')
            ->setCellValue('A1', 'SERVICIOS REGISTRADOS')
            ->setCellValue('A3', 'Nombre')
            ->setCellValue('B3', 'Descripciòn')
            ->setCellValue('C3', 'Precio');

$servicios = ServiceData::getAll();
$i = 4;
foreach ($servicios as $srvi) {
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("A$i", $srvi->nombre)
							->setCellValue("B$i", $srvi->descripcion)
							->setCellValue("C$i","$ ". $srvi->precio);
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
