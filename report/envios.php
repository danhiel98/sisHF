<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/EnvioData.php";
include "../core/modules/sistema/model/BancoData.php";
include "../core/modules/sistema/model/UserData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Envios"'.$hora." ".".xlsx");


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Envios")
               ->setSubject("Envios activos")
               ->setDescription("Reporte de los Envios")
               ->setKeywords("excel php reporte Envios")
               ->setCategory("Envios");

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
$sheet->mergeCells('A1:E1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:E1','A7B6F8');
cellColor('A3:E3','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A1'.':E1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':E3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:E1')
            ->setCellValue('A1', 'ENVIOS REGISTRADOS')
            ->setCellValue('A3', 'Banco')
            ->setCellValue('B3', 'Cantidad')
            ->setCellValue('C3', 'Nº Comprobante')
            ->setCellValue('D3', 'Fecha')
            ->setCellValue('E3', 'Registrado Por');

$envios = EnvioData::getAll();
$i = 4;
foreach ($envios as $envi) {
	$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A$i", $envi->getBanco()->nombre)
        ->setCellValue("B$i", $envi->cantidad)
        ->setCellValue("C$i", $envi->comprobante)
        ->setCellValue("D$i", $envi->fecha)
        ->setCellValue("E$i", $envi->getUsuario()->name);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A'.$i.':E'.$i)->applyFromArray($borders);
        $sheet->getStyle('B'.$i)->getNumberFormat()->setFormatCode("$#,##0.00;-$#,##0.00");
    
	$i++;
}

$sheet = $objPHPExcel->getActiveSheet();
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);


$sheet->setTitle('Reporte de Envios');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
