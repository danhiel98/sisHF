<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/CategoryData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Categorías "'.$hora.".xlsx");

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Categorías")
               ->setSubject("Categorías Registradas")
               ->setDescription("Reporte de las Categorías")
               ->setKeywords("excel php reporte categorías")
               ->setCategory("Categorías");

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
$sheet->mergeCells('A1:B1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:B1','A7B6F8');
cellColor('A3:B3','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3:B3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:B1')
            ->setCellValue('A1', 'CATEGORÍAS REGISTRADAS')
            ->setCellValue('A3', 'No.')
            ->setCellValue('B3', 'Nombre');

$categorias = CategoryData::getAll();
$i = 4;
$num = 1;
foreach ($categorias as $cat) {
	$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A$i", $num++)
        ->setCellValue("B$i", $cat->nombre);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A'.$i.':B'.$i)->applyFromArray($borders);
	$i++;
}

$sheet = $objPHPExcel->getActiveSheet();
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);

$sheet->setTitle('Reporte de Categorías');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
