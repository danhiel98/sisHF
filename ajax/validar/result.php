<?php
  include("../conectarpdo.php");
  $cn = conexion();
  $valor = $_REQUEST["value"];
  $sql= "select * from usuario where usuario = \"$valor\"";
  $query = $cn->query($sql);
  $datos = $query->fetchAll();
  $usr = "";
  if (count($datos) > 0 ) {
    $usr = $datos[0][4];
  }
  $valid = 1;
  if ($usr != "") {
    $valid = 0;
  }
  echo json_encode(
    array(
      "value" => $valor,
      "valid" => $valid,
      "message" => "Must start with an uppercase letter"
    )
  );
