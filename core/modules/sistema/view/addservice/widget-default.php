<?php

  include 'loader.php';
  if (isset($_POST["addService"])) {
    $serv = new ServiceData();
    $serv->idusuario = Session::getUID();
    $serv->nombre = $_POST["nombre"];
    $serv->descripcion = $_POST["descripcion"];
    $serv->precio = $_POST["precio"];
    $serv->add();
  }

?>
<script>window.location='index.php?view=services';</script>
