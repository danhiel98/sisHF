<?php
  @session_start();
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
    if (!isset($_SESSION["user_temp"]) || (isset($_SESSION["user_temp"]) && $_SESSION["user_temp"] != $usr)) {
      $valid = 0;
    }
  }
  echo json_encode(
    array(
      "value" => $valor,
      "valid" => $valid,
      "message" => "El nombre de usuario ingresado no está disponible."
    )
  );
