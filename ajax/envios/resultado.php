<?php

  if (isset($_POST['idEnv'])) {
    include("../conectarpdo.php");
    $cn = conexion();

    $id = $_POST['idEnv'];

    $sql= "select * from envioBanco where idEnvioBanco = $id and estado = 1";

    $query = $cn->query($sql);
    $datos = $query->fetchAll();
    echo json_encode($datos);
  }

?>
