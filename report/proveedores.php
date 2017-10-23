<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/ProviderData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Proveedores")
               ->setSubject("Proveedores activos")
               ->setDescription("Reporte de los Proveedores")
               ->setKeywords("excel php reporte Proveedores")
               ->setCategory("Proveedores");

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
$objPHPExcel->getActiveSheet()->getStyle('A1'.':E1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':E3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:D1')
            ->setCellValue('A1', 'PROVEEDORES REGISTRADOS')
            ->setCellValue('A3', 'Nombre')
            ->setCellValue('B3', 'Provee')
            ->setCellValue('C3', 'Direciòn')
            ->setCellValue('D3', 'Telèfono')
            ->setCellValue('E3', 'Correo Electronico');

$Proveedores = ProviderData::getAll();
$i = 4;
foreach ($Proveedores as $provider) {
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("A$i", $provider->nombre)
							->setCellValue("B$i", $provider->tipoprovee)
							->setCellValue("C$i", $provider->direccion)
							->setCellValue("D$i", $provider->telefono)
              ->setCellValue("E$i", $provider->correo);
	cellColor('A'.$i.':E'.$i, 'E0FCFD');
 $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->applyFromArray($borders);
	$i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Proveedores');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
