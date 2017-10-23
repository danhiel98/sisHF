<?php
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ClientData.php");

	$ccf = false;
	if (isset($_POST["idCliente"]) && !empty($_POST["idCliente"])) {

		$idCliente = $_POST["idCliente"];
		$cliente = ClientData::getById($idCliente);
		echo '<option value="">--NINGUNO--</option>';
		echo '<option value="Factura">Factura</option>';
		if ($cliente->nrc != "" && $cliente->nrc != null) {
	?>
			<option value="CCF">CCF</option>
	<?php
		}
	}else{
		echo '<option value="">--SELECCIONE UN CLIENTE--</option>';
	}
?>
<?php /* if (count($clientes)>0): ?>
		<?php foreach ($clientes as $cli): ?>
			<option value="<?php echo $cli->id; ?>"><?php echo $cli->name." ".$cli->lastname; ?></option>
		<?php endforeach; ?>
	<?php endif; ?>
	<script type="text/javascript">
		$(function(){
			$('.selectpicker').selectpicker('refresh');
		});
	</script>
	<?php if ($ccf): ?>
		<script type="text/javascript">
			$(function(){
				$("#cliente").attr("required","true");
			});
		</script>
	<?php else: ?>
		<script type="text/javascript">
			$(function(){
				$("#cliente").removeAttr("required","true");
			});
		</script>
	<?php endif; */ ?>
