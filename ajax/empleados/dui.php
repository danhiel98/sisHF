<?php

  @session_start();
  include("../conectarpdo.php");
  $cn = conexion();
  $valor = $_REQUEST["value"];
  $sql= "select * from empleado where dui = \"$valor\"";
  $query = $cn->query($sql);
  $datos = $query->fetchAll();
  $emp = "";
  if (count($datos) > 0 ) {
    if (!isset($_SESSION["emp_dui"]) || (isset($_SESSION["emp_dui"]) && $_SESSION["emp_dui"] != $datos[0][2])) {
      $emp = $datos[0][2];
    }
  }
  $valid = 1;
  if ($emp != "") {
    $valid = 0;
  }
  echo json_encode(
    array(
      "value" => $valor,
      "valid" => $valid,
      "message" => "El número de DUI ingresado es repetido."
    )
  );
