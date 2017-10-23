<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/BancoData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de bancos")
               ->setSubject("Bancos activos")
               ->setDescription("Reporte de los bancos a los que se hacen envíos de dinero.")
               ->setKeywords("excel php reporte bancos")
               ->setCategory("Bancos");

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

cellColor('A1:D1','A7B6F8');
cellColor('A3:D3','27D3E1');
$objPHPExcel->getActiveSheet()->getStyle('A1'.':D1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':D3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:D1')
            ->setCellValue('A1', 'BANCOS REGISTRADOS')
            ->setCellValue('A3', 'Nº')
            ->setCellValue('B3', 'Nombre')
            ->setCellValue('C3', 'Direcciòn')
            ->setCellValue('D3', 'Telèfono');

$bancos = BancoData::getAll();
$i = 4;
foreach ($bancos as $banc) {
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("A$i", $banc->id)
							->setCellValue("B$i", $banc->nombre)
							->setCellValue("C$i", $banc->direccion)
							->setCellValue("D$i", $banc->telefono);
	cellColor('A'.$i.':D'.$i, 'E0FCFD');
 $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($borders);
	$i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Bancos');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
