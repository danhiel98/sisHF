<?php

  if (isset($_POST['idServ'])) {
    include("../conectarpdo.php");
    $cn = conexion();
    $id = $_POST['idServ'];
    $sql= "select * from servicio where idServicio = $id and estado = 1";
    $query = $cn->query($sql);
    $datos = $query->fetchAll();
    echo json_encode($datos);
  }

?>
