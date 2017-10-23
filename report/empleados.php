<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/EmpleadoData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/SucursalData.php";
require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

$emple = UserData::getAll();
$empleado = array();
foreach ($emple as $emp) {
  if ($emp->getEmpleado()->idsucursal == $_GET["idEmple"]) {
    array_push($empleado, $emp);
  }
}

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

$i = 4;
foreach ($empleado as $xdempleado) {
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("A$i", $xdempleado->getEmpleado()->dui)
							->setCellValue("B$i", $xdempleado->getEmpleado()->nit)
							->setCellValue("C$i", $xdempleado->getEmpleado()->nombre)
							->setCellValue("D$i", $xdempleado->getEmpleado()->apellido)
              ->setCellValue("E$i", $xdempleado->getEmpleado()->sexo)
              ->setCellValue("F$i", $xdempleado->getEmpleado()->telefono)
              ->setCellValue("G$i", $xdempleado->getEmpleado()->area)
              ->setCellValue("H$i", $xdempleado->getEmpleado()->getSucursal()->nombre);
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
