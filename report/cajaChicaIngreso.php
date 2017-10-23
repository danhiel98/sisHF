<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/EmpleadoData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/SucursalData.php";
include "../core/modules/sistema/model/CajaChicaData.php";
require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Developero")
               ->setLastModifiedBy("Maarten Balliauw")
               ->setTitle("Office 2007 XLSX Test Document")
               ->setSubject("Office 2007 XLS Test Document")
               ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
               ->setKeywords("office 2007 openxml php")
               ->setCategory("Test result file");

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
            ->mergeCells('A1:C1')
            ->setCellValue('A1', 'Detalle De Entrada De Dinero En Caja Chica')
            ->setCellValue('A3', 'Nº')
            ->setCellValue('B3', 'Ingresado por')
            ->setCellValue('C3', 'Cantidad')
            ->setCellValue('D3', 'Fecha');

$ingre = CajaChicaData::getIngresos();
$i = 4;
foreach ($ingre as $ch) {
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue("A$i", $ch->id)
              ->setCellValue("B$i", $ch->getUsuario()->name ." ". $ch->getUsuario()->lastname)
              ->setCellValue("C$i", $ch->cantidad)
              ->setCellValue("D$i", $ch->fecha);
  cellColor('A'.$i.':D'.$i, 'E0FCFD');
  $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($borders);
  $i++;
}


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Ing. Caja Ch.');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
