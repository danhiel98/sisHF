<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/EmpleadoData.php";
include "../core/modules/sistema/model/SucursalData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Todos Empleados")
               ->setSubject("Empleados activos")
               ->setDescription("Reporte de los Empleados a los que se hacen envíos de dinero.")
               ->setKeywords("excel php reporte Empleados")
               ->setCategory("Empleados");

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

cellColor('A1:H1','A7B6F8');
cellColor('A3:H3','27D3E1');
$objPHPExcel->getActiveSheet()->getStyle('A1'.':H1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':H3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:H1')
            ->setCellValue('A1', 'EMPLEADOS REGISTRADOS')
            ->setCellValue('A3', 'DUI')
            ->setCellValue('B3', 'NIT')
            ->setCellValue('C3', 'Nombre')
            ->setCellValue('D3', 'Apellido')
            ->setCellValue('E3', 'Sexo')
            ->setCellValue('F3', 'Telèfono')
            ->setCellValue('G3', 'Àrea')
            ->setCellValue('H3', 'Sucursal');

$empleadoxd = EmpleadoData::getAll();
$i = 4;
foreach ($empleadoxd as $empledosall) {
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue("A$i", $empledosall->dui)
              ->setCellValue("B$i", $empledosall->nit)
              ->setCellValue("C$i", $empledosall->nombre)
              ->setCellValue("D$i", $empledosall->apellido)
              ->setCellValue("E$i", $empledosall->sexo)
              ->setCellValue("F$i", $empledosall->telefono)
              ->setCellValue("G$i", $empledosall->area)
              ->setCellValue("H$i", $empledosall->getSucursal()->nombre);
  cellColor('A'.$i.':H'.$i, 'E0FCFD');
  $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->applyFromArray($borders);
  $i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Empleados');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
