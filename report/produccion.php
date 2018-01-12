<?php
    include "../core/autoload.php";
    include "../core/modules/sistema/model/ProductData.php";    
    include "../core/modules/sistema/model/ProduccionData.php";
    include "../core/modules/sistema/model/ProduccionMPData.php";
    include "../core/modules/sistema/model/MateriaPrimaData.php";
    include "../core/modules/sistema/model/UserData.php";
    include "../core/modules/sistema/model/EmpleadoData.php";

    require_once '../ReporteExcel/functions/excel.php';
    activeErrorReporting();
    noCli();
    require_once '../ReporteExcel/PHPExcel/Classes/PHPExcel.php';

    date_default_timezone_set('America/El_Salvador');
    $hora= date('m/d/y g:ia');
    
    $idProd = $_GET["idProd"];
	$prodxn = ProduccionData::getById($idProd);
	if (is_null($prodxn)) {
		@header("location: index.php?view=produccion");
	}
	$matP = ProduccionMPData::getAllByProdId($idProd);
    
    $estado = "";
	if ($prodxn->terminado == 1) {
		$estado = "Finalizado";
	}else{
		$estado = "En Proceso";
	}

    $encargado = "";
    if (!is_null($prodxn->getUser()->idempleado)){
        $encargado = $prodxn->getUser()->getEmpleado()->nombrecompleto;
    }else{
        $encargado = $prodxn->getUser()->fullname;
    }

    header('Content-Disposition: attachment;filename="Producción"'.$hora.".xlsx");

    $objPHPExcel = new PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Hierro Forjado")
            ->setLastModifiedBy("Administrador")
            ->setTitle("Reporte de producciones")
            ->setSubject("Detalle de Producción")
            ->setDescription("Reporte del detalle de producción.")
            ->setKeywords("excel php reporte produccion")
            ->setCategory("Producción");

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

    if($estado == "En Proceso"){
        cellColor('A1:C1','A7B6F8');
        cellColor('A3:A9','E2DFDF');
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->getStyle('A3:A9')->applyFromArray($borders);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Detalle De Producción')
            ->setCellValue('A3', 'No.')
            ->setCellValue('A4', 'Estado')
            ->setCellValue('A5', 'Producto')
            ->setCellValue('A6', 'Cantidad')
            ->setCellValue('A7', 'Fecha De Inicio')
            ->setCellValue('A8', 'Fecha Límite')
            ->setCellValue('A9', 'Encargado');
    
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B3', $idProd)
            ->setCellValue('B4', $estado)
            ->setCellValue('B5', $prodxn->getProduct()->nombre)
            ->setCellValue('B6', $prodxn->cantidad)
            ->setCellValue('B7', $prodxn->fechainicio)
            ->setCellValue('B8', $prodxn->fechafin)
            ->setCellValue('B9', $encargado);
            
        $objPHPExcel->getActiveSheet()->getStyle('B3:B9')->applyFromArray($borders);
    }elseif($estado == "Finalizado"){
        cellColor('A1:C1','A7B6F8');
        cellColor('A3:A10','E2DFDF');
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->getStyle('A3:A10')->applyFromArray($borders);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Detalle De Producción')
            ->setCellValue('A3', 'No.')
            ->setCellValue('A4', 'Estado')
            ->setCellValue('A5', 'Fecha Finalizado')
            ->setCellValue('A6', 'Producto')
            ->setCellValue('A7', 'Cantidad')
            ->setCellValue('A8', 'Fecha De Inicio')
            ->setCellValue('A9', 'Fecha Límite')
            ->setCellValue('A10', 'Encargado');
    
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B3', $idProd)
            ->setCellValue('B4', $estado)
            ->setCellValue('B5', $prodxn->fechafinalizado)
            ->setCellValue('B6', $prodxn->getProduct()->nombre)
            ->setCellValue('B7', $prodxn->cantidad)
            ->setCellValue('B8', $prodxn->fechainicio)
            ->setCellValue('B9', $prodxn->fechafin)
            ->setCellValue('B10', $encargado);
            
        $objPHPExcel->getActiveSheet()->getStyle('B3:B10')->applyFromArray($borders);
    }
    
    $i = 11;
    if($estado == "Finalizado"){
        $i++;
    }
    cellColor("A$i:C$i",'E2DFDF');
    $objPHPExcel->getActiveSheet()->getStyle("A$i:C$i")->applyFromArray($borders);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue("A$i", 'ID')
        ->setCellValue("B$i", 'Nombre')
        ->setCellValue("C$i", 'Cantidad');

    $i = 12;
    if($estado == "Finalizado"){
        $i++;
    }
    foreach($matP as $mpp) {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $mpp->id)
            ->setCellValue("B$i", $mpp->getMateriaPrima()->nombre)
            ->setCellValue("C$i", $mpp->cantidad);

        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':C'.$i)->applyFromArray($borders);
        $i++;
    }

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

    $objPHPExcel->getActiveSheet()->setTitle('Reporte de Producción');

    $objPHPExcel->setActiveSheetIndex(0);

    getHeaders();

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
