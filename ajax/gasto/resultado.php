<?php

  if (isset($_POST['idGst'])) {
    include("../conectarpdo.php");
    $cn = conexion();

    $id = $_POST['idGst'];

    $sql= "select * from gasto where idGasto = $id and estado = 1";

    $query = $cn->query($sql);
    $datos = $query->fetchAll();
    echo json_encode($datos);
  }

?>
