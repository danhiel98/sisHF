<?php 
require_once 'functions/excel.php';

activeErrorReporting();
noCli();

require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'functions/conexion.php';
require_once 'functions/getAllListsAndVideos.php';

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Developero")
               ->setLastModifiedBy("Maarten Balliauw")
               ->setTitle("Office 2007 XLSX Test Document")
               ->setSubject("Office 2007 XLSX Test Document")
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

$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:D1')
            ->setCellValue('A1', 'TABLA DE EMPLEADOS')
            ->setCellValue('A2', 'DUI')
            ->setCellValue('B2', 'NIT')
            ->setCellValue('C2', 'NOMBRE')
            ->setCellValue('D2', 'APELLIDO')
            ->setCellValue('E2', 'SEXO')
            ->setCellValue('F2', 'AREA')
            ->setCellValue('G2', 'TELEFONO')
            ->setCellValue('H2', 'SUCURSAL');

$informe = getAllListsAndVideos();
$i = 3;
while($row = $informe->fetch_array(MYSQLI_ASSOC))
{
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $row['dui'])
            ->setCellValue("B$i", $row['nit'])
            ->setCellValue("C$i", $row['nombreE'])
            ->setCellValue("D$i", $row['apellido'])
            ->setCellValue("E$i", $row['sexo'])
            ->setCellValue("F$i", $row['area'])
            ->setCellValue("G$i", $row['telefono'])
            ->setCellValue("H$i", $row['nombreS']);
cellColor('A'.$i.':H'.$i, 'E0FCFD');
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
$objPHPExcel->getActiveSheet()->setTitle('Informe de Empleados');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;