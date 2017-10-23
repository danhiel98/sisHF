<?php

  if (isset($_POST['idBanc'])) {
    include("../conectarpdo.php");
    $cn = conexion();
    $id = $_POST['idBanc'];
    $sql= "select * from banco where idBanco = $id and estado = 1";
    $query = $cn->query($sql);
    $datos = $query->fetchAll();
    echo json_encode($datos);
  }

?>
