<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/ProductData.php";
include "../core/modules/sistema/model/CategoryData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Productos "'.$hora." ".".xlsx");


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Productos")
               ->setSubject("Productos activos")
               ->setDescription("Reporte de los Productos")
               ->setKeywords("excel php reporte Productos")
               ->setCategory("Productos");

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
$sheet->mergeCells('A1:F1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:F1','A7B6F8');
cellColor('A3:F3','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:F1')
            ->setCellValue('A1', 'PRODUCTOS REGISTRADOS')
            ->setCellValue('A3', 'Nombre')
            ->setCellValue('B3', 'Descripción')
            ->setCellValue('C3', 'Categoría')
            ->setCellValue('D3', 'Precio Entrada')
            ->setCellValue('E3', 'Precio Salida')
            ->setCellValue('F3', 'Req. Mantenimiento');

$productos = ProductData::getAll();
$i = 4;
foreach ($productos as $produc) {
    $mantto = "No";
    if ($produc->mantenimiento == 1){
        $mantto = "Sí";
    }
	$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A$i", $produc->nombre)
        ->setCellValue("B$i", $produc->descripcion)
        ->setCellValue("C$i", $produc->getCategory()->nombre)
        ->setCellValue("D$i", $produc->preciocosteo)
        ->setCellValue("E$i", $produc->precioventa)
        ->setCellValue("F$i", $mantto);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A'.$i.':F'.$i)->applyFromArray($borders);
        $sheet->getStyle("D$i:E$i")->getNumberFormat()->setFormatCode("$#,##0.00;-$#,##0.00");
	$i++;
}

$sheet = $objPHPExcel->getActiveSheet();
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);

$sheet->setTitle('Reporte de Productos');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
