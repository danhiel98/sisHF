<?php
  include("../conectarpdo.php");
  $cn = conexion();
  $valor = $_REQUEST["value"];
  $sql= "select * from banco where nombre = \"$valor\"";
  $query = $cn->query($sql);
  $datos = $query->fetchAll();
  $banco = "";
  if (count($datos) > 0 ) {
    $banco = $datos[0][1];
  }
  $valid = 1;
  if ($banco != "") {
    $valid = 0;
  }
  echo json_encode(
    array(
      "value" => $valor,
      "valid" => $valid,
      "message" => "Ya se registró un banco con este nombre."
    )
  );
