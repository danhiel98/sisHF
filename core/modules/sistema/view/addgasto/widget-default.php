<?php
	include("loader.php");
  if (isset($_POST["addGasto"])) {
		$data = new GastoData();
		$data->idsucursal = $_SESSION["usr_suc"];
		$data->idusuario = $_SESSION["user_id"];
		if (isset($_POST["responsable"]) && $_POST["responsable"] !=""){
			$data->idempleado = $_POST["responsable"];
		}
  	$data->descripcion = $_POST["descripcion"];
		$data->comprobante = $_POST["comprobante"];
		$data->pago = $_POST["pago"];
  	$data->add();
  }
?>
<script>window.location='index.php?view=gastos';</script>
