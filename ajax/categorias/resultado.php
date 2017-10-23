<?php

  if (isset($_POST['idCat'])) {
    include("../conectarpdo.php");
    $cn = conexion();

    $id = $_POST['idCat'];

    $sql= "select * from categoria where idCategoria = $id and estado = 1";

    $query = $cn->query($sql);
    $datos = $query->fetchAll();
    echo json_encode($datos);
  }

?>
