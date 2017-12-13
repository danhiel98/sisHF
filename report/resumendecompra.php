<?php
include "../core/autoload.php";
include "../core/modules/sistema/model/FacturaData.php";
include "../core/modules/sistema/model/UserData.php";
include "../core/modules/sistema/model/ProductData.php";
include "../core/modules/sistema/model/ClientData.php";
include "../core/modules/sistema/model/ServiceData.php";
include "../core/modules/sistema/model/ReabastecimientoData.php";
include "../core/modules/sistema/model/ReabastecimientoMPData.php";
include "../core/modules/sistema/model/ProviderData.php";
include "../core/modules/sistema/model/ComprobanteData.php";
include "../core/modules/sistema/model/MateriaPrimaData.php";


require_once '../ReporteExcel/functions/excel.php';
activeErrorReporting();
noCli();
require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';




// para que ponga el nombre y le agregue la fecha y hora
date_default_timezone_set('America/El_Salvador');
$hora= date('m/d/y g:ia');

header('Content-Disposition: attachment;filename="Resumen De Compra"'.$hora." ".".xlsx");


$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Hierro Forjado")
               ->setLastModifiedBy("Administrador")
               ->setTitle("Reporte de Resumen De Compras")
               ->setSubject("Resumen De Compras activas")
               ->setDescription("Reporte de los Resumen De Compras")
               ->setKeywords("excel php reporte Resumen De Compras")
               ->setCategory("Resumen De Compras");

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

cellColor('A1:F1','A7B6F8');
$objPHPExcel->getActiveSheet()->getStyle('A9'.':F9')->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)
            //->mergeCells('A1:A5')
            ->setCellValue('A1', 'Resumen De Compra')
            ->setCellValue('A3', 'Proveedor')
            ->setCellValue('A4', 'Tipo De Comprobante')
            ->setCellValue('A5', 'Nº De Comprobante')
            ->setCellValue('A6', 'Usuario');

if(isset($_GET["id"]) && $_GET["id"]!=""){

      $reab = ReabastecimientoData::getById($_GET["id"]);
      $reabMP = ReabastecimientoMPData::getAllByReabId($_GET["id"]);
      $total = 0;

      if($reab->idproveedor!=""){
    $prov = $reab->getProvider();

  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue("B3", $prov->nombre)
              ->setCellValue("B4", $reab->getComprobante()->nombre)
              ->setCellValue("B5", $reab->comprobante)
              ->setCellValue("B6", $reab->getUser()->name." ".$reab->getUser()->lastname);

  }
//for ($i = 3; $i<7; $i++)
cellColor('A8:F8','E2DFDF');
        $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A8', 'Codigo.')
              ->setCellValue('B8', 'Nombre Producto')
              ->setCellValue('C8', 'Cantidad')
              ->setCellValue('D8', 'Precio')
              ->setCellValue('E8', 'Total');

 $i=9;
      foreach($reabMP as $rb){
          $mp = $rb->getMateriaPrima();

           $objPHPExcel->setActiveSheetIndex(0)
                      ->setCellValue("A$i", $mp->id)
                      ->setCellValue("B$i", $mp->nombre)
                      ->setCellValue("C$i", $rb->cantidad)
                      ->setCellValue("D$i","$ ". $rb->precio)
                      ->setCellValue("E$i","$ ".$rb->total);
                    
          $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($borders);
           $i++;
           $total += $rb->total;
       }
       $i++;
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A$i", "Total")
                ->setCellValue("B$i","$ ". $total);
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
