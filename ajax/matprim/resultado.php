<?php
  @Session_start();
  if (isset($_POST['idMP'])) {
    include("../conectarpdo.php");
    $cn = conexion();

    $id = $_POST['idMP'];

    $sql= "select * from materiaPrima where idMateriaPrima=$id and estado = 1";

    $query = $cn->query($sql);
    $datos = $query->fetchAll();
    $_SESSION["mp_temp"] = $datos[0][1];
    echo json_encode($datos);
  }

?>
