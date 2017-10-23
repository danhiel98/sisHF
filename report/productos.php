<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/ProductData.php";
include "../core/modules/sistema/model/CategoryData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

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

cellColor('A1:F1','A7B6F8');
cellColor('A3:F3','27D3E1');
$objPHPExcel->getActiveSheet()->getStyle('A1'.':F1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':F3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:F1')
            ->setCellValue('A1', 'PRODUCTOS REGISTRADOS')
            ->setCellValue('A3', 'Nombre')
            ->setCellValue('B3', 'Descripciòn')
            ->setCellValue('C3', 'Categoria')
            ->setCellValue('D3', 'Precio Entrada')
            ->setCellValue('E3', 'Precio Salida')
            ->setCellValue('F3', 'Total Existencias');

$productos = ProductData::getAll();
$i = 4;
foreach ($productos as $produc) {
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("A$i", $produc->nombre)
							->setCellValue("B$i", $produc->descripcion)
							->setCellValue("C$i", $produc->getCategory()->nombre)
              ->setCellValue("D$i","$ ". $produc->preciocosteo)
              ->setCellValue("E$i","$ ". $produc->precioventa)
              ->setCellValue("F$i", $produc->existencias);
	cellColor('A'.$i.':F'.$i, 'E0FCFD');
 $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($borders);
	$i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Productos');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
