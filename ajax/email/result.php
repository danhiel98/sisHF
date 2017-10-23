<?php
  include("../conectarpdo.php");
  $cn = conexion();
  $valor = $_REQUEST["value"];
  $sql= "select * from usuario where email = \"$valor\"";
  $query = $cn->query($sql);
  $datos = $query->fetchAll();
  $mail = "";
  if (count($datos) > 0 ) {
    $mail = $datos[0][5];
  }
  $valid = 1;
  if ($mail != "") {
    $valid = 0;
  }
  echo json_encode(
    array(
      "value" => $valor,
      "valid" => $valid,
      "message" => "El correo electrónico ingresado no está disponible."
    )
  );
