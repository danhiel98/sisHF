<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/EmpleadoData.php";
include "../core/modules/sistema/model/SucursalData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Todos los empleados"'.$hora." ".".xlsx");


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Todos Empleados")
               ->setSubject("Empleados activos")
               ->setDescription("Reporte de los Empleados.")
               ->setKeywords("excel php reporte Empleados")
               ->setCategory("Empleados");

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
$sheet->mergeCells('A1:H1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:H1','A7B6F8');
cellColor('A3:H3','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:H1')
            ->setCellValue('A1', 'EMPLEADOS REGISTRADOS')
            ->setCellValue('A3', 'DUI')
            ->setCellValue('B3', 'NIT')
            ->setCellValue('C3', 'Nombre')
            ->setCellValue('D3', 'Apellido')
            ->setCellValue('E3', 'Sexo')
            ->setCellValue('F3', 'Teléfono')
            ->setCellValue('G3', 'Área')
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
    $obj = $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i);
    $obj->getAlignment()->setWrapText(true);
    $obj->applyFromArray($borders);
  	$i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('9');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('20');

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Empleados');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
