<?php

  @session_start();
  if (isset($_POST['idSuc'])) {
    include("../conectarpdo.php");
    $cn = conexion();
    $id = $_POST['idSuc'];
    $sql= "select * from sucursal where idSucursal = $id and estado = 1";
    $query = $cn->query($sql);
    $datos = $query->fetchAll();
    $_SESSION["suc_temp"] = $datos[0][1];
    echo json_encode($datos);
  }

?>
