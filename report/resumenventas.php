<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/FacturaData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/ProductData.php";
include "../core/modules/sistema/model/ClientData.php";
include "../core/modules/sistema/model/ServiceData.php";


require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

$pVend = FacturaData::getAllSellsByFactId($_GET["id"]);
$sVend = FacturaData::getAllServicesByFactId($_GET["id"]);
$fact = FacturaData::getById($_GET["id"]);
//$tVend = $pVend;
//array_push($tVend,$sVend);
$total = 0;

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Resumen De Ventas")
               ->setSubject("Resumen De Ventas activas")
               ->setDescription("Reporte de los Resumen De Ventas")
               ->setKeywords("excel php reporte Resumen De Ventas")
               ->setCategory("Resumen De Ventas");

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

cellColor('A1:F1','A7B6F8');
$objPHPExcel->setActiveSheetIndex(0)
            //->mergeCells('A1:A5')
            ->setCellValue('A1', 'Resumen De Venta')
            ->setCellValue('A2', 'No.')
            ->setCellValue('A3', 'FECHA')
            ->setCellValue('A4', 'CLIENTE')
            ->setCellValue('A5', 'VENDEDOR');

//for ($i = 3; $i<7; $i++)
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("B2", $fact->numerofactura)
							->setCellValue("B3", $fact->fecha)
              ->setCellValue("B4", $fact->getClient()->name." ".$fact->getClient()->lastname)
              ->setCellValue("B5", $fact->getUser()->name." ".$fact->getUser()->lastname);
cellColor('A7:F7','A7B6F8');
        $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A7', 'Codigo.')
              ->setCellValue('B7', 'Cantidad')
              ->setCellValue('C7', 'Nombre Producto')
              ->setCellValue('D7', 'Precio')
              ->setCellValue('E7', 'Total')
                ->setCellValue('F7', 'Total Final');

         $i=8;
         foreach ($pVend as $rv) {
           $objPHPExcel->setActiveSheetIndex(0)
             					->setCellValue("A$i", $rv->idproducto)
                      ->setCellValue("B$i", $rv->cantidad)
                      ->setCellValue("C$i", $rv->getProduct()->nombre)
                      ->setCellValue("D$i","$ ". $rv->getProduct()->precioventa)
                      ->setCellValue("E$i","$ ".$rv->total)
                      ->setCellValue("F8","$ ".$total+=$rv->total);
           cellColor('A'.$i.':E'.$i, 'E0FCFD');
           cellColor('F8', '46FF33');
          $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($borders);
           $i++;
         }
         $i=8;
         foreach ($sVend as $rvs) {
           $objPHPExcel->setActiveSheetIndex(0)
             					->setCellValue("A$i", $rvs->idventa)
                      ->setCellValue("B$i", $rvs->cantidad)
                      ->setCellValue("C$i", $rvs->getService()->nombre)
                      ->setCellValue("D$i","$ ". $rvs->getService()->precio)
                      ->setCellValue("E$i","$ ".$rvs->total)
                      ->setCellValue("F8","$ ".$total+=$rvs->total);
           cellColor('A'.$i.':E'.$i, 'E0FCFD');
           cellColor('F8', '46FF33');
          $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($borders);
           $i++;
         }

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setTitle('Resumen Ventas');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
