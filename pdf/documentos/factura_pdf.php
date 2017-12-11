<?php

	@session_start();
	include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/FacturaData.php");
    include ("../../core/modules/sistema/model/ComprobanteData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
    include ("../../core/modules/sistema/model/ClientData.php");
    include ("../../core/modules/sistema/model/ServiceData.php");
	include ("../../core/modules/sistema/model/UserData.php");
	
	$sell = FacturaData::getById($_GET["id"]);

	if (is_null($sell)) {
		@header("location: index.php?view=sells");
	}

	$pVend = FacturaData::getAllSellsByFactId($_GET["id"]);
	$sVend = FacturaData::getAllServicesByFactId($_GET["id"]);
	$total = 0;

	
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$id_cliente = $sell->getClient()->id;
	$id_vendedor = $sell->getUser()->id;
	
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/factura_html.php');
   	 $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('Factura.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
