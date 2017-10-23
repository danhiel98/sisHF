<?php

  include "loader.php";
  if (isset($_POST["editMP"])) {
    $matPrim = MateriaPrimaData::getById($_POST["eid"]);
    $matPrim->id = $_POST["eid"];
    $matPrim->nombre = $_POST["enombre"];
  	$matPrim->descripcion = $_POST["edescripcion"];
    $matPrim->minimo = $_POST["eminimo"];
  	$matPrim->update();
  }
?>
<script>window.location='index.php?view=inventarymp';</script>"
