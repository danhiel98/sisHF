<?php
  
  $matPrim = new MateriaPrimaData();
  if ((isset($_GET["id"]) && !empty($_GET["id"])) && !is_null($matPrim->getById($_GET["id"]))){
    $matPrim = $matPrim->getById($_GET["id"]);
    $matPrimBuy = ReabastecimientoMPData::getAllByMP($matPrim->id);
    $matPrimProd = ProduccionMPData::getAllByMP($matPrim->id);
    $numMP = 0;

	foreach ($matPrimBuy as $mpb){
	  if ($mpb->getFacturaMP()->estado == 1){
		$numMP++;
	  }
	}
	
	if (count($matPrimProd) > 0){
		$numMP++;		
	}

	/*
    foreach ($matPrimProd as $mps){s
      if ($mps->getProduccion()->estado == 1){
        $numMP++;
      }
    }
	*/

    if ($numMP <= 0){
      $matPrim->del();
      setcookie("okMatPrim","¡Se eliminó la información correctamente!");
    }else{
      setcookie("errorMatPrim","No se puede eliminar la información porque se han registrado compras y/o producciones.");
    }
  }else{
    setcookie("errorMatPrim","!Vaya! Parece que no se ha podido eliminar la información. Por favor, inténtelo nuevamente.");
  }
  Core::redir("./index.php?view=inventarymp");

?>
