<?php 
require_once 'functions/excel.php';

activeErrorReporting();
noCli();

require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'functions/conexion.php';
require_once 'functions/obtenerlistaclientes.php';

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

cellColor('B1:H1','A7B6F8');
$objPHPExcel->getActiveSheet()->getStyle('B1:H1')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('B1:H1')
            ->setCellValue('B1', 'TABLA DE CLIENTES')
            ->setCellValue('B2', 'DUI')
            ->setCellValue('C2', 'NIT')
            ->setCellValue('D2', 'NCR')
            ->setCellValue('E2', 'APELLIDO')
            ->setCellValue('F2', 'NOMBRE')
            ->setCellValue('G2', 'SEXO')
            ->setCellValue('H2', 'CORREO ELECTRONICO');

$informe = obtenerlistaclientes();
$i = 3;
while($row = $informe->fetch_array(MYSQLI_ASSOC))
{
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("B$i", $row['dui'])
            ->setCellValue("C$i", $row['nit'])
            ->setCellValue("D$i", $row['nrc'])
            ->setCellValue("E$i", $row['nombre'])
            ->setCellValue("F$i", $row['apellido'])
            ->setCellValue("G$i", $row['sexo'])
            ->setCellValue("H$i", $row['email']);
cellColor('B'.$i.':H'.$i, 'E0FCFD');
$i++;

}

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