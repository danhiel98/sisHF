<?php
    @session_start();
    include "../core/autoload.php";
    include "../core/modules/sistema/model/SucursalData.php";   
    include "../core/modules/sistema/model/ProductData.php";    
    include "../core/modules/sistema/model/ProductoSucursalData.php";

    require_once '../ReporteExcel/functions/excel.php';
    activeErrorReporting();
    noCli();
    require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

    // para que ponga el nombre y le agregue la fecha y hora
    date_default_timezone_set('America/El_Salvador');
    $hora= date('m/d/y g:ia');
    
    $idSuc = $_SESSION["usr_suc"];

    $sucursal = SucursalData::getById($idSuc);
    $products = ProductoSucursalData::getAllBySucId($idSuc);

    header('Content-Disposition: attachment;filename="Inventario Producto "'.$hora." ".".xlsx");

    $objPHPExcel = new PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Hierro Forjado")
            ->setLastModifiedBy("Administrador")
            ->setTitle("Reporte de Productos")
            ->setSubject("Productos activos")
            ->setDescription("Reporte de los Productos")
            ->setKeywords("excel php reporte Productos")
            ->setCategory("Productos");

    $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

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
    $sheet->mergeCells('A1:C1');
    $sheet->getStyle('A1')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
    );

    cellColor('A1:C1','A7B6F8');
    cellColor('A3:C3','E2DFDF');
    $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A3:C3')->applyFromArray($borders);
    $objPHPExcel->setActiveSheetIndex(0)
                ->mergeCells('A1:C1')
                ->setCellValue('A1', 'PRODUCTOS REGISTRADOS EN INVENTARIO [Sucursal: '.$sucursal->nombre.']')
                ->setCellValue('A3', 'Nombre')
                ->setCellValue('B3', 'Descripción')
                ->setCellValue('C3', 'Existencias');

    $i = 4;
    foreach ($products as $prods) {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $prods->getProduct()->nombre)
            ->setCellValue("B$i", $prods->getProduct()->descripcion)
            ->setCellValue("C$i", $prods->cantidad);
                
        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':C'.$i)->applyFromArray($borders);
        $i++;
    }

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 

    if ($idSuc == 1){
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setCellValueByColumnAndRow(0, 1, "test");
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
    
        cellColor('A1:D1','A7B6F8');
        cellColor('A3:D3','E2DFDF');
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($borders);
        $objPHPExcel->setActiveSheetIndex(0)
                    ->mergeCells('A1:D1')
                    ->setCellValue('A1', 'PRODUCTOS REGISTRADOS EN INVENTARIO [Sucursal: '.$sucursal->nombre.']')
                    ->setCellValue('A3', 'Nombre')
                    ->setCellValue('B3', 'Descripción')
                    ->setCellValue('C3', 'Mínimo')
                    ->setCellValue('D3', 'Existencias');
    
        $i = 4;
        foreach ($products as $prods) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A$i", $prods->getProduct()->nombre)
                ->setCellValue("B$i", $prods->getProduct()->descripcion)
                ->setCellValue("C$i", $prods->minimo)
                ->setCellValue("D$i", $prods->cantidad);
                    
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($borders);
            $i++;
        }
    
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
    }


    $objPHPExcel->getActiveSheet()->setTitle('Reporte de Productos');

    $objPHPExcel->setActiveSheetIndex(0);

    getHeaders();

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
