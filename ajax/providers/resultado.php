<?php

  if (isset($_POST['idProv'])) {
    include("../conectarpdo.php");
    $cn = conexion();
    $id = $_POST['idProv'];
    $sql= "select * from proveedor where idProveedor = $id and estado = 1";
    $query = $cn->query($sql);
    $datos = $query->fetchAll();
    echo json_encode($datos);
  }

?>
