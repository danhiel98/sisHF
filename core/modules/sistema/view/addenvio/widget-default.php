<?php
	include("loader.php");
  if (isset($_POST["addEnvio"])) {
    $data = new EnvioData();
  	$data->idusuario = $_SESSION["user_id"];
  	$data->idbanco = $_POST["banco"];
  	$data->cantidad = $_POST["cantidad"];
    $data->comprobante = $_POST["comprobante"];
  	$data->add();
  }
?>
<script>window.location='index.php?view=envios';</script>
