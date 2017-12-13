<?php

include "loader.php";

if(count($_POST)>0){
  $service = ServiceData::getById($_POST['idServicio']);
  $service->nombre = $_POST["nombre"];
  $service->descripcion = $_POST["descripcion"];
  $service->precio = $_POST["precio"];
  $service->update();

  print "<script>window.location='index.php?view=services';</script>";
}

?>
