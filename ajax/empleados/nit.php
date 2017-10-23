<?php

  @session_start();
  include("../conectarpdo.php");
  $cn = conexion();
  $valor = $_REQUEST["value"];
  $sql= "select * from empleado where nit = \"$valor\"";
  $query = $cn->query($sql);
  $datos = $query->fetchAll();
  $emp = "";
  if (count($datos) > 0 ) {
    if (!isset($_SESSION["emp_nit"]) || (isset($_SESSION["emp_nit"]) && $_SESSION["emp_nit"] != $datos[0][3])) {
      $emp = $datos[0][3];
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
      "message" => "El número de NIT ingresado es repetido."
    )
  );
