<?php 
require_once 'functions/excel.php';

activeErrorReporting();
noCli();

require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'functions/conexion.php';
require_once 'functions/obtenerlistasucursal.php';

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

cellColor('A1:D1','A7B6F8');
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:D1')
            ->setCellValue('A1', 'TABLA DE EMPLEADOS')
            ->setCellValue('A2', 'Nº  ')
            ->setCellValue('B2', 'NOMBRE')
            ->setCellValue('C2', 'DIRECCION')
            ->setCellValue('D2', 'TELEFONO');

$informe = obtenerlistasucursal();
$i = 3;
while($row = $informe->fetch_array(MYSQLI_ASSOC))
{
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $row['idSucursal'])
            ->setCellValue("B$i", $row['nombre'])
            ->setCellValue("C$i", $row['direccion'])
            ->setCellValue("D$i", $row['telefono']);
cellColor('A'.$i.':D'.$i, 'E0FCFD');
$i++;

}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Informe de Empleados');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;