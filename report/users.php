<?php
include "../core/autoload.php";
#include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/EmpleadoData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/SucursalData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Usuarios")
               ->setSubject("Usuarios activos")
               ->setDescription("Reporte de los usuarios activos.")
               ->setKeywords("excel php reporte usuarios")
               ->setCategory("Usuarios");

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
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':F3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:F1')
            ->setCellValue('A1', 'USUARIOS REGISTRADOS')
            ->setCellValue('A3', 'Nº')
            ->setCellValue('B3', 'Nombres')
            ->setCellValue('C3', 'Aapellidos')
            ->setCellValue('D3', 'Usuario')
            ->setCellValue('E3', 'Correo Electronico')
            ->setCellValue('F3', 'Sucursal');

$users = UserData::getAll();
$i = 4;
foreach ($users as $usr) {
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue("A$i", $usr->id)
              ->setCellValue("B$i", $usr->getEmpleado()->nombre)
              ->setCellValue("C$i", $usr->getEmpleado()->apellido)
              ->setCellValue("D$i", $usr->username)
              ->setCellValue("E$i", $usr->email)
              ->setCellValue("F$i", $usr->getEmpleado()->getSucursal()->nombre);
  cellColor('A'.$i.':F'.$i, 'E0FCFD');
  $i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Usuarios');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
