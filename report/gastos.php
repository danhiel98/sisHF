<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/GastoData.php";
include "../core/modules/sistema/model/UserData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Gastos"'.$hora." ".".xlsx");


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Gastos")
               ->setSubject("Gastos activos")
               ->setDescription("Reporte de los Gastos")
               ->setKeywords("excel php reporte Gastos")
               ->setCategory("Gastos");

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
            ->setCellValue('A1', 'GASTOS REGISTRADOS')
            ->setCellValue('A3', 'Descripciòn')
            ->setCellValue('B3', 'Valor')
            ->setCellValue('C3', 'Nº Comprobante')
            ->setCellValue('D3', 'Fecha')
            ->setCellValue('E3', 'Registrado Por');

$gastos = GastoData::getAll();
$i = 4;
$cant = count($gastos);

$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':E'.(--$cant + $i))->applyFromArray($borders); #XD
foreach ($gastos as $gast) {
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("A$i", $gast->descripcion)
							->setCellValue("B$i", $gast->pago)
							->setCellValue("C$i", $gast->comprobante)
							->setCellValue("D$i", $gast->fecha)
                            ->setCellValue("E$i", $gast->getUsuario()->name);
            $sheet = $objPHPExcel->getActiveSheet();
            $sheet->getStyle('B'.$i)->getNumberFormat()->setFormatCode("$#,##0.00;-$#,##0.00");
	$i++;
}


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Envios');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
