<?php
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ClientData.php");

	if (isset($_POST["idCliente"]) && !empty($_POST["idCliente"])) {
		$idCliente = $_POST["idCliente"];
		$cliente = ClientData::getById($idCliente);
	?>
		<option value="">--NINGUNO--</option>
		<option value="1">Factura</option>
	<?php
		if ($cliente->nit != "" && $cliente->nit != null):
	?>
		<option value="2">Comprobante de Crédito Fiscal</option>
	<?php
		endif;
	?>
		<option value="3">Recibo</option>
	<?php
	}else{
		echo '<option value="">--SELECCIONE UN CLIENTE--</option>';
	}
?>
