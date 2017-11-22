<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/BoxData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/SucursalData.php";
include "../core/modules/sistema/model/CajaChicaData.php";
include "../core/modules/sistema/model/FacturaData.php";
include "../core/modules/sistema/model/EmpleadoData.php";
include "../core/modules/sistema/model/ClientData.php";
include "../core/modules/sistema/model/ProductData.php";

require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

$box = BoxData::getById($_GET["id"]);

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de bancos")
               ->setSubject("Bancos activos")
               ->setDescription("Reporte de los bancos a los que se hacen envíos de dinero.")
               ->setKeywords("excel php reporte bancos")
               ->setCategory("Bancos");

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
$sheet->mergeCells('A1:D1'); 
$sheet->getStyle('A1')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

cellColor('A1','27D3E1');
cellColor('A6:D6','E2DFDF');
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:D1')
            ->setCellValue('A1', 'CORTE DE CAJA #'.$_GET["id"])
            ->setCellValue('A3', 'Fecha')
            ->setCellValue('A4', 'Nombre');

	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("B3", $box->fecha)
							->setCellValue("B4", $box->getUser()->name." ".$box->getUser()->lastname);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A6', "Tipo De Comprobante")
            ->setCellValue('B6', 'Número')
            ->setCellValue('C6', 'Cliente')
            ->setCellValue('D6', 'Total');

$i = 7;
$facturas = FacturaData::getByBoxId($_GET["id"]);
if (count($facturas)>0) {
  $total_total = 0;
    foreach ($facturas as $fact) {
      $ventasFactura = FacturaData::getAllSellsByFactId($fact->id);
      $total=0;
      foreach($ventasFactura as $s){
        $prod = $s->getProduct();
        $total += $s->cantidad * $prod->precioventa;
      }
      $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue("A$i", $fact->tipo)
                  ->setCellValue("B$i", $fact->numerofactura)
                  ->setCellValue("C$i", $fact->getClient()->name." ".$fact->getClient()->lastname)
                  ->setCellValue("D$i", "$ ".$total);

                  $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($borders);
                  $i++;
      $total_total+= $total;
    }
    $i++;
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A$i", "Total")
                ->setCellValue("B$i","$ ". $total_total);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Corte de Caja');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
