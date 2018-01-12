<?php
include "../core/autoload.php";
  include ("../core/modules/sistema/model/UserData.php");
  include ("../core/modules/sistema/model/ClientData.php");
  include ("../core/modules/sistema/model/ProductData.php");
  include ("../core/modules/sistema/model/FacturaData.php");


date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';
header('Content-Disposition: attachment;filename="Busqueda De Ventas"'.$hora.".xlsx");
/*
  $desde = "2017-11-09";
  $hasta = "2017-12-01";*/
  $desde = $_GET["facInicio"];
  $hasta = $_GET["facFinal"];

        $fechaInicio = array_reverse(preg_split("[/]",$desde));
        $desde = $fechaInicio[0]."-".$fechaInicio[1]."-".$fechaInicio[2];

        $fechaFin = array_reverse(preg_split("[/]",$hasta));
        $hasta = $fechaFin[0]."-".$fechaFin[1]."-".$fechaFin[2];

  

  
  $fact = FacturaData::getBetweenDates($desde,$hasta);

/*$pVend = FacturaData::getAllSellsByFactId($_GET["id"]);
$sVend = FacturaData::getAllServicesByFactId($_GET["id"]);
$fact = FacturaData::getById($_GET["id"]);*/
//$tVend = $pVend;
//array_push($tVend,$sVend);

// para que ponga el nombre y le agregue la fecha y hora
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de ventas")
               ->setSubject("Ventas activos")
               ->setDescription("Reporte de las ventas")
               ->setKeywords("excel php reporte ventas")
               ->setCategory("ventas");

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
$sheet->mergeCells('A1:F1');
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);
$sheet->getStyle('A2')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1:F1','A7B6F8');
cellColor('A3:F3','E2DFDF');
$sheet->mergeCells('A2:F2');


$objPHPExcel->getActiveSheet()->getStyle('A1'.':F1')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A3'.':F3')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:F1')
            ->setCellValue('A1', 'VENTAS REGISTRADAS')
            ->setCellValue('A2', "Desde ". $desde ."         "."Hasta ". $hasta)
            ->setCellValue('A3', 'Nº')
            ->setCellValue('B3', 'Cliente')
            ->setCellValue('C3', 'Vendedor')
            ->setCellValue('D3', 'Fecha')
            ->setCellValue('E3', 'Tipo De Documento')
            ->setCellValue('F3', 'Total');

$i = 4;
foreach ($fact as $fa) {
   $prodsx = FacturaData::getAllSellsByFactId($fa->id); #Productos vendidos en la factura
   $servsx = FacturaData::getAllServicesByFactId($fa->id); #Servicios vendidos en la 
   $total=0;
      foreach($prodsx as $p){
        $prd = $p->getProduct();
        $total += $p->cantidad * $prd->precioventa;
      }
      foreach ($servsx as $s) {
        $srv = $s->getService();
        $total += $s->cantidad * $srv->precio;
      }
  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue("A$i", $fa->numerofactura)
              ->setCellValue("B$i", $fa->getClient()->name)
              ->setCellValue("C$i", $fa->getUser()->name." ".$fa->getUser()->lastname)
              ->setCellValue("D$i", $fa->fecha)
              ->setCellValue("E$i", $fa->getComprobante()->nombre)
              ->setCellValue("F$i", "$ ".$total);
 $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($borders);
  $i++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Ventas');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
