<?php

include "loader.php";

if(count($_POST)>0){
  $data = EnvioData::getById($_POST['idEnvio']);
  $data->idBanco = $_POST["banco"];
  $data->cantidad = $_POST["cantidad"];
  $data->update();

  print "<script>window.location='index.php?view=envios';</script>";
}

?>
