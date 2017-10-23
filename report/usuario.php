<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/EmpleadoData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/SucursalData.php";
require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

$usuarios = UserData::getAll();
$users = array();
foreach ($usuarios as $usr) {
  if ($usr->getEmpleado()->idsucursal == $_GET["idSuc"]) {
    array_push($users, $usr);
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

cellColor('A1:E1','A7B6F8');
cellColor('A3:E3','27D3E1');
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':E3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:E1')
            ->setCellValue('A1', 'USUARIOS REGISTRADOS')
            ->setCellValue('A3', 'Nombre')
            ->setCellValue('B3', 'Apellido')
            ->setCellValue('C3', 'Usuario')
            ->setCellValue('D3', 'Correo Electronico')
            ->setCellValue('E3', 'Sucursal');

$i = 4;
foreach ($users as $xdusuario) {
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("A$i", $xdusuario->getEmpleado()->nombre)
							->setCellValue("B$i", $xdusuario->getEmpleado()->apellido)
							->setCellValue("C$i", $xdusuario->username)
							->setCellValue("D$i", $xdusuario->email)
              ->setCellValue("E$i", $xdusuario->getEmpleado()->getSucursal()->nombre);
	cellColor('A'.$i.':E'.$i, 'E0FCFD');
  $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->applyFromArray($borders);
	$i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Usuarios');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
