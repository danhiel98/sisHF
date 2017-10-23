<?php
  @Session_start();
  include("../conectarpdo.php");
  $cn = conexion();
  $valor = $_REQUEST["value"];
  $sql= "select * from materiaPrima where nombre = \"$valor\"";
  $query = $cn->query($sql);
  $datos = $query->fetchAll();
  $matP = "";
  if (count($datos) > 0 ) {
    $matP = $datos[0][1];
  }
  $valid = 1;
  if ($matP != "") {
    if (!isset($_SESSION["mp_temp"]) || (isset($_SESSION["mp_temp"]) && $_SESSION["mp_temp"] != $matP)) {
      $valid = 0;
    }
  }
  echo json_encode(
    array(
      "value" => $valor,
      "valid" => $valid,
      "message" => "Ya existe un producto con este nombre."
    )
  );
