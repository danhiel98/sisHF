<?php
	include("loader.php");
  if (isset($_POST["addGasto"])) {
    $data = new GastoData();
  	$data->idusuario = $_SESSION["user_id"];
  	$data->descripcion = $_POST["descripcion"];
		$data->comprobante = $_POST["comprobante"];
  	$data->pago = $_POST["pago"];
  	$data->add();
  }
?>
<script>window.location='index.php?view=gastos';</script>
