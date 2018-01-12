<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/TraspasoData.php";
include "../core/modules/sistema/model/SucursalData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/EmpleadoData.php";
include "../core/modules/sistema/model/ProductData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

//$traspasode = TraspasoData::getAllProductsByTraspasoId($_GET["id"]);
$traspasoDatos = TraspasoData::getById($_GET["id"]);

$nombreUsuario = $traspasoDatos->getUser()->fullname;

if (!is_null($traspasoDatos->getUser()->idempleado)){
  $nombreUsuario = $traspasoDatos->getUser()->getEmpleado()->nombrecompleto;
}

$prodtrasp = TraspasoData::getAllProductsByTraspasoId($_GET["id"]);
/*$tras = TraspasoData::getAllProductsByTraspasoId();
$traspasode = array();
foreach ($tras as $t) {
  if ($t->idtraspasoprod == $_GET["id"]) {
    array_push($traspasode, $trass);
  }
}*/

// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Detalle De Traspaso "'.$hora." ".".xlsx");


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Todos Traspasos")
               ->setSubject("Traspasos activos")
               ->setDescription("Reporte de los Traspasos a los que se hacen envíos de dinero.")
               ->setKeywords("excel php reporte Traspasos")
               ->setCategory("Traspasos");

$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                                          ->setSize(10);
$borders = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('rgb' => '#0A0909'),
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
$sheet->mergeCells('A1:C1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:C1','A7B6F8');
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:C1')
            ->setCellValue('A1', 'TRASPASOS REGISTRADOS')
            ->setCellValue('A3', 'Origen')
            ->setCellValue('A4', 'Destino')
            ->setCellValue('A5', 'Fecha')
            ->setCellValue('A6', 'Realizado Por');

$objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue("B3", $traspasoDatos->getSucursalO()->nombre)
              ->setCellValue("B4", $traspasoDatos->getSucursalD()->nombre)
              ->setCellValue("B5", $traspasoDatos->fecha)
              ->setCellValue("B6", $nombreUsuario);

cellColor('A8:C8','E2DFDF');
$objPHPExcel->getActiveSheet()->getStyle('A8'.':C8')->applyFromArray($borders);
//$objPHPExcel->getActiveSheet()->getStyle('A2'.':D2')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A8', 'Producto')
            ->setCellValue('B8', 'Descripcion')
            ->setCellValue('C8', 'Cantidad');
$i = 9;
foreach ($prodtrasp as $pt) {
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue("A$i", $pt->getProduct()->nombre)
              ->setCellValue("B$i", $pt->getProduct()->descripcion)
              ->setCellValue("C$i", $pt->cantidad);
  
  $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':C'.$i)->applyFromArray($borders);
  $i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Traspasos');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
