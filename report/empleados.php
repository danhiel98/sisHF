<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/EmpleadoData.php";
include "../core/modules/sistema/model/SucursalData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

$idSuc = $_REQUEST["idEmple"];
$empleados = EmpleadoData::getAllBySucId($idSuc);
$sucursal = SucursalData::getById($idSuc);

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Empleados de "'.$sucursal->nombre." ".$hora." ".".xlsx");

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("HierroForjado")
               ->setTitle("Excel Document")
               ->setSubject("Excel Document")
               ->setDescription("Excel Documents")
               ->setKeywords("office 2007 openxml php")
               ->setCategory("Test result file");

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
$sheet->mergeCells('A1:G1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:G1','A7B6F8');
cellColor('A3:G3','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:G1')
            ->setCellValue('A1', 'EMPLEADOS REGISTRADOS [Sucursal: '.$sucursal->nombre.']')
            ->setCellValue('A3', 'DUI')
            ->setCellValue('B3', 'NIT')
            ->setCellValue('C3', 'Nombre')
            ->setCellValue('D3', 'Apellido')
            ->setCellValue('E3', 'Sexo')
            ->setCellValue('F3', 'Teléfono')
            ->setCellValue('G3', 'Área');
			

$i = 4;
foreach ($empleados as $emp) {
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A$i", $emp->dui)
			->setCellValue("B$i", $emp->nit)
			->setCellValue("C$i", $emp->nombre)
			->setCellValue("D$i", $emp->apellido)
			->setCellValue("E$i", $emp->sexo)
			->setCellValue("F$i", $emp->telefono)
			->setCellValue("G$i", $emp->area);

   	$obj = $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i);
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

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Empleados');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;