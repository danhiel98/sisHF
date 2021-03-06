<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/MateriaPrimaData.php";
include "../core/modules/sistema/model/FacturaData.php";
include "../core/modules/sistema/model/ProviderData.php";
include "../core/modules/sistema/model/ReabastecimientoData.php";
include "../core/modules/sistema/model/ReabastecimientoMPData.php";




require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Materia Prima "'.$hora." ".".xlsx");


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Materia Prima")
               ->setSubject("Materia Prima activos")
               ->setDescription("Reporte de los Materia Prima")
               ->setKeywords("excel php reporte Materia Prima")
               ->setCategory("Materia Prima");

$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                                          ->setSize(10);
$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
    );

$sheet = $objPHPExcel->getActiveSheet();
$sheet->setCellValueByColumnAndRow(0, 1, "test");
$sheet->mergeCells('A1:D1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
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
cellColor('A3:D3','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A1'.':D1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':D3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:D1')
            ->setCellValue('A1', 'COMPRAS DE MATERIA PRIMA')
            ->setCellValue('A3', 'Nª Factura')
            ->setCellValue('B3', 'Proveedor')
            ->setCellValue('C3', 'Fecha')
            ->setCellValue('D3', 'Total');

          $i = 4;
$materias = ReabastecimientoData::getAll();
if(count($materias)>0){
  foreach($materias as $re){
          $total = 0;
          $reabT = ReabastecimientoMPData::getAllByReabId($re->id);
          foreach($reabT as $rb){
              $total += $rb->total;
            }
          	$objPHPExcel->setActiveSheetIndex(0)
          							->setCellValue("A$i", $re->comprobante)
          							->setCellValue("B$i", $re->getProvider()->nombre)
          							->setCellValue("C$i", $re->fecha)
                        ->setCellValue("D$i", $re->total);
          	
           $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($borders);
          	$i++;
    }
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Materia Prima');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
