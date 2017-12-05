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

date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Caja Chica Ingreso"'.$hora." ".".xlsx");


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Hierro Forjado")
               ->setTitle("Office 2007 XLSX Test Document")
               ->setSubject("Office 2007 XLS Test Document")
               ->setDescription("ingresos a la caja chica.")
               ->setKeywords("office 2007 openxml php")
               ->setCategory("Ingreso Caja Chica");

$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                                          ->setSize(10);
$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('rgb' => '#0A0909'),
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
$sheet->mergeCells('A1:D1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1','A7B6F8');
cellColor('A3:D3','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A1'.':D1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':D3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
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
