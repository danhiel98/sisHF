<?php
  
  $service = new ServiceData();
  if ((isset($_GET["id"]) && !empty($_GET["id"])) && !is_null($service->getById($_GET["id"]))){
    $service = $service->getById($_GET["id"]);
    $serviceSells = FacturaData::getAllByService($service->id);
    $serviceReq = PedidoData::getAllByService($service->id);
    $numSrv = 0;

    foreach ($serviceSells as $srvs){
      if ($srvs->getFact()->estado == 1){
        $numSrv++;
      }
    }

    foreach ($serviceReq as $srvr){
      if ($srvr->getReq()->estado == 1){
        $numSrv++;
      }
    }

    if ($numSrv <= 0){
      $service->del();
      setcookie("okService","¡Se eliminó la información correctamente!");
    }else{
      setcookie("errorService","No se puede eliminar el servicio porque se han registrado pedidos y/o ventas de él.");
    }
  }else{
    setcookie("errorService","!Vaya! Parece que no se ha podido eliminar el servicio. Por favor, inténtelo nuevamente.");
  }
  Core::redir("./index.php?view=services");

?>
