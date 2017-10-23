<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/TraspasoData.php";
include "../core/modules/sistema/model/SucursalData.php";
include "../core/modules/sistema/model/UserData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

$tras = TraspasoData::getById();
$traspasode = array();
foreach ($tras as $trass) {
  if ($trass->id == $_GET["id"]) {
    array_push($traspasode, $trass);
  }
}

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Todos Traspasos")
               ->setSubject("Traspasos activos")
               ->setDescription("Reporte de los Traspasos a los que se hacen envíos de dinero.")
               ->setKeywords("excel php reporte Traspasos")
               ->setCategory("Traspasos");

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
$objPHPExcel->getActiveSheet()->getStyle('A1'.':D1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A2'.':D2')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:D1')
            ->setCellValue('A1', 'TRASPASOS REGISTRADOS')
            ->setCellValue('A2', 'Origen')
            ->setCellValue('B2', 'Destino')
            ->setCellValue('C2', 'Fecha')
            ->setCellValue('D2', 'Realizado Por');


$i = 3;
foreach ($traspasode as $tras) {
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue("A$i", $tras->getSucursalO()->nombre)
              ->setCellValue("B$i", $tras->getSucursalD()->nombre)
              ->setCellValue("C$i", $tras->fecha)
              ->setCellValue("D$i", $tras->getUser()->name);
  cellColor('A'.$i.':D'.$i, 'E0FCFD');
  $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($borders);
  $i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Traspasos');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
