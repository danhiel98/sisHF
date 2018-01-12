<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/ServiceData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Servicios "'.$hora." ".".xlsx");


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
$sheet->mergeCells('A1:C1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:C1','A7B6F8');
cellColor('A3:C3','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A1'.':C1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':C3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:C1')
            ->setCellValue('A1', 'SERVICIOS REGISTRADOS')
            ->setCellValue('A3', 'Nombre')
            ->setCellValue('B3', 'Descripción')
            ->setCellValue('C3', 'Precio');

$servicios = ServiceData::getAll();
$i = 4;
$cant = count($servicios);
$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':C'.(--$cant+$i))->applyFromArray($borders);

foreach ($servicios as $srvi) {
	$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A$i", $srvi->nombre)
        ->setCellValue("B$i", $srvi->descripcion)
        ->setCellValue("C$i", $srvi->precio);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle("A$i:C$i")->getAlignment()->setWrapText(true);
        $sheet->getStyle("C$i")->getNumberFormat()->setFormatCode("$#,##0.00;-$#,##0.00");
	$i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Servicios');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
