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

cellColor('A4:C4','27D3E1');
$objPHPExcel->getActiveSheet()->getStyle('A4'.':C4')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A2:C2')
            ->setCellValue('A2', "REPORTE DE CORTE DE CAJA")
            ->setCellValue('A4', "Nº")
            ->setCellValue('B4', 'Total')
            ->setCellValue('C4', 'Fecha');

            $i = 5;
            $factu = BoxData::getAll();
            if(count($factu)>0){
      				$total_total = 0;
              foreach ($factu as  $facid) {
                  $facturas = FacturaData::getByBoxId($facid->id);
              }
                foreach ($facturas as $fact) {
                  $ventasFactura = FacturaData::getAllSellsByFactId($fact->id);
                  $total=0;
                  foreach($ventasFactura as $s){
                    $prod = $s->getProduct();
                    $total += $s->cantidad * $prod->precioventa;
                  }
                  $objPHPExcel->setActiveSheetIndex(0)
                              ->setCellValue("A$i", $fact->id)
                              ->setCellValue("B$i",  "$ ".$total)
                              ->setCellValue("C$i", $fact->fecha);

                              $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':C'.$i)->applyFromArray($borders);
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

$objPHPExcel->getActiveSheet()->setTitle('Reporte de Corte de Caja');

$objPHPExcel->setActiveSheetIndex(0);

getHeaders();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
